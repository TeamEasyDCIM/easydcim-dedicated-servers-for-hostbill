<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Power;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class PowerPortData
{
    public ?int $id;
    public ?string $name;
    public ?string $status;
    public ?string $type;
    public ?string $description;
    public ?string $createdAt;
    public ?string $updatedAt;
    public function __construct(?int $id, ?string $name, ?string $status, ?string $type = null, ?string $description = null, ?string $createdAt = null, ?string $updatedAt = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
        $this->type = $type;
        $this->description = $description;
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
            Arr::get($data, 'status', ''),
            Arr::get($data, 'type'),
            Arr::get($data, 'description'),
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
            'status' => $this->status,
            'type' => $this->type,
            'description' => $this->description,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ], fn($value) => $value !== null);
    }
}
