<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Device;

/**
 * Request for getting device bandwidth
 */
class GetDeviceBandwidthRequest
{
    /**
     * @param string $startDate Start date for bandwidth calculation
     * @param string $endDate End date for bandwidth calculation
     * @param string|null $units Units for bandwidth (optional)
     * @param array<int>|null $ports Array of port IDs (optional)
     */
    public function __construct(
        public string $startDate,
        public string $endDate,
        public ?string $units = null,
        public ?array $ports = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'units' => $this->units,
            'ports' => $this->ports,
        ], fn($value) => $value !== null);
    }
}
