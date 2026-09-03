<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * ISO Image data
 */
class IsoImageData
{
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?string $isoUrl,
        public ?int $status,
        public ?string $statusLabel,
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
            name: Arr::get($data, 'name'),
            isoUrl: Arr::get($data, 'iso_url'),
            status: Arr::get($data, 'status'),
            statusLabel: Arr::get($data, 'status_label'),
            createdAt: Arr::get($data, 'created_at'),
            updatedAt: Arr::get($data, 'updated_at'),
        );
    }
}
