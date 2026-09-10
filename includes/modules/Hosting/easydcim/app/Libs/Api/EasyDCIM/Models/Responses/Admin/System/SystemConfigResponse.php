<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\System;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\BaseResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Response for System configuration
 */
class SystemConfigResponse extends BaseResponse
{
    public ?array $data = null;

    public static function fromArray(array $response)
    {
        $instance = parent::fromArray($response);
        $responseData = Arr::get($response, 'data');
        $instance->data = is_array($responseData) ? $responseData : [];
        return $instance;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), array_filter(
            ['data' => $this->data],
            fn($v) => $v !== null
        ));
    }
}
