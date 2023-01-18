<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;

class ServiceActions
{

    /**
     * @var EasyDCIM
     */
    protected $api;

    public function __construct($api)
    {
        $this->api = $api;
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
                    $result = $this->api->ipmi->lunchConsole();
                    if(isset($result->status) && $result->status == 'error')
                    {
                        header('HTTP/1.1 400 Bad Request');
                        self::jsonEncode([
                            'errors'=>$result->message
                        ]);
                    }
                    self::jsonEncode([
                        'success'=>'KVM Console Lunched Successfully'
                    ]);
                    break;
                case "noVNCConsole":
                    $result = $this->api->ipmi->getNoVNCConsole();
                    if(isset($result->status) && $result->status == 'error')
                    {
                        header('HTTP/1.1 400 Bad Request');
                        self::jsonEncode([
                            'errors'=>$result->message
                        ]);
                    }
                    self::jsonEncode([
                        'success'=>'No VNC Console Lunched Successfully',
                        'url'=>$result->url
                    ]);
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
}