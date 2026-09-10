<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Service;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class RackData
{
    public ?int $id;
    public ?string $name;
    public ?int $locationId;
    public ?FloorData $floor;
    public function __construct(?int $id, ?string $name, ?int $locationId, ?FloorData $floor)
    {
        $this->id = $id;
        $this->name = $name;
        $this->locationId = $locationId;
        $this->floor = $floor;
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
            Arr::get($data, 'location_id', 0),
            FloorData::fromArray(Arr::get($data, 'floor', []))
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
