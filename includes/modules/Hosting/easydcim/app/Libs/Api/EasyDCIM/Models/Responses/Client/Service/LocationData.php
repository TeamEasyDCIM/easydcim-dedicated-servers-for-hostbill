<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Service;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class LocationData
{
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?string $address,
        public ?string $city,
        public ?string $state,
        public ?string $description,
        public ?string $phone,
        public ?string $zip,
        public ?string $country,
        public ?string $notes,
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
            address: Arr::get($data, 'address', ''),
            city: Arr::get($data, 'city', ''),
            state: Arr::get($data, 'state', ''),
            description: Arr::get($data, 'description', ''),
            phone: Arr::get($data, 'phone', ''),
            zip: Arr::get($data, 'zip', ''),
            country: Arr::get($data, 'country', ''),
            notes: Arr::get($data, 'notes', ''),
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
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'description' => $this->description,
            'phone' => $this->phone,
            'zip' => $this->zip,
            'country' => $this->country,
            'notes' => $this->notes,
        ];
    }
}
