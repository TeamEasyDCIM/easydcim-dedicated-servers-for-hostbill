<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Sensors;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class SensorData
{
    public function __construct(
        public ?int $id,
        public ?int $itemId = null,
        public ?string $name = null,
        public ?string $class = null,
        public ?string $type = null,
        public ?string $unit = null,
        public ?string $index = null,
        public ?string $reading = null,
        public ?string $lastPolled = null,
        public mixed $configuration = null,
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
            itemId: Arr::get($data, 'item_id'),
            name: Arr::get($data, 'name'),
            class: Arr::get($data, 'class'),
            type: Arr::get($data, 'type'),
            unit: Arr::get($data, 'unit'),
            index: Arr::get($data, 'index'),
            reading: Arr::get($data, 'reading'),
            lastPolled: Arr::get($data, 'last_polled'),
            configuration: Arr::get($data, 'configuration'),
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
