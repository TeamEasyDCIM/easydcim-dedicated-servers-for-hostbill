<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * OS Installation data
 */
class OsInstallationData
{
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
    public function __construct(
        public ?int $id,
        public ?int $deviceId,
        public ?int $templateId,
        public ?int $serverId,
        public ?string $message,
        public ?int $dhcp,
        public ?array $configuration,
        public ?string $log,
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
            templateId: Arr::get($data, 'template_id'),
            serverId: Arr::get($data, 'server_id'),
            message: Arr::get($data, 'message', ''),
            dhcp: Arr::get($data, 'dhcp'),
            configuration: Arr::get($data, 'configuration', []),
            log: Arr::get($data, 'log', ''),
            createdAt: Arr::get($data, 'created_at'),
            updatedAt: Arr::get($data, 'updated_at'),
        );
    }
}
