<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class RescueModeStatusData
{
    public ?bool $inRescueMode;
    public function __construct(?bool $inRescueMode)
    {
        $this->inRescueMode = $inRescueMode;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'inRescueMode', false)
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'inRescueMode' => $this->inRescueMode,
        ];
    }
}
