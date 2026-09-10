<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\User;

/**
 * Request for updating user profile
 */
class UpdateUserRequest
{
    public ?string $email;
    public ?string $firstname;
    public ?string $lastname;
    public ?string $company;
    public ?string $locale;
    public ?int $timezone;
    public function __construct(?string $email = null, ?string $firstname = null, ?string $lastname = null, ?string $company = null, ?string $locale = null, ?int $timezone = null)
    {
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->company = $company;
        $this->locale = $locale;
        $this->timezone = $timezone;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'email' => $this->email,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'company' => $this->company,
            'locale' => $this->locale,
            'timezone' => $this->timezone,
        ], fn($value) => $value !== null);
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['email'] ?? null,
            $data['firstname'] ?? null,
            $data['lastname'] ?? null,
            $data['company'] ?? null,
            $data['locale'] ?? null,
            $data['timezone'] ?? null
        );
    }
}
