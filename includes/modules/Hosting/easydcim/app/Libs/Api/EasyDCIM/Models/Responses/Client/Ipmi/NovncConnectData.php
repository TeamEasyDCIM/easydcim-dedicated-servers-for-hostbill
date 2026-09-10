<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Ipmi;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class NovncConnectData
{
    public ?int $id;
    public ?int $device_id;
    public ?string $url;
    public ?int $status;
    public ?string $message;
    public function __construct(?int $id = null, ?int $device_id = null, ?string $url = null, ?int $status = null, ?string $message = null)
    {
        $this->id = $id;
        $this->device_id = $device_id;
        $this->url = $url;
        $this->status = $status;
        $this->message = $message;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'id'),
            Arr::get($data, 'device_id'),
            Arr::get($data, 'url'),
            Arr::get($data, 'status'),
            Arr::get($data, 'message')
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
