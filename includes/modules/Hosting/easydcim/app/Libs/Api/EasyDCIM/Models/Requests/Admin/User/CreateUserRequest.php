<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\User;

/**
 * Request for creating a user
 */
class CreateUserRequest
{
    public function __construct(
        public string $email,
        public string $password,
        public ?string $username = null,
        public ?string $firstname = null,
        public ?string $lastname = null,
        public ?string $company = null,
        public ?string $dateOfBirth = null,
        public ?string $address1 = null,
        public ?string $address2 = null,
        public ?string $city = null,
        public ?string $state = null,
        public ?string $postcode = null,
        public ?string $countryCode = null,
        public ?string $locale = null,
        public ?string $timezone = null,
        public int $role = 2,
        public int $active = 1,
    ) {}

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
