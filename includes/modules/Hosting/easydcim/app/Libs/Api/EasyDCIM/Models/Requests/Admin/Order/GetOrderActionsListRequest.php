<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Order;

/**
 * Request for getting order actions list
 */
class GetOrderActionsListRequest
{
    public function __construct(
        public ?string $type = null,
        public ?string $action = null,
    ) {}

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
