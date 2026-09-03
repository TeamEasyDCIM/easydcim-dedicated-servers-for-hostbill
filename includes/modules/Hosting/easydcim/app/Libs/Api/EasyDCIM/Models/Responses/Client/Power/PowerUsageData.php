<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Power;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class PowerUsageData
{
    public function __construct(
        public null|int|float $avgTotalUsage,
        public ?string $units,
    ) {}

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            avgTotalUsage: Arr::get($data, 'AVG_TOTAL_USAGE', 0),
            units: Arr::get($data, 'units', ''),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'AVG_TOTAL_USAGE' => $this->avgTotalUsage,
            'units' => $this->units,
        ];
    }
}
