<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Device\DevicePowerActionRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Device\DeviceData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Interfaces\IClient;

class ServiceActions
{
    /**
     * Metadata EasyDCIM must hold before a noVNC session can be opened.
     */
    protected const IPMI_METADATA = ['IPMI IP Address', 'IPMI Username', 'IPMI Password'];

    /**
     * @var EasyDCIMClient
     */
    protected $api;

    /**
     * @var IClient
     */
    protected $client;

    public function __construct($api, $client)
    {
        $this->api = $api;
        $this->client = $client;
    }

    public function manageServiceActions($action)
    {
        try {
            $deviceId = $this->client->getEasyServerID();

            switch ($action) {
                case "boot":
                    $this->powerAction($deviceId, 'boot', 'Server Was Boot Successfully');
                    break;

                case "shutdown":
                    $this->powerAction($deviceId, 'shutdown', 'Server Was Shutdown Successfully');
                    break;

                case "reboot":
                    $this->powerAction($deviceId, 'reboot', 'Server Was Reboot Successfully');
                    break;

                case "bmcColdReset":
                    $result = $this->api->admin()->ipmi()->bmcColdReset($deviceId);

                    if ($result->success === false) {
                        $this->fail($result->message);
                    }

                    self::jsonEncode(['success' => 'BMC Cold Reset Successfull']);
                    break;

                case "enableRescueMode":
                    $result = $this->api->admin()->osInstallation()->enableRescueMode($deviceId);

                    if ($result->success === false) {
                        $this->fail($result->message);
                    }

                    self::jsonEncode(['success' => 'Enable Rescue Mode Successfull']);
                    break;

                case "noVNCConsole":
                    try {
                        if ($this->checkIsIPMIEnable($deviceId) === false) {
                            throw new \Exception('IPMI is not enabled');
                        }

                        $result = $this->api->admin()->ipmi()->startNoVncSession($deviceId);

                        if ($result->success === false) {
                            $this->fail($result->message);
                        }

                        self::jsonEncode([
                            'success' => 'noVNC KVM Console Launched Successfully',
                            'url'     => $result->data === null ? null : $result->data->url,
                        ]);
                    } catch (\Exception $e) {
                        $this->fail($e->getMessage());
                    }
                    break;

                case "logIntoPanel":
                    try {
                        // Client-scoped call: the API client already impersonates
                        // the account's owner, so the link is issued for them.
                        $result = $this->api->client()->users()->getAutoLoginLink();

                        if ($result->success === false || empty($result->data === null ? null : $result->data->link)) {
                            throw new \Exception($result->message ?: 'Account Not Exist');
                        }

                        self::jsonEncode([
                            'success' => 'You have been redirected correctlly',
                            'url'     => $result->data->link,
                        ]);
                    } catch (\Exception $e) {
                        $this->fail($e->getMessage());
                    }
                    break;
            }
        } catch (\RuntimeException $e) {
        }

        return '';
    }

    protected function powerAction($deviceId, string $action, string $successMessage): void
    {
        $result = $this->api->admin()->devices()->powerAction($deviceId, new DevicePowerActionRequest($action));

        if ($result->success === false) {
            $this->fail($result->message);
        }

        self::jsonEncode(['success' => $successMessage]);
    }

    /**
     * Answer the AJAX caller with an error and stop.
     */
    protected function fail(?string $message): void
    {
        header('HTTP/1.1 400 Bad Request');
        self::jsonEncode(['errors' => $message ?: 'The action could not be completed.']);
    }

    public static function jsonEncode(array $data)
    {
        ob_clean();
        echo(json_encode([
            'data'=>$data
        ]));
        die;
    }

    private function checkIsIPMIEnable($deviceId): bool
    {
        $device = $this->api->admin()->devices()->show($deviceId)->data;

        return $this->checkMetadataPresent($device, self::IPMI_METADATA);
    }

    protected function checkMetadataPresent(?DeviceData $device, array $requiredProperties): bool
    {
        foreach ($requiredProperties as $property) {
            if (empty(($device === null ? null : $device->metadata)[$property] ?? null)) {
                return false;
            }
        }

        return true;
    }
}
