<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Provisioning Server Configuration data
 */
class ProvisioningServerConfigurationData
{
    public ?int $app;
    public ?string $rebootmethod;
    public ?string $nameserver1;
    public ?string $nameserver2;
    public ?string $emailsToAdmin;
    public ?string $admin;
    public ?string $emailsToClient;
    public ?string $rescueTemplate;
    public ?string $reinstallTemplate;
    public ?string $bootloader;
    /**
     * @param int|null $app
     * @param string|null $rebootmethod
     * @param string|null $nameserver1
     * @param string|null $nameserver2
     * @param string|null $emailsToAdmin
     * @param string|null $admin
     * @param string|null $emailsToClient
     * @param string|null $rescueTemplate
     * @param string|null $reinstallTemplate
     * @param string|null $bootloader
     */
    public function __construct(?int    $app = null, ?string $rebootmethod = null, ?string $nameserver1 = null, ?string $nameserver2 = null, ?string $emailsToAdmin = null, ?string $admin = null, ?string $emailsToClient = null, ?string $rescueTemplate = null, ?string $reinstallTemplate = null, ?string $bootloader = null)
    {
        $this->app = $app;
        $this->rebootmethod = $rebootmethod;
        $this->nameserver1 = $nameserver1;
        $this->nameserver2 = $nameserver2;
        $this->emailsToAdmin = $emailsToAdmin;
        $this->admin = $admin;
        $this->emailsToClient = $emailsToClient;
        $this->rescueTemplate = $rescueTemplate;
        $this->reinstallTemplate = $reinstallTemplate;
        $this->bootloader = $bootloader;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'app'),
            Arr::get($data, 'rebootmethod'),
            Arr::get($data, 'nameserver_1'),
            Arr::get($data, 'nameserver_2'),
            Arr::get($data, 'emails_to_admin'),
            Arr::get($data, 'admin'),
            Arr::get($data, 'emails_to_client'),
            Arr::get($data, 'rescue_template'),
            Arr::get($data, 'reinstall_template'),
            Arr::get($data, 'bootloader')
        );
    }
}