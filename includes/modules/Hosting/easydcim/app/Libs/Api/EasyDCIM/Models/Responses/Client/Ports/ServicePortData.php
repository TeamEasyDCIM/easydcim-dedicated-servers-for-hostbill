<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Ports;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class ServicePortData
{
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?string $type,
        public ?string $speed = null,
        public ?string $mac = null,
        public ?string $status = null,
        public ?array $traffic = null,
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
            speed: Arr::get($data, 'speed'),
            mac: Arr::get($data, 'mac'),
            status: Arr::get($data, 'status'),
            traffic: Arr::get($data, 'traffic'),
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
            'speed' => $this->speed,
            'mac' => $this->mac,
            'status' => $this->status,
            'traffic' => $this->traffic,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ], fn($value) => $value !== null);
    }
}
