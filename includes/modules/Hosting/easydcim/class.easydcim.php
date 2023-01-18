<?php
require_once 'vendor/autoload.php';

use ModulesGarden\Servers\EasyDCIMv2\App\Http\Actions\TestConnection;
use ModulesGarden\Servers\EasyDCIMv2\App\Http\Actions\CreateAccount;
use ModulesGarden\Servers\EasyDCIMv2\App\Http\Actions\SuspendAccount;
use ModulesGarden\Servers\EasyDCIMv2\App\Http\Actions\UnsuspendAccount;
use ModulesGarden\Servers\EasyDCIMv2\App\Http\Actions\TerminateAccount;
use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\Synchronize;
use ModulesGarden\Servers\EasyDCIMv2\App\Api\EasyDCIMConfigFactory;

class easydcim extends HostingModule implements Observer
{
    protected $version = '1.1';

    protected $commands = ['updateOrderInformation'=>'Update Order Information'];

    protected $modname = 'EasyDCIM';

    protected $options = [];

    protected $lang = [];

    protected $details = array(
        'option1' => array(
            'name' => 'username',
            'value' => '',
            'type' => 'input',
            'default' => false
        ),
        'option2' => array(
            'name' => 'password',
            'value' => '',
            'type' => 'input',
            'default' => false
        ),
        'option3' => array(
            'name' => 'domain',
            'value' => '',
            'type' => 'input',
            'default' => false
        ),
        'option4' =>array (
            'name'=> 'Order ID',
            'value' => '',
            'type'=> 'input',
            'default'=>false
        ),
        'option5' =>array (
            'name'=> 'Server ID',
            'value' => '',
            'type'=> 'input',
            'default'=>false
        ),
        'option6' =>array (
            'name'=> 'Last Module Action',
            'value' => '',
            'type'=> 'input',
            'default'=>false
        ),
        'option7' =>array (
            'name'=> 'Bandwidth Usage From Registration Date',
            'value' => false,
            'type'=> 'check',
            'default'=>false
        ),
        'option8' =>array (
            'name'=> 'Dedicated IP',
            'value' => '',
            'type'=> 'input',
            'default'=>false
        )
    );

    public function __construct()
    {
        $this->loadLang();
        parent::__construct();
    }

    public function connect($app_details) {
        $this->connection['ip'] = $app_details['ip'];
        $this->connection['host'] = $app_details['host'];
        $this->connection['username'] = $app_details['username'];
        $this->connection['password'] = $app_details['password'];

        //is "use ssl" option enabled? (True/false)
        $this->connection['secure'] = $app_details['secure'];
    }

    public function testConnection() {

        $connection = new TestConnection($this);

        if($connection->execute() == 'success') {
            $this->addInfo('Connection Successful.');
            return true;
        }
        else {
            $this->addError('Connection cannot be established!');
            return false;
        }

    }

    public function updateOrderInformation()
    {
        try {
            $clientModel = HBLoader::LoadModel("Clients");
            $serverModel = HBLoader::LoadModel("Servers");
            $params = $this->getAccount();
            $server = $serverModel->getServerDetails($params["server_id"]);
            $clientData = $clientModel->getClient($params['client_id']);
            $params['clientsdetails'] = $clientData;
            $params['configoptions'] = $this->getAccountConfig();
            $mailer = new Mailer();
            $client = (new EasyDCIMConfigFactory())->fromParams($this->connection,$params);
            $synchronize = new Synchronize($client,$this,$mailer);
            $synchronize->synchronize($clientData,$server);
            $this->addInfo('Account was synchronized correctly');
            return true;
        }catch (Exception $exception)
        {
            $this->addError($exception->getMessage());
            return false;
        }
    }

    public function Create() {
        //if we set $this->details['option1'] to be username, by changing it here we will update database as well
        try {
            $serverModel = HBLoader::LoadModel("Servers");
            $mailer = new Mailer();
            $create = new CreateAccount($this,$mailer,$serverModel);
            $orderData = $create->execute();

            if(isset($orderData['orderId'], $orderData['serverId'], $orderData['lastModuleAction'])) {
                $this->details['option4']['value'] = $orderData['orderId'];
                $this->details['option5']['value'] = $orderData['serverId'];
                $this->details['option6']['value'] = $orderData['lastModuleAction'];
                $this->addInfo('Account has been created.');
                return true;
            } else
            {
                return false;
            }
        }catch(Exception $e)
        {
            $this->addError($e->getMessage());
            return false;
        }
    }

