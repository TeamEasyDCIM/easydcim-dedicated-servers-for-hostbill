<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\System;

/**
 * Request for updating user profile
 */
class UpdateUserRequest
{
    public ?string $email;
    public ?string $firstName;
    public ?string $lastName;
    public ?string $phone;
    public ?string $company;
    public ?string $address;
    public ?string $city;
    public ?string $state;
    public ?string $zipCode;
    public ?string $country;
    public function __construct(?string $email = null, ?string $firstName = null, ?string $lastName = null, ?string $phone = null, ?string $company = null, ?string $address = null, ?string $city = null, ?string $state = null, ?string $zipCode = null, ?string $country = null)
    {
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phone = $phone;
        $this->company = $company;
        $this->address = $address;
        $this->city = $city;
        $this->state = $state;
        $this->zipCode = $zipCode;
        $this->country = $country;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'email' => $this->email,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'phone' => $this->phone,
            'company' => $this->company,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zipCode,
            'country' => $this->country,
        ], fn($value) => $value !== null);
    }
}
