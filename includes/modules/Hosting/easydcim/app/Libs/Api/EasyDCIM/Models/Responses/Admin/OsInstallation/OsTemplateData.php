<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * OS Template data
 */
class OsTemplateData
{
    public ?int $id;
    public ?string $name;
    public ?array $servers;
    public $tags;
    public ?string $architecture;
    public ?string $cacheFolder;
    public ?string $mirror;
    public ?string $edition;
    public ?string $isoUrl;
    public ?bool $extractIso;
    public ?string $timezone;
    public ?string $language;
    public ?string $gpxeScript;
    public ?string $diskLayout;
    public ?string $packages;
    public ?string $postInstallation;
    public ?string $family;
    public ?bool $isWindows;
    public ?string $firstBoot;
    public ?string $createdAt;
    public ?string $updatedAt;
    public ?array $addons;
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
    public function __construct(?int $id, ?string $name, ?array $servers = null, $tags = null, ?string $architecture = null, ?string $cacheFolder = null, ?string $mirror = null, ?string $edition = null, ?string $isoUrl = null, ?bool $extractIso = null, ?string $timezone = null, ?string $language = null, ?string $gpxeScript = null, ?string $diskLayout = null, ?string $packages = null, ?string $postInstallation = null, ?string $family = null, ?bool $isWindows = null, ?string $firstBoot = null, ?string $createdAt = null, ?string $updatedAt = null, ?array $addons = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->servers = $servers;
        $this->tags = $tags;
        $this->architecture = $architecture;
        $this->cacheFolder = $cacheFolder;
        $this->mirror = $mirror;
        $this->edition = $edition;
        $this->isoUrl = $isoUrl;
        $this->extractIso = $extractIso;
        $this->timezone = $timezone;
        $this->language = $language;
        $this->gpxeScript = $gpxeScript;
        $this->diskLayout = $diskLayout;
        $this->packages = $packages;
        $this->postInstallation = $postInstallation;
        $this->family = $family;
        $this->isWindows = $isWindows;
        $this->firstBoot = $firstBoot;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->addons = $addons;
    }

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
            Arr::get($data, 'id'),
            Arr::get($data, 'name'),
            $servers,
            Arr::get($data, 'tags'),
            Arr::get($data, 'architecture'),
            Arr::get($data, 'cache_folder'),
            Arr::get($data, 'mirror'),
            Arr::get($data, 'edition'),
            Arr::get($data, 'iso_url'),
            Arr::get($data, 'extract_iso'),
            Arr::get($data, 'timezone'),
            Arr::get($data, 'language'),
            Arr::get($data, 'gpxe_script'),
            Arr::get($data, 'disk_layout'),
            Arr::get($data, 'packages'),
            Arr::get($data, 'post_installation'),
            Arr::get($data, 'family'),
            Arr::get($data, 'is_windows'),
            Arr::get($data, 'first_boot'),
            Arr::get($data, 'created_at'),
            Arr::get($data, 'updated_at'),
            $addons
        );
    }
}
