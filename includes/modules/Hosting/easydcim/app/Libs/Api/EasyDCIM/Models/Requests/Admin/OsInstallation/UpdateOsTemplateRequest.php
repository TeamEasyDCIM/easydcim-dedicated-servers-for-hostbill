<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation;

/**
 * Request for updating an OS template
 */
class UpdateOsTemplateRequest
{
    public ?string $name;
    public ?array $server;
    public ?string $tags;
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
    public ?string $firstBoot;
    /**
     * @param string|null $name Template name
     * @param array<int>|null $server Server IDs
     * @param string|null $tags Tags
     * @param string|null $architecture Architecture (x86_64, i386, etc.)
     * @param string|null $cacheFolder Cache folder path
     * @param string|null $mirror Mirror URL
     * @param string|null $edition Edition/version
     * @param string|null $isoUrl ISO URL
     * @param bool|null $extractIso Extract ISO flag
     * @param string|null $timezone Timezone
     * @param string|null $language Language
     * @param string|null $gpxeScript gPXE script
     * @param string|null $diskLayout Disk layout configuration
     * @param string|null $packages Packages to install
     * @param string|null $postInstallation Post-installation script
     * @param string|null $firstBoot First boot script
     */
    public function __construct(?string $name = null, ?array $server = null, ?string $tags = null, ?string $architecture = null, ?string $cacheFolder = null, ?string $mirror = null, ?string $edition = null, ?string $isoUrl = null, ?bool $extractIso = null, ?string $timezone = null, ?string $language = null, ?string $gpxeScript = null, ?string $diskLayout = null, ?string $packages = null, ?string $postInstallation = null, ?string $firstBoot = null)
    {
        $this->name = $name;
        $this->server = $server;
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
        $this->firstBoot = $firstBoot;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'server' => $this->server,
            'tags' => $this->tags,
            'architecture' => $this->architecture,
            'cache_folder' => $this->cacheFolder,
            'mirror' => $this->mirror,
            'edition' => $this->edition,
            'iso_url' => $this->isoUrl,
            'extract_iso' => $this->extractIso,
            'timezone' => $this->timezone,
            'language' => $this->language,
            'gpxe_script' => $this->gpxeScript,
            'disk_layout' => $this->diskLayout,
            'packages' => $this->packages,
            'post_installation' => $this->postInstallation,
            'first_boot' => $this->firstBoot,
        ], fn($value) => $value !== null);
    }
}
