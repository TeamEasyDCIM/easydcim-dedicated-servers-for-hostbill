<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\TwoFactor;

/**
 * Request for enabling two-factor authentication
 */
class EnableTwoFactorRequest
{
    public string $moduleName;
    public function __construct(string $moduleName = 'Totp')
    {
        $this->moduleName = $moduleName;
    }

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
            $data['module_name'] ?? $data['moduleName'] ?? 'Totp'
        );
    }
}
