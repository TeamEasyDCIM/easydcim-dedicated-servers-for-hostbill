<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Order;

/**
 * Request for creating an order
 */
class CreateOrderRequest
{
    public string $module;
    public int $client;
    public bool $autoAccept;
    public ?array $criteria;
    public ?array $service;
    public ?array $other;
    public ?array $actions;
    public function __construct(string $module, int $client, bool $autoAccept = false, ?array $criteria = null, ?array $service = null, ?array $other = null, ?array $actions = null)
    {
        $this->module = $module;
        $this->client = $client;
        $this->autoAccept = $autoAccept;
        $this->criteria = $criteria;
        $this->service = $service;
        $this->other = $other;
        $this->actions = $actions;
    }

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
