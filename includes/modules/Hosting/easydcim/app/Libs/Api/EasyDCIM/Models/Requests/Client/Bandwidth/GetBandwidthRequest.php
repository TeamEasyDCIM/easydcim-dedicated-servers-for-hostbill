<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Bandwidth;

class GetBandwidthRequest
{
    /**
     * @param string|null $startDate Start date (format: Y-m-d H:i:s)
     * @param string|null $endDate End date (format: Y-m-d H:i:s)
     * @param string|null $units Units (GB, MB, etc.)
     * @param array<int>|null $ports Array of port IDs
     */
    public function __construct(
        public ?string $startDate = null,
        public ?string $endDate = null,
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

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            startDate: $data['startDate'] ?? $data['start_date'] ?? null,
            endDate: $data['endDate'] ?? $data['end_date'] ?? null,
            units: $data['units'] ?? null,
            ports: $data['ports'] ?? null,
        );
    }
}
