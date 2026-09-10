<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation;

/**
 * Request for updating an OS addon
 */
class UpdateOsAddonRequest
{
    public ?string $name;
    public ?string $tag;
    public ?string $type;
    public ?string $description;
    public ?string $data;
    /**
     * @param string|null $name Addon name
     * @param string|null $tag Tag identifier
     * @param string|null $type Addon type
     * @param string|null $description Description
     * @param string|null $data Addon data/configuration
     */
    public function __construct(?string $name = null, ?string $tag = null, ?string $type = null, ?string $description = null, ?string $data = null)
    {
        $this->name = $name;
        $this->tag = $tag;
        $this->type = $type;
        $this->description = $description;
        $this->data = $data;
    }

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
