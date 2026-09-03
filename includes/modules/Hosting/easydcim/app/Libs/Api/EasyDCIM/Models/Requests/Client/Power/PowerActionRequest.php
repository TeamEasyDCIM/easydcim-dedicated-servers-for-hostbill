<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Power;

class PowerActionRequest
{
    /**
     * @param string $action Action to perform (boot, reboot, shutdown, etc.)
     */
    public function __construct(
        public string $action,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return ['action' => $this->action];
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            action: $data['action'],
        );
    }
}
