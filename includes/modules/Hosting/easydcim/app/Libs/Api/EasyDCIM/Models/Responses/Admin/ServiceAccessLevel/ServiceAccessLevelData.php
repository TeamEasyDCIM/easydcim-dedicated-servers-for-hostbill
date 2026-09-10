<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\ServiceAccessLevel;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Service Access Level data structure
 */
class ServiceAccessLevelData
{
    public ?int $id;
    public ?string $name;
    public ?string $type;
    public ?int $default;
    public ?array $value;
    public function __construct(?int $id, ?string $name, ?string $type, ?int $default, ?array $value)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->default = $default;
        $this->value = $value;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'id', 0),
            Arr::get($data, 'name', ''),
            Arr::get($data, 'type', ''),
            Arr::get($data, 'default', 0),
            Arr::get($data, 'value', [])
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
