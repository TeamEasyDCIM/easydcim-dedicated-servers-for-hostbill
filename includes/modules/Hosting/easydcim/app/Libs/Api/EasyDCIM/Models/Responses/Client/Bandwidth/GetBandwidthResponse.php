<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Bandwidth;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\BaseResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class GetBandwidthResponse extends BaseResponse
{
    public ?BandwidthData $data = null;

    public static function fromArray(array $response)
    {
        $instance = parent::fromArray($response);
        $responseData = Arr::get($response, 'data');
        $instance->data = !empty($responseData) ? BandwidthData::fromArray((array) $responseData) : null;
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
