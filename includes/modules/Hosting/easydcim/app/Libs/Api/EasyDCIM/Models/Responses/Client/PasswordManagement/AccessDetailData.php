<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\PasswordManagement;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class AccessDetailData
{
    public ?int $id;
    public ?string $name;
    public ?string $username;
    public ?string $password;
    public ?int $deviceId;
    public ?string $createdAt;
    public ?string $updatedAt;
    public function __construct(?int $id, ?string $name, ?string $username, ?string $password, ?int $deviceId = null, ?string $createdAt = null, ?string $updatedAt = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
        $this->deviceId = $deviceId;
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
            Arr::get($data, 'id', 0),
            Arr::get($data, 'name', ''),
            Arr::get($data, 'username', ''),
            Arr::get($data, 'password', ''),
            Arr::get($data, 'device_id'),
            Arr::get($data, 'created_at'),
            Arr::get($data, 'updated_at')
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'password' => $this->password,
            'device_id' => $this->deviceId,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ], fn($value) => $value !== null);
    }
}
