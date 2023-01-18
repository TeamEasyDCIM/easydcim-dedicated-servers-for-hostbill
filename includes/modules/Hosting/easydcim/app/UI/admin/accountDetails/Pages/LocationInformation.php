<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters\ClientAdapter;
use ModulesGarden\Servers\EasyDCIMv2\App\FileReader\Reader;

class LocationInformation
{
    /**
     * @var EasyDCIM
     */
    protected $api;

    /**
     * @var ClientAdapter
     */
    protected $client;

    /**
     * @var array
     */
    protected $locationInformations = [];

    /**
     * @var string
     */
    protected $instalationStatus = [];

    /**
     * @var array
     */
    protected $configuration = [];

    public function __construct($api,$client)
    {
        $this->api = $api;
        $this->client = $client;
        $this->getDeviceDetails();
        $this->getConfiguration();
    }

    public function getDeviceDetails()
    {
        $this->locationInformations = $this->api->device->getInformation();
    }

    /**
     * @return string
     */
    public function getLocationName(): string
    {
        return $this->locationInformations->location->name ?? '-';
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->locationInformations->location->address ?? '-';
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->locationInformations->location->phone ?? '-';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->locationInformations->location->description ?? '-';
    }

    /**
     * @return string
     */
    public function getRackWithPosition(): string
    {
        return $this->locationInformations->labeledRackWithPosition ?? '-';
    }

    /**
     * @return string
     */
    public function getFloor(): string
    {
        return $this->locationInformations->rack->floor_id ?? '-';
    }

    /**
     * @return string
     */
    public function getRackName(): string
    {
        return $this->locationInformations->rack->name ?? '-';
    }

    /**
     * @return string
     */
    public function getRackLink():string
    {
        return $this->client->getServerHostname().$this->configuration['easyDCIM']['racksPath'].$this->locationInformations->rack->id.$this->configuration['easyDCIM']['endPath'] ?? '-';
    }

    /**
     * @return string
     */
    public function getLocationLink():string
    {
        return $this->client->getServerHostname().$this->configuration['easyDCIM']['locationPath'].$this->locationInformations->location->id.$this->configuration['easyDCIM']['endPath'] ?? '-';
    }

    private function getPath()
    {
        return dirname(__DIR__,5) . DS . 'app' . DS . 'Config' . DS . 'configuration.json';
    }

    private function getConfiguration()
    {
        $file = Reader::read($this->getPath());
        $this->configuration =  $file->get();
    }
}