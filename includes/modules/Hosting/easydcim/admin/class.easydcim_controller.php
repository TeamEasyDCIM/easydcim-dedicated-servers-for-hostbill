<?php

use ModulesGarden\Servers\EasyDCIMv2\App\Api\ApiClientFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Api\EasyDCIMConfigFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
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

use Illuminate\Database\Capsule\Manager as DB;

class easydcim_controller extends HBController
{
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
        $serverId = $this->getServerId($params['id']);
        if ($serverId != null && $serverId != '')
        {
            $this->configFieldsModel = HBLoader::LoadModel("ConfigFields");
            $serverHelper = HBLoader::LoadModel('Servers');
            $this->servers = $serverHelper->findServersBy('module','easydcim');
            $this->serverDetails = $this->getServerDetails($this->getServerId($params['id']));
            $this->configuration = $this->module->getOptions()['simple'];
            $this->client = (new EasyDCIMConfigFactory())->fromParams($this->serverDetails);
            $this->api = ApiClientFactory::fromClient($this->client);
            $this->defaultOptions = new DefaultOptions($this->api);
            $this->automationSettings = new AutomationSettings($this->api);
            $this->additionalParts = new AdditionalParts($this->api);
            $this->clientAreaFeatures = new ClientAreaFeatures($this->api);
            $this->emailNotifications = new EmailNotifications();
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
                self::jsonEncode(['fieldData'=>$this->api->admin()->fields()->show($_GET['metadataType'])->data]);
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
            $this->template->assign('orderActionsList',$this->automationSettings->getAllOrderActions());
            $this->template->assign('caTemplateList',$this->defaultOptions->getTemplateList($config->LocationID));
            $this->template->assign('metadataList',$this->clientAreaFeatures->getFields());
            $this->template->assign('adminList',$this->emailNotifications->getAdmins());
            $this->template->assign('adminEmailTemplateList',$this->emailNotifications->getAdminEmailTemplates());
            $this->template->assign('clientEmailTemplateList',$this->emailNotifications->getClientEmailTemplates());
            $this->template->assign('moduleConfiguration',$config);
            $this->template->assign('configurableOptions',$this->configFieldsModel->exportData($params['id']));
            $this->template->assign('defaultConfigOptionsJson',json_encode($this->getDefaultConfigOptions()));
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
            $this->serverDetails = $this->getServerDetails($this->getServerId($params['account']['product_id']));
            $this->client = (new EasyDCIMConfigFactory())->fromParams($this->serverDetails,$params['account']);
            $this->api = ApiClientFactory::fromClient($this->client);
            $this->serverInformation = new ServerInformation($this->api,$this->client);
            $this->generalInformation = new GeneralInformation($this->api,$this->client);
            $this->locationInformation = new LocationInformation($this->api,$this->client);
            $this->bandwidth = new Bandwidth($this->api,$this->client);
            $this->graphs = new Graphs($this->api,$this->client);
            $this->serviceActions = new ServiceActions($this->api,$this->client);

            if (isset($_GET['graphs']))
            {
                $this->graphs->manageEasyDCIMGraphs($_GET);
            }
            if (isset($_GET['bandwidthPeriod']))
            {
                $this->bandwidth->managePeriod($_GET);
            }
            // "Filter Graph" / "Filter Bandwidth" saved for this service.
            if (isset($_GET['edcSaveScope']))
            {
                \ModulesGarden\Servers\EasyDCIMv2\App\Helpers\ScopeSettings::handleSave($params['account']['id'] ?? null, $_GET);
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
            $options = $params['account']['options'];
            $this->template->assign('configuration', $options);
            // As in WHMCS: when set, the client-area feature switches also decide what this page shows.
            $this->template->assign('applyFeatures', ($options['ApplyFeatureSettingsToAdminArea'] ?? '') == 'on');
            $this->template->assign('metadata',$this->serverInformation->getMetadata($params['account'], 'caMetadataAdmin'));
            $this->template->assign('lang',$lang);
            $this->template->assign('serviceId', $params['account']['id'] ?? '');
            $this->template->assign('edcLang', \ModulesGarden\Servers\EasyDCIMv2\App\Helpers\UiLang::json());
            $this->template->assign('edcScopes', \ModulesGarden\Servers\EasyDCIMv2\App\Helpers\ScopeSettings::json($params['account']['id'] ?? null));
        }

    }

