<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Provisioning Server Configuration data
 */
class ProvisioningServerConfigurationData
{
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
    public function __construct(
        public ?int    $app = null,
        public ?string $rebootmethod = null,
        public ?string $nameserver1 = null,
        public ?string $nameserver2 = null,
        public ?string $emailsToAdmin = null,
        public ?string $admin = null,
        public ?string $emailsToClient = null,
        public ?string $rescueTemplate = null,
        public ?string $reinstallTemplate = null,
        public ?string $bootloader = null,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            app: Arr::get($data, 'app'),
            rebootmethod: Arr::get($data, 'rebootmethod'),
            nameserver1: Arr::get($data, 'nameserver_1'),
            nameserver2: Arr::get($data, 'nameserver_2'),
            emailsToAdmin: Arr::get($data, 'emails_to_admin'),
            admin: Arr::get($data, 'admin'),
            emailsToClient: Arr::get($data, 'emails_to_client'),
            rescueTemplate: Arr::get($data, 'rescue_template'),
            reinstallTemplate: Arr::get($data, 'reinstall_template'),
            bootloader: Arr::get($data, 'bootloader'),
        );
    }
}