    public function updateDetail($name,$value)
    {
        switch ($name) {
            case 'OrderID':
                $this->details['option4']['value'] = $value;
                break;
            case 'ServerID':
                $this->details['option5']['value'] = $value;
                break;
            case 'LastModuleAction':
                $this->details['option6']['value'] = $value;
                break;
            case 'DedicatedIP':
                $this->details['option8']['value'] = $value;
                break;
        }
        $acc = HBLoader::LoadModel("Accounts");
        $acc->updateExtraDetails($this->account_details['id'], $this->getDetails());
    }

    public function changeAccountStatus($status)
    {
        $acc = HBLoader::LoadModel("Accounts");
        $acc->markAsStatus($this->account_details['id'], $status);
    }

    public function getDetail($name)
    {
        switch ($name) {
            case 'OrderID':
                return $this->details['option4']['value'];
            case 'ServerID':
                return $this->details['option5']['value'];
            case 'LastModuleAction':
                return $this->details['option6']['value'];
            case 'DedicatedIP':
                return $this->details['option8']['value'];
        }
    }

    public function getAccountDetails()
    {
        return $this->details;
    }

    public function getClient()
    {
        return $this->client_data;
    }
    public function getAccountConfig()
    {
        return $this->account_config;
    }

    public function Suspend() {
        try {
            $this->setClientDetails($this->account_details['client_id']);
            $mailer = new Mailer();
            $suspend = new SuspendAccount($this,$mailer);
            $suspendData = $suspend->execute();
            $this->details['option6']['value'] = $suspendData['lastModuleAction'];
            $this->addInfo('Account has been suspended.');
            return true;
        }catch(Exception $exception)
        {
            $this->addError($exception->getMessage());
            return false;
        }
    }

    public function Unsuspend() {
        try {
            $this->setClientDetails($this->account_details['client_id']);
            $mailer = new Mailer();
            $unsuspend = new UnsuspendAccount($this,$mailer);
            $unsuspendData = $unsuspend->execute();
            $this->details['option6']['value'] = $unsuspendData['lastModuleAction'];
            $this->addInfo('Account has been Unsuspended.');
            return true;
        }catch(Exception $exception)
        {
            $this->addError($exception->getMessage());
            return false;
        }
    }

    public function Terminate() {
        try {
            $this->setClientDetails($this->account_details['client_id']);
            $mailer = new Mailer();
            $terminate = new TerminateAccount($this,$mailer);
            $terminateData = $terminate->execute();
            $this->details['option6']['value'] = $terminateData['lastModuleAction'];
            $this->details['option5']['value'] = '';
            $this->addInfo('Account has been Terminated.');
            return true;
        }catch(Exception $exception)
        {
            $this->addError($exception->getMessage());
            return false;
        }
    }

    public function getLastHourBandwidth()
    {

    }

    function after_cronrun($details) {
    }

    function before_displayadminheader($details) {
    }

    public function loadLang()
    {
        $language = HBRegistry::singleton()->getObject("language");
        if ($language)
        {
            $language_name = $language->getLanguage();

            $file = __DIR__ . DS . 'lang' . DS . $language_name . '.php';

            if (file_exists($file))
            {
                include $file;
                $this->lang[$language_name] = $lang;
            }else{
                $language_name = 'english';
                $file = __DIR__ . DS . 'lang' . DS . $language_name . '.php';
                include $file;
                $this->lang[$language_name] = $lang;
            }
        }else{
            $language_name = 'english';
            $file = __DIR__ . DS . 'lang' . DS . $language_name . '.php';
            include $file;
            $this->lang[$language_name] = $lang;
        }

    }

