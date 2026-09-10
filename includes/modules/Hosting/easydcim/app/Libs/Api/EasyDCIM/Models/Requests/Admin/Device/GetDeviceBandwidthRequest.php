<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Device;

/**
 * Request for getting device bandwidth
 */
class GetDeviceBandwidthRequest
{
    public string $startDate;
    public string $endDate;
    public ?string $units;
    public ?array $ports;
    /**
     * @param string $startDate Start date for bandwidth calculation
     * @param string $endDate End date for bandwidth calculation
     * @param string|null $units Units for bandwidth (optional)
     * @param array<int>|null $ports Array of port IDs (optional)
     */
    public function __construct(string $startDate, string $endDate, ?string $units = null, ?array $ports = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->units = $units;
        $this->ports = $ports;
    }

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
