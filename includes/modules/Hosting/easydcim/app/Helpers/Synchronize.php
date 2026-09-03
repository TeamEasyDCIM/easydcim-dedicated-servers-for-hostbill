<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Helpers;

use ModulesGarden\Servers\EasyDCIMv2\App\Api\ApiClientFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Device\DeviceData;
use ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\productConfig\sections\EmailNotifications;

class Synchronize
{
    /**
     * @var EasyDCIMClient
     */
    protected $api;

    protected $client;

    protected $module;

    protected $mailer;

    public function __construct($client, $module, $mailer)
    {
        $this->api = ApiClientFactory::fromClient($client);
        $this->client = $client;
        $this->module = $module;
        $this->mailer = $mailer;
    }

    /**
     * Pull the order back from EasyDCIM and catch the account up with it.
     */
    public function synchronize($clientData, $server)
    {
        $info = $this->getOrderInformation($this->client->getEasyOrderID());

        $service = $info->data?->service;

        if (empty($service?->related_id) || $this->module->getDetail('ServerID') != '')
        {
            return;
        }

        $device = $this->getDeviceInformation($service->related_id);
        $this->saveDedicatedIP($device);

        $this->module->updateDetail('ServerID', $service->related_id);

        if (!empty($service->id))
        {
            $this->module->updateDetail('EasyServiceID', $service->id);
        }

        $account = $this->module->getAccount();
        $createTemplateId = $account['options']['CreateServerNotification'];
        $emailTemplates = new EmailNotifications();
        $mail = new Emails($this->mailer);
        $mail->sendServerCreateEmail($this->client, $emailTemplates->getTemplate($createTemplateId), $clientData, $account, $server);

        $this->module->changeAccountStatus('Active');

        $lastModuleAction = $this->module->getDetail('LastModuleAction');

        if (in_array($lastModuleAction, ['CreateAccount', 'SuspendAccount', 'UnsuspendAccount', 'TerminateAccount']))
        {
            if ($service->status == 'aborted')
            {
                $this->module->changeAccountStatus('Pending');
            }
        }
    }

    /**
     * @return \ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Order\OrderResponse
     */
    protected function getOrderInformation($orderId = null)
    {
        return $this->api->admin()->orders()->show($orderId ?: $this->client->getEasyOrderID());
    }

    /**
     * @return DeviceData|null
     */
    public function getDeviceInformation($deviceID)
    {
        return $this->api->admin()->devices()->show($deviceID)->data;
    }

    /**
     * Copy the device's primary IP into the account so HostBill can show it
     * without another API round trip.
     */
    public function saveDedicatedIP($device)
    {
        $this->module->updateDetail('DedicatedIP', $device?->metadata['IP Address'] ?? '');
    }
}
