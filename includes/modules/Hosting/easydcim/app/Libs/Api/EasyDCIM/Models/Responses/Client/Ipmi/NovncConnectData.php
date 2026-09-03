<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Ipmi;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class NovncConnectData
{
    public function __construct(
        public ?int $id = null,
        public ?int $device_id = null,
        public ?string $url = null,
        public ?int $status = null,
        public ?string $message = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: Arr::get($data, 'id'),
            device_id: Arr::get($data, 'device_id'),
            url: Arr::get($data, 'url'),
            status: Arr::get($data, 'status'),
            message: Arr::get($data, 'message'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'device_id' => $this->device_id,
            'url' => $this->url,
            'status' => $this->status,
            'message' => $this->message,
        ], fn($value) => $value !== null);
    }
}
