<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\TwoFactor;

/**
 * Request for enabling two-factor authentication
 */
class EnableTwoFactorRequest
{
    public function __construct(
        public string $moduleName = 'Totp',
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'module_name' => $this->moduleName,
        ];
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            moduleName: $data['module_name'] ?? $data['moduleName'] ?? 'Totp',
        );
    }
}
