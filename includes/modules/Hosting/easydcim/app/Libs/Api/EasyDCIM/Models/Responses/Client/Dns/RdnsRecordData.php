<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Dns;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class RdnsRecordData
{
    public function __construct(
        public ?int $id,
        public ?int $deviceId,
        public ?int $userId,
        public ?int $serverId,
        public ?string $ip,
        public ?string $from,
        public ?string $name,
        public ?int $ttl,
        public ?string $createdAt,
        public ?string $updatedAt,
    ) {}

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: Arr::get($data, 'id'),
            deviceId: Arr::get($data, 'device_id'),
            userId: Arr::get($data, 'user_id'),
            serverId: Arr::get($data, 'server_id'),
            ip: Arr::get($data, 'ip'),
            from: Arr::get($data, 'from', ''),
            name: Arr::get($data, 'name', ''),
            ttl: Arr::get($data, 'ttl'),
            createdAt: Arr::get($data, 'created_at'),
            updatedAt: Arr::get($data, 'updated_at'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'device_id' => $this->deviceId,
            'user_id' => $this->userId,
            'server_id' => $this->serverId,
            'ip' => $this->ip,
            'from' => $this->from,
            'name' => $this->name,
            'ttl' => $this->ttl,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
