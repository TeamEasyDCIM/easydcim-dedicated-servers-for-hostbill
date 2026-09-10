<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Location;

/**
 * Request for creating a location
 */
class CreateLocationRequest
{
    public string $name;
    public ?string $address;
    public ?string $city;
    public ?string $country;
    public ?string $phone;
    public ?string $description;
    public function __construct(string $name, ?string $address = null, ?string $city = null, ?string $country = null, ?string $phone = null, ?string $description = null)
    {
        $this->name = $name;
        $this->address = $address;
        $this->city = $city;
        $this->country = $country;
        $this->phone = $phone;
        $this->description = $description;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
            'phone' => $this->phone,
            'description' => $this->description,
        ], fn($value) => $value !== null);
    }
}
