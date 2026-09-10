<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\UsageCollector;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Usage collector configuration data
 */
class LimitsConfigData
{
    public ?float $bandwidth;
    public ?string $bandwidthUnit;
    public ?float $bandwidthIn;
    public ?string $bandwidthInUnit;
    public ?float $bandwidthOut;
    public ?string $bandwidthOutUnit;
    public ?float $percentile;
    public ?string $intervalStartDay;
    public ?int $disableTrafficAggregationPorts;
    public ?bool $enableNotifications;
    public ?int $timeUnit;
    public ?int $warningNotificationThreshold;
    public function __construct(?float $bandwidth = null, ?string $bandwidthUnit = null, ?float $bandwidthIn = null, ?string $bandwidthInUnit = null, ?float $bandwidthOut = null, ?string $bandwidthOutUnit = null, ?float $percentile = null, ?string $intervalStartDay = null, ?int $disableTrafficAggregationPorts = null, ?bool $enableNotifications = null, ?int $timeUnit = null, ?int $warningNotificationThreshold = null)
    {
        $this->bandwidth = $bandwidth;
        $this->bandwidthUnit = $bandwidthUnit;
        $this->bandwidthIn = $bandwidthIn;
        $this->bandwidthInUnit = $bandwidthInUnit;
        $this->bandwidthOut = $bandwidthOut;
        $this->bandwidthOutUnit = $bandwidthOutUnit;
        $this->percentile = $percentile;
        $this->intervalStartDay = $intervalStartDay;
        $this->disableTrafficAggregationPorts = $disableTrafficAggregationPorts;
        $this->enableNotifications = $enableNotifications;
        $this->timeUnit = $timeUnit;
        $this->warningNotificationThreshold = $warningNotificationThreshold;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'bandwidth') !== null ? (float) Arr::get($data, 'bandwidth') : null,
            Arr::get($data, 'bandwidth_unit'),
            Arr::get($data, 'bandwidth_in') !== null ? (float) Arr::get($data, 'bandwidth_in') : null,
            Arr::get($data, 'bandwidth_in_unit'),
            Arr::get($data, 'bandwidth_out') !== null ? (float) Arr::get($data, 'bandwidth_out') : null,
            Arr::get($data, 'bandwidth_out_unit'),
            Arr::get($data, 'percentile') !== null ? (float) Arr::get($data, 'percentile') : null,
            Arr::get($data, 'interval_start_day'),
            Arr::get($data, 'disable_traffic_aggregation_ports') !== null ? (int) Arr::get($data, 'disable_traffic_aggregation_ports') : null,
            Arr::get($data, 'enable_notifications') !== null ? (bool) Arr::get($data, 'enable_notifications') : null,
            Arr::get($data, 'time_unit') !== null ? (int) Arr::get($data, 'time_unit') : null,
            Arr::get($data, 'warning_notification_treshold') !== null ? (int) Arr::get($data, 'warning_notification_treshold') : null
        );
    }
}
