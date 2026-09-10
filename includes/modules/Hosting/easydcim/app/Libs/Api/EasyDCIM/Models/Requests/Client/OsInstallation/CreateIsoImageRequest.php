<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\OsInstallation;

class CreateIsoImageRequest
{
    public string $name;
    public string $isoUrl;
    public function __construct(string $name, string $isoUrl)
    {
        $this->name = $name;
        $this->isoUrl = $isoUrl;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'iso_url' => $this->isoUrl,
        ];
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['iso_url'] ?? $data['isoUrl']
        );
    }
}