    protected function getServerDetails($serverId):array
    {
        $serverConfig = [];

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
            $field = $this->api->admin()->fields()->show($key)->data;

            if ($field === null)
            {
                continue;
            }

            $fieldData = $field->toArray();
            $fieldData['settingsValue'] = $value;
            $metadata[] = $fieldData;
        }

        self::jsonEncode([
            'metadata'=>$metadata
        ]);
    }

    protected function getServerId($productId)
    {
        return DB::table('hb_products_modules')->where('product_id','=',$productId)->where('module','=',$this->moduleConfiguration()->id)->first()->server;
    }

    protected function updateProductConfig($config,$pid)
    {
        DB::table('hb_products_modules')->where('product_id','=',$pid)->where('module','=',$this->moduleConfiguration()->id)->update([
           'options'=>$config
        ]);
    }

    protected function moduleConfiguration()
    {
        return DB::table('hb_modules_configuration')->where('hb_modules_configuration.module','=','easydcim')->first();
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

    /**
     * The options "Create Default Options" offers in its modal, in the order
     * configurableOptions.json creates them.
     */
    private function getDefaultConfigOptions(): array
    {
        $options = [];

        foreach ($this->getConfiguration() as $field)
        {
            $options[] = ['variable' => $field['variable'], 'name' => trim($field['name'])];
        }

        return $options;
    }

    /**
     * The values of one list option, read from EasyDCIM; null for the quantity
     * fields, which keep the items configurableOptions.json gives them.
     */
    private function getDefaultConfigOptionItems(string $variable, $configuration)
    {
        switch ($variable)
        {
            case 'location':
                $list = $this->defaultOptions->getLocationList();
                break;
            case 'model':
                $list = $this->defaultOptions->getModelList('Server');
                break;
            case 'osTemplate':
                $list = $this->defaultOptions->getTemplateList($configuration->LocationID);
                break;
            case 'disk_layout':
            case 'extras':
                $list = [];
                foreach ($this->defaultOptions->getAddonsList(null, $configuration->LocationID) as $addon)
                {
                    if (($addon->type == "disklayout") === ($variable === 'disk_layout'))
                    {
                        $list[] = $addon;
                    }
                }
                break;
            default:
                return null;
        }

        $items = [];

        foreach ($list as $value)
        {
            $items[] = [
                "id" => $value->id,
                "category_id" => 9,
                // OS addons carry their label as the description.
                "name" => in_array($variable, ['disk_layout', 'extras'], true) ? $value->description : $value->name,
                "variable_id" => $value->id,
            ];
        }

        return $items;
    }

    /**
     * Create the default configurable options switched on in the modal, as the
     * WHMCS CreateConfigurableOptions provider does: only those picked, and none
     * the product already has. A request without a pick creates them all.
     */
    private function createConfigurableOptions($productId)
    {
        $picked = isset($_GET['formdata']) && is_array($_GET['formdata']) ? $_GET['formdata'] : null;
        $configuration = $this->parseConfig();
        $configFields = HBLoader::LoadModel("ConfigFields");
        $fields = [];
        $existing = 0;

        foreach ($this->getConfiguration() as $field)
        {
            if ($picked !== null && empty($picked[$field['variable']]))
            {
                continue;
            }

            if ($configFields->getFieldByVar($productId, $field['variable']) !== false)
            {
                $existing++;
                continue;
            }

            $items = $this->getDefaultConfigOptionItems($field['variable'], $configuration);

            if ($items !== null)
            {
                $field['items'] = $items;
            }

            $fields[] = $field;
        }

        if (empty($fields))
        {
            header('HTTP/1.1 400 Bad Request');
            self::jsonEncode(['error' => $existing > 0 ? "Configurable Options Were Already Created" : "No Configurable Options Were Selected"]);
        }

        $configFields->importJson($productId, json_encode($fields));
        self::jsonEncode(['success' => "Configurable Options Created Successfully"]);
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

    protected function createConfigurableOptionsForMetadata($productId,$metadataId,EasyDCIMClient $api)
    {
        if($metadataId === '' || $metadataId === 'default')
        {
            header('HTTP/1.1 400 Bad Request');
            self::jsonEncode(['error'=>"You have to choose a metadata type"]);
        }

        $metadata = $api->admin()->fields()->show($metadataId)->data;

        if ($metadata === null)
        {
            header('HTTP/1.1 400 Bad Request');
            self::jsonEncode(['error'=>"The selected metadata field does not exist"]);
        }
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