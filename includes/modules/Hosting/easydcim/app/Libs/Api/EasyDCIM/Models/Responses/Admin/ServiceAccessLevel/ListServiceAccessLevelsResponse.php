<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\ServiceAccessLevel;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\BaseResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\PaginationMeta;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Response for listing service access levels
 */
class ListServiceAccessLevelsResponse extends BaseResponse
{
    /** @var array<ServiceAccessLevelData> */
    public array $data = [];
    public ?PaginationMeta $meta = null;

    public static function fromArray(array $response)
    {
        $instance = parent::fromArray($response);
        $items = (array) (Arr::get($response, 'data') ?? []);
        $instance->data = array_map(fn(array $level) => ServiceAccessLevelData::fromArray($level), $items);
        $instance->meta = PaginationMeta::fromArray((array) (Arr::get($response, 'meta') ?? []));
        return $instance;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'data' => array_map(fn(ServiceAccessLevelData $level) => $level->toArray(), $this->data),
            'meta' => $this->meta === null ? null : $this->meta->toArray(),
        ]);
    }
}
