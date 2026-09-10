<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\UsageCollector;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\BaseResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Response for getting device usage/bandwidth limits
 */
class GetLimitsResponse extends BaseResponse
{
    public ?int $id = null;
    public ?string $label = null;
    public ?string $model = null;
    public ?string $deviceStatus = null;
    public ?string $location = null;
    public ?array $metadata = null;
    /** @var array<LimitsConfigurationData> */
    public ?array $configurations = [];

    public static function fromArray(array $response)
    {
        $instance = parent::fromArray($response);
        $data = Arr::get($response, 'data', []);
        $instance->id = (int) Arr::get($data, 'id', 0);
        $instance->label = Arr::get($data, 'label', '');
        $instance->model = Arr::get($data, 'model', '');
        $instance->deviceStatus = Arr::get($data, 'device_status', '');
        $instance->location = Arr::get($data, 'location', '');
        $instance->metadata = Arr::get($data, 'metadata', []);
        $instance->configurations = array_map(
            fn($config) => LimitsConfigurationData::fromArray($config),
            Arr::get($data, 'configurations', [])
        );
        return $instance;
    }

    /**
     * Get TrafficAggregation configuration if exists
     *
     * @return LimitsConfigurationData|null
     */
    public function getTrafficAggregationConfig(): ?LimitsConfigurationData
    {
        foreach ($this->configurations as $config) {
            if ($config->driver === 'TrafficAggregation') {
                return $config;
            }
        }

        return null;
    }
}
