<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * OS Addon data
 */
class OsAddonData
{
    /**
     * @param int|null $id
     * @param int|null $serverId
     * @param string|null $name
     * @param string|null $description
     * @param string|null $type
     * @param string|null $tag
     * @param array<string>|null $tags
     * @param string|null $data
     */
    public function __construct(
        public ?int $id = null,
        public ?int $serverId = null,
        public ?string $name = null,
        public ?string $description = null,
        public ?string $type = null,
        public ?string $tag = null,
        public ?array $tags = null,
        public ?string $data = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: Arr::get($data, 'id') !== null ? (int) Arr::get($data, 'id') : null,
            serverId: Arr::get($data, 'server_id') !== null ? (int) Arr::get($data, 'server_id') : null,
            name: Arr::get($data, 'name'),
            description: Arr::get($data, 'description'),
            type: Arr::get($data, 'type'),
            tag: Arr::get($data, 'tag'),
            tags: Arr::get($data, 'tags'),
            data: Arr::get($data, 'data'),
        );
    }
}
