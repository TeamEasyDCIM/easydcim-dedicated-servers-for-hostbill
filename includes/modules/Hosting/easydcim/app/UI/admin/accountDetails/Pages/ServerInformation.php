<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages;

use ModulesGarden\Servers\EasyDCIMv2\App\FileReader\Reader;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Device\AssignMetadataRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Device\DeviceData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Interfaces\IClient;

class ServerInformation
{
    /**
     * @var EasyDCIMClient
     */
    protected $api;

    /**
     * @var IClient
     */
    protected $client;

    /**
     * @var DeviceData|null
     */
    protected $generalInformations = null;

    /**
     * Human-readable OS installation state, empty when nothing is running.
     */
    protected $instalationStatus = '';

    protected $configuration = [];

    public function __construct($api, $client)
    {
        $this->api = $api;
        $this->client = $client;
        $this->getDeviceDetails();
        $this->getConfiguration();
    }

    public function getDeviceDetails()
    {
        $deviceId = $this->client->getEasyServerID();

        if (empty($deviceId))
        {
            return;
        }

        $this->generalInformations = $this->api->admin()->devices()->show($deviceId)->data;

        // API v3 reports the provisioning state as a message; there is no
        // separate status field the way v2 had one.
        $response = $this->api->admin()->osInstallation()->getOsInstallationInfo($deviceId);
        $this->instalationStatus = (string) (($response->data === null ? null : $response->data->message) ?? '');
    }

    public function getIPAddresses(): string
    {
        $ipAddresses = implode('<br>', (array) (($this->generalInformations === null ? null : $this->generalInformations->ipList) ?? []));

        return $ipAddresses != '' ? $ipAddresses : '-';
    }

    public function getServiceStatus(): string
    {
        return ($this->generalInformations === null ? null : $this->generalInformations->serviceStatus) ? ucfirst($this->generalInformations->serviceStatus) : '-';
    }

    public function getDeviceStatus(): string
    {
        return ($this->generalInformations === null ? null : $this->generalInformations->deviceStatus) ? ucfirst($this->generalInformations->deviceStatus) : '-';
    }

    public function getLabel(): string
    {
        return ($this->generalInformations === null ? null : $this->generalInformations->label) ?: '-';
    }

    public function getHostname(): string
    {
        return $this->getMetadataValue('Hostname') ?: '-';
    }

    public function getMacAddress(): string
    {
        return $this->getMetadataValue('MAC Address') ?: '-';
    }

    public function getCurrentOS(): string
    {
        return $this->getMetadataValue('OS') ?: '-';
    }

    public function getInstallationStatus(): string
    {
        return $this->instalationStatus;
    }

    public function getServiceID(): string
    {
        return (string) ($this->client->getEasyServiceID() ?? '-');
    }

    public function getServerID(): string
    {
        return ($this->generalInformations === null ? null : $this->generalInformations->id) ? (string) $this->generalInformations->id : '-';
    }

    public function getServerLink(): string
    {
        return $this->client->getServerHostname()
            . $this->configuration['easyDCIM']['serverPath']
            . $this->getServerID()
            . $this->configuration['easyDCIM']['endPath'];
    }

    /**
     * Metadata rows the product is configured to surface.
     */
    /**
     * @param string $selection option holding the chosen fields - "caMetadata" for
     *                          the client area, "caMetadataAdmin" for the admin area
     */
    public function getMetadata($productSettings, string $selection = 'caMetadata')
    {
        $options = $productSettings['options'];

        // The admin selection came later; until a product is saved with it, the
        // admin area keeps showing the client-area fields.
        if (!isset($options[$selection]))
        {
            $selection = 'caMetadata';
        }

        // The product page posts an empty entry so "nothing selected" still saves.
        $caMetadata = array_filter((array) ($options[$selection] ?? []), 'strlen');
        $data = [];

        foreach ($caMetadata as $key => $value)
        {
            if ($value == "IP Address" && $productSettings['options']['IPAddresses'] == 'on'
                || $value == "MAC Address" && $productSettings['options']['MacAddress'] == 'on')
            {
                continue;
            }

            if ($value == "SSH Password" || $value == "SSH Root Password")
            {
                $data[] = [
                    'header' => $value,
                    'value'  => $this->getMetadataValue($value),
                ];

                continue;
            }

            $data[] = [
                'header' => $value,
                'value'  => $this->getMetadataValue($value) ?: '-',
            ];
        }

        return $data;
    }

    /**
     * API v3 returns device metadata as a plain array keyed by field label.
     */
    protected function getMetadataValue(string $key): string
    {
        return (string) (($this->generalInformations === null ? null : $this->generalInformations->metadata)[$key] ?? '');
    }

    public function changeHostname($data)
    {
        $deviceId = $this->client->getEasyServerID();

        $result = $this->api->admin()->devices()->assignMetadata(
            $deviceId,
            new AssignMetadataRequest('hostname', (string) $data['changeHostname'])
        );

        if ($result->success === false)
        {
            header('HTTP/1.1 400 Bad Request');
            self::jsonEncode([
                'error' => $result->message
            ]);
        }

        self::jsonEncode([
            'message' => 'Hostname has been changed successfully.'
        ]);
    }

    public static function jsonEncode(array $data)
    {
        ob_clean();
        echo(json_encode([
            'data' => $data
        ]));
        die;
    }

    private function getPath()
    {
        return dirname(__DIR__, 5) . DS . 'app' . DS . 'Config' . DS . 'configuration.json';
    }

    private function getConfiguration()
    {
        $file = Reader::read($this->getPath());
        $this->configuration = $file->get();
    }
}
