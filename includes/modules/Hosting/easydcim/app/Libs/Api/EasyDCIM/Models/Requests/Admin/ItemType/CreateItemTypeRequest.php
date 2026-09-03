<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\ItemType;

/**
 * Request for creating an item type
 */
class CreateItemTypeRequest
{
    public function __construct(
        public string $name,
        public ?string $description = null,
        public ?string $group = null,
        public ?string $color = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'description' => $this->description,
            'group' => $this->group,
            'color' => $this->color,
        ], fn($value) => $value !== null);
    }
}
