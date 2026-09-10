<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Ports;

/**
 * Request for performing an action on a power port
 */
class PerformPortActionRequest
{
    public $portId;
    public string $action;
    public function __construct($portId, string $action)
    {
        $this->portId = $portId;
        $this->action = $action;
    }

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
