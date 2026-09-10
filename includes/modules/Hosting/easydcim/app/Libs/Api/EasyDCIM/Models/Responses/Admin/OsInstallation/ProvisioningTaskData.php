<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Provisioning Task data
 */
class ProvisioningTaskData
{
    public ?array $attributes;
    /**
     * @param array<string, mixed> $attributes
     */
    public function __construct(?array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data
        );
    }
}
