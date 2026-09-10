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
    public ?int $id;
    public ?string $name;
    public ?int $number;
    public ?int $rows;
    public ?int $columns;
    public ?array $racks;
    public ?string $createdAt;
    public ?string $updatedAt;
    public function __construct(?int $id, ?string $name, ?int $number, ?int $rows, ?int $columns, ?array $racks, ?string $createdAt, ?string $updatedAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->number = $number;
        $this->rows = $rows;
        $this->columns = $columns;
        $this->racks = $racks;
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
            Arr::get($data, 'number', 0),
            Arr::get($data, 'rows', 0),
            Arr::get($data, 'columns', 0),
            Arr::get($data, 'racks', []),
            Arr::get($data, 'created_at', ''),
            Arr::get($data, 'updated_at', '')
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
