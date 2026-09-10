<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\User;

/**
 * Request for creating a user
 */
class CreateUserRequest
{
    public string $email;
    public string $password;
    public ?string $username;
    public ?string $firstname;
    public ?string $lastname;
    public ?string $company;
    public ?string $dateOfBirth;
    public ?string $address1;
    public ?string $address2;
    public ?string $city;
    public ?string $state;
    public ?string $postcode;
    public ?string $countryCode;
    public ?string $locale;
    public ?string $timezone;
    public int $role;
    public int $active;
    public function __construct(string $email, string $password, ?string $username = null, ?string $firstname = null, ?string $lastname = null, ?string $company = null, ?string $dateOfBirth = null, ?string $address1 = null, ?string $address2 = null, ?string $city = null, ?string $state = null, ?string $postcode = null, ?string $countryCode = null, ?string $locale = null, ?string $timezone = null, int $role = 2, int $active = 1)
    {
        $this->email = $email;
        $this->password = $password;
        $this->username = $username;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->company = $company;
        $this->dateOfBirth = $dateOfBirth;
        $this->address1 = $address1;
        $this->address2 = $address2;
        $this->city = $city;
        $this->state = $state;
        $this->postcode = $postcode;
        $this->countryCode = $countryCode;
        $this->locale = $locale;
        $this->timezone = $timezone;
        $this->role = $role;
        $this->active = $active;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password,
            'role' => $this->role,
            'active' => $this->active,
        ];

        if ($this->username !== null) {
            $data['username'] = $this->username;
        }

        if ($this->firstname !== null) {
            $data['firstname'] = $this->firstname;
        }

        if ($this->lastname !== null) {
            $data['lastname'] = $this->lastname;
        }

        if ($this->company !== null) {
            $data['company'] = $this->company;
        }

        if ($this->dateOfBirth !== null) {
            $data['date_of_birth'] = $this->dateOfBirth;
        }

        if ($this->address1 !== null) {
            $data['address1'] = $this->address1;
        }

        if ($this->address2 !== null) {
            $data['address2'] = $this->address2;
        }

        if ($this->city !== null) {
            $data['city'] = $this->city;
        }

        if ($this->state !== null) {
            $data['state'] = $this->state;
        }

        if ($this->postcode !== null) {
            $data['postcode'] = $this->postcode;
        }

        if ($this->countryCode !== null) {
            $data['country_code'] = $this->countryCode;
        }

        if ($this->locale !== null) {
            $data['locale'] = $this->locale;
        }

        if ($this->timezone !== null) {
            $data['timezone'] = $this->timezone;
        }

        return $data;
    }
}
