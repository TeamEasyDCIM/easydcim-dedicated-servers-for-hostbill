<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Device Configuration data
 */
class DeviceConfigurationData
{
    public function __construct(
        public ?string $gateway,
        public ?string $netmask,
        public ?string $nameserver1,
        public ?string $nameserver2,
        public ?string $rebootmethod,
        public ?string $bootloader,
    ) {}

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            gateway: Arr::get($data, 'gateway', ''),
            netmask: Arr::get($data, 'netmask', ''),
            nameserver1: Arr::get($data, 'nameserver_1', ''),
            nameserver2: Arr::get($data, 'nameserver_2', ''),
            rebootmethod: Arr::get($data, 'rebootmethod', ''),
            bootloader: Arr::get($data, 'bootloader', ''),
        );
    }
}
