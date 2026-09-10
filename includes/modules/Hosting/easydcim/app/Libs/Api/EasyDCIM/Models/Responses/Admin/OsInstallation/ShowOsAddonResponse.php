<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\BaseResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Response for showing a single OS addon
 */
class ShowOsAddonResponse extends BaseResponse
{
    public ?OsAddonData $data = null;

    public static function fromArray(array $response)
    {
        $instance = parent::fromArray($response);
        $instance->data = OsAddonData::fromArray($response);
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
