<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Bandwidth;

class GetBandwidthRequest
{
    public ?string $startDate;
    public ?string $endDate;
    public ?string $units;
    public ?array $ports;
    /**
     * @param string|null $startDate Start date (format: Y-m-d H:i:s)
     * @param string|null $endDate End date (format: Y-m-d H:i:s)
     * @param string|null $units Units (GB, MB, etc.)
     * @param array<int>|null $ports Array of port IDs
     */
    public function __construct(?string $startDate = null, ?string $endDate = null, ?string $units = null, ?array $ports = null)
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

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['startDate'] ?? $data['start_date'] ?? null,
            $data['endDate'] ?? $data['end_date'] ?? null,
            $data['units'] ?? null,
            $data['ports'] ?? null
        );
    }
}
