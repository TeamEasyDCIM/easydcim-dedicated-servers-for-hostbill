<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages;

use ModulesGarden\Servers\EasyDCIMv2\App\FileReader\Reader;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Device\DeviceData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Interfaces\IClient;

class GeneralInformation
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

    protected $configuration = [];

    public function __construct($api, $client)
    {
        $this->api = $api;
        $this->client = $client;
        $this->getDeviceDetails();
        $this->getConfiguration();
    }

    public function getIPAddresses(): string
    {
        $ipAddresses = implode(',', (array) ($this->generalInformations?->ipList ?? []));

        return $ipAddresses != '' ? $ipAddresses : '-';
    }

    public function getServiceStatus(): string
    {
        return $this->generalInformations?->serviceStatus ? ucfirst($this->generalInformations->serviceStatus) : '-';
    }

    public function getDeviceStatus(): string
    {
        return $this->generalInformations?->deviceStatus ?: '-';
    }

    public function getModel(): string
    {
        return $this->generalInformations?->model?->name ?: '-';
    }

    public function getLabel(): string
    {
        return $this->generalInformations?->label ?: '-';
    }

    public function getSerialNumber(): string
    {
        return $this->generalInformations?->serialnumber1 ?: '-';
    }

    public function getStatus(): string
    {
        return $this->generalInformations?->status ? ucfirst($this->generalInformations->status) : '-';
    }

    public function getPurchaseDate(): string
    {
        return $this->generalInformations?->purchaseDate ? (string) $this->generalInformations->purchaseDate : '-';
    }

    public function getWarrantyMonths(): string
    {
        $warrantyMonths = (int) ($this->generalInformations?->warrantyMonths ?? 0);

        if ($warrantyMonths === 0)
        {
            return 'Expired';
        }

        $years = 'Year';
        $months = 'Month';

        if (floor($warrantyMonths / 12) > 1 || floor($warrantyMonths / 12) == 0)
        {
            $years = 'Years';
        }

        if ($warrantyMonths % 12 > 1 || $warrantyMonths % 12 == 0)
        {
            $months = 'Months';
        }

        return floor($warrantyMonths / 12) . ' ' . $years . ' ' . $warrantyMonths % 12 . ' ' . $months;
    }

    public function getOrderID(): string
    {
        return $this->generalInformations?->orderId ? (string) $this->generalInformations->orderId : '-';
    }

    public function getServerID(): string
    {
        return $this->generalInformations?->id ? (string) $this->generalInformations->id : '-';
    }

    public function getOrderLink(): string
    {
        return $this->client->getServerHostname()
            . $this->configuration['easyDCIM']['orderPath']
            . $this->getOrderID()
            . $this->configuration['easyDCIM']['endPath'];
    }

    public function getServerLink(): string
    {
        return $this->client->getServerHostname()
            . $this->configuration['easyDCIM']['serverPath']
            . $this->getServerID()
            . $this->configuration['easyDCIM']['endPath'];
    }

    public function getDeviceDetails()
    {
        $deviceId = $this->client->getEasyServerID();

        if (empty($deviceId))
        {
            return;
        }

        $this->generalInformations = $this->api->admin()->devices()->show($deviceId)->data;
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
