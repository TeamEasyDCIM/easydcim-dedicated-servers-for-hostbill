<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation;

/**
 * Request for showing an OS template (with optional addons)
 */
class ShowOsTemplateRequest
{
    public ?int $withAddons;
    /**
     * @param int|null $withAddons Include addons (1/0)
     */
    public function __construct(?int $withAddons = null)
    {
        $this->withAddons = $withAddons;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'with_addons' => $this->withAddons,
        ], fn($value) => $value !== null);
    }
}
