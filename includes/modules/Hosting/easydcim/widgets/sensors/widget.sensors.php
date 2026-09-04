<?php
require_once dirname(__DIR__,2).DS.'vendor/autoload.php';

use ModulesGarden\Servers\EasyDCIMv2\App\Api\ApiClientFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Api\EasyDCIMConfigFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Api\ServiceContext;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\client\Sensors\Pages\Sensors;

class widget_sensors extends HostingWidget
{
    protected $widgetfullname = 'Sensors';

    protected $config = [
        "smallimg" => "includes/modules/Hosting/easydcim/widgets/sensors/small.png",
        "bigimg"   => "includes/modules/Hosting/easydcim/widgets/sensors/big.png",
    ];

    protected $client;

    protected $params;

    protected $api;

    protected $sensors;

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

    public function clientFunction(&$module)
    {
        $this->params = $module->getAccount();

        if ($this->params['options']['Sensors'] != 'on')
        {
            return array('disabledPage.tpl', []);
        }

        $this->params['clientsdetails'] = $module->getClient();
        $this->client = (new EasyDCIMConfigFactory())->fromParams($module->connection,$this->params);
        $this->api = ApiClientFactory::fromClient($this->client);
        // Sensors are service-scoped in API v3; the context resolves that ID.
        $this->sensors = new Sensors($this->api, new ServiceContext($this->api, $this->client, $module));

        if (isset($_GET['sensorGraph']))
        {
            $this->sensors->getGraph($_GET);
        }

        if (isset($_GET['getSensors']))
        {
            $this->sensors->getJSONSensors();
        }

        $assetsUrl = './includes/modules/Hosting/easydcim/templates/assets';

        return array('sensors.tpl', [
            'assetsURL' => $assetsUrl,
            'sensors'   => $this->sensors->getData(),
        ]);
    }
}
