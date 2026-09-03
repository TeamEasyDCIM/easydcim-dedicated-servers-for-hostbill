<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Parts;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class ServicePartData
{
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?string $type,
        public ?string $model = null,
        public ?string $serial = null,
        public ?string $size = null,
        public ?string $description = null,
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
            model: Arr::get($data, 'model'),
            serial: Arr::get($data, 'serial'),
            size: Arr::get($data, 'size'),
            description: Arr::get($data, 'description'),
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
            'model' => $this->model,
            'serial' => $this->serial,
            'size' => $this->size,
            'description' => $this->description,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ], fn($value) => $value !== null);
    }
}
