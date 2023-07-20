<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Http\Actions;

use ModulesGarden\Servers\EasyDCIMv2\App\Api\EasyDCIMConfigFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\Synchronize;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Database\Database;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters\ClientAdapter;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Interfaces\IClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Orders\OrderCreate;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Orders\OrderCriteria;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Orders\OrderMetadataContainer;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Orders\OrderPart;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Orders\OrderPartContainer;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Orders\OrderService;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Users\UserContainer;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Users\UserDetails;
use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\Emails;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections\EmailNotifications;

class CreateAccount
{
    private $disabledOptions = [
        'model',
        'Model',
        'Extras',
        'extras',
        'Disk Layout',
        'disk_layout',
        'Location',
        'location',
        'OS Template',
        'osTemplate',
        'Number of additional IP addresses',
        'numberOfAdditionalIpAddresses',
        'Bandwidth',
        'bandwidth',
        'location',
        'template',
        'bandwidth',
        'additionalIpsNumber',
        'hdd',
        'ssd',
        'ram',
        'cpuCores',
        'ram',
        'hostname',
        'username',
        'password',
        'monthly_traffic_limit',
        'additional_ips'
    ];
    /**
     * @var
     */
    protected $module;

    /**
     * @var ClientAdapter
     */
    protected $client;
    /**
     * @var
     */
    protected $params;
    protected $mailer;
    protected $db;
    protected $serverModel;

    /**
     * @param $module
     */
    public function __construct($module,$mailer,$serverModel)
    {
        $this->module = $module;
        $this->mailer = $mailer;
//        $this->checkOrderId();
        $this->params = $this->module->getAccount();
        $this->serverModel = $serverModel;
        $this->params['clientsdetails'] = $this->module->getClient();
        $this->params['configoptions'] = $this->module->getAccountConfig();
        $this->client = (new EasyDCIMConfigFactory())->fromParams($this->module->connection,$this->params);
        $db = new Database();
        $this->db = $db->getConnection();
    }

    public function checkOrderId()
    {
        $orderId = $this->module->getAccountDetails()['option4']['value'];
        if ($orderId != '')
        {
            throw new \Exception('The order ID field is not empty');
        }
    }

    /**
     * @return array|null
     */
    public function execute(): ?array
    {
        $orderData = $this->addOrder($this->client);
        return $orderData;
    }

    /**
     * Create new order
     * Save custom fields Order ID, server ID
     *
     * $param $client insteandof ClientAdapter
     *
     */
    private function addOrder(IClient $client)
    {
        $clientID = $this->getClientID($client);
        $parts = $this->getParts($client);
        $metadata = $this->getMetadata($client);

        $criteriaModel = new OrderCriteria();
        $criteriaModel->setModel($client->getModelID())
            ->setLocation($client->getLocationID())
            ->setRequirePdu($client->getBaseFeatures()['requirePdu'])
            ->setRequireSwitch($client->getBaseFeatures()['requireSwitch'])
            ->setRequireParts($this->checkPartIsActive($client))
            ->setRequireMetadata($this->checkMetadataIsActive($client))
            ->setParts($parts)
            ->setMetadata($metadata);


        try
        {

            $templateID = $client->getOsTemplate();
        }
        catch (\Exception $ex)
        {
            $templateID = $client->getOsTemplate();
        }



        $serviceModel = new OrderService();
        $serviceModel->setHostname($client->getDomain())
            ->setTemplate($templateID)
            ->setUsername($client->getUsername())
            ->setPassword($client->getPassword())
            ->setRootPassword($client->getRootPassword())
            ->setMonthlyTrafficLimit($client->getBandwidth())
            ->setAccessLevel($client->getAcccessLevel())
            ->setCustomFields($this->getCustomInformation());



        if(!empty($client->getAdditionalIPAddress()) || $client->getAdditionalIPAddress() != 0){
            $serviceModel->setAdditionalIps($this->getAdditionalIP($client))
                ->setAdditionalIpsNumber($client->getAdditionalIPAddress());
        }


        $createModel = new OrderCreate();
        $createModel->setModule('Server')
            ->setClient($clientID)
            ->setAutoAccept($client->getBaseFeatures()['autoAccept'])
            ->setCriteria($criteriaModel)
            ->setService($serviceModel);
        $api    = new EasyDCIM($client);
        $error = "";
        $orderId = 0;

        $result = $api->order->create($createModel);

        if ($result->status == 'error')
        {
            $error = implode("\n",$result->errors);
            if ($error == '')
            {
                $error = $result->message;
            }
            $orderId = $result->order->id;
        }

        $this->module->updateDetail('OrderID',$orderId);
        $this->module->updateDetail('LastModuleAction','CreateAccount');

        if($error != '') {
            throw new \Exception(ucfirst($error));
        }
        if (!empty($result->service->related_id))
        {
            $this->module->updateDetail('ServerID',$result->service->related_id);
            $synchronize = new Synchronize($client,$this->module,$this->mailer);
            $device = $synchronize->getDeviceInformation($result->service->related_id);
            $synchronize->saveDedicatedIP($device);
            $createTemplateId = $this->params['options']['CreateServerNotification'];
            $emailTemplates = new EmailNotifications($this->db);
            $mail = new Emails($this->mailer);
            $mail->sendServerCreateEmail($client,$emailTemplates->getTemplate($createTemplateId),$this->params['clientsdetails'],$this->params,$this->serverModel->getServerDetails($this->params["server_id"]));
        }
        return [
            'orderId'=>isset($result)?$result->id:$orderId,
            'serverId'=>!empty($result->service->related_id)?$result->service->related_id:'',
            'lastModuleAction'=>'CreateAccount',
        ];
    }

