<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Device;

/**
 * Request for performing power action on a device
 */
class DevicePowerActionRequest
{
    public string $action;
    /**
     * @param string $action Power action (boot, reboot, shutdown)
     */
    public function __construct(string $action)
    {
        $this->action = $action;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'action' => $this->action,
        ];
    }
}
