<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation;

/**
 * Request for creating an OS template
 */
class CreateOsTemplateRequest
{
    /**
     * @param string $name Template name
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
    public function __construct(
        public string $name,
        public ?array $server = null,
        public ?string $tags = null,
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
        public ?string $firstBoot = null,
    ) {}

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
