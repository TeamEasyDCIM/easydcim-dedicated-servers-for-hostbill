<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\User;

/**
 * Request for getting user bandwidth usage
 */
class GetUserBandwidthRequest
{
    public ?string $dateFrom;
    public ?string $dateTo;
    public ?string $period;
    public function __construct(?string $dateFrom = null, ?string $dateTo = null, ?string $period = null)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->period = $period;
    }

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
