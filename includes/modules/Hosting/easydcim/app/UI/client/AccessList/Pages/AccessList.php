<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\client\AccessList\Pages;

use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\ExtensionChecker;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\PasswordManagement\ListAccessDetailsRequest;

class AccessList
{
    /**
     * @var EasyDCIMClient
     */
    protected $api;

    protected $serverId;

    protected $accessList = [];

    public function __construct($api, $serverId)
    {
        $this->api = $api;
        $this->serverId = $serverId;
        $this->accessList = $this->getAccessList();
    }

    public function getData(): array
    {
        $data = [];

        foreach ($this->accessList as $value)
        {
            $data[] = [
                'name'     => $value->name,
                'username' => $value->username,
                'password' => $value->password,
            ];
        }

        return $data;
    }

    /**
     * Access details the password manager holds for this account's device.
     *
     * The endpoint is client-scoped: it returns what the impersonated user is
     * allowed to see, which is then narrowed to the device HostBill provisioned.
     *
     * @return array<\ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\PasswordManagement\AccessDetailData>
     */
    protected function getAccessList(): array
    {
        if (!ExtensionChecker::isPasswordManagerActive($this->api)) {
            return [];
        }

        try {
            $details = $this->api->client()->passwordManagement()->listAllAccessDetails(new ListAccessDetailsRequest());
        } catch (\Exception $ex) {
            return [];
        }

        $list = [];

        foreach ($details as $item) {
            if ($item->deviceId !== null && (int) $item->deviceId === (int) $this->serverId) {
                $list[] = $item;
            }
        }

        return $list;
    }
}
