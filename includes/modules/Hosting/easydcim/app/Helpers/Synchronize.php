<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Helpers;

use ModulesGarden\Servers\EasyDCIMv2\App\Api\ApiClientFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\User\UpdateUserRequest;
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
        $this->synchronizeClientDetails($clientData);

        $info = $this->getOrderInformation($this->client->getEasyOrderID());

        $service = $info->data === null ? null : $info->data->service;

        if (empty($service === null ? null : $service->related_id) || $this->module->getDetail('ServerID') != '')
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
     * Push the HostBill client's contact details onto their EasyDCIM user.
     *
     * The `after_clientedit` hook is what normally keeps these in step (see
     * ClientSync). This is the reconcile for everything the hook cannot catch:
     * clients that existed before the module was installed, and edits made
     * while EasyDCIM was unreachable.
     *
     * A failure here must not abort the synchronisation - the order and device
     * data matter more than the contact details being a run behind.
     */
    protected function synchronizeClientDetails($clientData): void
    {
        $email = $this->client->getEmail();

        if (empty($email))
        {
            return;
        }

        try
        {
            $existing = $this->api->admin()->users()->fetchByEmail($email);

            if (empty($existing->data === null ? null : $existing->data->id))
            {
                return;
            }

            $current = $existing->data;

            $request = new UpdateUserRequest(null, null, $this->pick($clientData, 'firstname', $current->firstname), $this->pick($clientData, 'lastname', $current->lastname), $this->pick($clientData, 'companyname', $current->company), $this->pick($clientData, 'phonenumber', null));

            if ($request->toArray() === [])
            {
                return;
            }

            $this->api->admin()->users()->update($current->id, $request);
        }
        catch (\Exception $e)
        {
            // Contact details are best-effort; the rest of the sync continues.
        }
    }

    /**
     * The HostBill value when it differs from what EasyDCIM already holds.
     */
    private function pick($clientData, string $field, ?string $current): ?string
    {
        $value = is_array($clientData) ? ($clientData[$field] ?? null) : null;

        if ($value === null || $value === '' || (string) $value === (string) $current)
        {
            return null;
        }

        return (string) $value;
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
        $this->module->updateDetail('DedicatedIP', ($device === null ? null : $device->metadata)['IP Address'] ?? '');
    }
}
