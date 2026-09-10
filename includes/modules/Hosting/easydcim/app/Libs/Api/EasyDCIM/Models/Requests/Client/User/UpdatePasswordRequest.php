<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\User;

/**
 * Request for updating user password
 */
class UpdatePasswordRequest
{
    public string $currentPassword;
    public string $password;
    public string $passwordConfirmation;
    public function __construct(string $currentPassword, string $password, string $passwordConfirmation)
    {
        $this->currentPassword = $currentPassword;
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirmation;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'current_password' => $this->currentPassword,
            'password' => $this->password,
            'password_confirmation' => $this->passwordConfirmation,
        ];
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['current_password'] ?? $data['currentPassword'],
            $data['password'],
            $data['password_confirmation'] ?? $data['passwordConfirmation']
        );
    }
}
