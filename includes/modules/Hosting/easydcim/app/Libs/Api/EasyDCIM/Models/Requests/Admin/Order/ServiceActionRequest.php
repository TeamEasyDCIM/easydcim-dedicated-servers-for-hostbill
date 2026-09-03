<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Order;

/**
 * Request for service actions (activate, suspend, unsuspend, terminate)
 */
class ServiceActionRequest
{
    public function __construct(
        public ?string $reason = null,
        public ?array $additionalData = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = array_filter([
            'reason' => $this->reason,
        ], fn($value) => $value !== null);

        if ($this->additionalData !== null) {
            $data = array_merge($data, $this->additionalData);
        }

        return $data;
    }
}
