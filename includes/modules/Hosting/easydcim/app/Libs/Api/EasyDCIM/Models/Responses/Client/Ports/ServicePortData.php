<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Ports;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class ServicePortData
{
    public ?int $id;
    public ?string $name;
    public ?string $type;
    public ?string $speed;
    public ?string $mac;
    public ?string $status;
    public ?array $traffic;
    public ?string $createdAt;
    public ?string $updatedAt;
    public function __construct(?int $id, ?string $name, ?string $type, ?string $speed = null, ?string $mac = null, ?string $status = null, ?array $traffic = null, ?string $createdAt = null, ?string $updatedAt = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->speed = $speed;
        $this->mac = $mac;
        $this->status = $status;
        $this->traffic = $traffic;
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
            Arr::get($data, 'speed'),
            Arr::get($data, 'mac'),
            Arr::get($data, 'status'),
            Arr::get($data, 'traffic'),
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
            'speed' => $this->speed,
            'mac' => $this->mac,
            'status' => $this->status,
            'traffic' => $this->traffic,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ], fn($value) => $value !== null);
    }
}
