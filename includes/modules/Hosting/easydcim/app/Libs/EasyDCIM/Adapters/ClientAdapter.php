<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Exceptions\FatalError;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Interfaces\IClient;
//use ModulesGarden\Servers\EasyDCIMv2\App\Traits\ProductSetting;
//use ModulesGarden\Servers\EasyDCIMv2\Core\UI\Traits\WhmcsParams;



/**
 * Description of ClientAdapter
 *
 * @author Mateusz Pawłowski
 */
class ClientAdapter implements IClient
{
    /*
     * @var string $domain
     */
    private $domain;
    /*
     * @var string $serverHostname
     */

    private $serverHostname;
    /*
     * @var string $serverAPIKey
     */
    private $serverAPIKey;

    private $caBaseFeatures;
    /*
     * @var string $serverAPIKey
     */
    private $accountID;
    /*
     * @var integer $accountID
     */
    private $serviceID;
    /*
     * @var integer $serviceID
     */
    private $userID;
    /*
     * @var integer $serverAPIKey
     */
    private $username;
    /*
     * @var string $username
     */
    private $password;
    /*
     * @var string $password
     */
    private $firstName;
    /*
     * @var string $firstName
     */
    private $lastName;
    /*
     * @var string $lastName
     */
    private $fullName;
    /*
     * @var string $fullName
     */
    private $companyName;
    /*
     * @var string $companyName
     */
    private $email;
    /*
     * @var string $email
     */
    private $address1;
    /*
     * @var string $address1
     */
    private $address2;
    /*
     * @var string $address2
     */
    private $city;
    /*
     * @var string $city
     */
    private $fullState;
    /*
     * @var string $fullState
     */
    private $state;
    /*
     * @var string $state
     */
    private $postCode;
    /*
     * @var integer $postCode
     */
    private $countryCode;
    /*
     * @var string $countryCode
     */
    private $country;
    /*
     * @var string $country
     */
    private $phoneNumber;
    /*
     * @var string $phoneNumber
     */
    private $countryName;
    /*
     * @var string $countryName
     */
    private $productID;
    /*
     * @var integer $productID
     */
    private $locationID;
    /*
     * @var integer $locationID
     */
    private $modelID;
    /*
     * @var integer $modelID
     */
    private $autoAccept;
    /*
     * @var integer $acccessLevel
     */
    private $acccessLevel;
    /*
     * @var boolean $suspendAction
     */
    private $suspendAction;
    /*
     * @var integer $suspendActionTemplate
     */
    private $suspendActionTemplate;
    /*
     * @var boolean $unsuspendAction
     */
    private $unsuspendAction;
    /*
     * @var integer $unsuspendActionTemplate
     */
    private $unsuspendActionTemplate;
    /*
     * @var boolean $terminateAction
     */
    private $terminateAction;
    /*
     * @var integer $terminateActiontemplate
     */
    private $terminateActiontemplate;
    /*
     * @var array $adminis
     */
    private $adminis;
    /*
     * @var boolean $trafficAction
     */
    private $trafficAction;
    /*
     * @var boolean $powerUsageAction
     */
    private $powerUsageAction;
    /*
     * @var boolean $powerOutletsAction
     */
    private $powerOutletsAction;

    /*
     * @var integer $easyOrderID
     */
    private $easyOrderID;
    /*
     * @var integer $easyServerID
     */
    private $easyServerID;
    /*
     * @var integer $osTemplate
     */
    private $osTemplate;
    /*
     * @var string $rootPassword
     */
    private $rootPassword;
    /*
     * @var integer $bandwidth
     */
    private $bandwidth;
    /*
     * @var string $additionalIPAddress
     */
    private $additionalIPAddress;

    private $caSelectedGraphs;

    private $notificationServerCreate;

