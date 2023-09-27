<?php

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Database\Database;
use Illuminate\Database\Connection;
use ModulesGarden\Servers\EasyDCIMv2\App\Api\EasyDCIMConfigFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections\DefaultOptions;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections\AutomationSettings;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections\AdditionalParts;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections\ClientAreaFeatures;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections\EmailNotifications;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages\ServerInformation;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages\GeneralInformation;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages\LocationInformation;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages\Bandwidth;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages\Graphs;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages\ServiceActions;
use ModulesGarden\Servers\EasyDCIMv2\App\FileReader\Reader;

class easydcim_controller extends HBController
{
    protected $db;
    protected $hostBillApi;
    protected $serverDetails;
    protected $client;
    protected $api;
    protected $defaultOptions;
    protected $automationSettings;
    protected $additionalParts;
    protected $clientAreaFeatures;
    protected $emailNotifications;
    protected $configuration;
    protected $lang;
    public $serverInformation;
    public $generalInformation;
    public $locationInformation;
    public $bandwidth;
    protected $graphs;
    protected $serviceActions;
    protected $servers;
    protected $configFieldsModel;

    public function productdetails($params)
    {
        $db = new Database();
        $this->db = $db->getConnection();
        $serverId = $this->getServerId($params['id']);
        if ($serverId != null && $serverId != '')
        {
            $this->configFieldsModel = HBLoader::LoadModel("ConfigFields");
            $serverHelper = HBLoader::LoadModel('Servers');
            $this->servers = $serverHelper->findServersBy('module','easydcim');
            $this->serverDetails = $this->getServerDetails($this->getServerId($params['id']));
            $this->configuration = $this->module->getOptions()['simple'];
            $this->client = (new EasyDCIMConfigFactory())->fromParams($this->serverDetails);
            $this->api = new EasyDCIM($this->client);
            $this->defaultOptions = new DefaultOptions($this->api);
            $this->automationSettings = new AutomationSettings($this->api);
            $this->additionalParts = new AdditionalParts($this->api);
            $this->clientAreaFeatures = new ClientAreaFeatures($this->api);
            $this->emailNotifications = new EmailNotifications($this->db);
            if (isset($_GET['createConfigurableOptions']))
            {
                $this->createConfigurableOptions($params['id']);
            }
            if (isset($_GET['createConfigurableOptionsForParts']))
            {
                $this->createConfigurableOptionsForParts($params['id'],$_GET['configurableOptionPartType'],$_GET['configurableOptionPartModel'],$_GET['configurableOptionPartTypeName'],$_GET['configurableOptionPartModelName']);
            }
            if (isset($_GET['createConfigurableOptionsForMetadata']))
            {
                $this->createConfigurableOptionsForMetadata($params['id'],$_GET['configurableOptionMetadataId'],$this->api);
            }
            if (isset($_GET['partType']))
            {
                $this->additionalParts->getTypes($_GET['partType']);
            }
            if (isset($_GET['metadataType']))
            {
                self::jsonEncode(['fieldData'=>$this->api->system->showField($_GET['metadataType'])]);
            }
            if (isset($_GET['partTypeName']) && isset($_GET['partTypeId']))
            {
                $this->additionalParts->getTypes($_GET['partTypeName']);
            }
            if (isset($_GET['getSettings']))
            {
                $this->additionalParts->getParts($this->parseConfig()->parts);
            }
            if (isset($_GET['getMetadataSettings']))
            {
                $this->getMetadataSettings($this->parseConfig()->metadata);
            }
            if (isset($_GET['reloadSelectsForLocation']))
            {
                $result['templates'] = $this->defaultOptions->getTemplateList($_GET['locationId']);
                $result['addons'] = $this->defaultOptions->getAddonsList($_GET['osTemplateId'],$_GET['locationId']);
                self::jsonEncode($result);
            }
            if (isset($_GET['reloadSelectsForOsTemplate']))
            {
                $result['addons'] = $this->defaultOptions->getAddonsList($_GET['osTemplateId'],$_GET['locationId']);
                self::jsonEncode($result);
            }
            if (isset($_GET['metadataSelect']))
            {
                self::jsonEncode($this->clientAreaFeatures->getFields());
            }

            $path = APPDIR_MODULES.'Hosting/easydcim/templates/myproductconfig.tpl';
            $assetsUrl = '.././includes/modules/Hosting/easydcim/templates/assets';
            $config = $this->parseConfig();
            $this->template->assign('customconfig',$path);
            $this->template->assign('assetsURL',$assetsUrl);
            $this->template->assign('locationList',$this->defaultOptions->getLocationList());
            $this->template->assign('modelList',$this->defaultOptions->getModelList());
            $this->template->assign('templateList',$this->defaultOptions->getTemplateList($config->LocationID));
            $this->template->assign('addonsList',$this->defaultOptions->getAddonsList($config->OsTemplateID,$config->LocationID));
            $this->template->assign('accessLevelList',$this->automationSettings->getAccessLevelList());
            $this->template->assign('caTemplateList',$this->defaultOptions->getTemplateList($config->LocationID));
            $this->template->assign('metadataList',$this->clientAreaFeatures->getFields());
            $this->template->assign('adminList',$this->emailNotifications->getAdmins());
            $this->template->assign('adminEmailTemplateList',$this->emailNotifications->getAdminEmailTemplates());
            $this->template->assign('clientEmailTemplateList',$this->emailNotifications->getClientEmailTemplates());
            $this->template->assign('moduleConfiguration',$config);
            $this->template->assign('configurableOptions',$this->configFieldsModel->exportData($params['id']));
            $this->template->assign('productId',$params['id']);
        }

    }

