<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class OsTemplateData
{
    public ?int $id;
    public ?int $templateId;
    public ?string $name;
    public ?array $tags;
    public ?string $architecture;
    public ?string $cacheFolder;
    public ?string $mirror;
    public ?string $edition;
    public ?string $isoUrl;
    public ?string $tftpUrl;
    public ?string $license;
    public ?string $gpxe;
    public ?string $diskLayout;
    public ?string $packages;
    public ?string $preInstallation;
    public ?string $postInstallation;
    public ?string $firstBoot;
    public ?string $extras;
    public ?string $timezone;
    public ?string $language;
    public ?string $family;
    public ?bool $isWindows;
    public ?bool $isRescue;
    public ?string $description;
    public ?array $addons;
    /**
     * @param array<string>|null $tags
     * @param array<mixed>|null $addons
     */
    public function __construct(?int $id, ?int $templateId, ?string $name, ?array $tags = null, ?string $architecture = null, ?string $cacheFolder = null, ?string $mirror = null, ?string $edition = null, ?string $isoUrl = null, ?string $tftpUrl = null, ?string $license = null, ?string $gpxe = null, ?string $diskLayout = null, ?string $packages = null, ?string $preInstallation = null, ?string $postInstallation = null, ?string $firstBoot = null, ?string $extras = null, ?string $timezone = null, ?string $language = null, ?string $family = null, ?bool $isWindows = null, ?bool $isRescue = null, ?string $description = null, ?array $addons = null)
    {
        $this->id = $id;
        $this->templateId = $templateId;
        $this->name = $name;
        $this->tags = $tags;
        $this->architecture = $architecture;
        $this->cacheFolder = $cacheFolder;
        $this->mirror = $mirror;
        $this->edition = $edition;
        $this->isoUrl = $isoUrl;
        $this->tftpUrl = $tftpUrl;
        $this->license = $license;
        $this->gpxe = $gpxe;
        $this->diskLayout = $diskLayout;
        $this->packages = $packages;
        $this->preInstallation = $preInstallation;
        $this->postInstallation = $postInstallation;
        $this->firstBoot = $firstBoot;
        $this->extras = $extras;
        $this->timezone = $timezone;
        $this->language = $language;
        $this->family = $family;
        $this->isWindows = $isWindows;
        $this->isRescue = $isRescue;
        $this->description = $description;
        $this->addons = $addons;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'id', 0),
            Arr::get($data, 'template_id', 0),
            Arr::get($data, 'name', ''),
            Arr::get($data, 'tags'),
            Arr::get($data, 'architecture'),
            Arr::get($data, 'cache_folder'),
            Arr::get($data, 'mirror'),
            Arr::get($data, 'edition'),
            Arr::get($data, 'iso_url'),
            Arr::get($data, 'tftp_url'),
            Arr::get($data, 'license'),
            Arr::get($data, 'gpxe'),
            Arr::get($data, 'disk_layout'),
            Arr::get($data, 'packages'),
            Arr::get($data, 'pre_installation'),
            Arr::get($data, 'post_installation'),
            Arr::get($data, 'first_boot'),
            Arr::get($data, 'extras'),
            Arr::get($data, 'timezone'),
            Arr::get($data, 'language'),
            Arr::get($data, 'family'),
            Arr::get($data, 'is_windows'),
            Arr::get($data, 'is_rescue'),
            Arr::get($data, 'description'),
            Arr::get($data, 'addons')
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'template_id' => $this->templateId,
            'name' => $this->name,
            'tags' => $this->tags,
            'architecture' => $this->architecture,
            'cache_folder' => $this->cacheFolder,
            'mirror' => $this->mirror,
            'edition' => $this->edition,
            'iso_url' => $this->isoUrl,
            'tftp_url' => $this->tftpUrl,
            'license' => $this->license,
            'gpxe' => $this->gpxe,
            'disk_layout' => $this->diskLayout,
            'packages' => $this->packages,
            'pre_installation' => $this->preInstallation,
            'post_installation' => $this->postInstallation,
            'first_boot' => $this->firstBoot,
            'extras' => $this->extras,
            'timezone' => $this->timezone,
            'language' => $this->language,
            'family' => $this->family,
            'is_windows' => $this->isWindows,
            'is_rescue' => $this->isRescue,
            'description' => $this->description,
            'addons' => $this->addons,
        ], fn($value) => $value !== null);
    }
}
