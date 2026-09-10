<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\TwoFactor;

/**
 * Request for storing two-factor authentication configuration
 */
class StoreTwoFactorRequest
{
    public string $moduleName;
    public array $configuration;
    /**
     * @param array<string, string> $configuration
     */
    public function __construct(string $moduleName, array $configuration)
    {
        $this->moduleName = $moduleName;
        $this->configuration = $configuration;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'module_name' => $this->moduleName,
            'configuration' => $this->configuration,
        ];
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['module_name'] ?? $data['moduleName'],
            $data['configuration'] ?? []
        );
    }
}
