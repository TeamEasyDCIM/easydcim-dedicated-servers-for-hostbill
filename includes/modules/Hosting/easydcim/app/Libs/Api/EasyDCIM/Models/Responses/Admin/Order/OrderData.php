<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Order;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Service\ServiceData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class OrderData
{
    public function __construct(
        public ?int $id = null,
        public ?int $ordernumber = null,
        public ?int $user_id = null,
        public ?string $status = null,
        public ?string $service_status = null,
        public ?string $type = null,
        public mixed $options = null,
        public ?OrderService $service = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
    ) {}

    public static function fromArray(array $data): self
    {
        $serviceData = Arr::get($data, 'service', []);

        return new self(
            id: Arr::get($data, 'id'),
            ordernumber: Arr::get($data, 'ordernumber'),
            user_id: Arr::get($data, 'user_id'),
            status: Arr::get($data, 'status'),
            service_status: Arr::get($data, 'service_status'),
            type: Arr::get($data, 'type'),
            options: Arr::get($data, 'options'),
            service: !empty($serviceData) ? OrderService::fromArray($serviceData) : null,
            created_at: Arr::get($data, 'created_at'),
            updated_at: Arr::get($data, 'updated_at'),
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
            'service' => $this->service?->toArray(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}