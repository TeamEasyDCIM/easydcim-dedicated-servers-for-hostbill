<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Helpers;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Adapters\ClientAdapter;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections\EmailNotifications;

use Illuminate\Database\Capsule\Manager as DB;

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

    public function __construct($client,$module,$mailer)
    {
        $this->api = new EasyDCIM($client);
        $this->client = $client;
        $this->module = $module;
        $this->mailer = $mailer;
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
            $emailTemplates = new EmailNotifications();
            $mail = new Emails($this->mailer);
            $mail->sendServerCreateEmail($this->client,$emailTemplates->getTemplate($createTemplateId),$clientData,$account,$server);
            $this->module->changeAccountStatus('Active');
            $lastModuleAction = $this->module->getDetail('LastModuleAction');
            if(in_array($lastModuleAction, ['CreateAccount', 'SuspendAccount', 'UnsuspendAccount', 'TerminateAccount'])) {
                if($info->service->status == 'aborted') {
                    $this->module->changeAccountStatus('Pending');
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