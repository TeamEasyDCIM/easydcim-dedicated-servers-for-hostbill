<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Order;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class OrderService
{
    public ?int $id;
    public ?int $related_id;
    public ?string $type;
    public ?string $status;
    public ?ServiceRelated $related;
    public ?ServiceAccessLevel $access_level;
    public ?string $created_at;
    public function __construct(?int $id = null, ?int $related_id = null, ?string $type = null, ?string $status = null, ?ServiceRelated $related = null, ?ServiceAccessLevel $access_level = null, ?string $created_at = null)
    {
        $this->id = $id;
        $this->related_id = $related_id;
        $this->type = $type;
        $this->status = $status;
        $this->related = $related;
        $this->access_level = $access_level;
        $this->created_at = $created_at;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'id'),
            Arr::get($data, 'related_id'),
            Arr::get($data, 'type'),
            Arr::get($data, 'status'),
            isset($data['related']) ? ServiceRelated::fromArray($data['related']) : null,
            isset($data['access_level']) ? ServiceAccessLevel::fromArray($data['access_level']) : null,
            Arr::get($data, 'created_at')
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'related_id' => $this->related_id,
            'type' => $this->type,
            'status' => $this->status,
            'related' => $this->related === null ? null : $this->related->toArray(),
            'access_level' => $this->access_level === null ? null : $this->access_level->toArray(),
            'created_at' => $this->created_at,
        ];
    }
}