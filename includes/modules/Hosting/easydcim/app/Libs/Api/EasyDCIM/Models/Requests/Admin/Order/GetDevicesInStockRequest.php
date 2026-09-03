<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Order;

/**
 * Request for getting devices in stock based on criteria
 */
class GetDevicesInStockRequest
{
    public function __construct(
        public array $criteria,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'criteria' => $this->criteria,
        ];
    }
}
