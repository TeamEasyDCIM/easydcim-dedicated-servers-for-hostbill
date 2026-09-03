<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\OsInstallation;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class OsTemplateData
{
    /**
     * @param array<string>|null $tags
     * @param array<mixed>|null $addons
     */
    public function __construct(
        public ?int $id,
        public ?int $templateId,
        public ?string $name,
        public ?array $tags = null,
        public ?string $architecture = null,
        public ?string $cacheFolder = null,
        public ?string $mirror = null,
        public ?string $edition = null,
        public ?string $isoUrl = null,
        public ?string $tftpUrl = null,
        public ?string $license = null,
        public ?string $gpxe = null,
        public ?string $diskLayout = null,
        public ?string $packages = null,
        public ?string $preInstallation = null,
        public ?string $postInstallation = null,
        public ?string $firstBoot = null,
        public ?string $extras = null,
        public ?string $timezone = null,
        public ?string $language = null,
        public ?string $family = null,
        public ?bool $isWindows = null,
        public ?bool $isRescue = null,
        public ?string $description = null,
        public ?array $addons = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: Arr::get($data, 'id', 0),
            templateId: Arr::get($data, 'template_id', 0),
            name: Arr::get($data, 'name', ''),
            tags: Arr::get($data, 'tags'),
            architecture: Arr::get($data, 'architecture'),
            cacheFolder: Arr::get($data, 'cache_folder'),
            mirror: Arr::get($data, 'mirror'),
            edition: Arr::get($data, 'edition'),
            isoUrl: Arr::get($data, 'iso_url'),
            tftpUrl: Arr::get($data, 'tftp_url'),
            license: Arr::get($data, 'license'),
            gpxe: Arr::get($data, 'gpxe'),
            diskLayout: Arr::get($data, 'disk_layout'),
            packages: Arr::get($data, 'packages'),
            preInstallation: Arr::get($data, 'pre_installation'),
            postInstallation: Arr::get($data, 'post_installation'),
            firstBoot: Arr::get($data, 'first_boot'),
            extras: Arr::get($data, 'extras'),
            timezone: Arr::get($data, 'timezone'),
            language: Arr::get($data, 'language'),
            family: Arr::get($data, 'family'),
            isWindows: Arr::get($data, 'is_windows'),
            isRescue: Arr::get($data, 'is_rescue'),
            description: Arr::get($data, 'description'),
            addons: Arr::get($data, 'addons'),
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
