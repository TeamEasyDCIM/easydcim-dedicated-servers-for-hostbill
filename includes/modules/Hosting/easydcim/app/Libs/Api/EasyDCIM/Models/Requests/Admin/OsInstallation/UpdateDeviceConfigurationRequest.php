<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation;

/**
 * Request for updating device configuration
 */
class UpdateDeviceConfigurationRequest
{
    /**
     * @param string|null $gateway Gateway IP address
     * @param string|null $netmask Network mask
     * @param string|null $nameserver1 Primary nameserver
     * @param string|null $nameserver2 Secondary nameserver
     * @param string|null $rebootmethod Reboot method
     * @param string|null $bootloader Bootloader type
     */
    public function __construct(
        public ?string $gateway = null,
        public ?string $netmask = null,
        public ?string $nameserver1 = null,
        public ?string $nameserver2 = null,
        public ?string $rebootmethod = null,
        public ?string $bootloader = null,
    ) {}

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