    public function install()
    {
        $addTemplate = function ($name, $subject, $body, $altbody) {
            return $this->db->exec("INSERT INTO `hb_email_templates` (`id`, `tplname`, `group`, `for`, `language_id`, `subject`, `message`, `altmessage`, `send`, `plain`, `system`, `hidden`) VALUES\r\n                    ('', '" . $name . "', 'Product', 'Admin', 1, '" . $subject . "', '" . $body . "', '" . $altbody . "', 1, 2, 1, 0);");
        };
        $addTemplate("EasyDCIM:Account:Suspension", "EasyDCIM Service Suspension", "
            <h1>This is a notification that service has now been suspended. The details of this suspension are below:</h1>
            
            <p>
                <b>Client Name:</b> {"."$"."client.firstname} {"."$"."client.lastname}  <br>
            </p>
            
            <p>
                <b>Account ID:</b> {"."$"."details.accountid} <br>
                <b>EasyDCIM Order ID:</b> {"."$"."details.orderid} <br>
                <b>EasyDCIM Server ID:</b> {"."$"."details.serverid} <br> <br>
            </p>", "");

        $addTemplate("EasyDCIM:Account:Termination", "EasyDCIM Service Termination", "
            <h1>This is a notification that service has now been terminated. The details of this termination are below:</h1>
            
            <p>
                <b>Client Name:</b> {"."$"."client.firstname} {"."$"."client.lastname}  <br>
            </p>
            
            <p>
                <b>Account ID:</b> {"."$"."details.accountid} <br>
                <b>EasyDCIM Order ID:</b> {"."$"."details.orderid} <br>
                <b>EasyDCIM Server ID:</b> {"."$"."details.serverid} <br> <br>
            </p>", "");

        $addTemplate("EasyDCIM:Account:Unsuspension", "EasyDCIM Service Unsuspension", "
            <h1>This is a notification that service has now been unsuspended. The details of this unsuspension are below:</h1>
            
            <p>
                <b>Client Name:</b> {"."$"."client.firstname} {"."$"."client.lastname}  <br>
            </p>
            
            <p>
                <b>Account ID:</b> {"."$"."details.accountid} <br>
                <b>EasyDCIM Order ID:</b> {"."$"."details.orderid} <br>
                <b>EasyDCIM Server ID:</b> {"."$"."details.serverid} <br> <br>
            </p>", "");

        return true;
    }

    public function upgrade($previous_version) {
        if($previous_version=='1.0') {

            $addTemplate = function ($name, $subject, $body, $altbody) {
                return $this->db->exec("INSERT INTO `hb_email_templates` (`id`, `tplname`, `group`, `for`, `language_id`, `subject`, `message`, `altmessage`, `send`, `plain`, `system`, `hidden`) VALUES\r\n                    ('', '" . $name . "', 'Product', 'Admin', 1, '" . $subject . "', '" . $body . "', '" . $altbody . "', 1, 2, 1, 0);");
            };
            $addTemplate("EasyDCIM:Account:Suspension", "EasyDCIM Service Suspension", "
            <h1>This is a notification that service has now been suspended. The details of this suspension are below:</h1>
            
            <p>
                <b>Client Name:</b> {"."$"."client.firstname} {"."$"."client.lastname}  <br>
            </p>
            
            <p>
                <b>Account ID:</b> {"."$"."details.accountid} <br>
                <b>EasyDCIM Order ID:</b> {"."$"."details.orderid} <br>
                <b>EasyDCIM Server ID:</b> {"."$"."details.serverid} <br> <br>
            </p>", "");

            $addTemplate("EasyDCIM:Account:Termination", "EasyDCIM Service Termination", "
            <h1>This is a notification that service has now been terminated. The details of this termination are below:</h1>
            
            <p>
                <b>Client Name:</b> {"."$"."client.firstname} {"."$"."client.lastname}  <br>
            </p>
            
            <p>
                <b>Account ID:</b> {"."$"."details.accountid} <br>
                <b>EasyDCIM Order ID:</b> {"."$"."details.orderid} <br>
                <b>EasyDCIM Server ID:</b> {"."$"."details.serverid} <br> <br>
            </p>", "");

            $addTemplate("EasyDCIM:Account:Unsuspension", "EasyDCIM Service Unsuspension", "
            <h1>This is a notification that service has now been unsuspended. The details of this unsuspension are below:</h1>
            
            <p>
                <b>Client Name:</b> {"."$"."client.firstname} {"."$"."client.lastname}  <br>
            </p>
            
            <p>
                <b>Account ID:</b> {"."$"."details.accountid} <br>
                <b>EasyDCIM Order ID:</b> {"."$"."details.orderid} <br>
                <b>EasyDCIM Server ID:</b> {"."$"."details.serverid} <br> <br>
            </p>", "");

        }
        return true;
    }
}