    /**
     * Calculate number of IP addresses
     *
     * $param $client insteandof ClientAdapter
     *
     * @return string
     *
     */
    private function getAdditionalIP(IClient $client)
    {
        $additionalIP = $client->getAdditionalIPAddress();
        if ($additionalIP == 1)
        {
            return '/30';
        }
        $hosts = [];
        $mask  = null;
        for ($i = 1; $i <= 30; $i++)
        {
            $hosts[$i] = (1 << (32 - $i)) - 2;
        }
        for ($i = 30; $i >= 0; $i--)
        {
            if ($hosts[$i] >= $additionalIP)
            {
                $mask = $i;
                break;
            }
        }
        return '/' . $mask;
    }

    /**
     * Get Container of metadata
     *
     * $param $client insteandof ClientAdapter
     *
     */
    private function getMetadata(IClient $client)
    {
        $metadataContainer = new OrderMetadataContainer();

        $metadata = $client->getMetadata();
        $confMetadata = $client->getConfigMetadata();

        if (!empty($metadata))
        {
            foreach ($metadata as $key=>$value)
            {
                $metadataValue = $confMetadata['Metadata_' . $key] ?? $value;
                $metadataContainer->set($key,$metadataValue);
            }
        }else{
            foreach ($confMetadata as $key=>$value)
            {
                $arr = explode("_", $key);
                $id = $arr[1];
                $metadataContainer->set($id,$value);
            }
        }

        return $metadataContainer->getAll();
    }

    /**
     * Get Container of parts
     *
     * $param $client insteandof ClientAdapter
     *
     * @return $hddModel insteandof OrderPart
     *
     */
    private function getParts(IClient $client)
    {
        $partContainer = new OrderPartContainer();

        $hdd = [];
        $ssd = [];
        $ram = [];
        $cpu = [];

        $parts = $client->getParts();
        $confParts = $client->getConfigOptParts();

        if (empty($parts['type']))
        {
            foreach ($confParts as $key => $value) {
                $det = explode('_', $key);
                $typeId = $det[0];
                $modelId = $det[1];

                /**
                 * One model parts with metadata value. Example: 8:6 . Value: 4096|4 GB
                 */
                if(is_numeric($modelId)) {
                    switch ($typeId) {
                        case 8: $hdd[] = [$det[1] => $value]; break;
                        case 9: $ssd[] = [$det[1] => $value]; break;
                        case 10: $ram[] = [$det[1] => $value]; break;
                        case 11: $cpu[] = [$det[1] => $value]; break;
                    }
                }

                /**
                 * CO with multiple models. Example: 8:models.
                 * Value: 9|1TB MODEL 1 or 9:4096|1TB MODEL 1 with 4096 metadata value
                 */
                if($modelId == 'models') {
                    if (strpos($value, '_') !== false) {
                        $det = explode('_', $value);

                        $modelId = (int) $det[0];
                        $metadataValue = (int) $det[1];

                        switch ($typeId) {
                            case 8: $hdd[] = [$modelId => $metadataValue]; break;
                            case 9: $ssd[] = [$modelId => $metadataValue]; break;
                            case 10: $ram[] = [$modelId => $metadataValue]; break;
                            case 11: $cpu[] = [$modelId => $metadataValue]; break;
                        }
                    } else {
                        switch ($typeId) {
                            case 8: $hdd[] = [$value => '']; break;
                            case 9: $ssd[] = [$value => '']; break;
                            case 10: $ram[] = [$value => '']; break;
                            case 11: $cpu[] = [$value => '']; break;
                        }
                    }
                }
            }
        }else{
            foreach ($parts['type'] as $key => $type) {
                switch ($type) {
                    case 'HDD': $partType = 8; break;
                    case 'SSD': $partType = 9; break;
                    case 'RAM': $partType = 10; break;
                    case 'CPU': $partType = 11; break;
                }
                $size = $confParts[$partType . "_" . $parts['model'][$key]] ?? $parts['size'][$key];

                switch ($type) {
                    case 'HDD': $hdd[] = [$parts['model'][$key] => $size]; break;
                    case 'SSD': $ssd[] = [$parts['model'][$key] => $size]; break;
                    case 'RAM': $ram[] = [$parts['model'][$key] => $size]; break;
                    case 'CPU': $cpu[] = [$parts['model'][$key] => $size]; break;
                }
            }
        }

        if(!empty($hdd)) {
            $partContainer->setHdd($this->getHddModel($hdd));
        }

        if(!empty($ssd)) {
            $partContainer->setSsd($this->getSsdModel($ssd));
        }

        if(!empty($ram)) {
            $partContainer->setRam($this->getRamModel($ram));
        }

        if(!empty($cpu)) {
            $partContainer->setCpu($this->getCpuModel($cpu));
        }

        return $partContainer;
    }

