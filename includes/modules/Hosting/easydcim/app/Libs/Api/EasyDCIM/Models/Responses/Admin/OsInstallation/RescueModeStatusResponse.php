<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\BaseResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Response for rescue mode status
 */
class RescueModeStatusResponse extends BaseResponse
{
    public ?bool $inRescueMode = null;

    public static function fromArray(array $response): static
    {
        $instance = parent::fromArray($response);
        $data = (array) (Arr::get($response, 'data') ?? []);
        $instance->inRescueMode = Arr::get($data, 'inRescueMode', false);
        return $instance;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'data' => ['inRescueMode' => $this->inRescueMode],
        ]);
    }
}
