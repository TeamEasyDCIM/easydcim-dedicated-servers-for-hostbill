<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\User;

/**
 * Request for getting user bandwidth usage
 */
class GetUserBandwidthRequest
{
    public function __construct(
        public ?string $dateFrom = null,
        public ?string $dateTo = null,
        public ?string $period = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'start_date' => $this->dateFrom,
            'end_date' => $this->dateTo,
            'period' => $this->period,
        ], fn($value) => $value !== null);
    }
}
