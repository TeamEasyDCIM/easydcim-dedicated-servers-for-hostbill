<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages;

use ModulesGarden\Servers\EasyDCIMv2\App\FileReader\Reader;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Devices\Metadata;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters\ClientAdapter;

class ServerInformation
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

    public function getDeviceDetails()
    {
        $this->generalInformations = $this->api->device->getInformation();
        $response = $this->api->os->installInformation();
        $this->instalationStatus = $response->status;
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
        return $this->generalInformations->device_status != '' ? ucfirst($this->generalInformations->device_status) :'-';
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
    public function getHostname(): string
    {
        return $this->generalInformations->metadata->{'Hostname'} != '' ? $this->generalInformations->metadata->{'Hostname'} :'-';
    }

    /**
     * @return string
     */
    public function getMacAddress(): string
    {
        return $this->generalInformations->metadata->{'MAC Address'} != '' ? $this->generalInformations->metadata->{'MAC Address'} :'-';
    }

    /**
     * @return string
     */
    public function getCurrentOS(): string
    {
        return $this->generalInformations->metadata->{'OS'} != '' ? $this->generalInformations->metadata->{'OS'} :'-';
    }

    /**
     * @return string
     */
    public function getInstallationStatus(): string
    {
        return $this->instalationStatus != '' ? $this->instalationStatus :'-';
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
    public function getServerLink():string
    {
        return $this->client->getServerHostname().$this->configuration['easyDCIM']['serverPath'].$this->generalInformations->id.$this->configuration['easyDCIM']['endPath'];
    }

    public function getMetadata($productSettings)
    {
        $caMetadata = $productSettings['options']['caMetadata'];
        $data = [];
        foreach($caMetadata as $key=>$value)
        {
            if ($value == "IP Address" && $productSettings['options']['IPAddresses'] == 'on' || $value == "MAC Address" && $productSettings['options']['MacAddress'] == 'on')
            {
            }
            elseif($value == "SSH Password" || $value == "SSH Root Password"){
                $data[] = [
                    'header'=>$value,
                    'value'=>$this->generalInformations->metadata->{$value},
                ];
            }
            else{
                $data[] = [
                    'header'=>$value,
                    'value'=>$this->generalInformations->metadata->{$value} == ''? '-':$this->generalInformations->metadata->{$value},
                ];
            }
        }
        return $data;
    }

    public function changeHostname($data)
    {
        $metadataModel = new Metadata();
        $metadataModel->setSlug('hostname')
            ->setValue($data['changeHostname']);
        $result = $this->api->device->assignMetadata($metadataModel);
        if (isset($result->status) && $result->status == 'error')
        {
            header('HTTP/1.1 400 Bad Request');

            self::jsonEncode([
                'error'=>$result->message
            ]);
        }else
        {
            self::jsonEncode([
                'message'=>'Hostname has been changed successfully.'
            ]);
        }
    }

    /**
     * @param array $data
     */
    public static function jsonEncode(array $data)
    {
        ob_clean();
        echo(json_encode([
            'data'=>$data
        ]));
        die;
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