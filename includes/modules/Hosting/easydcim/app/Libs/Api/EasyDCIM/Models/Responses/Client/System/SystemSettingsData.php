<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\System;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class SystemSettingsData
{
    /**
     * @param array<string, string> $languages
     * @param array<string, string> $timezones
     */
    public function __construct(
        public ?string $companyName,
        public ?string $defaultClientAreaLanguage,
        public ?array $languages,
        public ?array $timezones,
    ) {}

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            companyName: Arr::get($data, 'company_name'),
            defaultClientAreaLanguage: Arr::get($data, 'default_client_area_language'),
            languages: Arr::get($data, 'languages'),
            timezones: Arr::get($data, 'timezones'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'company_name' => $this->companyName,
            'default_client_area_language' => $this->defaultClientAreaLanguage,
            'languages' => $this->languages,
            'timezones' => $this->timezones,
        ];
    }
}
