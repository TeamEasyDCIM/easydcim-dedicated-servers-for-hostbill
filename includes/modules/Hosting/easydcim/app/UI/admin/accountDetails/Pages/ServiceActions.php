<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Interfaces\IClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Users\UserDetails;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Users\UserLoginData;

class ServiceActions
{

    /**
     * @var EasyDCIM
     */
    protected $api;

    /**
     * @var IClient
     */
    protected $client;

    public function __construct($api,$client)
    {
        $this->api = $api;
        $this->client = $client;
    }

    public function manageServiceActions($action)
    {
        try {
            switch ($action) {
                case "boot":
                    $result = $this->api->device->powerOn();
                    if(isset($result->status) && $result->status == 'error')
                    {
                        header('HTTP/1.1 400 Bad Request');
                        self::jsonEncode([
                            'errors'=>$result->message
                        ]);
                    }
                    self::jsonEncode([
                        'success'=>'Server Was Boot Successfully'
                    ]);
                    break;
                case "shutdown":
                    $result = $this->api->device->powerOff();
                    if(isset($result->status) && $result->status == 'error')
                    {
                        header('HTTP/1.1 400 Bad Request');
                        self::jsonEncode([
                            'errors'=>$result->message
                        ]);
                    }
                    self::jsonEncode([
                        'success'=>'Server Was Shutdown Successfully'
                    ]);
                    break;
                case "reboot":
                    $result = $this->api->device->reboot();
                    if(isset($result->status) && $result->status == 'error')
                    {
                        header('HTTP/1.1 400 Bad Request');
                        self::jsonEncode([
                            'errors'=>$result->message
                        ]);
                    }
                    self::jsonEncode([
                        'success'=>'Server Was Reboot Successfully'
                    ]);
                    break;
                case "bmcColdReset":
                    $result = $this->api->ipmi->coldReset();
                    if(isset($result->status) && $result->status == 'error')
                    {
                        header('HTTP/1.1 400 Bad Request');
                        self::jsonEncode([
                            'errors'=>$result->message
                        ]);
                    }
                    self::jsonEncode([
                        'success'=>'BMC Cold Reset Successfull'
                    ]);
                    break;
                case "enableRescueMode":
                    $result = $this->api->device->changeRescueModeStatus('enable');
                    if(isset($result->status) && $result->status == 'error')
                    {
                        header('HTTP/1.1 400 Bad Request');
                        self::jsonEncode([
                            'errors'=>$result->message
                        ]);
                    }
                    self::jsonEncode([
                        'success'=>'Enable Rescue Mode Successfull'
                    ]);
                    break;
                case "kvmConsole":
                    try {
                        $result = $this->api->ipmi->lunchConsole();
                        if(isset($result->status) && $result->status == 'error')
                        {
                            header('HTTP/1.1 400 Bad Request');
                            self::jsonEncode([
                                'errors'=>$result->message
                            ]);
                        }
                        self::jsonEncode([
                            'kvmConsole'=>$result,
                            'success'=>'KVM Java Console Launched Successfully'
                        ]);
                    }catch(\Exception $e)
                    {
                        header('HTTP/1.1 400 Bad Request');
                        self::jsonEncode([
                            'errors'=>$e->getMessage()
                        ]);
                    }
                    break;
                case "noVNCConsole":
                    try {
                        if($this->checkIsIPMIEnable() === false){
                            throw new \Exception('IPMI is not enabled');
                        }
                        $result = $this->api->ipmi->getNoVNCConsole();
                        if(isset($result->status) && $result->status == 'error')
                        {
                            header('HTTP/1.1 400 Bad Request');
                            self::jsonEncode([
                                'errors'=>$result->message
                            ]);
                        }
                        self::jsonEncode([
                            'success'=>'noVNC KVM Console Launched Successfully',
                            'url'=>$result->url
                        ]);
                    }catch (\Exception $e)
                    {
                        header('HTTP/1.1 400 Bad Request');
                        self::jsonEncode([
                            'errors'=>$e->getMessage()
                        ]);
                    }
                    break;
                case "logIntoPanel":
                    try {
                        $check = $this->checkUserExists($this->client);
                        if (!empty($check->user->id))
                        {
                            $link = $this->prepareLink($this->client, $check->user->id);
                        }
                        else
                        {
                            throw new \Exception('Account Not Exist');
                        }

                        self::jsonEncode([
                            'success'=>'You have been redirected correctlly',
                            'url'=>$link->link
                        ]);
                    }catch(\Exception $e)
                    {
                        header('HTTP/1.1 400 Bad Request');
                        self::jsonEncode([
                            'errors'=>$e->getMessage()
                        ]);
                    }

                    break;
            }



        } catch (\RuntimeException $e) {
        }
        return '';
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

    /**
     * Checks if IPMI is active for this device
     * @return bool
     */
    private function checkIsIPMIEnable(){

        $deviceInformation = $this->api->device->getInformation();
        $requiredProperties = ['IPMI IP Address', 'IPMI Username', 'IPMI Password'];

        return $this->checkObjectProperties($deviceInformation->metadata, $requiredProperties);

    }

    /**
     * Checks that the right attributes are in the object
     * @return bool
     */
    protected function checkObjectProperties($object, $requiredProperties) {
        foreach ($requiredProperties as $property) {
            if (!property_exists($object, $property)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check is user exists
     *
     * @param IClient $client insteandof ClientAdapter
     */
    private function checkUserExists(IClient $client)
    {
        $userDetails = new UserDetails();
        $userDetails->setEmail($client->getEmail());

        return $this->api->user->checkIfExists($userDetails);
    }

    /**
     * Get Auto Login link to Easy DCIM
     *
     * @param IClient $client insteandof ClientAdapter, integer $easyClientID
     * @param $easyClientID
     */
    public function prepareLink(IClient $client, $easyClientID)
    {
        $userModel = new UserLoginData();
        $userModel->setId($easyClientID)
            ->setEmail($client->getEmail())
            ->setPath('services/' . $this->getServiceID() . '/summary');

        return $this->api->user->getKeyLogin($userModel);
    }

    public function getServiceID()
    {
        $device = $this->api->device->getInformation();

        return $device->order->service->id;
    }
}