<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Ports;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\BaseResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\PaginationMeta;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class ListServicePortsResponse extends BaseResponse
{
    /** @var array<ServicePortData> */
    public array $data = [];
    public ?PaginationMeta $meta = null;

    public static function fromArray(array $response): static
    {
        $instance = parent::fromArray($response);
        $items = (array) (Arr::get($response, 'data') ?? []);
        $instance->data = array_map(fn(array $item) => ServicePortData::fromArray($item), $items);
        $instance->meta = PaginationMeta::fromArray((array) (Arr::get($response, 'meta') ?? []));
        return $instance;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'data' => array_map(fn(ServicePortData $port) => $port->toArray(), $this->data),
            'meta' => $this->meta?->toArray(),
        ]);
    }
}
