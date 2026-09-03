<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Power;

class GetPowerUsageRequest
{
    /**
     * @param string|null $startDate Start date (format: Y-m-d H:i:s)
     * @param string|null $endDate End date (format: Y-m-d H:i:s)
     */
    public function __construct(
        public ?string $startDate = null,
        public ?string $endDate = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
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
        );
    }
}
