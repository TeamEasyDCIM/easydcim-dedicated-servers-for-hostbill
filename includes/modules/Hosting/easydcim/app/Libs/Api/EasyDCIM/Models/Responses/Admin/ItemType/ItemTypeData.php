<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\ItemType;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Item Type data structure
 */
class ItemTypeData
{
    public ?int $id;
    public ?string $name;
    public ?string $description;
    public ?int $hardware;
    public ?int $software;
    public ?int $predefined;
    public ?string $color;
    public ?string $createdAt;
    public ?string $updatedAt;
    public function __construct(?int $id, ?string $name, ?string $description, ?int $hardware, ?int $software, ?int $predefined, ?string $color, ?string $createdAt, ?string $updatedAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->hardware = $hardware;
        $this->software = $software;
        $this->predefined = $predefined;
        $this->color = $color;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
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
            Arr::get($data, 'description', ''),
            Arr::get($data, 'hardware', 0),
            Arr::get($data, 'software', 0),
            Arr::get($data, 'predefined', 0),
            Arr::get($data, 'color', ''),
            Arr::get($data, 'created_at', ''),
            Arr::get($data, 'updated_at', '')
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
            'description' => $this->description,
            'hardware' => $this->hardware,
            'software' => $this->software,
            'predefined' => $this->predefined,
            'color' => $this->color,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