    public function accountdetails($params)
    {
        if ($params['account']['extra_details']['option5'] == '' || $params['account']['extra_details']['option4'] == '' || $params['account']['status'] != 'Active')
        {
            $path = APPDIR_MODULES.'Hosting/easydcim/templates/source.tpl';
            $assetsUrl = '.././includes/modules/Hosting/easydcim/templates/assets';

            $this->template->assign('custom_template',$path);
            $this->template->assign('assetsURL',$assetsUrl);
        }else
        {
            $serverHelper = HBLoader::LoadModel('Servers');
            $this->servers = $serverHelper->findServersBy('module','easydcim');
            $clientModel = HBLoader::LoadModel("Clients");
            $clientData = $clientModel->getClient($params['account']['client_id']);
            $params['account']['clientsdetails'] = $clientData;
            $db = new Database();
            $this->db = $db->getConnection();
            $this->serverDetails = $this->getServerDetails($this->getServerId($params['account']['product_id']));
            $this->client = (new EasyDCIMConfigFactory())->fromParams($this->serverDetails,$params['account']);
            $this->api = new EasyDCIM($this->client);
            $this->serverInformation = new ServerInformation($this->api,$this->client);
            $this->generalInformation = new GeneralInformation($this->api,$this->client);
            $this->locationInformation = new LocationInformation($this->api,$this->client);
            $this->bandwidth = new Bandwidth($this->api);
            $this->graphs = new Graphs($this->api);
            $this->serviceActions = new ServiceActions($this->api,$this->client);

            if (isset($_GET['graphs']))
            {
                $this->graphs->manageEasyDCIMGraphs($_GET);
            }
            if (isset($_GET['deviceButtonsAction']))
            {
                $this->serviceActions->manageServiceActions($_GET['deviceButtonsAction']);
            }
            $path = APPDIR_MODULES.'Hosting/easydcim/templates/adminarea.tpl';
            $assetsUrl = '.././includes/modules/Hosting/easydcim/templates/assets';

            $this->template->assign('custom_template',$path);
            $this->template->assign('assetsURL',$assetsUrl);
            $this->template->assign('rawObject',$this);
            $this->template->assign('metadata',$this->serverInformation->getMetadata($params['account']));
            $this->template->assign('lang',$lang);
        }

    }

    protected function getServerDetails($serverId):array
    {
        foreach ($this->servers as $key=>$value)
        {
            if ($value['id'] == $serverId)
            {
                $serverConfig = [
                    'secure' => $value['secure'] == '1' ? 'on': '',
                    'ip' => $value['ip'],
                    'host' => $value['host'],
                    'username' => $value['username'],
                    'password' => $value['password'],
                ];
            }
        }

        return $serverConfig;
    }

