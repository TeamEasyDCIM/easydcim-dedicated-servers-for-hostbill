<?php
require_once dirname(__DIR__,2).DS.'vendor/autoload.php';

use ModulesGarden\Servers\EasyDCIMv2\App\Api\ApiClientFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Api\EasyDCIMConfigFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\client\SshKeys\Pages\SshKeys;

/**
 * HostBill names a widget after its class (widget_<name>), and ships its own
 * "sshkeys" widget - hence "edsshkeys", like "edreversedns".
 */
class widget_edsshkeys extends HostingWidget
{
    protected $widgetfullname = 'SSH Keys';

    protected $config = [
        "smallimg" => "includes/modules/Hosting/easydcim/widgets/edsshkeys/small.png",
        "bigimg"   => "includes/modules/Hosting/easydcim/widgets/edsshkeys/big.png",
    ];

    protected $client;

    protected $params;

    protected $api;

    protected $sshKeys;

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

        // SSH keys sit under "OS Installation", as in the WHMCS module.
        if (($this->params['options']['OsInstallation'] ?? '') != 'on' || ($this->params['options']['SshKeys'] ?? '') != 'on')
        {
            return array('disabledPage.tpl', []);
        }

        $this->params['clientsdetails'] = $module->getClient();
        $this->client = (new EasyDCIMConfigFactory())->fromParams($module->connection,$this->params);
        $this->api = ApiClientFactory::fromClient($this->client);
        $this->sshKeys = new SshKeys($this->api);

        if (isset($_GET['createSshKey']))
        {
            $this->sshKeys->create($_GET['formdata']);
        }

        if (isset($_GET['editSshKey']))
        {
            $this->sshKeys->update($_GET['formdata']);
        }

        if (isset($_GET['deleteSshKey']))
        {
            $this->sshKeys->delete($_GET['formdata']);
        }

        if (isset($_GET['defaultSshKey']))
        {
            $this->sshKeys->setAsDefault($_GET['formdata']);
        }

        if (isset($_GET['getSshKeys']))
        {
            $this->sshKeys->getJSONKeys();
        }

        $assetsUrl = './includes/modules/Hosting/easydcim/templates/assets';

        $variables = [
            'assetsURL' => $assetsUrl,
            'sshKeys'   => $this->sshKeys->getData(),
            'serviceId' => $this->params['id'] ?? '',
            'edcLang'   => \ModulesGarden\Servers\EasyDCIMv2\App\Helpers\UiLang::json(),
        ];

        return array('edsshkeys.tpl', $variables);
    }
}
