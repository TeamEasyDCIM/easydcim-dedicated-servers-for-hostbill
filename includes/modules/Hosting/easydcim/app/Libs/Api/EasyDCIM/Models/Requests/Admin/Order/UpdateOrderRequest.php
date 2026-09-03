<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Order;

/**
 * Request for updating an order
 */
class UpdateOrderRequest
{
    public function __construct(
        public ?int $client = null,
        public ?array $criteria = null,
        public ?array $service = null,
        public ?array $other = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [];

        if ($this->client !== null) {
            $data['client'] = $this->client;
        }

        if ($this->criteria !== null) {
            $data['criteria'] = $this->criteria;
        }

        if ($this->service !== null) {
            $data['service'] = $this->service;
        }

        if ($this->other !== null) {
            $data['other'] = $this->other;
        }

        return $data;
    }
}
