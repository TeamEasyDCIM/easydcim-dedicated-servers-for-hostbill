<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * OS Addon data
 */
class OsAddonData
{
    public ?int $id;
    public ?int $serverId;
    public ?string $name;
    public ?string $description;
    public ?string $type;
    public ?string $tag;
    public ?array $tags;
    public ?string $data;
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
    public function __construct(?int $id = null, ?int $serverId = null, ?string $name = null, ?string $description = null, ?string $type = null, ?string $tag = null, ?array $tags = null, ?string $data = null)
    {
        $this->id = $id;
        $this->serverId = $serverId;
        $this->name = $name;
        $this->description = $description;
        $this->type = $type;
        $this->tag = $tag;
        $this->tags = $tags;
        $this->data = $data;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'id') !== null ? (int) Arr::get($data, 'id') : null,
            Arr::get($data, 'server_id') !== null ? (int) Arr::get($data, 'server_id') : null,
            Arr::get($data, 'name'),
            Arr::get($data, 'description'),
            Arr::get($data, 'type'),
            Arr::get($data, 'tag'),
            Arr::get($data, 'tags'),
            Arr::get($data, 'data')
        );
    }
}
