<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\UsageCollector;

/**
 * Request for updating device usage/bandwidth limits
 */
class UpdateLimitsRequest
{
    public function __construct(
        public string $limitType = 'TrafficAggregation',
        public ?float $bandwidth = null,
        public ?string $bandwidthUnit = null,
        public ?float $bandwidthIn = null,
        public ?string $bandwidthInUnit = null,
        public ?float $bandwidthOut = null,
        public ?string $bandwidthOutUnit = null,
        public ?float $percentile = null,
        public ?int $disableTrafficAggregationPorts = null,
        public ?string $intervalStartDay = null,
        public ?bool $enableNotifications = null,
        public ?int $timeUnit = null,
        public ?int $warningNotificationThreshold = null,
    ) {}

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
