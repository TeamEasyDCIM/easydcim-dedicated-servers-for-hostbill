<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * OS Template data
 */
class OsTemplateData
{
    /**
     * @param int $id
     * @param string $name
     * @param array<ProvisioningServerData>|null $servers
     * @param mixed $tags
     * @param string|null $architecture
     * @param string|null $cacheFolder
     * @param string|null $mirror
     * @param string|null $edition
     * @param string|null $isoUrl
     * @param bool|null $extractIso
     * @param string|null $timezone
     * @param string|null $language
     * @param string|null $gpxeScript
     * @param string|null $diskLayout
     * @param string|null $packages
     * @param string|null $postInstallation
     * @param string|null $family
     * @param bool|null $isWindows
     * @param string|null $firstBoot
     * @param string|null $createdAt
     * @param string|null $updatedAt
     * @param array<OsAddonData>|null $addons
     */
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?array $servers = null,
        public mixed $tags = null,
        public ?string $architecture = null,
        public ?string $cacheFolder = null,
        public ?string $mirror = null,
        public ?string $edition = null,
        public ?string $isoUrl = null,
        public ?bool $extractIso = null,
        public ?string $timezone = null,
        public ?string $language = null,
        public ?string $gpxeScript = null,
        public ?string $diskLayout = null,
        public ?string $packages = null,
        public ?string $postInstallation = null,
        public ?string $family = null,
        public ?bool $isWindows = null,
        public ?string $firstBoot = null,
        public ?string $createdAt = null,
        public ?string $updatedAt = null,
        public ?array $addons = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $servers = null;
        $serversData = Arr::get($data, 'servers');
        if (is_array($serversData)) {
            $servers = array_map(
                fn($server) => ProvisioningServerData::fromArray($server),
                $serversData
            );
        }

        $addons = null;
        $addonsData = Arr::get($data, 'addons');
        if (is_array($addonsData)) {
            $addons = array_map(
                fn($addon) => OsAddonData::fromArray($addon),
                $addonsData
            );
        }

        return new self(
            id: Arr::get($data, 'id'),
            name: Arr::get($data, 'name'),
            servers: $servers,
            tags: Arr::get($data, 'tags'),
            architecture: Arr::get($data, 'architecture'),
            cacheFolder: Arr::get($data, 'cache_folder'),
            mirror: Arr::get($data, 'mirror'),
            edition: Arr::get($data, 'edition'),
            isoUrl: Arr::get($data, 'iso_url'),
            extractIso: Arr::get($data, 'extract_iso'),
            timezone: Arr::get($data, 'timezone'),
            language: Arr::get($data, 'language'),
            gpxeScript: Arr::get($data, 'gpxe_script'),
            diskLayout: Arr::get($data, 'disk_layout'),
            packages: Arr::get($data, 'packages'),
            postInstallation: Arr::get($data, 'post_installation'),
            family: Arr::get($data, 'family'),
            isWindows: Arr::get($data, 'is_windows'),
            firstBoot: Arr::get($data, 'first_boot'),
            createdAt: Arr::get($data, 'created_at'),
            updatedAt: Arr::get($data, 'updated_at'),
            addons: $addons,
        );
    }
}
