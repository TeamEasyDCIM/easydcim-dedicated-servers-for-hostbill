<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Location;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\BaseResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Response for showing a single location
 */
class ShowLocationResponse extends BaseResponse
{
    public ?LocationData $data = null;

    public static function fromArray(array $response): static
    {
        $instance = parent::fromArray($response);
        $responseData = Arr::get($response, 'data');
        $instance->data = !empty($responseData) ? LocationData::fromArray((array) $responseData) : null;
        return $instance;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), array_filter(
            ['data' => $this->data?->toArray()],
            fn($v) => $v !== null
        ));
    }
}
