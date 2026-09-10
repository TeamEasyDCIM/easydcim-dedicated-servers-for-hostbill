<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\User;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Client user data structure
 */
class UserData
{
    public ?int $id;
    public ?string $username;
    public ?string $firstname;
    public ?string $lastname;
    public ?string $name;
    public ?string $email;
    public ?string $company;
    public ?string $avatar;
    public ?string $largeAvatar;
    public ?string $gender;
    public ?string $countryCode;
    public ?string $countryName;
    public ?int $active;
    public ?string $status;
    public ?string $lastLogin;
    public ?string $locale;
    public ?int $timezone;
    public ?bool $twoFactorEnabled;
    public function __construct(?int $id, ?string $username, ?string $firstname, ?string $lastname, ?string $name, ?string $email, ?string $company, ?string $avatar, ?string $largeAvatar, ?string $gender, ?string $countryCode, ?string $countryName, ?int $active, ?string $status, ?string $lastLogin, ?string $locale, ?int $timezone, ?bool $twoFactorEnabled)
    {
        $this->id = $id;
        $this->username = $username;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->name = $name;
        $this->email = $email;
        $this->company = $company;
        $this->avatar = $avatar;
        $this->largeAvatar = $largeAvatar;
        $this->gender = $gender;
        $this->countryCode = $countryCode;
        $this->countryName = $countryName;
        $this->active = $active;
        $this->status = $status;
        $this->lastLogin = $lastLogin;
        $this->locale = $locale;
        $this->timezone = $timezone;
        $this->twoFactorEnabled = $twoFactorEnabled;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'id', 0),
            Arr::get($data, 'username', ''),
            Arr::get($data, 'firstname', ''),
            Arr::get($data, 'lastname', ''),
            Arr::get($data, 'name', ''),
            Arr::get($data, 'email', ''),
            Arr::get($data, 'company'),
            Arr::get($data, 'avatar', ''),
            Arr::get($data, 'large_avatar', ''),
            Arr::get($data, 'gender', ''),
            Arr::get($data, 'country_code'),
            Arr::get($data, 'country_name', ''),
            Arr::get($data, 'active', 0),
            Arr::get($data, 'status', ''),
            Arr::get($data, 'last_login'),
            Arr::get($data, 'locale'),
            Arr::get($data, 'timezone', 0),
            Arr::get($data, 'two_factor_enabled', false)
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'name' => $this->name,
            'email' => $this->email,
            'company' => $this->company,
            'avatar' => $this->avatar,
            'large_avatar' => $this->largeAvatar,
            'gender' => $this->gender,
            'country_code' => $this->countryCode,
            'country_name' => $this->countryName,
            'active' => $this->active,
            'status' => $this->status,
            'last_login' => $this->lastLogin,
            'locale' => $this->locale,
            'timezone' => $this->timezone,
            'two_factor_enabled' => $this->twoFactorEnabled,
        ];
    }
}
