<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Api;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Interfaces\IClient;

/**
 * Resolves the EasyDCIM identifiers an account maps onto.
 *
 * API v2 addressed almost everything by device ID. API v3 splits the surface:
 * admin endpoints stay device-scoped, but the endpoints with no admin
 * counterpart - reverse DNS and the password manager - are service-scoped.
 *
 * HostBill only ever stored the order ID and the device ID, so the service ID
 * is looked up once from the order and then cached in the account's extra
 * details (option9), mirroring the SERVICE_ID custom field the WHMCS module
 * keeps.
 */
class ServiceContext
{
    protected EasyDCIMClient $api;

    protected IClient $client;

    /**
     * The HostBill module instance, when one is in scope. Provisioning actions
     * and the client/admin area have it; the cron does not.
     *
     * @var object|null
     */
    protected $module;

    protected ?int $serviceId = null;

    public function __construct(EasyDCIMClient $api, IClient $client, $module = null)
    {
        $this->api    = $api;
        $this->client = $client;
        $this->module = $module;
    }

    /**
     * EasyDCIM device ID - what HostBill stores as "Server ID".
     */
    public function deviceId(): ?int
    {
        $deviceId = $this->client->getEasyServerID();

        return !empty($deviceId) ? (int) $deviceId : null;
    }

    /**
     * EasyDCIM order ID.
     */
    public function orderId(): ?int
    {
        $orderId = $this->client->getEasyOrderID();

        return !empty($orderId) ? (int) $orderId : null;
    }

    /**
     * EasyDCIM service ID, required by every `api/v3/client/...` endpoint.
     *
     * Reads the cached value first, then falls back to the order, which carries
     * the service it provisioned.
     */
    public function serviceId(): ?int
    {
        if ($this->serviceId !== null) {
            return $this->serviceId;
        }

        $stored = $this->module ? $this->module->getDetail('EasyServiceID') : null;

        if (!empty($stored)) {
            return $this->serviceId = (int) $stored;
        }

        $orderId = $this->orderId();

        if ($orderId === null) {
            return null;
        }

        $response = $this->api->admin()->orders()->show($orderId);

        $resolved = $response->data?->service?->id;

        if (empty($resolved)) {
            return null;
        }

        $this->serviceId = (int) $resolved;

        if ($this->module) {
            $this->module->updateDetail('EasyServiceID', $this->serviceId);
        }

        return $this->serviceId;
    }

    /**
     * @throws \Exception when the account has no EasyDCIM service to act on
     */
    public function requireServiceId(): int
    {
        $serviceId = $this->serviceId();

        if ($serviceId === null) {
            throw new \Exception('EasyDCIM service ID could not be resolved for this account.');
        }

        return $serviceId;
    }

    /**
     * @throws \Exception when the account has no device assigned yet
     */
    public function requireDeviceId(): int
    {
        $deviceId = $this->deviceId();

        if ($deviceId === null) {
            throw new \Exception('No EasyDCIM device is assigned to this account.');
        }

        return $deviceId;
    }
}
