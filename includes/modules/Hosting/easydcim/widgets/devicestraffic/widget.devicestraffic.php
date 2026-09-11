<?php

require_once dirname(__DIR__,2).DS.'vendor/autoload.php';

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters\ClientAdapter;
use ModulesGarden\Servers\EasyDCIMv2\App\Api\ApiClientFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Api\EasyDCIMConfigFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages\Graphs;

class widget_devicestraffic extends HostingWidget
{
    protected $widgetfullname = 'Usage Graphs';
    protected $config = ["smallimg" => "includes/modules/Hosting/easydcim/widgets/devicestraffic/small.png","bigimg" => "includes/modules/Hosting/easydcim/widgets/devicestraffic/big.png"];

    /**
     * @var ClientAdapter
     */
    protected $client;
    /**
     * @var
     */
    protected $params;
    protected $api;

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
        $options = $this->params['options'];
        // Graphs sit under "Device Statistics" and its "View Graphs" switch, as in
        // the WHMCS module; a product saved before "View Graphs" existed keeps them.
        if (($options['TrafficStatistics'] ?? '') != 'on'
            || (isset($options['ViewGraphs']) && $options['ViewGraphs'] != 'on'))
        {
            return 'This page is disabled';
        }
        if (($options['AggregateTraffic'] ?? '') != 'on' && ($options['Ping'] ?? '') != 'on' && ($options['Status'] ?? '') != 'on')
        {
            return 'This page is disabled';
        }
        $this->params['clientsdetails'] = $module->getClient();
        $this->client = (new EasyDCIMConfigFactory())->fromParams($module->connection,$this->params);
        $this->client->getEasyServerID();
        $this->api = ApiClientFactory::fromClient($this->client);
        $this->graphs = new Graphs($this->api,$this->client);
        if (isset($_GET['graphs']))
        {
            $this->graphs->manageEasyDCIMGraphs($_GET);
        }
        $assetsUrl = './includes/modules/Hosting/easydcim/templates/assets';
        $variables = [
            'assetsURL'=>  $assetsUrl,
            'configuration'=>  $this->params['options'],
        ];
        return array('graph.tpl', $variables);
    }
}