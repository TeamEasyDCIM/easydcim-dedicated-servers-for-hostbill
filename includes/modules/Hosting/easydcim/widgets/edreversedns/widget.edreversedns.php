<?php

require_once dirname(__DIR__,2).DS.'vendor/autoload.php';

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters\ClientAdapter;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;
use ModulesGarden\Servers\EasyDCIMv2\App\Api\EasyDCIMConfigFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\client\ReverseDNS\Pages\ReverseDNS;

class widget_edreversedns extends HostingWidget
{
    protected $widgetfullname = 'Reverse DNS';
    protected $config = ["smallimg" => "includes/modules/Hosting/easydcim/widgets/edreversedns/small.png","bigimg" => "includes/modules/Hosting/easydcim/widgets/edreversedns/big.png"];

    /**
     * @var ClientAdapter
     */
    protected $client;
    /**
     * @var
     */
    protected $params;
    protected $api;
    protected $reverseDNS;

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
        if ($this->params['options']['DNSManager'] != 'on')
        {
            return 'This page is disabled';
        }
        $this->params['clientsdetails'] = $module->getClient();
        $this->client = (new EasyDCIMConfigFactory())->fromParams($module->connection,$this->params);
        $this->api = new EasyDCIM($this->client);
        $this->reverseDNS = new ReverseDNS($this->api);
        if (isset($_GET['reverseDNS']))
        {
            $this->reverseDNS->create($_GET['formdata']);
        }
        if (isset($_GET['editDNS']))
        {
            $this->reverseDNS->update($_GET['formdata']);
        }
        if (isset($_GET['deleteDNS']))
        {
            $this->reverseDNS->delete($_GET['formdata']);
        }
        $assetsUrl = './includes/modules/Hosting/easydcim/templates/assets';
        $variables = [
            'assetsURL'=>  $assetsUrl,
            'ipAddresses'=> $this->reverseDNS->getIPAddresses(),
            'jsonIpAddresses'=> json_encode($this->reverseDNS->getIPAddresses()),
            'dnsRecords'=> $this->reverseDNS->getDNS(),
        ];
        return array('reverseDNS.tpl', $variables);

    }

}