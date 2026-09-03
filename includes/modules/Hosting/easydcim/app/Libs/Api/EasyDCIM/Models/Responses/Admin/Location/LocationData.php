<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Location;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Location data structure
 */
class LocationData
{
    public function __construct(
        public ?int $id,
        public ?string $appId,
        public ?string $name,
        public ?string $address,
        public ?string $city,
        public ?string $state,
        public ?string $description,
        public ?string $notes,
        public ?string $emergency,
        public ?string $phone,
        public ?string $flag,
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
            appId: Arr::get($data, 'app_id'),
            name: Arr::get($data, 'name', ''),
            address: Arr::get($data, 'address', ''),
            city: Arr::get($data, 'city', ''),
            state: Arr::get($data, 'state', ''),
            description: Arr::get($data, 'description', ''),
            notes: Arr::get($data, 'notes', ''),
            emergency: Arr::get($data, 'emergency', ''),
            phone: Arr::get($data, 'phone', ''),
            flag: Arr::get($data, 'flag', ''),
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
            'app_id' => $this->appId,
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'description' => $this->description,
            'notes' => $this->notes,
            'emergency' => $this->emergency,
            'phone' => $this->phone,
            'flag' => $this->flag,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
