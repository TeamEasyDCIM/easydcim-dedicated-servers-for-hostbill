<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\client\Rebuild\Pages;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;
use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\SystemLogo;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Os\Configuration;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Os\InstallParams;

class Rebuild
{
    /**
     * @var EasyDCIM
     */
    protected $api;
    protected $params;
    protected $addons;

    public function __construct($api,$params)
    {
        $this->api = $api;
        $this->params = $params;
    }

    public function prepareData()
    {
        $caTemplates = $this->params['options']['caTemplates'];
        foreach($caTemplates as $key=>$value)
        {
            $values = explode('_',$value);
            $this->addons = $this->getAddons($values[1]);
            $data[] = [
                'id'=>$values[1],
                'Description'=>$values[0],
                'extras'=>$this->getExtras(),
                'diskLayout'=>$this->getDiskLayout(),
            ];
        }
        return $data;
    }

    public function getDataForModal($templateId)
    {
        $this->addons = $this->getAddons($templateId);
        self::jsonEncode([
            'extras'=>$this->getExtras(),
            'diskLayout'=>$this->getDiskLayout(),
            'username'=>$this->params['username'],
        ]);
    }

    protected function getAddons($templateId)
    {
        $provisioningServerId = $this->api->os->getOsTemplateForLocation($this->params['options']['LocationID'])->id;

        $model = new InstallParams();
        $model->setFilter([
            'server_id' => $provisioningServerId,
            'template_id' => $templateId,
        ]);
        $configuration = new Configuration();
        $configuration->setConfiguration($model);
        $response = $this->api->os->getAddonList($configuration);
        return $response;
    }

    protected function getExtras()
    {
        $options = [];

        foreach ($this->addons as $item) {
            if ($item->type != "disklayout") {
                $options[] = [
                    'key' => $item->id,
                    'value' => $item->description
                ];
            }
        }
        return $options;
    }

    protected function getDiskLayout()
    {
        $options = [];

        foreach ($this->addons as $item) {
            if ($item->type == "disklayout") {
                $options[] = [
                    'key' => $item->id,
                    'value' => $item->description
                ];
            }
        }
        return $options;
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

    public function installOS($data)
    {
        $install    = new InstallParams();
        $install->setTemplate($data['templateCaId']);
        $install->setHostname($data['rebuildHostname']);
        $install->setUsername($data['rebuildUsername']);
        $install->setPassword($data['rebuildPassword']);
        $install->setRootPassword($data['rebuildRootSSHPassword']);
        if (isset($data['rebuildDiskLayout']))
        {
            $install->setDiskAddon($data['rebuildDiskLayout']);
        }
        if (isset($data['rebuildExtras']))
        {
            $install->setDiskAddon($data['rebuildExtras']);
        }

        $configurtation = new Configuration();
        $configurtation->setConfiguration($install);
        $result = $this->api->os->install($configurtation);
        if (isset($result->status) && $result->status == 'error')
        {
            header('HTTP/1.1 400 Bad Request');

            self::jsonEncode([
                'error'=>$result->message
            ]);
        }else
        {
            self::jsonEncode([
                'message'=>$result
            ]);
        }
    }

    public function cancelInstall()
    {
        $result = $this->api->os->cancelInstal();
        if (isset($result->status) && $result->status == 'error')
        {
            header('HTTP/1.1 400 Bad Request');

            self::jsonEncode([
                'error'=>$result->message
            ]);
        }else
        {
            self::jsonEncode([
                'message'=>"Installation was canceled correctlly"
            ]);
        }
    }

    public function getOsInstallInformation()
    {
        $device = $this->api->device->getInformation();
        $response = $this->api->os->installInformation();
        $instalationStatus = $response->status;

        $path = SystemLogo::getLogo($device->metadata->OS);
        return [
          'hostInformation'=>$device->metadata->{'IP Address'},
          'hostname'=>$device->metadata->{'Hostname'},
          'currentOS'=>$device->metadata->OS,
          'osIsCurrentlyBeingInstalled'=>$device->os_installation == '0' ? 'NO' : 'YES',
          'username'=>$this->params['username'],
          'sshPassword'=>$device->metadata->{'SSH Password'},
          'sshRootPassword'=>$device->metadata->{'SSH Root Password'},
          'macAddress'=>$device->metadata->{'MAC Address'},
          'path'=>$path,
          'installationStatus'=>$instalationStatus,
        ];
    }
}