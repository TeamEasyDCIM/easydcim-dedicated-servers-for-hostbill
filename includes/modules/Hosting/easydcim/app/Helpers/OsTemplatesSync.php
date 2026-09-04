<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Helpers;

use Exception;
use Illuminate\Database\Capsule\Manager as DB;
use ModulesGarden\Servers\EasyDCIMv2\App\Api\ApiClientFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters\ClientAdapter;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections\DefaultOptions;

/**
 * Keeps the OS template, disk layout and extras configurable options in step
 * with what EasyDCIM offers.
 *
 * The product's "Create Configurable Options" buttons build these lists once;
 * without this they drift as templates are added in EasyDCIM. Enabled per
 * product through the SyncOsTemplates option.
 *
 * Only ever **adds** missing sub-options. Removing one would break the services
 * already ordered against it, and HostBill's own OS sync (ConfigFields
 * ::addOSFieldCat) takes the same additive line.
 */
class OsTemplatesSync
{
    /**
     * Configurable option variable => how its choices are sourced.
     */
    protected const OS_TEMPLATE_VARIABLE = 'osTemplate';
    protected const DISK_LAYOUT_VARIABLE = 'disk_layout';
    protected const EXTRAS_VARIABLE = 'extras';

    protected const DISK_LAYOUT_TYPE = 'disklayout';

    protected $servers;

    /**
     * HostBill's ConfigFields model.
     *
     * @var object
     */
    protected $configFields;

    public function __construct($servers, $configFields)
    {
        $this->servers = $servers;
        $this->configFields = $configFields;
    }

    public function run(): void
    {
        foreach ($this->getProducts() as $product)
        {
            try
            {
                $options = $this->parseOptions($product->options);

                if (($options['SyncOsTemplates'] ?? '') != 'on')
                {
                    continue;
                }

                $this->syncProduct((int) $product->product_id, (int) $product->server, $options);
            }
            catch (Exception $ex)
            {
                echo 'OS TEMPLATE SYNC ERROR (product #' . $product->product_id . '): ' . $ex->getMessage() . PHP_EOL;
            }
        }
    }

    protected function syncProduct(int $productId, int $serverId, array $options): void
    {
        $client = new ClientAdapter($this->getServer($serverId));
        $api = ApiClientFactory::fromClient($client);
        $defaults = new DefaultOptions($api);

        $locationId = $options['LocationID'] ?? '';

        $templates = [];

        foreach ($defaults->getTemplateList($locationId) as $template)
        {
            $templates[(string) $template->id] = (string) $template->name;
        }

        $this->addMissing($productId, self::OS_TEMPLATE_VARIABLE, $templates);

        $diskLayouts = [];
        $extras = [];

        foreach ($defaults->getAddonsList(null, $locationId) as $addon)
        {
            $label = (string) ($addon->description ?: $addon->name);

            if ($addon->type == self::DISK_LAYOUT_TYPE)
            {
                $diskLayouts[(string) $addon->id] = $label;
                continue;
            }

            $extras[(string) $addon->id] = $label;
        }

        $this->addMissing($productId, self::DISK_LAYOUT_VARIABLE, $diskLayouts);
        $this->addMissing($productId, self::EXTRAS_VARIABLE, $extras);
    }

    /**
     * Add any choice EasyDCIM offers that the configurable option lacks.
     *
     * @param array<string, string> $choices EasyDCIM id => label
     */
    protected function addMissing(int $productId, string $variable, array $choices): void
    {
        if (empty($choices))
        {
            return;
        }

        $field = $this->configFields->getFieldByVar($productId, $variable);

        // Nothing to extend until an administrator has created the option.
        if (empty($field) || empty($field['id']))
        {
            return;
        }

        $existing = [];

        foreach ((array) ($field['items'] ?? []) as $item)
        {
            $existing[(string) ($item['variable_id'] ?? '')] = true;
        }

        foreach ($choices as $id => $label)
        {
            if (isset($existing[$id]))
            {
                continue;
            }

            $this->configFields->addField([
                'category_id' => $field['id'],
                'name'        => $label !== '' ? $label : $id,
                'variable_id' => $id,
                'paytype'     => $field['product_paytype'] ?? '',
            ], $field);

            echo 'OS TEMPLATE SYNC: product #' . $productId . ' ' . $variable . ' += ' . $label . PHP_EOL;
        }
    }

    protected function getProducts()
    {
        return DB::table('hb_products_modules')
            ->join('hb_modules_configuration', 'hb_products_modules.module', '=', 'hb_modules_configuration.id')
            ->where('hb_modules_configuration.module', '=', 'easydcim')
            ->select('hb_products_modules.product_id', 'hb_products_modules.server', 'hb_products_modules.options')
            ->get();
    }

    /**
     * HostBill stores each option as ['value' => ...]; older rows may be bare.
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

    private function getServer(int $serverId): array
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
