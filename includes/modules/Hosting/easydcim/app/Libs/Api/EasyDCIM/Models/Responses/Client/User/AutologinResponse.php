<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\User;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\BaseResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class AutologinResponse extends BaseResponse
{
    public static function fromArray(array $response): static
    {
        $instance = parent::fromArray($response);
        $instance->success = Arr::get($response, 'success', false) ?? true;
        $instance->status = Arr::get($response, 'status', '') ?? 'success';
        $instance->message = Arr::get($response, 'message', '') ?? '';
        return $instance;
    }
}
