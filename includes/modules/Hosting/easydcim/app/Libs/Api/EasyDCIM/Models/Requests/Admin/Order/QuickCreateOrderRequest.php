<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Order;

/**
 * Request for quick creating and activating an order
 */
class QuickCreateOrderRequest
{
    public $userId;
    public $productId;
    public ?array $additionalData;
    public function __construct($userId, $productId, ?array $additionalData = null)
    {
        $this->userId = $userId;
        $this->productId = $productId;
        $this->additionalData = $additionalData;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'user_id' => $this->userId,
            'product_id' => $this->productId,
        ];

        if ($this->additionalData !== null) {
            $data = array_merge($data, $this->additionalData);
        }

        return $data;
    }
}
