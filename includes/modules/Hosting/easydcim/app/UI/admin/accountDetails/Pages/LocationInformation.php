<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages;

use ModulesGarden\Servers\EasyDCIMv2\App\FileReader\Reader;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Device\DeviceData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Interfaces\IClient;

class LocationInformation
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
    protected $locationInformations = null;

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

        $this->locationInformations = $this->api->admin()->devices()->show($deviceId)->data;
    }

    public function getLocationName(): string
    {
        return $this->locationInformations?->location?->name ?: '-';
    }

    public function getAddress(): string
    {
        return $this->locationInformations?->location?->address ?: '-';
    }

    public function getPhoneNumber(): string
    {
        return $this->locationInformations?->location?->phone ?: '-';
    }

    public function getDescription(): string
    {
        return $this->locationInformations?->location?->description ?: '-';
    }

    public function getRackWithPosition(): string
    {
        return $this->locationInformations?->labeledRackWithPosition ?: '-';
    }

    public function getFloor(): string
    {
        return $this->locationInformations?->rack?->floorId ? (string) $this->locationInformations->rack->floorId : '-';
    }

    public function getRackName(): string
    {
        return $this->locationInformations?->rack?->name ?: '-';
    }

    public function getRackLink(): string
    {
        $rackId = $this->locationInformations?->rack?->id;

        if (empty($rackId))
        {
            return '-';
        }

        return $this->client->getServerHostname()
            . $this->configuration['easyDCIM']['racksPath']
            . $rackId
            . $this->configuration['easyDCIM']['endPath'];
    }

    public function getLocationLink(): string
    {
        $locationId = $this->locationInformations?->location?->id;

        if (empty($locationId))
        {
            return '-';
        }

        return $this->client->getServerHostname()
            . $this->configuration['easyDCIM']['locationPath']
            . $locationId
            . $this->configuration['easyDCIM']['endPath'];
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
