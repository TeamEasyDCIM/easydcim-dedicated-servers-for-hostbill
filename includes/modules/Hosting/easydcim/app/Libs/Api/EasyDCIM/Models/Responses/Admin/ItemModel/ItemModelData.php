<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\ItemModel;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class ItemModelData
{
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?string $label,
        public ?int $typeId,
        public ?int $locationId,
        public ?string $status,
        public ?string $description,
        public ?bool $isPart,
        public ?bool $mountable,
        public ?string $manufacturer,
        public ?string $position,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: Arr::get($data, 'id', 0),
            name: Arr::get($data, 'name', ''),
            label: Arr::get($data, 'label', ''),
            typeId: Arr::get($data, 'type_id', 0),
            locationId: Arr::get($data, 'location_id', 0),
            status: Arr::get($data, 'status', ''),
            description: Arr::get($data, 'description', ''),
            isPart: (bool) Arr::get($data, 'is_part', false),
            mountable: (bool) Arr::get($data, 'mountable', false),
            manufacturer: Arr::get($data, 'manufacturer', ''),
            position: Arr::get($data, 'position', ''),
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
