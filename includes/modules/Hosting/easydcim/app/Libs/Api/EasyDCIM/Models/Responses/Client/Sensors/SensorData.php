<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Sensors;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class SensorData
{
    public ?int $id;
    public ?int $itemId;
    public ?string $name;
    public ?string $class;
    public ?string $type;
    public ?string $unit;
    public ?string $index;
    public ?string $reading;
    public ?string $lastPolled;
    public $configuration;
    public ?string $createdAt;
    public ?string $updatedAt;
    public function __construct(?int $id, ?int $itemId = null, ?string $name = null, ?string $class = null, ?string $type = null, ?string $unit = null, ?string $index = null, ?string $reading = null, ?string $lastPolled = null, $configuration = null, ?string $createdAt = null, ?string $updatedAt = null)
    {
        $this->id = $id;
        $this->itemId = $itemId;
        $this->name = $name;
        $this->class = $class;
        $this->type = $type;
        $this->unit = $unit;
        $this->index = $index;
        $this->reading = $reading;
        $this->lastPolled = $lastPolled;
        $this->configuration = $configuration;
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
            Arr::get($data, 'item_id'),
            Arr::get($data, 'name'),
            Arr::get($data, 'class'),
            Arr::get($data, 'type'),
            Arr::get($data, 'unit'),
            Arr::get($data, 'index'),
            Arr::get($data, 'reading'),
            Arr::get($data, 'last_polled'),
            Arr::get($data, 'configuration'),
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
            'item_id' => $this->itemId,
            'name' => $this->name,
            'class' => $this->class,
            'type' => $this->type,
            'unit' => $this->unit,
            'index' => $this->index,
            'reading' => $this->reading,
            'last_polled' => $this->lastPolled,
            'configuration' => $this->configuration,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ], fn($value) => $value !== null);
    }
}
