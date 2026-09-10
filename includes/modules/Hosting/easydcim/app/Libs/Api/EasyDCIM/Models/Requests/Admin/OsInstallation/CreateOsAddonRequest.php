<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation;

/**
 * Request for creating an OS addon
 */
class CreateOsAddonRequest
{
    public string $name;
    public string $tag;
    public string $type;
    public ?string $description;
    public ?string $data;
    /**
     * @param string $name Addon name
     * @param string $tag Tag identifier
     * @param string $type Addon type
     * @param string|null $description Description
     * @param string|null $data Addon data/configuration
     */
    public function __construct(string $name, string $tag, string $type, ?string $description = null, ?string $data = null)
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