    /**
     * Create Client Adapter
     * 
     * @param array $params
     */
    public function __construct($params)
    {
        /*
         * API Details Group
         */
        $this->serverHostname = $this->prepareHostname($params);
        $this->serverAPIKey   = $params['serverpassword'];

        /*
         * Client Details Group
         */
        $this->accountID   = $params['config']['id'];
        $this->userID      = $params['config']['client_id'];
        $this->username    = $params['config']['username'];
        $this->password    = $params['config']['password'];
        $this->rootPassword    = $params['config']['password'];
        $this->domain      = $params['config']['domain'];
        $this->firstName   = $params['config']['clientsdetails']['firstname'];
        $this->lastName    = $params['config']['clientsdetails']['lastname'];
        $this->fullName    = $params['config']['clientsdetails']['fullname'];
        $this->companyName = $params['config']['clientsdetails']['companyname'];
        $this->email       = $params['config']['clientsdetails']['email'];
        $this->address1    = $params['config']['clientsdetails']['address1'];
        $this->address2    = $params['config']['clientsdetails']['address2'];
        $this->city        = $params['config']['clientsdetails']['city'];
        $this->fullState   = $params['config']['clientsdetails']['fullstate'];
        $this->state       = $params['config']['clientsdetails']['state'];
        $this->postCode    = $params['config']['clientsdetails']['postcode'];
        $this->countryCode = $params['config']['clientsdetails']['countrycode'];
        $this->country     = $params['config']['clientsdetails']['country'];
        $this->phoneNumber = $params['config']['clientsdetails']['phonenumber'];
        $this->countryName = $params['config']['clientsdetails']['countryname'];


        $this->productID = $params['config']['product_id'];
        $this->serviceID = $params['config']['id'];
        /*
         * Configuration Detials Group
         */

        $productConfiguration = $params['config']['options'];

        $this->locationID              = ($params['config']['configoptions']['location']['variable_id']) ?: $productConfiguration['LocationID'];
        $this->modelID                 = ($params['config']['configoptions']['model']['variable_id']) ?: $productConfiguration['ModelID'];
        $this->osTemplate               = ($params['config']['configoptions']['osTemplate']['variable_id'] ?: $productConfiguration['OsTemplateID']);
        $this->bandwidth               = ($params['config']['configoptions']['bandwidth']['value'] ?: $productConfiguration['Bandwidth']);
        $this->additionalIPAddress     = ($params['config']['configoptions']['numberOfAdditionalIpAddresses']['value'] ?: $productConfiguration['AdditionalIPAddresses']);
//        if (!empty($this->getWhmcsParamByKey('pid')))
//        {
            $this->baseFeatures             = [
                'requirePdu'=>$productConfiguration['RequirePDU'] == "on" ? 1 : 0,
                'requireSwitch'=>$productConfiguration['RequireSwitch'] == "on" ? 1 : 0,
                'debug'=>$productConfiguration['Debug'] == "on" ? 1 : 0,
                'autoAccept'=>$productConfiguration['AutoAccept'] == "on" ? 1 : 0,
            ];
            $this->caBaseFeatures = [
//                'caImage'=>$this->productSetting()->Image == "on" ? 1 : 0,
                'caModel'=>$productConfiguration['Model'] == "on" ? 1 : 0,
                'caLabel'=>$productConfiguration['Label'] == "on" ? 1 : 0,
                'caStatus'=>$productConfiguration['ServerStatus'] == "on" ? 1 : 0,
                'caSerialnumber'=>$productConfiguration['SerialNumber'] == "on" ? 1 : 0,
                'caPurchaseDate'=>$productConfiguration['PurchaseDate'] == "on" ? 1 : 0,
                'caWarrantyMonths'=>$productConfiguration['WarrantyMonths'] == "on" ? 1 : 0,
                'caHostname'=>$productConfiguration['Hostname'] == "on" ? 1 : 0,
                'caChangeHostname'=>$productConfiguration['ChangeHostname'] == "on" ? 1 : 0,
                'caIps'=>$productConfiguration['IPAddresses'] == "on" ? 1 : 0,
                'caLocation'=>$productConfiguration['Location'] == "on" ? 1 : 0,
//                'caRack'=>$this->productSetting()->Rack == "on" ? 1 : 0,
                'caGraphs'=>$productConfiguration['Graphs'] == "on" ? 1 : 0,
                'caSshDetails'=>$productConfiguration['SSHDetails'] == "on" ? 1 : 0,
                'caOs'=>$productConfiguration['CurrentOS'] == "on" ? 1 : 0,
                'caOsInstallation'=>$productConfiguration['OsInstallation'] == "on" ? 1 : 0,
            ];
            $this->caSelectedGraphs = [
                'Ping'=>$productConfiguration['Ping'] == "on" ? 1 : 0,
                'Status'=>$productConfiguration['Status'] == "on" ? 1 : 0,
                'AggregateTraffic'=>$productConfiguration['AggregateTraffic'] == "on" ? 1 : 0,
//                'ProcessorsLoad'=>$productConfiguration['ServerStatus'] == "on" ? 1 : 0,
//                'PollerDuration'=>$productConfiguration['PollerDuration'] == "on" ? 1 : 0,
            ];
            $this->notificationServerCreate = $productConfiguration['CreateServerNotification'];
//        }
//        if (!empty($this->getWhmcsParamByKey('pid')))
//        {
            $this->parts = $productConfiguration['parts'];
//        }
        $partsOptions = preg_grep('/^\d{1,}_\w{1}/', array_keys($params['config']['configoptions']));
        $this->configOptParts           = array_intersect_key($params['config']['configoptions'], array_flip($partsOptions));

        foreach($this->configOptParts as $key=>$value)
        {
            $this->configOptParts[$key] = $value['variable_id'];
        }

        $this->autoAccept              = $productConfiguration['AutoAccept'] == "on" ? 1 : 0;
        $this->acccessLevel            = $productConfiguration['serviceAccessID'];
        $this->suspendAction           = $productConfiguration['SuspensionAction'] == "on" ? 1 : 0;
        $this->suspendActionTemplate   = $productConfiguration['SuspensionTemplate'];
        $this->unsuspendAction         = $productConfiguration['UnsuspensionAction'] == "on" ? 1 : 0;
        $this->unsuspendActionTemplate = $productConfiguration['UnsuspensionTemplate'];
        $this->terminateAction         = $productConfiguration['TerminateAction'] == "on" ? 1 : 0;
        $this->terminateActiontemplate = $productConfiguration['TerminateTemplate'];
        $this->adminis                 = $productConfiguration['adminID'];
        $this->trafficAction           = $productConfiguration['TrafficStatistics'];
//        $this->powerUsageAction        = $productConfiguration['BootServer'];
//        $this->powerOutletsAction      = $productConfiguration['BootServer'];
        /*
         * Custom Fields Group;
         */
        $this->easyOrderID  = $params['config']['extra_details']['option4'];
        $this->easyServerID = $params['config']['extra_details']['option5'];
    }

