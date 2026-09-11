<?php

require_once dirname(__DIR__,2).DS.'vendor/autoload.php';

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters\ClientAdapter;
use ModulesGarden\Servers\EasyDCIMv2\App\Api\ApiClientFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\ExtensionChecker;
use ModulesGarden\Servers\EasyDCIMv2\App\Api\ServiceContext;
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
        $this->api = ApiClientFactory::fromClient($this->client);

        // Reverse DNS is served by the DNS Manager addon; hide it when absent.
        if (!ExtensionChecker::isDnsManagerActive($this->api))
        {
            return 'This page requires the DNS Manager module in EasyDCIM';
        }

        // Reverse DNS is service-scoped in API v3; the context resolves and caches that ID.
        $this->reverseDNS = new ReverseDNS($this->api, new ServiceContext($this->api, $this->client, $module));
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
        if (isset($_GET['massDeleteDNS']))
        {
            $this->reverseDNS->massDelete($_GET['ids'] ?? []);
        }
        $assetsUrl = './includes/modules/Hosting/easydcim/templates/assets';
        $variables = [
            'assetsURL'=>  $assetsUrl,
            'dnsRecords'=> $this->reverseDNS->getDNS(),
            // The usable addresses the create form lists (WHMCS IpsHelper).
            'ipList'=> json_encode($this->reverseDNS->getIPAddresses()),
            'serviceId'=> $this->params['id'] ?? '',
            'edcLang'=> \ModulesGarden\Servers\EasyDCIMv2\App\Helpers\UiLang::json(),
        ];
        return array('reverseDNS.tpl', $variables);

    }

}