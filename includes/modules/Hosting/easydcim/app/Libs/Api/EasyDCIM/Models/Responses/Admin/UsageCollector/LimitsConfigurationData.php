<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\UsageCollector;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Configuration entry in limits response
 */
class LimitsConfigurationData
{
    public function __construct(
        public ?int $id = null,
        public ?string $driver = null,
        public ?bool $enabled = null,
        public ?LimitsConfigData $config = null,
        public ?string $createdAt = null,
        public ?string $updatedAt = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $configData = Arr::get($data, 'config');

        return new self(
            id: Arr::get($data, 'id') !== null ? (int) Arr::get($data, 'id') : null,
            driver: Arr::get($data, 'driver'),
            enabled: Arr::get($data, 'enabled') !== null ? (bool) Arr::get($data, 'enabled') : null,
            config: $configData !== null ? LimitsConfigData::fromArray($configData) : null,
            createdAt: Arr::get($data, 'created_at'),
            updatedAt: Arr::get($data, 'updated_at'),
        );
    }
}
