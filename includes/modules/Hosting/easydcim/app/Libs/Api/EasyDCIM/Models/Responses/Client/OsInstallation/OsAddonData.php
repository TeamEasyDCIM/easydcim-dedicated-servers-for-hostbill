<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class OsAddonData
{
    public ?int $id;
    public ?string $name;
    public ?string $type;
    public ?string $description;
    public ?string $tag;
    public ?array $tags;
    public ?string $data;
    public ?bool $isDefault;
    public ?string $createdAt;
    public ?string $updatedAt;
    /**
     * @param array<string>|null $tags
     */
    public function __construct(?int $id, ?string $name, ?string $type, ?string $description = null, ?string $tag = null, ?array $tags = null, ?string $data = null, ?bool $isDefault = null, ?string $createdAt = null, ?string $updatedAt = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->description = $description;
        $this->tag = $tag;
        $this->tags = $tags;
        $this->data = $data;
        $this->isDefault = $isDefault;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'id', 0),
            Arr::get($data, 'name', ''),
            Arr::get($data, 'type', ''),
            Arr::get($data, 'description'),
            Arr::get($data, 'tag'),
            Arr::get($data, 'tags'),
            Arr::get($data, 'data'),
            Arr::get($data, 'is_default'),
            Arr::get($data, 'created_at'),
            Arr::get($data, 'updated_at')
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'description' => $this->description,
            'tag' => $this->tag,
            'tags' => $this->tags,
            'data' => $this->data,
            'is_default' => $this->isDefault,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ], fn($value) => $value !== null);
    }
}
