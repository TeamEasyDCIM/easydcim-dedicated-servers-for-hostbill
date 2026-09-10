<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Order;

/**
 * Request for updating an order
 */
class UpdateOrderRequest
{
    public ?int $client;
    public ?array $criteria;
    public ?array $service;
    public ?array $other;
    public function __construct(?int $client = null, ?array $criteria = null, ?array $service = null, ?array $other = null)
    {
        $this->client = $client;
        $this->criteria = $criteria;
        $this->service = $service;
        $this->other = $other;
    }

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
