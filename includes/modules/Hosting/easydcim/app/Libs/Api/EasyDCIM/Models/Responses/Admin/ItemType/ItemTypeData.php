<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\ItemType;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Item Type data structure
 */
class ItemTypeData
{
    public function __construct(
        public ?int $id,
        public ?string $name,
        public ?string $description,
        public ?int $hardware,
        public ?int $software,
        public ?int $predefined,
        public ?string $color,
        public ?string $createdAt,
        public ?string $updatedAt,
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
            description: Arr::get($data, 'description', ''),
            hardware: Arr::get($data, 'hardware', 0),
            software: Arr::get($data, 'software', 0),
            predefined: Arr::get($data, 'predefined', 0),
            color: Arr::get($data, 'color', ''),
            createdAt: Arr::get($data, 'created_at', ''),
            updatedAt: Arr::get($data, 'updated_at', ''),
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
