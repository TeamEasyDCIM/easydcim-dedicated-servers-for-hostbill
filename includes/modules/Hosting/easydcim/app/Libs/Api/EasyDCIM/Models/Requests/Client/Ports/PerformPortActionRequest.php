<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Ports;

/**
 * Request for performing an action on a power port
 */
class PerformPortActionRequest
{
    public function __construct(
        public int|string $portId,
        public string $action,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'port_id' => $this->portId,
            'action' => $this->action,
        ];
    }
}