    protected function getMetadataSettings($metadataSettings)
    {
        $metadata = [];
        foreach ($metadataSettings as $key=>$value)
        {
            $field = $this->api->system->showField($key);
            $field->settingsValue = $value;
            $metadata[] = $field;
        }

        self::jsonEncode([
            'metadata'=>$metadata
        ]);
    }

    protected function getServerId($productId)
    {
        return $this->db->table('hb_products_modules')->where('product_id','=',$productId)->first()->server;
    }

    protected function updateProductConfig($config,$pid)
    {
        $this->db->table('hb_products_modules')->where('product_id','=',$pid)->update([
           'options'=>$config
        ]);
    }

    protected function parseConfig()
    {
        foreach($this->configuration as $key=>$value)
        {
            if ($key != 'caTemplates')
            {
                $this->configuration[$key] = $value['value'];

            }else
            {
                foreach ($value['value'] as $key1=>$value1)
                {
                    $values = explode('_',$value1);
                    $value['value'][$key1] = $values[1];
                }
                $this->configuration[$key] = $value['value'];
            }
        }
        return (object)$this->configuration;
    }

    private function getPath()
    {
        return dirname(__DIR__) . DS . 'app' . DS . 'Config' . DS . 'configurableOptions.json';
    }

    private function getConfiguration()
    {
        $file = Reader::read($this->getPath());
        return  $file->get();
    }

    private function createConfigurableOptions($productId)
    {
        $config = $this->getConfiguration();

        foreach ($this->defaultOptions->getLocationList() as $key=>$value)
        {
            $locationItems[] = [
                "id" => $value->id,
                "category_id" => 9,
                "name" => $value->name,
                "variable_id" => $value->id,
            ];
        }
        foreach ($this->defaultOptions->getModelList('Server') as $key=>$value)
        {
            $modelItems[] = [
                "id" => $value->id,
                "category_id" => 9,
                "name" => $value->name,
                "variable_id" => $value->id,
            ];
        }
        foreach ($this->defaultOptions->getTemplateList($this->parseConfig()->LocationID) as $key=>$value)
        {
            $templateItems[] = [
                "id" => $value->id,
                "category_id" => 9,
                "name" => $value->name,
                "variable_id" => $value->id,
            ];
        }
        foreach ($this->defaultOptions->getAddonsList(null,$this->parseConfig()->LocationID) as $key=>$value)
        {
            if ($value->type == "disklayout")
            {
                $diskLayoutItems[] = [
                    "id" => $value->id,
                    "category_id" => 9,
                    "name" => $value->description,
                    "variable_id" => $value->id,
                ];
            }
        }
        foreach ($this->defaultOptions->getAddonsList(null,$this->parseConfig()->LocationID) as $key=>$value)
        {
            if ($value->type != "disklayout")
            {
                $extrasItems[] = [
                    "id" => $value->id,
                    "category_id" => 9,
                    "name" => $value->description,
                    "variable_id" => $value->id,
                ];
            }
        }

        $config[0]['items'] = $diskLayoutItems;
        $config[1]['items'] = $extrasItems;
        $config[2]['items'] = $modelItems;
        $config[3]['items'] = $locationItems;
        $config[4]['items'] = $templateItems;

        $c = HBLoader::LoadModel("ConfigFields");

        if($c->getFieldByVar($productId,'extras') !== false || $c->getFieldByVar($productId,'disk_layout') !== false || $c->getFieldByVar($productId,'model') !== false || $c->getFieldByVar($productId,'location') !== false || $c->getFieldByVar($productId,'osTemplate') !== false || $c->getFieldByVar($productId,'numberOfAdditionalIpAddresses') !== false || $c->getFieldByVar($productId,'bandwidth') !== false)
        {
            header('HTTP/1.1 400 Bad Request');
            self::jsonEncode(['error'=>"Configurable Options Were Already Created"]);
        }
        $c->importJson($productId,json_encode($config));
        self::jsonEncode(['success'=>"Configurable Options Created Successfully"]);
    }

