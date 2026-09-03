<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\User;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class UserData
{
    public function __construct(
        public ?int $id,
        public ?string $username,
        public ?string $email,
        public ?string $name,
        public ?string $firstname,
        public ?string $lastname,
        public null|string|int $gender,
        public ?string $avatar,
        public ?string $largeAvatar,
        public ?string $company,
        public ?int $active,
        public ?string $status,
        public ?string $address1,
        public ?string $address2,
        public ?string $city,
        public ?string $state,
        public ?string $postcode,
        public ?string $countryCode,
        public ?string $countryName,
        public ?string $locale,
        public ?int $timezone,
        public ?string $lastLogin,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: Arr::get($data, 'id', 0),
            username: Arr::get($data, 'username', ''),
            email: Arr::get($data, 'email', ''),
            name: Arr::get($data, 'name', ''),
            firstname: Arr::get($data, 'firstname', ''),
            lastname: Arr::get($data, 'lastname', ''),
            gender: Arr::get($data, 'gender', ''),
            avatar: Arr::get($data, 'avatar', ''),
            largeAvatar: Arr::get($data, 'large_avatar', ''),
            company: Arr::get($data, 'company'),
            active: Arr::get($data, 'active', 0),
            status: Arr::get($data, 'status', ''),
            address1: Arr::get($data, 'address1'),
            address2: Arr::get($data, 'address2'),
            city: Arr::get($data, 'city'),
            state: Arr::get($data, 'state'),
            postcode: Arr::get($data, 'postcode'),
            countryCode: Arr::get($data, 'country_code'),
            countryName: Arr::get($data, 'country_name', ''),
            locale: Arr::get($data, 'locale'),
            timezone: Arr::get($data, 'timezone', 0),
            lastLogin: Arr::get($data, 'last_login'),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'name' => $this->name,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'gender' => $this->gender,
            'avatar' => $this->avatar,
            'large_avatar' => $this->largeAvatar,
            'company' => $this->company,
            'active' => $this->active,
            'status' => $this->status,
            'address1' => $this->address1,
            'address2' => $this->address2,
            'city' => $this->city,
            'state' => $this->state,
            'postcode' => $this->postcode,
            'country_code' => $this->countryCode,
            'country_name' => $this->countryName,
            'locale' => $this->locale,
            'timezone' => $this->timezone,
            'last_login' => $this->lastLogin,
        ];
    }
}