    /**
     * Prepare API Hostname
     * @param array $params
     * $return string
     */
    private function prepareHostname($params)
    {
        return 'http' . (($params['serversecure'] == 'on' || $params['serversecure'] == 1) ? 's' : '') . '://' . ($params['serverhostname']) ?: $params['serverip'];
    }

    private function getProductConfiguration($productID)
    {
        $configuration = new ProductInformation($productID);
        return $configuration->getConfiguration();
    }

    /**
     * WHMCS Hosting Password
     *
     * @return string
     */
    public function getRootPassword()
    {
        return $this->rootPassword;
    }

    /**
     * Easy Additional IP Addressess
     *
     * @return string
     */
    public function getAdditionalIPAddress()
    {
        return $this->additionalIPAddress;
    }

    /**
     * Easy Bandwidth
     *
     * @return integer
     */
    public function getBandwidth()
    {
        return $this->bandwidth;
    }

    /**
     * EasyDCIM API Hostname
     * 
     * @return string
     */
    public function getServerHostname()
    {
        return $this->serverHostname;
    }

    /**
     * EasyDCIM API Token
     * 
     * @return string
     */
    public function getServerAPIKey()
    {
        return $this->serverAPIKey;
    }

    /**
     * WHMCS Account ID
     * 
     * @return integer
     */
    public function getAccountID()
    {
        return $this->accountID;
    }

    /**
     * WHMCS Service ID
     * 
     * @return integer
     */
    public function getServiceID()
    {
        return $this->serviceID;
    }

    /**
     * WHMCS User ID
     * 
     * @return integer
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * WHMCS Hosting Username 
     * 
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * WHMCS Hosting Password 
     * 
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * WHMCS User first name
     * 
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * WHMCS User last name
     * 
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * WHMCS User first and last name
     * 
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * WHMCS Company name
     * 
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * WHMCS User email address
     * 
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * WHMCS User address
     * 
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * WHMCS User address
     * 
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * WHMCS User city
     * 
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * WHMCS User full state
     * 
     * @return string
     */
    public function getFullState()
    {
        return $this->fullState;
    }

    /**
     * WHMCS User state
     * 
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * WHMCS User post code
     * 
     * @return string
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * WHMCS User country code
     * 
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * WHMCS User country
     * 
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * WHMCS User phone number
     * 
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * WHMCS User country name
     * 
     * @return string
     */
    public function getCountryName()
    {
        return $this->countryName;
    }

    /**
     * WHMCS Product ID
     * 
     * @return string
     */
    public function getProductID()
    {
        return $this->productID;
    }

    /**
     * Easy Location ID
     * 
     * @return integer
     */
    public function getLocationID()
    {
        return $this->locationID;
    }

