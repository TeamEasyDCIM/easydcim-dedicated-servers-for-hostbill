<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Order;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class ServiceAccessLevel
{
    public ?int $id;
    public ?string $name;
    public ?string $type;
    public ?bool $default;
    public ?array $value;
    public function __construct(?int    $id = null, ?string $name = null, ?string $type = null, ?bool   $default = null, ?array  $value = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->default = $default;
        $this->value = $value;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'id'),
            Arr::get($data, 'name'),
            Arr::get($data, 'type'),
            Arr::get($data, 'default'),
            Arr::get($data, 'value')
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