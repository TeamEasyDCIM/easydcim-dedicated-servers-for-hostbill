<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Helpers;

use Exception;
use Illuminate\Database\Capsule\Manager as DB;
use ModulesGarden\Servers\EasyDCIMv2\App\Api\ApiClientFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\User\UpdateUserRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters\ClientAdapter;

/**
 * Mirrors HostBill client detail changes onto the matching EasyDCIM user.
 *
 * Driven by the `after_clientedit` hook, which hands over the record both
 * before and after the edit (see HostBill's core Events class). The previous
 * email is what identifies the EasyDCIM user, because the edit may be the very
 * change of address that would otherwise make them unfindable.
 *
 * A client can hold services on more than one EasyDCIM server, so the update is
 * applied once per server the client actually has an account on.
 */
class ClientSync
{
    /**
     * HostBill field => EasyDCIM update field. HostBill's own docblock spells
     * the company key "comapnyname"; both spellings are accepted.
     */
    protected const FIELDS = [
        'firstname'   => 'firstName',
        'lastname'    => 'lastName',
        'companyname' => 'company',
        'phonenumber' => 'phone',
        'email'       => 'email',
    ];

    protected $servers;

    public function __construct($servers)
    {
        $this->servers = $servers;
    }

    /**
     * @param array $details `after_clientedit` payload: ['previous' => [...], 'new' => [...]]
     */
    public function handle(array $details): void
    {
        $previous = $this->normalise($details['previous'] ?? []);
        $new = $this->normalise($details['new'] ?? []);

        $clientId = $new['id'] ?? ($previous['id'] ?? null);
        $lookupEmail = $previous['email'] ?? ($new['email'] ?? null);

        if (empty($clientId) || empty($lookupEmail))
        {
            return;
        }

        $changed = $this->changedFields($previous, $new);

        if (empty($changed))
        {
            return;
        }

        foreach ($this->getServerIdsForClient((int) $clientId) as $serverId)
        {
            try
            {
                $this->pushToServer((int) $serverId, $lookupEmail, $changed);
            }
            catch (Exception $e)
            {
                // One unreachable server must not stop the others.
                continue;
            }
        }
    }

    /**
     * HostBill's docblock uses "comapnyname"; accept it and the correct spelling.
     */
    protected function normalise($record): array
    {
        $record = (array) $record;

        if (!isset($record['companyname']) && isset($record['comapnyname']))
        {
            $record['companyname'] = $record['comapnyname'];
        }

        return $record;
    }

    /**
     * @return array<string, string> EasyDCIM field => new value
     */
    protected function changedFields(array $previous, array $new): array
    {
        $changed = [];

        foreach (self::FIELDS as $hostbillField => $apiField)
        {
            if (!array_key_exists($hostbillField, $new))
            {
                continue;
            }

            $value = (string) $new[$hostbillField];
            $before = isset($previous[$hostbillField]) ? (string) $previous[$hostbillField] : null;

            if ($value !== '' && $value !== $before)
            {
                $changed[$apiField] = $value;
            }
        }

        return $changed;
    }

    /**
     * EasyDCIM servers this client holds an account on.
     *
     * @return array<int>
     */
    protected function getServerIdsForClient(int $clientId): array
    {
        $rows = DB::table('hb_accounts')
            ->join('hb_products_modules', 'hb_accounts.product_id', '=', 'hb_products_modules.product_id')
            ->join('hb_modules_configuration', 'hb_products_modules.module', '=', 'hb_modules_configuration.id')
            ->where('hb_modules_configuration.module', '=', 'easydcim')
            ->where('hb_accounts.client_id', '=', $clientId)
            ->distinct()
            ->pluck('hb_accounts.server_id');

        $ids = [];

        foreach ($rows as $id)
        {
            if (!empty($id))
            {
                $ids[(int) $id] = (int) $id;
            }
        }

        return array_values($ids);
    }

    /**
     * @param array<string, string> $changed
     */
    protected function pushToServer(int $serverId, string $lookupEmail, array $changed): void
    {
        $client = new ClientAdapter($this->getServer($serverId));
        $api = ApiClientFactory::fromClient($client);

        $existing = $api->admin()->users()->fetchByEmail($lookupEmail);

        if (empty($existing->data === null ? null : $existing->data->id))
        {
            return;
        }

        $api->admin()->users()->update($existing->data->id, new UpdateUserRequest($changed['email'] ?? null, null, $changed['firstName'] ?? null, $changed['lastName'] ?? null, $changed['company'] ?? null, $changed['phone'] ?? null));
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
