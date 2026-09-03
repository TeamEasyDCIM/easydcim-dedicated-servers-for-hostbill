<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Order;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class OrderService
{
    public function __construct(
        public ?int $id = null,
        public ?int $related_id = null,
        public ?string $type = null,
        public ?string $status = null,
        public ?ServiceRelated $related = null,
        public ?ServiceAccessLevel $access_level = null,
        public ?string $created_at = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: Arr::get($data, 'id'),
            related_id: Arr::get($data, 'related_id'),
            type: Arr::get($data, 'type'),
            status: Arr::get($data, 'status'),
            related: isset($data['related']) ? ServiceRelated::fromArray($data['related']) : null,
            access_level: isset($data['access_level']) ? ServiceAccessLevel::fromArray($data['access_level']) : null,
            created_at: Arr::get($data, 'created_at'),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'related_id' => $this->related_id,
            'type' => $this->type,
            'status' => $this->status,
            'related' => $this->related?->toArray(),
            'access_level' => $this->access_level?->toArray(),
            'created_at' => $this->created_at,
        ];
    }
}