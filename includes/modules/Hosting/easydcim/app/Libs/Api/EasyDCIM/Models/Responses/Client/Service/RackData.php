<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Service;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class RackData
{
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?int $locationId,
        public ?FloorData $floor,
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
            locationId: Arr::get($data, 'location_id', 0),
            floor: FloorData::fromArray(Arr::get($data, 'floor', [])),
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
            'location_id' => $this->locationId,
            'floor' => $this->floor->toArray(),
        ];
    }
}
