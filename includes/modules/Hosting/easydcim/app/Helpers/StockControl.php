<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Helpers;

use Exception;
use Illuminate\Database\Capsule\Manager as DB;
use ModulesGarden\Servers\EasyDCIMv2\App\Api\ApiClientFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters\ClientAdapter;

/**
 * Keeps HostBill product stock in step with EasyDCIM device availability.
 *
 * EasyDCIM is asked how many devices match a product's order criteria, and the
 * answer is written back to `hb_products`.
 *
 * HostBill counts stock the other way round from WHMCS: `stock` is the cap and
 * `qty` the number already sold, with a product out of stock once
 * `stock > 0 && stock <= qty` (see Products::stockControlCheck) and `stock = 0`
 * meaning unlimited. So to expose N available units the cap is set to
 * `qty + N`, and a product with nothing left gets `qty + 1` rather than 0 -
 * 0 would read as "unlimited" and let it be ordered anyway.
 */
class StockControl
{
    /**
     * Part type IDs as EasyDCIM knows them, and the size key each expects.
     */
    private const PART_TYPE_IDS = [
        'HDD' => 8,
        'SSD' => 9,
        'RAM' => 10,
        'CPU' => 11,
    ];

    private const PART_SIZE_KEYS = [
        8  => 'hdd.size',
        9  => 'ssd.size',
        10 => 'ram.size',
        11 => 'cpu.cores',
    ];

    protected $servers;

    public function __construct($servers)
    {
        $this->servers = $servers;
    }

    /**
     * Refresh stock for every EasyDCIM product that opted in.
     */
    public function run(): void
    {
        foreach ($this->getProducts() as $product)
        {
            try
            {
                $options = $this->parseOptions($product->options);

                if (($options['EnableStockControl'] ?? '') != 'on')
                {
                    continue;
                }

                $server = $this->getServer((int) $product->server);
                $client = new ClientAdapter($server);
                $api = ApiClientFactory::fromClient($client);

                $response = $api->admin()->orders()->getStockByCriteria($this->buildCriteria($options));

                $stock = (int) ($response['data']['stock'] ?? 0);

                $this->updateProductStock((int) $product->product_id, $stock);
            }
            catch (Exception $ex)
            {
                echo 'STOCK CONTROL ERROR (product #' . $product->product_id . '): ' . $ex->getMessage() . PHP_EOL;
            }
        }
    }

    /**
     * EasyDCIM products, with the module options blob each one stores.
     */
    protected function getProducts()
    {
        return DB::table('hb_products_modules')
            ->join('hb_modules_configuration', 'hb_products_modules.module', '=', 'hb_modules_configuration.id')
            ->where('hb_modules_configuration.module', '=', 'easydcim')
            ->select('hb_products_modules.product_id', 'hb_products_modules.server', 'hb_products_modules.options')
            ->get();
    }

    /**
     * The product options blob down to plain values.
     *
     * HostBill stores each option as ['value' => ...]; older rows may hold the
     * bare value, so both shapes are accepted.
     */
    protected function parseOptions($raw): array
    {
        $options = is_string($raw) ? @unserialize($raw) : $raw;

        if (!is_array($options))
        {
            $options = json_decode((string) $raw, true) ?: [];
        }

        $parsed = [];

        foreach ($options as $key => $value)
        {
            $parsed[$key] = (is_array($value) && array_key_exists('value', $value)) ? $value['value'] : $value;
        }

        return $parsed;
    }

    /**
     * The same criteria an order would be placed with, minus the service part.
     */
    protected function buildCriteria(array $options): array
    {
        $parts = $this->buildParts($options['parts'] ?? []);

        $criteria = [
            'model'          => $options['ModelID'] ?? null,
            'location'       => $options['LocationID'] ?? null,
            'require_pdu'    => ($options['RequirePDU'] ?? '') == 'on' ? 1 : 0,
            'require_switch' => ($options['RequireSwitch'] ?? '') == 'on' ? 1 : 0,
            'require_parts'  => !empty($parts) ? 1 : 0,
        ];

        if (!empty($parts))
        {
            $criteria['parts'] = $parts;
        }

        $metadata = $this->buildMetadata($options['metadata'] ?? []);

        if (!empty($metadata))
        {
            $criteria['require_metadata'] = 1;
            $criteria['metadata'] = $metadata;
        }
        else
        {
            $criteria['require_metadata'] = 0;
        }

        return array_filter($criteria, fn($value) => $value !== null && $value !== '');
    }

    /**
     * Product part rows into the parallel arrays EasyDCIM matches on.
     */
    protected function buildParts($parts): array
    {
        if (empty($parts['type']) || !is_array($parts['type']))
        {
            return [];
        }

        $result = [];

        foreach ($parts['type'] as $key => $type)
        {
            $typeId = self::PART_TYPE_IDS[$type] ?? null;

            if ($typeId === null)
            {
                continue;
            }

            if (!isset($result[$typeId]))
            {
                $result[$typeId] = ['model' => [], self::PART_SIZE_KEYS[$typeId] => []];
            }

            $result[$typeId]['model'][] = $parts['model'][$key] ?? '';
            $result[$typeId][self::PART_SIZE_KEYS[$typeId]][] = $parts['size'][$key] ?? '';
        }

        return $result;
    }

    /**
     * @return array<int, array{value: mixed}>
     */
    protected function buildMetadata($metadata): array
    {
        if (!is_array($metadata))
        {
            return [];
        }

        $result = [];

        foreach ($metadata as $id => $value)
        {
            $value = (is_array($value) && array_key_exists('value', $value)) ? $value['value'] : $value;

            if ($value !== null && $value !== '')
            {
                $result[(int) $id] = ['value' => $value];
            }
        }

        return $result;
    }

    /**
     * Write the availability back as a HostBill stock cap.
     *
     * HostBill reports remaining units as `stock - qty` (CartData) and calls a
     * product sold out when `stock > 0 && stock <= qty` (Products). `qty` only
     * ever grows, so setting `stock = qty + available` makes the remaining
     * count read as `available` whatever `qty` happens to be.
     */
    protected function updateProductStock(int $productId, int $available): void
    {
        $product = DB::table('hb_products')->where('id', '=', $productId)->first();

        if (empty($product))
        {
            return;
        }

        $sold = (int) $product->qty;

        if ($available > 0)
        {
            DB::table('hb_products')->where('id', '=', $productId)->update([
                'stock' => $sold + $available,
            ]);

            return;
        }

        // Nothing available. `stock = qty` reads as sold out - except when the
        // product has never sold, because `stock = 0` means "unlimited" to
        // HostBill and there is no other way to express an empty cap. Nudging
        // both to 1 is what makes it read as sold out; it leaves the remaining
        // count at 0 either way, since that is always `stock - qty`.
        $update = ['stock' => $sold > 0 ? $sold : 1];

        if ($sold === 0)
        {
            $update['qty'] = 1;
        }

        DB::table('hb_products')->where('id', '=', $productId)->update($update);
    }

    private function getServer(int $serverId)
    {
        foreach ($this->servers as $value)
        {
            if ($value['id'] == $serverId)
            {
                return [
                    'serversecure'   => $value['secure'] == '1' ? 'on' : '',
                    'serverip'       => $value['ip'],
                    'serverhostname' => $value['host'],
                    'username'       => $value['username'],
                    'serverpassword' => $value['password'],
                ];
            }
        }

        throw new Exception('Server not exists! Server ID #' . $serverId);
    }
}
