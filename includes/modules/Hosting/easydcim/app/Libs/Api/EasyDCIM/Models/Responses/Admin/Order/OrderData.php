<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Order;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Service\ServiceData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class OrderData
{
    public ?int $id;
    public ?int $ordernumber;
    public ?int $user_id;
    public ?string $status;
    public ?string $service_status;
    public ?string $type;
    public $options;
    public ?OrderService $service;
    public ?string $created_at;
    public ?string $updated_at;
    public function __construct(?int $id = null, ?int $ordernumber = null, ?int $user_id = null, ?string $status = null, ?string $service_status = null, ?string $type = null, $options = null, ?OrderService $service = null, ?string $created_at = null, ?string $updated_at = null)
    {
        $this->id = $id;
        $this->ordernumber = $ordernumber;
        $this->user_id = $user_id;
        $this->status = $status;
        $this->service_status = $service_status;
        $this->type = $type;
        $this->options = $options;
        $this->service = $service;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function fromArray(array $data): self
    {
        $serviceData = Arr::get($data, 'service', []);

        return new self(
            Arr::get($data, 'id'),
            Arr::get($data, 'ordernumber'),
            Arr::get($data, 'user_id'),
            Arr::get($data, 'status'),
            Arr::get($data, 'service_status'),
            Arr::get($data, 'type'),
            Arr::get($data, 'options'),
            !empty($serviceData) ? OrderService::fromArray($serviceData) : null,
            Arr::get($data, 'created_at'),
            Arr::get($data, 'updated_at')
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'ordernumber' => $this->ordernumber,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'service_status' => $this->service_status,
            'type' => $this->type,
            'options' => $this->options,
            'service' => $this->service === null ? null : $this->service->toArray(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}