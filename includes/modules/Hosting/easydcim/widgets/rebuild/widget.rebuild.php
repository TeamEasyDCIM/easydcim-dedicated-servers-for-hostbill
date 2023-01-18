<?php

require_once dirname(__DIR__,2).DS.'vendor/autoload.php';

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters\ClientAdapter;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;
use ModulesGarden\Servers\EasyDCIMv2\App\Api\EasyDCIMConfigFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\client\Rebuild\Pages\Rebuild;

class widget_rebuild extends HostingWidget
{
    protected $widgetfullname = 'Rebuild';
    protected $config = ["smallimg" => "includes/modules/Hosting/easydcim/widgets/rebuild/small.png","bigimg" => "includes/modules/Hosting/easydcim/widgets/rebuild/big.png"];

    /**
     * @var ClientAdapter
     */
    protected $client;
    /**
     * @var
     */
    protected $params;
    protected $api;
    protected $rebuild;

    protected function setIconConfig()
    {
        $default = function ($filename) {
            return $filename;
        };
        if (!$this->config["smallimg"]) {
            $p = $this->getWidgetURIPath() . "/";
            $this->config["smallimg"] = $p . "small.png";
        }
        if (!$this->config["bigimg"]) {
            if (!$p) {
                $p = $this->getWidgetURIPath() . "/";
            }
            $this->config["bigimg"] = $p . "big.png";
        }
        $this->config["smallimg"] = $default($this->config["smallimg"]);
        $this->config["bigimg"] = $default($this->config["bigimg"]);
    }

    /**
     * HostBill will call this function when widget is visited from clientarea
     * @param HostingModule $module Your provisioning module object
     * @return array|string
     */
    public function clientFunction(&$module) {
        $this->params = $module->getAccount();
        if ($this->params['options']['OsInstallation'] != 'on')
        {
            return 'This page is disabled';
        }
        $this->params['clientsdetails'] = $module->getClient();
        $this->client = (new EasyDCIMConfigFactory())->fromParams($module->connection,$this->params);
        $this->api = new EasyDCIM($this->client);
        $this->rebuild = new Rebuild($this->api,$this->params);
        if (isset($_GET['reloadRebuild']))
        {
           self::jsonEncode($this->rebuild->getOsInstallInformation());
        }
        if (isset($_GET['osTemplateID']))
        {
            $this->rebuild->getDataForModal($_GET['osTemplateID']);
        }
        if (isset($_GET['rebuild']))
        {
            $this->rebuild->installOS($_GET['formdata']);
        }
        if (isset($_GET['cancelInstallation']))
        {
            $this->rebuild->cancelInstall();
        }
        $assetsUrl = './includes/modules/Hosting/easydcim/templates/assets';
        $variables = [
            'assetsURL'=>  $assetsUrl,
            'caTemplates'=>  json_encode($this->rebuild->prepareData()),
            'installationInformation'=> $this->rebuild->getOsInstallInformation(),
            'jsonEncodeinstallationInformation'=> json_encode($this->rebuild->getOsInstallInformation()),
        ];
        return array('rebuild.tpl', $variables);
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
}