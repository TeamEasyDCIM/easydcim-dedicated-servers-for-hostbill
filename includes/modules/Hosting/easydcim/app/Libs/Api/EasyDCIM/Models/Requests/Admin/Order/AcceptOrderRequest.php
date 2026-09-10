<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Order;

/**
 * Request for accepting an order
 */
class AcceptOrderRequest
{
    public ?array $additionalData;
    public function __construct(?array $additionalData = null)
    {
        $this->additionalData = $additionalData;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->additionalData ?? [];
    }
}
