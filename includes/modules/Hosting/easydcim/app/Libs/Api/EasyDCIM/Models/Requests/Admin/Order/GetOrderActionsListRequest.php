<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Order;

/**
 * Request for getting order actions list
 */
class GetOrderActionsListRequest
{
    public ?string $type;
    public ?string $action;
    public function __construct(?string $type = null, ?string $action = null)
    {
        $this->type = $type;
        $this->action = $action;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'type' => $this->type,
            'action' => $this->action,
        ], fn($value) => $value !== null);
    }
}