    /*
     *
     * Get configurable options without disabled
     *
     * @return array $options
     */

    /**
     * @return mixed
     */
    private function getCustomInformation()
    {
        $options = $this->params['configoptions'];
        foreach ($options as $key => $value)
        {
            if (strpos($key, '8') === 0 || strpos($key, '9') === 0 || strpos($key, '10') === 0 || strpos($key, '11') === 0) {
                unset($options[$key]);
            }

            if (in_array($key, $this->disabledOptions) || preg_match('/^[0-9]+:[0-9]+/', $key) || strpos($key, "Metadata") !== false)
            {
                unset($options[$key]);
            }
        }

        return $options;
    }

    /**
     * Check Active Parts
     *
     * $param $client insteandof ClientAdapter
     *
     * @return integer
     *
     */
    private function checkPartIsActive(IClient $client)
    {
        if (!empty($client->getParts()) || !empty($client->getConfigOptParts()))
        {
            return 1;
        }
        return 0;
    }

    /**
     * Check Active Parts
     *
     * $param $client insteandof ClientAdapter
     *
     * @return integer
     *
     */
    private function checkMetadataIsActive(IClient $client)
    {
        if (!empty($client->getMetadata()) || !empty($client->getConfigMetadata()))
        {
            return 1;
        }
        return 0;
    }

    /**
     * Get HDD Part Model
     *
     * $param $details array
     *
     * @return $hddModel insteandof OrderPart
     *
     */
    private function getHddModel($details)
    {
        $hddModel = new OrderPart();
        $hddModel->setPartType('hdd.size')
            ->setModels($details);

        return $hddModel;
    }

    /**
     * Get SSD Part Model
     *
     * $param $details array
     *
     * @return $hddModel insteandof OrderPart
     *
     */
    private function getSsdModel($details)
    {
        $hddModel = new OrderPart();
        $hddModel->setPartType('ssd.size')
            ->setModels($details);

        return $hddModel;
    }

    /**
     * Get RAM Part Model
     *
     * $param $details array
     *
     * @return $hddModel insteandof OrderPart
     *
     */
    private function getRamModel($details)
    {
        $hddModel = new OrderPart();
        $hddModel->setPartType('ram.size')
            ->setModels($details);

        return $hddModel;
    }

    /**
     * Get CPU Part Model
     *
     * $param $details array
     *
     * @return $hddModel insteandof OrderPart
     *
     */
    private function getCpuModel($details)
    {
        $hddModel = new OrderPart();
        $hddModel->setPartType('cpu.cores')
            ->setModels($details);

        return $hddModel;
    }

    /**
     * Get Client ID
     *
     * $param $client insteandof ClientAdapter
     * $return integer
     *
     */
    private function getClientID(IClient $client)
    {
        $check = $this->checkUserExists($client);
        if ($check->count == 1)
        {
            return $check->user->id;
        }
        $newUser = $this->createClient($client);
        return $newUser->id;
    }

    /**
     * Check user exsists on Easy DCIM
     *
     * $param $client insteandof ClientAdapter
     * $return JSON object
     *
     */
    private function checkUserExists(IClient $client)
    {
        $userDetails = new UserDetails();
        $userDetails->setEmail($client->getEmail());

        $api = new EasyDCIM($client);
        return $api->user->checkIfExists($userDetails);
    }

    /**
     * Create new EASY DCIM user
     *
     * $param $client insteandof ClientAdapter
     * $return JSON object
     *
     */
    private function createClient(IClient $client)
    {

        $userDetails = new UserDetails();
        $userDetails->setUsername($client->getEmail())
            ->setFirstname($client->getFirstName())
            ->setLastname($client->getLastName())
            ->setEmail($client->getEmail())
            ->setPassword($client->getPassword())
            ->setPasswordConfirmation($client->getPassword())
            ->setCity($client->getCity())
            ->setAddress1($client->getAddress1())
            ->setAddress2($client->getAddress2())
            ->setState($client->getState())
            ->setCountryCode($client->getCountryCode())
            ->setPostcode($client->getPostCode());

        $createUser = new UserContainer();
        $createUser->setData($userDetails)
            ->setRole($this->getUserRole());

        $api = new EasyDCIM($client);
        return $api->user->create($createUser);
    }

    /**
     * Get user role
     *
     * $return integer
     *
     */
    private function getUserRole()
    {
//        $file = Reader::read(ModuleConstants::getModuleRootDir() . DS . 'app' . DS . 'Config' . DS . 'configuration.json');
//        $config =  $file->get();
        return 1;
//        return ($config->base->userRole) ?: 1;
    }
}