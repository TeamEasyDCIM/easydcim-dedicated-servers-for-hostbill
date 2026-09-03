<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\UsageCollector;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Usage collector configuration data
 */
class LimitsConfigData
{
    public function __construct(
        public ?float $bandwidth = null,
        public ?string $bandwidthUnit = null,
        public ?float $bandwidthIn = null,
        public ?string $bandwidthInUnit = null,
        public ?float $bandwidthOut = null,
        public ?string $bandwidthOutUnit = null,
        public ?float $percentile = null,
        public ?string $intervalStartDay = null,
        public ?int $disableTrafficAggregationPorts = null,
        public ?bool $enableNotifications = null,
        public ?int $timeUnit = null,
        public ?int $warningNotificationThreshold = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            bandwidth: Arr::get($data, 'bandwidth') !== null ? (float) Arr::get($data, 'bandwidth') : null,
            bandwidthUnit: Arr::get($data, 'bandwidth_unit'),
            bandwidthIn: Arr::get($data, 'bandwidth_in') !== null ? (float) Arr::get($data, 'bandwidth_in') : null,
            bandwidthInUnit: Arr::get($data, 'bandwidth_in_unit'),
            bandwidthOut: Arr::get($data, 'bandwidth_out') !== null ? (float) Arr::get($data, 'bandwidth_out') : null,
            bandwidthOutUnit: Arr::get($data, 'bandwidth_out_unit'),
            percentile: Arr::get($data, 'percentile') !== null ? (float) Arr::get($data, 'percentile') : null,
            intervalStartDay: Arr::get($data, 'interval_start_day'),
            disableTrafficAggregationPorts: Arr::get($data, 'disable_traffic_aggregation_ports') !== null ? (int) Arr::get($data, 'disable_traffic_aggregation_ports') : null,
            enableNotifications: Arr::get($data, 'enable_notifications') !== null ? (bool) Arr::get($data, 'enable_notifications') : null,
            timeUnit: Arr::get($data, 'time_unit') !== null ? (int) Arr::get($data, 'time_unit') : null,
            warningNotificationThreshold: Arr::get($data, 'warning_notification_treshold') !== null ? (int) Arr::get($data, 'warning_notification_treshold') : null,
        );
    }
}
