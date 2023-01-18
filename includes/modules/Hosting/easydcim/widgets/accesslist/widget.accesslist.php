<?php

require_once dirname(__DIR__,2).DS.'vendor/autoload.php';

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters\ClientAdapter;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\client\AccessList\Pages\AccessList;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;
use ModulesGarden\Servers\EasyDCIMv2\App\Api\EasyDCIMConfigFactory;

class widget_accesslist extends HostingWidget {
    protected $widgetfullname = 'Access List';
    protected $config = ["smallimg" =>'includes/modules/Hosting/easydcim/widgets/accesslist/small.png',"bigimg" => "includes/modules/Hosting/easydcim/widgets/accesslist/big.png"];
    /**
     * @var ClientAdapter
     */
    protected $client;
    /**
     * @var
     */
    protected $params;
    protected $api;
    protected $accessList;

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
        if ($this->params['options']['PasswordManagement'] != 'on')
        {
            return 'This page is disabled';
        }
        $this->params['clientsdetails'] = $module->getClient();
        $this->client = (new EasyDCIMConfigFactory())->fromParams($module->connection,$this->params);
        $this->api = new EasyDCIM($this->client);
        $this->accessList = new AccessList($this->api,$this->client->getEasyServerID());
        $assetsUrl = './includes/modules/Hosting/easydcim/templates/assets';
        $variables = [
          'assetsURL'=>  $assetsUrl,
          'accessList'=> $this->accessList->getData()
        ];
        return array('accessList.tpl', $variables);
    }

}