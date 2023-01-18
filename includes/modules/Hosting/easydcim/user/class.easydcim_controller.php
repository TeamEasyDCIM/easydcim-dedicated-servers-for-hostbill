<?php

require_once dirname(__DIR__).DS.'vendor/autoload.php';

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;
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
        $this->client = (new EasyDCIMConfigFactory())->fromParams($this->serverDetails,$params['account']);
        $this->api = new EasyDCIM($this->client);
        $this->serverInformation = new ServerInformation($this->api,$this->client);
        $this->generalInformation = new GeneralInformation($this->api,$this->client);
        $this->locationInformation = new LocationInformation($this->api,$this->client);
        $this->bandwidth = new Bandwidth($this->api);
        $this->graphs = new Graphs($this->api);
        $this->serviceActions = new ServiceActions($this->api);
        if (isset($_GET['changeHostname']))
        {
            $this->serverInformation->changeHostname($_GET['formdata']);
        }
        if (isset($_GET['deviceButtonsAction']))
        {
            $this->serviceActions->manageServiceActions($_GET['deviceButtonsAction']);
        }
        $assetsUrl = './includes/modules/Hosting/easydcim/templates/assets';

        $this->template->render(APPDIR_MODULES.'Hosting/easydcim/templates/service_details.tpl');
        $this->template->assign('assetsURL',$assetsUrl);
        $this->template->assign('rawObject',$this);
        $this->template->assign('metadata',$this->serverInformation->getMetadata($params['account']));
        $this->template->assign('configuration',$params['account']['options']);
        $this->template->assign('currentTemplate',$_SESSION['AppSettings']['UserTemplate']);

    }
}