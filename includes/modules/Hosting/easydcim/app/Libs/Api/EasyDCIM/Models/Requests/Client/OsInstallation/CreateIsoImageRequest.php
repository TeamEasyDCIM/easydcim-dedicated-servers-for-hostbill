<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\OsInstallation;

class CreateIsoImageRequest
{
    public function __construct(
        public string $name,
        public string $isoUrl,
    ) {}

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
            name: $data['name'],
            isoUrl: $data['iso_url'] ?? $data['isoUrl'],
        );
    }
}
