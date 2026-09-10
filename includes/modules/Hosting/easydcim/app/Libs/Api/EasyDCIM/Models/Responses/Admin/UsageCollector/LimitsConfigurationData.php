<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\UsageCollector;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Configuration entry in limits response
 */
class LimitsConfigurationData
{
    public ?int $id;
    public ?string $driver;
    public ?bool $enabled;
    public ?LimitsConfigData $config;
    public ?string $createdAt;
    public ?string $updatedAt;
    public function __construct(?int $id = null, ?string $driver = null, ?bool $enabled = null, ?LimitsConfigData $config = null, ?string $createdAt = null, ?string $updatedAt = null)
    {
        $this->id = $id;
        $this->driver = $driver;
        $this->enabled = $enabled;
        $this->config = $config;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $configData = Arr::get($data, 'config');

        return new self(
            Arr::get($data, 'id') !== null ? (int) Arr::get($data, 'id') : null,
            Arr::get($data, 'driver'),
            Arr::get($data, 'enabled') !== null ? (bool) Arr::get($data, 'enabled') : null,
            $configData !== null ? LimitsConfigData::fromArray($configData) : null,
            Arr::get($data, 'created_at'),
            Arr::get($data, 'updated_at')
        );
    }
}
