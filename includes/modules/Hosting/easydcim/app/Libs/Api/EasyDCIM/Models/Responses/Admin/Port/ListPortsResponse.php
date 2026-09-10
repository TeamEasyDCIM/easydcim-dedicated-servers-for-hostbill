<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Port;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\BaseResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\PaginationMeta;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Response for listing ports
 */
class ListPortsResponse extends BaseResponse
{
    /** @var array<PortData> */
    public array $data = [];
    public ?PaginationMeta $meta = null;

    public static function fromArray(array $response)
    {
        $instance = parent::fromArray($response);
        $items = (array) (Arr::get($response, 'data') ?? []);
        $instance->data = array_map(fn(array $item) => PortData::fromArray($item), $items);
        $metaData = Arr::get($response, 'meta');
        $instance->meta = $metaData !== null ? PaginationMeta::fromArray((array) $metaData) : null;
        return $instance;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'data' => array_map(fn(PortData $port) => $port->toArray(), $this->data),
            'meta' => $this->meta === null ? null : $this->meta->toArray(),
        ]);
    }

    /**
     * Get all port IDs
     *
     * @return array<int>
     */
    public function getPortIds(): array
    {
        return array_map(fn(PortData $port) => $port->id, $this->data);
    }
}
