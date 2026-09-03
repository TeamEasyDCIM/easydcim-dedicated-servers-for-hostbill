<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Order;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class ServiceRelated
{
    public function __construct(
        public ?string $label = null,
        public ?string $model = null,
        public ?string $location = null,
        public ?string $location_flag = null,
        public ?string $rack = null,
        public ?string $device_status = null,
        public ?string $uptime = null,
        public ?array  $ip_addresses = null,
        public ?array  $metadata = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            label: Arr::get($data, 'label'),
            model: Arr::get($data, 'model'),
            location: Arr::get($data, 'location'),
            location_flag: Arr::get($data, 'location_flag'),
            rack: Arr::get($data, 'rack'),
            device_status: Arr::get($data, 'device_status'),
            uptime: Arr::get($data, 'uptime'),
            ip_addresses: Arr::get($data, 'ip_addresses'),
            metadata: Arr::get($data, 'metadata'),
        );
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'model' => $this->model,
            'location' => $this->location,
            'location_flag' => $this->location_flag,
            'rack' => $this->rack,
            'device_status' => $this->device_status,
            'uptime' => $this->uptime,
            'ip_addresses' => $this->ip_addresses,
            'metadata' => $this->metadata,
        ];
    }
}