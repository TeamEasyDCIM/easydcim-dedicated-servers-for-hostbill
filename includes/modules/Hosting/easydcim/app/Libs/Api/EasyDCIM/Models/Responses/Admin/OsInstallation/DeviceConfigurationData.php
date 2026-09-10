<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Device Configuration data
 */
class DeviceConfigurationData
{
    public ?string $gateway;
    public ?string $netmask;
    public ?string $nameserver1;
    public ?string $nameserver2;
    public ?string $rebootmethod;
    public ?string $bootloader;
    public function __construct(?string $gateway, ?string $netmask, ?string $nameserver1, ?string $nameserver2, ?string $rebootmethod, ?string $bootloader)
    {
        $this->gateway = $gateway;
        $this->netmask = $netmask;
        $this->nameserver1 = $nameserver1;
        $this->nameserver2 = $nameserver2;
        $this->rebootmethod = $rebootmethod;
        $this->bootloader = $bootloader;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'gateway', ''),
            Arr::get($data, 'netmask', ''),
            Arr::get($data, 'nameserver_1', ''),
            Arr::get($data, 'nameserver_2', ''),
            Arr::get($data, 'rebootmethod', ''),
            Arr::get($data, 'bootloader', '')
        );
    }
}
