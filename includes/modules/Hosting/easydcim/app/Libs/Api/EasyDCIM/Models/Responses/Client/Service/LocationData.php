<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Service;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class LocationData
{
    public ?int $id;
    public ?string $name;
    public ?string $address;
    public ?string $city;
    public ?string $state;
    public ?string $description;
    public ?string $phone;
    public ?string $zip;
    public ?string $country;
    public ?string $notes;
    public function __construct(?int $id, ?string $name, ?string $address, ?string $city, ?string $state, ?string $description, ?string $phone, ?string $zip, ?string $country, ?string $notes)
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->city = $city;
        $this->state = $state;
        $this->description = $description;
        $this->phone = $phone;
        $this->zip = $zip;
        $this->country = $country;
        $this->notes = $notes;
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
            Arr::get($data, 'address', ''),
            Arr::get($data, 'city', ''),
            Arr::get($data, 'state', ''),
            Arr::get($data, 'description', ''),
            Arr::get($data, 'phone', ''),
            Arr::get($data, 'zip', ''),
            Arr::get($data, 'country', ''),
            Arr::get($data, 'notes', '')
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
