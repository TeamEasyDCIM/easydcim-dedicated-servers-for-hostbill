<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Http\Actions;

use ModulesGarden\Servers\EasyDCIMv2\App\Api\ApiClientFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Api\EasyDCIMConfigFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\Emails;
use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\SshPublicKey;
use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\Synchronize;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Order\CreateOrderRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\User\CreateUserRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\SshKey\CreateSshKeyRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters\ClientAdapter;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Interfaces\IClient;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections\EmailNotifications;

class CreateAccount
{
    /**
     * Part type IDs as EasyDCIM knows them, and the size key each one expects
     * inside the order criteria.
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

    /**
     * Configurable options the module consumes itself; they must not be passed
     * through to EasyDCIM as service custom fields.
     */
    private $disabledOptions = [
        'model',
        'Model',
        'Extras',
        'extras',
        'Disk Layout',
        'disk_layout',
        'Location',
        'location',
        'OS Template',
        'osTemplate',
        'Number of additional IP addresses',
        'numberOfAdditionalIpAddresses',
        'Bandwidth',
        'bandwidth',
        'location',
        'template',
        'bandwidth',
        'additionalIpsNumber',
        'hdd',
        'ssd',
        'ram',
        'cpuCores',
        'ram',
        'hostname',
        'username',
        'password',
        'monthly_traffic_limit',
        'additional_ips',
        'sshPublicKey',
        'ssh_public_key'
    ];

    /**
     * @var
     */
    protected $module;

    /**
     * @var ClientAdapter
     */
    protected $client;

    /**
     * @var
     */
    protected $params;

    protected $mailer;

    protected $serverModel;

    /**
     * @param $module
     */
    public function __construct($module, $mailer, $serverModel)
    {
        $this->module = $module;
        $this->mailer = $mailer;
        $this->checkOrderId();
        $this->params = $this->module->getAccount();
        $this->serverModel = $serverModel;
        $this->params['clientsdetails'] = $this->module->getClient();
        $this->params['configoptions'] = $this->module->getAccountConfig();
        $this->client = (new EasyDCIMConfigFactory())->fromParams($this->module->connection, $this->params);
    }

    public function checkOrderId()
    {
        $orderId = $this->module->getAccountDetails()['option4']['value'];
        if ($orderId != '')
        {
            throw new \Exception('The order ID field is not empty');
        }
    }

    /**
     * @return array|null
     */
    public function execute(): ?array
    {
        return $this->addOrder($this->client);
    }

    /**
     * Place the EasyDCIM order and record what came back.
     *
     * $param $client insteandof ClientAdapter
     */
    private function addOrder(IClient $client)
    {
        $api = ApiClientFactory::fromClient($client);

        $clientID = $this->getClientID($api, $client);

        $request = new CreateOrderRequest(
            module: 'Server',
            client: (int) $clientID,
            autoAccept: (bool) $client->getBaseFeatures()['autoAccept'],
            criteria: $this->buildCriteria($client),
            service: $this->buildService($api, $client)
        );

        $result = $api->admin()->orders()->create($request);

        $error   = '';
        $orderId = $result->data?->id ?: 0;

        if ($result->success === false)
        {
            $error = $result->hasErrors() ? $result->getErrorsSummary() : '';

            if ($error === '')
            {
                $error = (string) $result->message;
            }
        }

        $this->module->updateDetail('OrderID', $orderId);
        $this->module->updateDetail('LastModuleAction', 'CreateAccount');

        if ($error != '')
        {
            throw new \Exception(ucfirst($error));
        }

        $service = $result->data?->service;

        // The EasyDCIM service ID is what every client-scoped v3 endpoint keys
        // off, so store it alongside the order and device IDs.
        if (!empty($service?->id))
        {
            $this->module->updateDetail('EasyServiceID', $service->id);
        }

        if (!empty($service?->related_id))
        {
            $this->module->updateDetail('ServerID', $service->related_id);

            $synchronize = new Synchronize($client, $this->module, $this->mailer);
            $device = $synchronize->getDeviceInformation($service->related_id);
            $synchronize->saveDedicatedIP($device);

            $createTemplateId = $this->params['options']['CreateServerNotification'];
            $emailTemplates = new EmailNotifications();
            $mail = new Emails($this->mailer);
            $mail->sendServerCreateEmail(
                $client,
                $emailTemplates->getTemplate($createTemplateId),
                $this->params['clientsdetails'],
                $this->params,
                $this->serverModel->getServerDetails($this->params["server_id"])
            );
        }

        return [
            'orderId'          => $orderId,
            'serverId'         => !empty($service?->related_id) ? $service->related_id : '',
            'lastModuleAction' => 'CreateAccount',
        ];
    }

