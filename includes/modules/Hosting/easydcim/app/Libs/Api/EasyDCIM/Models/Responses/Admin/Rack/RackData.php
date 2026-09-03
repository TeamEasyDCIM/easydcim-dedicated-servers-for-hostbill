<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Rack;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Floor\FloorData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Location\LocationData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\User\UserData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Rack data structure from EasyDCIM API
 *
 * Represents rack information including identification, location, floor,
 * physical properties, and related entities.
 */
class RackData
{
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?int $floorId,
        public ?int $locationId,
        public ?string $description,
        public ?string $room,
        public ?int $unitsNumber,
        public null|int|float $weight,
        public null|int|float $speed,
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
            floorId: Arr::get($data, 'floor_id', 0),
            locationId: Arr::get($data, 'location_id', 0),
            description: Arr::get($data, 'description', ''),
            room: Arr::get($data, 'room'),
            unitsNumber: Arr::get($data, 'units_number', 0),
            weight: Arr::get($data, 'weight', 0),
            speed: Arr::get($data, 'speed', 0),
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
            'floor_id' => $this->floorId,
            'location_id' => $this->locationId,
            'description' => $this->description,
            'room' => $this->room,
            'units_number' => $this->unitsNumber,
            'weight' => $this->weight,
            'speed' => $this->speed,
        ];
    }
}

