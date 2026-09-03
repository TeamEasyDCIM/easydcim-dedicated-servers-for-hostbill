<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\ServiceAccessLevel;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Service Access Level data structure
 */
class ServiceAccessLevelData
{
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?string $type,
        public ?int $default,
        public ?array $value,
    ) {}

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: Arr::get($data, 'id', 0),
            name: Arr::get($data, 'name', ''),
            type: Arr::get($data, 'type', ''),
            default: Arr::get($data, 'default', 0),
            value: Arr::get($data, 'value', []),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'default' => $this->default,
            'value' => $this->value,
        ];
    }
}