    /**
     * Order criteria - what EasyDCIM should look for when picking a device.
     */
    private function buildCriteria(IClient $client): array
    {
        return [
            'model'            => $client->getModelID(),
            'location'         => $client->getLocationID(),
            'require_pdu'      => $client->getBaseFeatures()['requirePdu'],
            'require_switch'   => $client->getBaseFeatures()['requireSwitch'],
            'require_parts'    => $this->checkPartIsActive($client),
            'require_metadata' => $this->checkMetadataIsActive($client),
            'parts'            => $this->getParts($client),
            'metadata'         => $this->getMetadata($client),
        ];
    }

    /**
     * Order service - how the picked device should be provisioned.
     */
    private function buildService(EasyDCIMClient $api, IClient $client): array
    {
        $service = [
            'hostname'              => $client->getDomain(),
            'template'              => $client->getOsTemplate(),
            'username'              => $client->getUsername(),
            'password'              => $client->getPassword(),
            'root_password'         => $client->getRootPassword(),
            'monthly_traffic_limit' => $client->getBandwidth(),
            'access_level'          => $client->getAcccessLevel(),
        ];

        $additionalIps = $client->getAdditionalIPAddress();

        if (!empty($additionalIps) || $additionalIps != 0)
        {
            $service['additional_ips'] = $this->getAdditionalIP($client);
            $service['additional_ips_number'] = $additionalIps;
        }

        foreach ($this->getCustomInformation() as $key => $value)
        {
            $service[$key] = $value['value'];
        }

        $sshKeys = $this->getOrderSshKeys($api);

        if (!empty($sshKeys))
        {
            $service['ssh_keys'] = $sshKeys;
        }

        return $service;
    }

    /**
     * SSH key IDs to install on the new server.
     *
     * A `sshPublicKey` configurable option lets the client hand over a key at
     * order time. An ID is used as-is; a key body is registered against the
     * EasyDCIM user first, since the order only accepts IDs.
     *
     * @return array<int>
     */
    private function getOrderSshKeys(EasyDCIMClient $api): array
    {
        $options = $this->params['configoptions'] ?? [];

        $value = '';

        foreach (['sshPublicKey', 'ssh_public_key'] as $name)
        {
            if (!empty($options[$name]['value']))
            {
                $value = trim((string) $options[$name]['value']);
                break;
            }
        }

        if ($value === '')
        {
            return [];
        }

        if (is_numeric($value))
        {
            return [(int) $value];
        }

        if (!SshPublicKey::isValid($value))
        {
            return [];
        }

        try
        {
            $response = $api->client()->sshKeys()->create(new CreateSshKeyRequest(
                name: 'HostBill Order Key ' . date('Y-m-d H:i:s'),
                sshKey: $value
            ));

            if ($response->success !== false && !empty($response->data?->id))
            {
                return [(int) $response->data->id];
            }
        }
        catch (\Exception $e)
        {
            // A rejected key must not stop provisioning; the server is created
            // without it and the client can add it from the SSH Keys page.
        }

        return [];
    }

    /**
     * Calculate number of IP addresses
     *
     * $param $client insteandof ClientAdapter
     *
     * @return string
     *
     */
    private function getAdditionalIP(IClient $client)
    {
        $additionalIP = $client->getAdditionalIPAddress();
        if ($additionalIP == 1)
        {
            return '/30';
        }
        $hosts = [];
        $mask  = null;
        for ($i = 1; $i <= 30; $i++)
        {
            $hosts[$i] = (1 << (32 - $i)) - 2;
        }
        for ($i = 30; $i >= 0; $i--)
        {
            if ($hosts[$i] >= $additionalIP)
            {
                $mask = $i;
                break;
            }
        }
        return '/' . $mask;
    }

    /**
     * Metadata criteria, keyed by field ID: [id => ['value' => ...]]
     *
     * $param $client insteandof ClientAdapter
     */
    private function getMetadata(IClient $client): array
    {
        $result = [];

        $metadata = $client->getMetadata();
        $confMetadata = $client->getConfigMetadata();

        if (!empty($metadata))
        {
            foreach ($metadata as $key => $value)
            {
                $metadataValue = $confMetadata['Metadata_' . $key] ?? $value;
                $result[$key] = ['value' => $metadataValue];
            }

            return $result;
        }

        foreach ($confMetadata as $key => $value)
        {
            $arr = explode("_", $key);
            $id = $arr[1];
            $result[$id] = ['value' => $value];
        }

        return $result;
    }

