<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\User;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class UserData
{
    public ?int $id;
    public ?string $username;
    public ?string $email;
    public ?string $name;
    public ?string $firstname;
    public ?string $lastname;
    public $gender;
    public ?string $avatar;
    public ?string $largeAvatar;
    public ?string $company;
    public ?int $active;
    public ?string $status;
    public ?string $address1;
    public ?string $address2;
    public ?string $city;
    public ?string $state;
    public ?string $postcode;
    public ?string $countryCode;
    public ?string $countryName;
    public ?string $locale;
    public ?int $timezone;
    public ?string $lastLogin;
    public function __construct(?int $id, ?string $username, ?string $email, ?string $name, ?string $firstname, ?string $lastname, $gender, ?string $avatar, ?string $largeAvatar, ?string $company, ?int $active, ?string $status, ?string $address1, ?string $address2, ?string $city, ?string $state, ?string $postcode, ?string $countryCode, ?string $countryName, ?string $locale, ?int $timezone, ?string $lastLogin)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->name = $name;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->gender = $gender;
        $this->avatar = $avatar;
        $this->largeAvatar = $largeAvatar;
        $this->company = $company;
        $this->active = $active;
        $this->status = $status;
        $this->address1 = $address1;
        $this->address2 = $address2;
        $this->city = $city;
        $this->state = $state;
        $this->postcode = $postcode;
        $this->countryCode = $countryCode;
        $this->countryName = $countryName;
        $this->locale = $locale;
        $this->timezone = $timezone;
        $this->lastLogin = $lastLogin;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'id', 0),
            Arr::get($data, 'username', ''),
            Arr::get($data, 'email', ''),
            Arr::get($data, 'name', ''),
            Arr::get($data, 'firstname', ''),
            Arr::get($data, 'lastname', ''),
            Arr::get($data, 'gender', ''),
            Arr::get($data, 'avatar', ''),
            Arr::get($data, 'large_avatar', ''),
            Arr::get($data, 'company'),
            Arr::get($data, 'active', 0),
            Arr::get($data, 'status', ''),
            Arr::get($data, 'address1'),
            Arr::get($data, 'address2'),
            Arr::get($data, 'city'),
            Arr::get($data, 'state'),
            Arr::get($data, 'postcode'),
            Arr::get($data, 'country_code'),
            Arr::get($data, 'country_name', ''),
            Arr::get($data, 'locale'),
            Arr::get($data, 'timezone', 0),
            Arr::get($data, 'last_login')
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
