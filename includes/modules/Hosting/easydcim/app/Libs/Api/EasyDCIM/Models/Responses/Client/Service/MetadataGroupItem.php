<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Service;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class MetadataGroupItem
{
    public function __construct(
        public ?string $label,
        public ?string $value,
        public ?bool $encrypted,
    ) {}

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            label: Arr::get($data, 'label', ''),
            value: Arr::get($data, 'value', ''),
            encrypted: Arr::get($data, 'encrypted', false),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'value' => $this->value,
            'encrypted' => $this->encrypted,
        ];
    }
}
