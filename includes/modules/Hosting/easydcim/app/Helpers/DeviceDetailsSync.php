<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Helpers;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Device\DeviceData;

/**
 * Which account fields follow the EasyDCIM device, per the product's switches:
 * the dedicated IP and the additional IPs unless blocked, the domain only when
 * "Automatic Update of Domain" is on. Mirrors the WHMCS module keeping
 * dedicatedip / assignedips / domain in step with the device.
 *
 * An empty device value never overwrites what the account already has.
 */
class DeviceDetailsSync
{
    public const DEDICATED_IP   = 'option8';
    public const ADDITIONAL_IPS = 'option10';

    /**
     * @var array product module options
     */
    protected $options;

    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * False when the product blocks both IP updates and leaves the domain
     * alone - callers can skip fetching the device at all.
     */
    public function hasWork(): bool
    {
        return !$this->isOn('BlockUpdateOfDedicatedIP')
            || !$this->isOn('BlockUpdateOfAdditionalIpAddresses')
            || $this->isOn('EnableUpdateOfDomain');
    }

    /**
     * @param DeviceData|null $device
     * @return array{details: array<string, string>, domain: string|null}
     */
    public function changes($device): array
    {
        $metadata = (array) (($device === null ? null : $device->metadata) ?? []);
        $details  = [];
        $domain   = null;

        if (!$this->isOn('BlockUpdateOfDedicatedIP') && !empty($metadata['IP Address']))
        {
            $details[self::DEDICATED_IP] = (string) $metadata['IP Address'];
        }

        if (!$this->isOn('BlockUpdateOfAdditionalIpAddresses') && !empty($metadata['Additional IP Addresses']))
        {
            $details[self::ADDITIONAL_IPS] = (string) $metadata['Additional IP Addresses'];
        }

        if ($this->isOn('EnableUpdateOfDomain') && !empty($metadata['Hostname']))
        {
            $domain = (string) $metadata['Hostname'];
        }

        return ['details' => $details, 'domain' => $domain];
    }

    protected function isOn(string $key): bool
    {
        return ($this->options[$key] ?? '') == 'on';
    }
}
