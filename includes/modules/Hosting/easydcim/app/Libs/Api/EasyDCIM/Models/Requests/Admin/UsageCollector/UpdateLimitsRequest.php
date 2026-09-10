<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\UsageCollector;

/**
 * Request for updating device usage/bandwidth limits
 */
class UpdateLimitsRequest
{
    public string $limitType;
    public ?float $bandwidth;
    public ?string $bandwidthUnit;
    public ?float $bandwidthIn;
    public ?string $bandwidthInUnit;
    public ?float $bandwidthOut;
    public ?string $bandwidthOutUnit;
    public ?float $percentile;
    public ?int $disableTrafficAggregationPorts;
    public ?string $intervalStartDay;
    public ?bool $enableNotifications;
    public ?int $timeUnit;
    public ?int $warningNotificationThreshold;
    public function __construct(string $limitType = 'TrafficAggregation', ?float $bandwidth = null, ?string $bandwidthUnit = null, ?float $bandwidthIn = null, ?string $bandwidthInUnit = null, ?float $bandwidthOut = null, ?string $bandwidthOutUnit = null, ?float $percentile = null, ?int $disableTrafficAggregationPorts = null, ?string $intervalStartDay = null, ?bool $enableNotifications = null, ?int $timeUnit = null, ?int $warningNotificationThreshold = null)
    {
        $this->limitType = $limitType;
        $this->bandwidth = $bandwidth;
        $this->bandwidthUnit = $bandwidthUnit;
        $this->bandwidthIn = $bandwidthIn;
        $this->bandwidthInUnit = $bandwidthInUnit;
        $this->bandwidthOut = $bandwidthOut;
        $this->bandwidthOutUnit = $bandwidthOutUnit;
        $this->percentile = $percentile;
        $this->disableTrafficAggregationPorts = $disableTrafficAggregationPorts;
        $this->intervalStartDay = $intervalStartDay;
        $this->enableNotifications = $enableNotifications;
        $this->timeUnit = $timeUnit;
        $this->warningNotificationThreshold = $warningNotificationThreshold;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $config = array_filter([
            'bandwidth' => $this->bandwidth,
            'bandwidth_unit' => $this->bandwidthUnit,
            'bandwidth_in' => $this->bandwidthIn,
            'bandwidth_in_unit' => $this->bandwidthInUnit,
            'bandwidth_out' => $this->bandwidthOut,
            'bandwidth_out_unit' => $this->bandwidthOutUnit,
            'percentile' => $this->percentile,
            'disable_traffic_aggregation_ports' => $this->disableTrafficAggregationPorts,
            'interval_start_day' => $this->intervalStartDay,
            'enable_notifications' => $this->enableNotifications,
            'time_unit' => $this->timeUnit,
            'warning_notification_treshold' => $this->warningNotificationThreshold,
        ], fn($value) => $value !== null);

        return [
            'limit_type' => $this->limitType,
            'config' => $config,
        ];
    }
}
