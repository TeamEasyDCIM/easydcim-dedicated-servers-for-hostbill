<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Floor;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Floor data structure from EasyDCIM API
 *
 * Represents floor information within a location/datacenter.
 */
class FloorData
{
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?int $number,
        public ?int $rows,
        public ?int $columns,
        public ?array $racks,
        public ?string $createdAt,
        public ?string $updatedAt,
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
            number: Arr::get($data, 'number', 0),
            rows: Arr::get($data, 'rows', 0),
            columns: Arr::get($data, 'columns', 0),
            racks: Arr::get($data, 'racks', []),
            createdAt: Arr::get($data, 'created_at', ''),
            updatedAt: Arr::get($data, 'updated_at', ''),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'number' => $this->number,
            'rows' => $this->rows,
            'columns' => $this->columns,
            'racks' => $this->racks,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
