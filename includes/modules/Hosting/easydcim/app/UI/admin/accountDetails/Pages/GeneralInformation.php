<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages;

use ModulesGarden\Servers\EasyDCIMv2\App\FileReader\Reader;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters\ClientAdapter;

class GeneralInformation
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
    protected $generalInformations = [];

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

    /**
     * @return string
     */
    public function getIPAddresses(): string
    {
        $ipAddresses = implode(',',$this->generalInformations->ip_addresses);
        return  $ipAddresses != '' ? $ipAddresses :'-';
    }

    /**
     * @return string
     */
    public function getServiceStatus(): string
    {
        return $this->generalInformations->service_status != '' ? ucfirst($this->generalInformations->service_status) :'-';
    }

    /**
     * @return string
     */
    public function getDeviceStatus(): string
    {
        return $this->generalInformations->device_status != '' ? $this->generalInformations->device_status :'-';
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->generalInformations->model != '' ? $this->generalInformations->model :'-';
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->generalInformations->label != '' ? $this->generalInformations->label :'-';
    }

    /**
     * @return string
     */
    public function getSerialNumber(): string
    {
        return $this->generalInformations->serialnumber1 != '' ? $this->generalInformations->serialnumber1 :'-';
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->generalInformations->status != '' ? ucfirst($this->generalInformations->status) :'-';
    }

    /**
     * @return string
     */
    public function getPurchaseDate(): string
    {
        return $this->generalInformations->purchase_date != '' ? $this->generalInformations->purchase_date :'-';
    }

    /**
     * @return string
     */
    public function getWarrantyMonths(): string
    {
        if ($this->generalInformations->warranty_months == '')
        {
//            return sl('lang')->tr('Expired');
            return 'Expired';
        }
        $years = 'Year';
        $months = 'Month';
        if (floor(intval($this->generalInformations->warranty_months)/12) > 1 || floor(intval($this->generalInformations->warranty_months)/12) == 0)
        {
            $years = 'Years';
        }
        if (intval($this->generalInformations->warranty_months)%12 > 1 || intval($this->generalInformations->warranty_months)%12 == 0)
        {
            $months = 'Months';
        }
        return floor(intval($this->generalInformations->warranty_months)/12) . ' ' .$years .  ' ' . intval($this->generalInformations->warranty_months)%12 . ' ' .  $months ;
    }

    /**
     * @return string
     */
    public function getOrderID(): string
    {
        return $this->generalInformations->order_id != '' ? $this->generalInformations->order_id :'-';
    }

    /**
     * @return string
     */
    public function getServerID(): string
    {
        return $this->generalInformations->id != '' ? $this->generalInformations->id :'-';
    }

    /**
     * @return string
     */
    public function getOrderLink():string
    {
        return $this->client->getServerHostname().$this->configuration['easyDCIM']['orderPath'].$this->generalInformations->order_id.$this->configuration['easyDCIM']['endPath'];
    }

    /**
     * @return string
     */
    public function getServerLink():string
    {
        return $this->client->getServerHostname().$this->configuration['easyDCIM']['serverPath'].$this->generalInformations->id.$this->configuration['easyDCIM']['endPath'];
    }


    public function getDeviceDetails()
    {
        $this->generalInformations = $this->api->device->getInformation();
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