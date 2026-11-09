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
        $this->api = ApiClientFactory::fromClient($client, $module);
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

        $this->synchronizeOrderOwner($info);

        $service = $info->data === null ? null : $info->data->service;

        if (empty($service === null ? null : $service->related_id))
        {
            return;
        }

        // Already linked: keep the account's IPs and domain in step with the device.
        if ($this->module->getDetail('ServerID') != '')
        {
            $this->updateDeviceDetails($this->getDeviceInformation($service->related_id));

            return;
        }

        $device = $this->getDeviceInformation($service->related_id);
        $this->updateDeviceDetails($device);

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
     * Link the account to the EasyDCIM user that owns its order, following an
     * owner change made by an EasyDCIM administrator (EasyDCIMUserBinding).
     */
    protected function synchronizeOrderOwner($info): void
    {
        $orderUserId = $info->data === null ? 0 : (int) $info->data->user_id;

        if ($orderUserId > 0)
        {
            EasyDCIMUserBinding::syncWithOrderOwner((int) $this->client->getAccountID(), $orderUserId, $this->module);
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
     * Copy the device's IPs and hostname into the account, as far as the
     * product's "Block Automatic Update" / "Automatic Update of Domain"
     * switches allow, so HostBill can show them without another API call.
     */
    public function updateDeviceDetails($device)
    {
        $account = $this->module->getAccount();
        $sync = new DeviceDetailsSync((array) ($account['options'] ?? []));

        $this->module->applyDeviceDetails($sync->changes($device));
    }

    /**
     * @deprecated kept for existing callers; honours the same product switches.
     */
    public function saveDedicatedIP($device)
    {
        $this->updateDeviceDetails($device);
    }
}
