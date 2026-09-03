<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Group;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\BaseResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Response for listing permissions
 */
class ListPermissionsResponse extends BaseResponse
{
    /** @var array<PermissionData> */
    public array $data = [];

    public static function fromArray(array $response): static
    {
        $instance = parent::fromArray($response);
        $items = (array) (Arr::get($response, 'data') ?? []);
        $instance->data = array_map(fn(array $permission) => PermissionData::fromArray($permission), $items);
        return $instance;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'data' => array_map(fn(PermissionData $permission) => $permission->toArray(), $this->data),
        ]);
    }
}
