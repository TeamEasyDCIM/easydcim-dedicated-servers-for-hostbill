<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Order;

/**
 * Request for service actions (activate, suspend, unsuspend, terminate)
 */
class ServiceActionRequest
{
    public ?string $reason;
    public ?array $additionalData;
    public function __construct(?string $reason = null, ?array $additionalData = null)
    {
        $this->reason = $reason;
        $this->additionalData = $additionalData;
    }

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
