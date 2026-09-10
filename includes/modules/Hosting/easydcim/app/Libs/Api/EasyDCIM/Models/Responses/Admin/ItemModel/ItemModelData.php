<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\ItemModel;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class ItemModelData
{
    public ?int $id;
    public ?string $name;
    public ?string $label;
    public ?int $typeId;
    public ?int $locationId;
    public ?string $status;
    public ?string $description;
    public ?bool $isPart;
    public ?bool $mountable;
    public ?string $manufacturer;
    public ?string $position;
    public function __construct(?int $id, ?string $name, ?string $label, ?int $typeId, ?int $locationId, ?string $status, ?string $description, ?bool $isPart, ?bool $mountable, ?string $manufacturer, ?string $position)
    {
        $this->id = $id;
        $this->name = $name;
        $this->label = $label;
        $this->typeId = $typeId;
        $this->locationId = $locationId;
        $this->status = $status;
        $this->description = $description;
        $this->isPart = $isPart;
        $this->mountable = $mountable;
        $this->manufacturer = $manufacturer;
        $this->position = $position;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'id', 0),
            Arr::get($data, 'name', ''),
            Arr::get($data, 'label', ''),
            Arr::get($data, 'type_id', 0),
            Arr::get($data, 'location_id', 0),
            Arr::get($data, 'status', ''),
            Arr::get($data, 'description', ''),
            (bool) Arr::get($data, 'is_part', false),
            (bool) Arr::get($data, 'mountable', false),
            Arr::get($data, 'manufacturer', ''),
            Arr::get($data, 'position', '')
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'label' => $this->label,
            'type_id' => $this->typeId,
            'location_id' => $this->locationId,
            'status' => $this->status,
            'description' => $this->description,
            'is_part' => $this->isPart,
            'mountable' => $this->mountable,
            'manufacturer' => $this->manufacturer,
            'position' => $this->position,
        ];
    }
}
