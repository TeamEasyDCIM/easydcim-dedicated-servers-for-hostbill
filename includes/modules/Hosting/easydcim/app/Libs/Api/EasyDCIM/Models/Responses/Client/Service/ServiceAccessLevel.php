<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Service;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class ServiceAccessLevel
{
    public ?int $id;
    public ?string $name;
    public ?AccessLevelPermissions $value;
    public function __construct(?int $id, ?string $name, ?AccessLevelPermissions $value)
    {
        $this->id = $id;
        $this->name = $name;
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
            AccessLevelPermissions::fromArray(Arr::get($data, 'value', []))
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
            'value' => $this->value->toArray(),
        ];
    }
}

