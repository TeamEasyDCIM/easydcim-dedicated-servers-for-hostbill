<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\ItemType;

/**
 * Request for creating an item type
 */
class CreateItemTypeRequest
{
    public string $name;
    public ?string $description;
    public ?string $group;
    public ?string $color;
    public function __construct(string $name, ?string $description = null, ?string $group = null, ?string $color = null)
    {
        $this->name = $name;
        $this->description = $description;
        $this->group = $group;
        $this->color = $color;
    }

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
