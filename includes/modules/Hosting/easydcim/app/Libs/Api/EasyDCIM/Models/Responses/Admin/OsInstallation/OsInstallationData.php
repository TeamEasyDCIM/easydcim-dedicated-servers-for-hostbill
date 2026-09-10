<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * OS Installation data
 */
class OsInstallationData
{
    public ?int $id;
    public ?int $deviceId;
    public ?int $templateId;
    public ?int $serverId;
    public ?string $message;
    public ?int $dhcp;
    public ?array $configuration;
    public ?string $log;
    public ?string $createdAt;
    public ?string $updatedAt;
    /**
     * @param int $id
     * @param int $deviceId
     * @param int $templateId
     * @param int $serverId
     * @param string $message
     * @param int $dhcp
     * @param array<mixed> $configuration
     * @param string $log
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(?int $id, ?int $deviceId, ?int $templateId, ?int $serverId, ?string $message, ?int $dhcp, ?array $configuration, ?string $log, ?string $createdAt, ?string $updatedAt)
    {
        $this->id = $id;
        $this->deviceId = $deviceId;
        $this->templateId = $templateId;
        $this->serverId = $serverId;
        $this->message = $message;
        $this->dhcp = $dhcp;
        $this->configuration = $configuration;
        $this->log = $log;
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
            Arr::get($data, 'template_id'),
            Arr::get($data, 'server_id'),
            Arr::get($data, 'message', ''),
            Arr::get($data, 'dhcp'),
            Arr::get($data, 'configuration', []),
            Arr::get($data, 'log', ''),
            Arr::get($data, 'created_at'),
            Arr::get($data, 'updated_at')
        );
    }
}
