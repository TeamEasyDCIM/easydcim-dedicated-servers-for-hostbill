<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\TwoFactor;

/**
 * Request for disabling two-factor authentication
 */
class DisableTwoFactorRequest
{
    public string $password;
    public function __construct(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'password' => $this->password,
        ];
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['password']
        );
    }
}
