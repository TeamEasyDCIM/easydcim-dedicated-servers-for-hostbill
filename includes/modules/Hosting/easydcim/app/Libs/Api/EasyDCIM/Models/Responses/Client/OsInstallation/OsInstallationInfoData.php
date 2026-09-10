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
    public ?int $id;
    public ?int $deviceId;
    public ?int $templateId;
    public ?string $message;
    public ?array $log;
    public ?string $createdAt;
    public ?string $updatedAt;
    /**
     * @param array<string, string>|null $log Datetime-keyed history of status messages.
     */
    public function __construct(?int $id = null, ?int $deviceId = null, ?int $templateId = null, ?string $message = null, ?array $log = null, ?string $createdAt = null, ?string $updatedAt = null)
    {
        $this->id = $id;
        $this->deviceId = $deviceId;
        $this->templateId = $templateId;
        $this->message = $message;
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
        $log = Arr::get($data, 'log');

        return new self(
            Arr::get($data, 'id'),
            Arr::get($data, 'device_id'),
            Arr::get($data, 'template_id'),
            Arr::get($data, 'message'),
            is_array($log) ? $log : null,
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
            'device_id' => $this->deviceId,
            'template_id' => $this->templateId,
            'message' => $this->message,
            'log' => $this->log,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ], fn($value) => $value !== null);
    }
}
