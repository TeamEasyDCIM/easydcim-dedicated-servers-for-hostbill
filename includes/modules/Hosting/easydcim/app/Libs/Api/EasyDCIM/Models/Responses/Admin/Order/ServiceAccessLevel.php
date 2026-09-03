<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Order;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class ServiceAccessLevel
{
    public function __construct(
        public ?int    $id = null,
        public ?string $name = null,
        public ?string $type = null,
        public ?bool   $default = null,
        public ?array  $value = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: Arr::get($data, 'id'),
            name: Arr::get($data, 'name'),
            type: Arr::get($data, 'type'),
            default: Arr::get($data, 'default'),
            value: Arr::get($data, 'value'),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'default' => $this->default,
            'value' => $this->value,
        ];
    }
}