    /**
     * Easy Model ID
     * 
     * @return integer
     */
    public function getModelID()
    {
        return $this->modelID;
    }

    /**
     * Easy auto accept setting
     * 
     * @return boolean
     */
    public function getAutoAccept()
    {
        return $this->autoAccept;
    }

    /**
     * Easy Acces Level
     * 
     * @return integer
     */
    public function getAcccessLevel()
    {
        return $this->acccessLevel;
    }

    /**
     * Easy activate suspend email template
     * 
     * @return boolean
     */
    public function getSuspendAction()
    {
        return $this->suspendAction;
    }

    /**
     * WHMCS Custom suspend email template ID
     * 
     * @return integer
     */
    public function getSuspendActionTemplate()
    {
        return $this->suspendActionTemplate;
    }

    /**
     * Easy activate unsuspend email template
     * 
     * @return boolean
     */
    public function getUnsuspendAction()
    {
        return $this->unsuspendAction;
    }

    /**
     * WHMCS Custom unsuspend email template ID
     * 
     * @return integer
     */
    public function getUnsuspendActionTemplate()
    {
        return $this->unsuspendActionTemplate;
    }

    /**
     * Easy activate terminate email template
     * 
     * @return boolean
     */
    public function getTerminateAction()
    {
        return $this->terminateAction;
    }

    /**
     * WHMCS Custom terminate email template ID
     * 
     * @return integer
     */
    public function getTerminateActiontemplate()
    {
        return $this->terminateActiontemplate;
    }

    /**
     * WHMCS Admin list who get actions emails
     * 
     * @return aray
     */
    public function getAdminis()
    {
        return $this->adminis;
    }

    /**
     * WHMCS Easy order ID
     * 
     * @throws FatalError insteadof Exception
     * @return integer
     */
    public function getEasyOrderID()
    {
        if (empty($this->easyOrderID))
        {
            throw new FatalError('Order Id is empty');
        }
        return $this->easyOrderID;
    }

    /**
     * WHMCS Easy server ID
     * 
     * @throws FatalError insteadof Exception
     * @return integer
     */
    public function getEasyServerID()
    {
        if (empty($this->easyServerID))
        {
            throw new FatalError('Server ID Is Empty');
        }
        return $this->easyServerID;
    }

    /**
     * WHMCS Display statistics on traffic in the client area 
     * 
     * @return boolean
     */
    public function getTrafficAction()
    {
        return $this->trafficAction;
    }

    /**
     * WHMCS Display statistics on power usage in the client area 
     * 
     * @return boolean
     */
    public function getPowerUsageAction()
    {
        return $this->powerUsageAction;
    }

    /**
     * WHMCS Display power outlets in the client area
     * 
     * @return boolean
     */
    public function getPowerOutletsAction()
    {
        return $this->powerOutletsAction;
    }

    /**
     * Easy Parts
     *
     * @return array
     */
    public function getParts()
    {
        return $this->parts;
    }

    /**
     * Easy Config Options Parts
     *
     * @return array
     */
    public function getConfigOptParts()
    {
        return $this->configOptParts;
    }

    /**
     * System Base Features
     *
     * @return integer
     */
    public function getBaseFeatures()
    {
        return $this->baseFeatures;
    }

    /**
     * Client Area Base Features
     *
     * @return integer
     */
    public function getCaBaseFeatures()
    {
        return $this->caBaseFeatures;
    }

    /**
     * Client Area Selected Graphs
     *
     * @return integer
     */
    public function getCaSelectedGraphs()
    {
        return $this->caSelectedGraphs;
    }

    /**
     * Client Area Server Actions
     *
     * @return integer
     */
    public function getCaServerActions()
    {
        return $this->caServerActions;
    }

    /**
     * Client Sidebar Actions
     *
     * @return integer
     */
    public function getCaSidebarActions()
    {
        return $this->caSidebarActions;
    }

    /**
     * Client Area available os tempaltes
     *
     * @return integer
     */
    public function getCaOsTemplate()
    {
        return $this->caOsTemplate;
    }

    /**
     * Client Area Base Features
     *
     * @return integer
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * Email Notifictaion
     *
     * @return integer
     */
    public function getNotificationServerCreate()
    {
        return $this->notificationServerCreate;
    }

    /**
     * Easy Os Template
     *
     * @return integer
     */
    public function getOsTemplate()
    {
        return $this->osTemplate;
    }

    /**
     * WHMCS Hosting Domain
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }
    

}
