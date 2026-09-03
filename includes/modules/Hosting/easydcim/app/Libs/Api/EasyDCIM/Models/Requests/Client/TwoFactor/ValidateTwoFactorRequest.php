<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\TwoFactor;

/**
 * Request for validating two-factor authentication code
 */
class ValidateTwoFactorRequest
{
    /**
     * @param array<string, string> $configuration
     */
    public function __construct(
        public array $configuration,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
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
            configuration: $data['configuration'] ?? [],
        );
    }
}
