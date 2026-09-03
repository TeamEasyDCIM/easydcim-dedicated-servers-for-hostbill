<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * OS installation (provisioning) information.
 *
 * Mirrors the EasyDCIM OsProvisioningResource. A record only exists while a
 * provisioning task is in progress; EasyDCIM deletes it once the installation
 * completes or is cancelled. Therefore the presence of this data is itself the
 * "installation is running" signal, and {@see $message} carries the live status
 * text (e.g. "Waiting for manual reboot...").
 */
class OsInstallationInfoData
{
    /**
     * @param array<string, string>|null $log Datetime-keyed history of status messages.
     */
    public function __construct(
        public ?int $id = null,
        public ?int $deviceId = null,
        public ?int $templateId = null,
        public ?string $message = null,
        public ?array $log = null,
        public ?string $createdAt = null,
        public ?string $updatedAt = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $log = Arr::get($data, 'log');

        return new self(
            id: Arr::get($data, 'id'),
            deviceId: Arr::get($data, 'device_id'),
            templateId: Arr::get($data, 'template_id'),
            message: Arr::get($data, 'message'),
            log: is_array($log) ? $log : null,
            createdAt: Arr::get($data, 'created_at'),
            updatedAt: Arr::get($data, 'updated_at'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'device_id' => $this->deviceId,
            'template_id' => $this->templateId,
            'message' => $this->message,
            'log' => $this->log,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ], fn($value) => $value !== null);
    }
}
