<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Order;

/**
 * Request for creating an order
 */
class CreateOrderRequest
{
    public function __construct(
        public string $module,
        public int $client,
        public bool $autoAccept = false,
        public ?array $criteria = null,
        public ?array $service = null,
        public ?array $other = null,
        public ?array $actions = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'module' => $this->module,
            'client' => $this->client,
            'auto_accept' => $this->autoAccept,
        ];

        if ($this->criteria !== null) {
            $data['criteria'] = $this->criteria;
        }

        if ($this->service !== null) {
            $data['service'] = $this->service;
        }

        if ($this->other !== null) {
            $data['other'] = $this->other;
        }

        if ($this->actions !== null) {
            $data['actions'] = $this->actions;
        }

        return $data;
    }
}
