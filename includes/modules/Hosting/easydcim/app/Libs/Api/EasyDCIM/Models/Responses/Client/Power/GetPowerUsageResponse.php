<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Power;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\BaseResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class GetPowerUsageResponse extends BaseResponse
{
    public ?PowerUsageData $data = null;

    public static function fromArray(array $response)
    {
        $instance = parent::fromArray($response);
        $responseData = Arr::get($response, 'data');
        $instance->data = !empty($responseData) ? PowerUsageData::fromArray((array) $responseData) : null;
        return $instance;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), array_filter(
            ['data' => $this->data === null ? null : $this->data->toArray()],
            fn($v) => $v !== null
        ));
    }
}
