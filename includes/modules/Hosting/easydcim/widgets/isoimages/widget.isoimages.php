<?php

require_once dirname(__DIR__,2).DS.'vendor/autoload.php';

use ModulesGarden\Servers\EasyDCIMv2\App\Api\EasyDCIMConfigFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters\ClientAdapter;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\client\IsoImages\Pages\IsoImages;

class widget_isoimages extends HostingWidget
{
    protected $widgetfullname = 'ISO Images';
    protected $config = ["smallimg" => "includes/modules/Hosting/easydcim/widgets/isoimages/small.png","bigimg" => "includes/modules/Hosting/easydcim/widgets/isoimages/big.png"];

    /**
     * @var ClientAdapter
     */
    protected $client;
    /**
     * @var
     */
    protected $params;
    protected $api;
    protected $isoImages;

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
        if ($this->params['options']['IsoImages'] != 'on' || $this->params['options']['OsInstallation'] != 'on')
        {
            return array('disabledPage.tpl', $variables);
        }
        $this->params['clientsdetails'] = $module->getClient();
        $this->client = (new EasyDCIMConfigFactory())->fromParams($module->connection,$this->params);
        $this->client->getEasyServerID();
        $this->api = new EasyDCIM($this->client);
        $this->isoImages = new IsoImages($this->api,$this->client);
        if (isset($_GET['createIsoImage']))
        {
            $this->isoImages->create($_GET['formdata']);
        }
        if (isset($_GET['editIsoImage']))
        {
            $this->isoImages->update($_GET['formdata']);
        }
        if (isset($_GET['deleteIsoImage']))
        {
            $this->isoImages->delete($_GET['formdata']);
        }
        if (isset($_GET['getIsoImages']))
        {
            $this->isoImages->getJSONIsoImages();
        }
        $assetsUrl = './includes/modules/Hosting/easydcim/templates/assets';
        $variables = [
            'assetsURL'=>  $assetsUrl,
            'isoImages'=>  $this->isoImages->getIsoImages(),
        ];
        return array('isoimages.tpl', $variables);
    }
}