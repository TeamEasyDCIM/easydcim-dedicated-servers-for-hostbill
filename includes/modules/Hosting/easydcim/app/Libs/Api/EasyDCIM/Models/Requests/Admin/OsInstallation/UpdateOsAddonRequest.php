<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation;

/**
 * Request for updating an OS addon
 */
class UpdateOsAddonRequest
{
    /**
     * @param string|null $name Addon name
     * @param string|null $tag Tag identifier
     * @param string|null $type Addon type
     * @param string|null $description Description
     * @param string|null $data Addon data/configuration
     */
    public function __construct(
        public ?string $name = null,
        public ?string $tag = null,
        public ?string $type = null,
        public ?string $description = null,
        public ?string $data = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'tag' => $this->tag,
            'type' => $this->type,
            'description' => $this->description,
            'data' => $this->data,
        ], fn($value) => $value !== null);
    }
}
