<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Dns;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class RdnsRecordData
{
    public ?int $id;
    public ?int $deviceId;
    public ?int $userId;
    public ?int $serverId;
    public ?string $ip;
    public ?string $from;
    public ?string $name;
    public ?int $ttl;
    public ?string $createdAt;
    public ?string $updatedAt;
    public function __construct(?int $id, ?int $deviceId, ?int $userId, ?int $serverId, ?string $ip, ?string $from, ?string $name, ?int $ttl, ?string $createdAt, ?string $updatedAt)
    {
        $this->id = $id;
        $this->deviceId = $deviceId;
        $this->userId = $userId;
        $this->serverId = $serverId;
        $this->ip = $ip;
        $this->from = $from;
        $this->name = $name;
        $this->ttl = $ttl;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
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
            Arr::get($data, 'user_id'),
            Arr::get($data, 'server_id'),
            Arr::get($data, 'ip'),
            Arr::get($data, 'from', ''),
            Arr::get($data, 'name', ''),
            Arr::get($data, 'ttl'),
            Arr::get($data, 'created_at'),
            Arr::get($data, 'updated_at')
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
