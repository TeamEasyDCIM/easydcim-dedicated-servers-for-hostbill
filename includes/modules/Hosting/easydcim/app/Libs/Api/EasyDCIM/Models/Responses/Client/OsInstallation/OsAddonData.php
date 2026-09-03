<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class OsAddonData
{
    /**
     * @param array<string>|null $tags
     */
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?string $type,
        public ?string $description = null,
        public ?string $tag = null,
        public ?array $tags = null,
        public ?string $data = null,
        public ?bool $isDefault = null,
        public ?string $createdAt = null,
        public ?string $updatedAt = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: Arr::get($data, 'id', 0),
            name: Arr::get($data, 'name', ''),
            type: Arr::get($data, 'type', ''),
            description: Arr::get($data, 'description'),
            tag: Arr::get($data, 'tag'),
            tags: Arr::get($data, 'tags'),
            data: Arr::get($data, 'data'),
            isDefault: Arr::get($data, 'is_default'),
            createdAt: Arr::get($data, 'created_at'),
            updatedAt: Arr::get($data, 'updated_at'),
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
