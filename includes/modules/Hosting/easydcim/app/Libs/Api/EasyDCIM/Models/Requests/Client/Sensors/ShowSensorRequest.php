<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Sensors;

class ShowSensorRequest
{
    public function __construct(
        public int $sensorId,
    ) {}

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
            sensorId: $data['sensorId'] ?? $data['sensor_id'] ?? 0,
        );
    }
}
