<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation;

/**
 * Request for updating device configuration
 */
class UpdateDeviceConfigurationRequest
{
    public ?string $gateway;
    public ?string $netmask;
    public ?string $nameserver1;
    public ?string $nameserver2;
    public ?string $rebootmethod;
    public ?string $bootloader;
    /**
     * @param string|null $gateway Gateway IP address
     * @param string|null $netmask Network mask
     * @param string|null $nameserver1 Primary nameserver
     * @param string|null $nameserver2 Secondary nameserver
     * @param string|null $rebootmethod Reboot method
     * @param string|null $bootloader Bootloader type
     */
    public function __construct(?string $gateway = null, ?string $netmask = null, ?string $nameserver1 = null, ?string $nameserver2 = null, ?string $rebootmethod = null, ?string $bootloader = null)
    {
        $this->gateway = $gateway;
        $this->netmask = $netmask;
        $this->nameserver1 = $nameserver1;
        $this->nameserver2 = $nameserver2;
        $this->rebootmethod = $rebootmethod;
        $this->bootloader = $bootloader;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'gateway' => $this->gateway,
            'netmask' => $this->netmask,
            'nameserver_1' => $this->nameserver1,
            'nameserver_2' => $this->nameserver2,
            'rebootmethod' => $this->rebootmethod,
            'bootloader' => $this->bootloader,
        ], fn($value) => $value !== null);
    }
}
