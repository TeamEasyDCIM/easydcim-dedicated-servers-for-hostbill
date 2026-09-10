<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Device;

/**
 * Request for discovering a device
 */
class DiscoverDeviceRequest
{
    public string $protocol;
    public function __construct(string $protocol)
    {
        $this->protocol = $protocol;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'protocol' => $this->protocol,
        ];
    }
}
