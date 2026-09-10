<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Order;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\BaseResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Response for getting order actions list
 */
class GetOrderActionsListResponse extends BaseResponse
{
    /** @var array<string> Global actions available for all services */
    public ?array $globalActions = null;

    /** @var array<string, string> All available actions with their descriptions */
    public ?array $allActions = null;

    public static function fromArray(array $response)
    {
        $instance = parent::fromArray($response);
        $data = (array) (Arr::get($response, 'data') ?? []);
        $instance->globalActions = Arr::get($data, 'globalActions', []);
        $instance->allActions = Arr::get($data, 'allActions', []);
        return $instance;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'data' => [
                'globalActions' => $this->globalActions,
                'allActions' => $this->allActions,
            ],
        ]);
    }
}
