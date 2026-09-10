<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation;

/**
 * Request for finding provisioning server
 */
class FindProvisioningServerRequest
{
    public const LOCATION_TYPE = 'location';
    public const DEVICE_TYPE = 'device';
    public ?string $findByType;

    /**
     * @param string|null $findByType Find by type
     */
    public function __construct(?string $findByType = null)
    {
        $this->findByType = $findByType;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'find_by_type' => $this->findByType,
        ], fn($value) => $value !== null);
    }
}
