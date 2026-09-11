<?php

require_once dirname(__DIR__).DS.'vendor/autoload.php';

use ModulesGarden\Servers\EasyDCIMv2\App\Api\ApiClientFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Api\EasyDCIMConfigFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages\ServerInformation;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages\GeneralInformation;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages\LocationInformation;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages\Bandwidth;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages\Graphs;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages\ServiceActions;

class easydcim_controller extends HBController
{
    public function accountdetails($params)
    {
        $this->serverDetails = $this->module->connection;
        $params['account']['clientsdetails'] = $this->module->getClient();
        $this->client = (new EasyDCIMConfigFactory())->fromParams($this->serverDetails,$params['account']);
        $this->api = ApiClientFactory::fromClient($this->client);
        $this->serverInformation = new ServerInformation($this->api,$this->client);
        $this->generalInformation = new GeneralInformation($this->api,$this->client);
        $this->locationInformation = new LocationInformation($this->api,$this->client);
        $this->bandwidth = new Bandwidth($this->api,$this->client);
        $this->graphs = new Graphs($this->api,$this->client);
        $this->serviceActions = new ServiceActions($this->api,$this->client);
        if (isset($_GET['changeHostname']))
        {
            $this->serverInformation->changeHostname($_GET['formdata']);
        }
        if (isset($_GET['deviceButtonsAction']))
        {
            $this->serviceActions->manageServiceActions($_GET['deviceButtonsAction']);
        }
        // The Bandwidth widget's "Filter Bandwidth" period, as on the admin page.
        if (isset($_GET['bandwidthPeriod']) && ($params['account']['options']['BlockBandwidthTable'] ?? '') != 'on')
        {
            $this->bandwidth->managePeriod($_GET);
        }
        // "Filter Bandwidth" saved for this service.
        if (isset($_GET['edcSaveScope']))
        {
            \ModulesGarden\Servers\EasyDCIMv2\App\Helpers\ScopeSettings::handleSave($params['account']['id'] ?? null, $_GET);
        }
        $assetsUrl = './includes/modules/Hosting/easydcim/templates/assets';

        $this->template->render(APPDIR_MODULES.'Hosting/easydcim/templates/service_details.tpl');
        $this->template->assign('assetsURL',$assetsUrl);
        $this->template->assign('rawObject',$this);
        $this->template->assign('metadata',$this->serverInformation->getMetadata($params['account']));
        $this->template->assign('configuration',$params['account']['options']);
        $this->template->assign('currentTemplate',$_SESSION['AppSettings']['UserTemplate']);
        // One copy of the module's markup for every theme branch of service_details.tpl.
        $this->template->assign('edcClientBlock', APPDIR_MODULES.'Hosting/easydcim/templates/clientarea_module.tpl');
        $this->template->assign('serviceId', $params['account']['id'] ?? '');
        $this->template->assign('edcLang', \ModulesGarden\Servers\EasyDCIMv2\App\Helpers\UiLang::json());
        $this->template->assign('edcScopes', \ModulesGarden\Servers\EasyDCIMv2\App\Helpers\ScopeSettings::json($params['account']['id'] ?? null));

    }
}