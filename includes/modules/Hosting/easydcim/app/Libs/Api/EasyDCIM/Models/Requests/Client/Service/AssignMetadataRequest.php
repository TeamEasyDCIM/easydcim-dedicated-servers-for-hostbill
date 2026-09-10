<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Service;

class AssignMetadataRequest
{
    public string $slug;
    public string $value;
    public function __construct(string $slug, string $value)
    {
        $this->slug = $slug;
        $this->value = $value;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'slug' => $this->slug,
            'value' => $this->value,
        ];
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['slug'] ?? '',
            $data['value'] ?? ''
        );
    }
}
