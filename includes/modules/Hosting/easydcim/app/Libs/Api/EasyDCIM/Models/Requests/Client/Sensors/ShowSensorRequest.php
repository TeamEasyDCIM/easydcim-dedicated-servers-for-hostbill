<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Sensors;

class ShowSensorRequest
{
    public int $sensorId;
    public function __construct(int $sensorId)
    {
        $this->sensorId = $sensorId;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'sensorId' => $this->sensorId,
        ];
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['sensorId'] ?? $data['sensor_id'] ?? 0
        );
    }
}
