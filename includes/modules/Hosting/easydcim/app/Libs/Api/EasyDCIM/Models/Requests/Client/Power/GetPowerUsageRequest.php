<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Power;

class GetPowerUsageRequest
{
    public ?string $startDate;
    public ?string $endDate;
    /**
     * @param string|null $startDate Start date (format: Y-m-d H:i:s)
     * @param string|null $endDate End date (format: Y-m-d H:i:s)
     */
    public function __construct(?string $startDate = null, ?string $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

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
            $data['startDate'] ?? $data['start_date'] ?? null,
            $data['endDate'] ?? $data['end_date'] ?? null
        );
    }
}
