<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * ISO Image data
 */
class IsoImageData
{
    public ?int $id;
    public ?string $name;
    public ?string $isoUrl;
    public ?int $status;
    public ?string $statusLabel;
    public ?string $createdAt;
    public ?string $updatedAt;
    public function __construct(?int $id, ?string $name, ?string $isoUrl, ?int $status, ?string $statusLabel, ?string $createdAt, ?string $updatedAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->isoUrl = $isoUrl;
        $this->status = $status;
        $this->statusLabel = $statusLabel;
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
            Arr::get($data, 'name'),
            Arr::get($data, 'iso_url'),
            Arr::get($data, 'status'),
            Arr::get($data, 'status_label'),
            Arr::get($data, 'created_at'),
            Arr::get($data, 'updated_at')
        );
    }
}
