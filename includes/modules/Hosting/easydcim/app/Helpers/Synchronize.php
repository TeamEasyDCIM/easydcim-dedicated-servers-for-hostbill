<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Helpers;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters\ClientAdapter;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Database\Database;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections\EmailNotifications;

class Synchronize
{
    /**
     * @var EasyDCIM
     */
    protected $api;

    /**
     * @var ClientAdapter
     */
    protected $client;
    protected $module;
    protected $mailer;
    protected $db;

    public function __construct($client,$module,$mailer)
    {
        $this->api = new EasyDCIM($client);
        $this->client = $client;
        $this->module = $module;
        $this->mailer = $mailer;
        $db = new Database();
        $this->db = $db->getConnection();
    }

    public function synchronize($clientData,$server)
    {
        $packageId = $this->client->getProductID();
        $serviceId = $this->client->getServiceID();
        $info = $this->getOrderInformation($this->client->getEasyOrderID());
        if (!empty($info->service->related_id) && $this->module->getDetail('ServerID') == '')
        {
            $device = $this->getDeviceInformation($info->service->related_id);
            $this->saveDedicatedIP($device);
            $this->module->updateDetail('ServerID',$info->service->related_id);
            $account = $this->module->getAccount();
            $createTemplateId = $account['options']['CreateServerNotification'];
            $emailTemplates = new EmailNotifications($this->db);
            $mail = new Emails($this->mailer);
            $mail->sendServerCreateEmail($this->client,$emailTemplates->getTemplate($createTemplateId),$clientData,$account,$server);
            $this->module->changeAccountStatus('Active');
            $lastModuleAction = $this->module->getDetail('LastModuleAction');
            if(in_array($lastModuleAction, ['CreateAccount', 'SuspendAccount', 'UnsuspendAccount', 'TerminateAccount'])) {
                if($info->service->status == 'aborted') {
//                    Logs::save('CRON', $info, "Service aborted in EasyDCIM", $packageId);
//                    ModuleQueue::add([
//                        'service_type' => 'Server',
//                        'service_id' => $serviceId,
//                        'module_name' => 'EasyDCIM',
//                        'module_action' => $lastModuleAction,
//                        'error_message' => 'Service aborted in EasyDCIM'
//                    ]);
                }
            }
        }
    }

    protected function getOrderInformation($orderId = null)
    {
        return $this->api->order->getOrder($orderId);
    }

    public function getDeviceInformation($deviceID)
    {
        return $this->api->device->getInformation($deviceID);
    }

    public function saveDedicatedIP($device)
    {
        $this->module->updateDetail('DedicatedIP',$device->metadata->{'IP Address'});
    }
}