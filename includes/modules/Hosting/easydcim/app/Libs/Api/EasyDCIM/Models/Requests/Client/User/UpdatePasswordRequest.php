<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\User;

/**
 * Request for updating user password
 */
class UpdatePasswordRequest
{
    public function __construct(
        public string $currentPassword,
        public string $password,
        public string $passwordConfirmation,
    ) {}

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
            currentPassword: $data['current_password'] ?? $data['currentPassword'],
            password: $data['password'],
            passwordConfirmation: $data['password_confirmation'] ?? $data['passwordConfirmation'],
        );
    }
}
