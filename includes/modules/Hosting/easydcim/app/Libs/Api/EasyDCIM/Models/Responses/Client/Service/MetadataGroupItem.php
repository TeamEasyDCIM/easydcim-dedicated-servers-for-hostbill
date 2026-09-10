<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Service;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class MetadataGroupItem
{
    public ?string $label;
    public ?string $value;
    public ?bool $encrypted;
    public function __construct(?string $label, ?string $value, ?bool $encrypted)
    {
        $this->label = $label;
        $this->value = $value;
        $this->encrypted = $encrypted;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'label', ''),
            Arr::get($data, 'value', ''),
            Arr::get($data, 'encrypted', false)
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