    protected function createConfigurableOptionsForParts($productId,$type,$model,$typeName,$modelName)
    {
        switch ($type)
        {
            case '8':
                $items = [
                    [
                        "id" => '524288|1048576',
                        "category_id" => 9,
                        "name" => '524288|1048576[MB]',
                        "variable_id" => '524288|1048576',
                    ],
                    [
                        "id" => '1048576|2048576',
                        "category_id" => 9,
                        "name" => '1048576|2048576[MB]',
                        "variable_id" => '1048576|2048576',
                    ]
                ];
                break;

            case '9':
                $items = [
                    [
                        "id" => '262144|524288',
                        "category_id" => 9,
                        "name" => '262144|524288[MB]',
                        "variable_id" => '262144|524288',
                    ],
                    [
                        "id" => '524288|1048576',
                        "category_id" => 9,
                        "name" => '524288|1048576[MB]',
                        "variable_id" => '524288|1048576',
                    ]
                ];
                break;
            case '10':
                $items = [
                    [
                        "id" => '4096|8192',
                        "category_id" => 9,
                        "name" => '4096|8192[MB]',
                        "variable_id" => '4096-8192',
                    ],
                    [
                        "id" => '8192|16384',
                        "category_id" => 9,
                        "name" => '8192|16384[MB]',
                        "variable_id" => '8192|16384',
                    ],
                ];
                break;
            case '11':
                $items = [
                    [
                        "id" => '4|8',
                        "category_id" => 9,
                        "name" => '4|8[Cores]',
                        "variable_id" => '4|8',
                    ],
                    [
                        "id" => '8|16',
                        "category_id" => 9,
                        "name" => '8|16[Cores]',
                        "variable_id" => '8|16',
                    ],
                ];
                break;
        }
        if($type == '')
        {
            header('HTTP/1.1 400 Bad Request');
            self::jsonEncode(['error'=>"You have to choose a part type"]);
        }
        if($model == '')
        {
            header('HTTP/1.1 400 Bad Request');
            self::jsonEncode(['error'=>"You have to choose a part model"]);
        }
        $config[] = $this->prepareArrayForConfigOptionPart($typeName.': '.$modelName,$type.'_'.$model,$items);
        $c = HBLoader::LoadModel("ConfigFields");
        $c->importJson($productId,json_encode($config));
        self::jsonEncode(['success'=>"Configurable Part Option Created Successfully"]);
    }

    protected function createConfigurableOptionsForMetadata($productId,$metadataId,EasyDCIM $api)
    {
        if($metadataId === '' || $metadataId === 'default')
        {
            header('HTTP/1.1 400 Bad Request');
            self::jsonEncode(['error'=>"You have to choose a metadata type"]);
        }

        $metadata = $api->system->showField($metadataId);
        if ($metadata->element === 'dropdown')
        {
            foreach ($metadata->options as $key=>$option) {
                $items[] = [
                    "id" => $key,
                    "category_id" => 9,
                    "name" => $key,
                    "variable_id" => $option,
                ];
            }
            $config[] = $this->prepareArrayForConfigOptionMetadata('Metadata'.': '.$metadata->label,'Metadata'.'_'.$metadataId,$items);
            $c = HBLoader::LoadModel("ConfigFields");
            $c->importJson($productId,json_encode($config));
            self::jsonEncode(['success'=>"Configurable Metadata Option Created Successfully"]);
        }else{
            $config[] = $this->prepareArrayForConfigOptionMetadata('Metadata'.': '.$metadata->label,'Metadata'.'_'.$metadataId);
            $c = HBLoader::LoadModel("ConfigFields");
            $c->importJson($productId,json_encode($config));
            self::jsonEncode(['success'=>"Configurable Metadata Option Created Successfully"]);
        }
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

    protected function prepareArrayForConfigOptionPart($name,$variable,$items)
    {
        return [
            'type'=>'searchselect',
            'name'=>$name,
            'variable'=> $variable,
            'ftype'=>'searchselect',
            'premade'=>true,
            'items'=>$items
        ];
    }

    protected function prepareArrayForConfigOptionMetadata($name,$variable,$items = [])
    {
        if (!empty($items))
        {
            return [
                'type'=>'searchselect',
                'name'=>$name,
                'variable'=> $variable,
                'ftype'=>'searchselect',
                'premade'=>true,
                'items'=>$items
            ];
        }else{
            return [
                'type'=>'input',
                'name'=>$name,
                'variable'=> $variable,
                'ftype'=>'input',
                'premade'=>true,
            ];
        }

    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }

}