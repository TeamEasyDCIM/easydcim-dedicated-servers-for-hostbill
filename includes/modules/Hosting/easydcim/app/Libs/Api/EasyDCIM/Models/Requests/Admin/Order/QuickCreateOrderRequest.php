<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Order;

/**
 * Request for quick creating and activating an order
 */
class QuickCreateOrderRequest
{
    public function __construct(
        public int|string $userId,
        public int|string $productId,
        public ?array $additionalData = null,
    ) {}

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
