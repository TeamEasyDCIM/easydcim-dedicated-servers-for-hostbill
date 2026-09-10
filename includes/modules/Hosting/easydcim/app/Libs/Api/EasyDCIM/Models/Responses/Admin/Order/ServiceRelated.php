<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Order;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class ServiceRelated
{
    public ?string $label;
    public ?string $model;
    public ?string $location;
    public ?string $location_flag;
    public ?string $rack;
    public ?string $device_status;
    public ?string $uptime;
    public ?array $ip_addresses;
    public ?array $metadata;
    public function __construct(?string $label = null, ?string $model = null, ?string $location = null, ?string $location_flag = null, ?string $rack = null, ?string $device_status = null, ?string $uptime = null, ?array  $ip_addresses = null, ?array  $metadata = null)
    {
        $this->label = $label;
        $this->model = $model;
        $this->location = $location;
        $this->location_flag = $location_flag;
        $this->rack = $rack;
        $this->device_status = $device_status;
        $this->uptime = $uptime;
        $this->ip_addresses = $ip_addresses;
        $this->metadata = $metadata;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'label'),
            Arr::get($data, 'model'),
            Arr::get($data, 'location'),
            Arr::get($data, 'location_flag'),
            Arr::get($data, 'rack'),
            Arr::get($data, 'device_status'),
            Arr::get($data, 'uptime'),
            Arr::get($data, 'ip_addresses'),
            Arr::get($data, 'metadata')
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