    /**
     * Part criteria, keyed by part type ID:
     * [8 => ['model' => [...], 'hdd.size' => [...]], ...]
     *
     * $param $client insteandof ClientAdapter
     */
    private function getParts(IClient $client): array
    {
        $collected = [
            8  => [],
            9  => [],
            10 => [],
            11 => [],
        ];

        $parts = $client->getParts();
        $confParts = $client->getConfigOptParts();

        if (empty($parts['type']))
        {
            foreach ($confParts as $key => $value) {
                $det = explode('_', $key);
                $typeId = $det[0];
                $modelId = $det[1];

                /**
                 * One model parts with metadata value. Example: 8_6 . Value: 4096|4 GB
                 */
                if (is_numeric($modelId)) {
                    if (isset($collected[$typeId])) {
                        $collected[$typeId][] = [$modelId => $value];
                    }
                }

                /**
                 * CO with multiple models. Example: 8_models.
                 * Value: 9|1TB MODEL 1 or 9_4096|1TB MODEL 1 with 4096 metadata value
                 */
                if ($modelId == 'models' && isset($collected[$typeId])) {
                    if (strpos($value, '_') !== false) {
                        $parsed = explode('_', $value);
                        $collected[$typeId][] = [(int) $parsed[0] => (int) $parsed[1]];
                    } else {
                        $collected[$typeId][] = [$value => ''];
                    }
                }
            }
        }
        else
        {
            foreach ($parts['type'] as $key => $type) {
                $partType = self::PART_TYPE_IDS[$type] ?? null;

                if ($partType === null) {
                    continue;
                }

                $size = $confParts[$partType . "_" . $parts['model'][$key]] ?? $parts['size'][$key];

                $collected[$partType][] = [$parts['model'][$key] => $size];
            }
        }

        $criteriaParts = [];

        foreach ($collected as $typeId => $models) {
            if (empty($models)) {
                continue;
            }

            $criteriaParts[$typeId] = $this->buildPartCriteria($typeId, $models);
        }

        return $criteriaParts;
    }

    /**
     * Flatten [[modelId => size], ...] into the parallel arrays EasyDCIM wants.
     */
    private function buildPartCriteria(int $typeId, array $models): array
    {
        $modelIds = [];
        $sizes = [];

        foreach ($models as $model) {
            $modelId = array_keys($model)[0];
            $modelIds[] = $modelId;
            $sizes[] = $model[$modelId];
        }

        return [
            'model'                       => $modelIds,
            self::PART_SIZE_KEYS[$typeId] => $sizes,
        ];
    }

    /*
     *
     * Get configurable options without disabled
     *
     * @return array $options
     */

    /**
     * @return mixed
     */
    private function getCustomInformation()
    {
        $options = $this->params['configoptions'];
        foreach ($options as $key => $value)
        {
            if (strpos($key, '8') === 0 || strpos($key, '9') === 0 || strpos($key, '10') === 0 || strpos($key, '11') === 0) {
                unset($options[$key]);
            }

            if (in_array($key, $this->disabledOptions) || preg_match('/^[0-9]+:[0-9]+/', $key) || strpos($key, "Metadata") !== false)
            {
                unset($options[$key]);
            }
        }

        return $options;
    }

    /**
     * Check Active Parts
     *
     * $param $client insteandof ClientAdapter
     *
     * @return integer
     *
     */
    private function checkPartIsActive(IClient $client)
    {
        if (!empty($client->getParts()) || !empty($client->getConfigOptParts()))
        {
            return 1;
        }
        return 0;
    }

    /**
     * Check Active Parts
     *
     * $param $client insteandof ClientAdapter
     *
     * @return integer
     *
     */
    private function checkMetadataIsActive(IClient $client)
    {
        if (!empty($client->getMetadata()) || !empty($client->getConfigMetadata()))
        {
            return 1;
        }
        return 0;
    }

    /**
     * Get the EasyDCIM user ID to place the order for, creating the user first
     * if EasyDCIM does not know this email address yet.
     *
     * $param $client insteandof ClientAdapter
     * $return integer
     */
    private function getClientID(EasyDCIMClient $api, IClient $client)
    {
        $existing = $api->admin()->users()->fetchByEmail($client->getEmail());

        if (!empty($existing->data?->id))
        {
            return $existing->data->id;
        }

        return $this->createClient($api, $client);
    }

    /**
     * Create new EASY DCIM user
     *
     * $param $client insteandof ClientAdapter
     * $return integer
     */
    private function createClient(EasyDCIMClient $api, IClient $client)
    {
        $request = new CreateUserRequest(
            email: $client->getEmail(),
            password: $client->getPassword(),
            username: $client->getEmail(),
            firstname: $client->getFirstName(),
            lastname: $client->getLastName(),
            address1: $client->getAddress1(),
            address2: $client->getAddress2(),
            city: $client->getCity(),
            state: $client->getState(),
            postcode: $client->getPostCode(),
            countryCode: $client->getCountryCode(),
            role: $this->getUserRole()
        );

        $response = $api->admin()->users()->create($request);

        if ($response->success === false || empty($response->data?->id))
        {
            $message = $response->hasErrors() ? $response->getErrorsSummary() : (string) $response->message;

            throw new \Exception('Failed to create the EasyDCIM user. ' . $message);
        }

        return $response->data->id;
    }

    /**
     * Get user role
     *
     * $return integer
     *
     */
    private function getUserRole()
    {
        return 2;
    }
}
