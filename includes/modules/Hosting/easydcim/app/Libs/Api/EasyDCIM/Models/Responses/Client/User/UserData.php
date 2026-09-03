<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\User;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Client user data structure
 */
class UserData
{
    public function __construct(
        public ?int $id,
        public ?string $username,
        public ?string $firstname,
        public ?string $lastname,
        public ?string $name,
        public ?string $email,
        public ?string $company,
        public ?string $avatar,
        public ?string $largeAvatar,
        public ?string $gender,
        public ?string $countryCode,
        public ?string $countryName,
        public ?int $active,
        public ?string $status,
        public ?string $lastLogin,
        public ?string $locale,
        public ?int $timezone,
        public ?bool $twoFactorEnabled,
    ) {}

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: Arr::get($data, 'id', 0),
            username: Arr::get($data, 'username', ''),
            firstname: Arr::get($data, 'firstname', ''),
            lastname: Arr::get($data, 'lastname', ''),
            name: Arr::get($data, 'name', ''),
            email: Arr::get($data, 'email', ''),
            company: Arr::get($data, 'company'),
            avatar: Arr::get($data, 'avatar', ''),
            largeAvatar: Arr::get($data, 'large_avatar', ''),
            gender: Arr::get($data, 'gender', ''),
            countryCode: Arr::get($data, 'country_code'),
            countryName: Arr::get($data, 'country_name', ''),
            active: Arr::get($data, 'active', 0),
            status: Arr::get($data, 'status', ''),
            lastLogin: Arr::get($data, 'last_login'),
            locale: Arr::get($data, 'locale'),
            timezone: Arr::get($data, 'timezone', 0),
            twoFactorEnabled: Arr::get($data, 'two_factor_enabled', false),
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
