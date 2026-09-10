<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Parts;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\BaseResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\PaginationMeta;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class ListServicePartsResponse extends BaseResponse
{
    /** @var array<ServicePartData> */
    public array $data = [];
    public ?PaginationMeta $meta = null;

    public static function fromArray(array $response)
    {
        $instance = parent::fromArray($response);
        $items = (array) (Arr::get($response, 'data') ?? []);
        $instance->data = array_map(fn(array $item) => ServicePartData::fromArray($item), $items);
        $instance->meta = PaginationMeta::fromArray((array) (Arr::get($response, 'meta') ?? []));
        return $instance;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'data' => array_map(fn(ServicePartData $part) => $part->toArray(), $this->data),
            'meta' => $this->meta === null ? null : $this->meta->toArray(),
        ]);
    }
}
