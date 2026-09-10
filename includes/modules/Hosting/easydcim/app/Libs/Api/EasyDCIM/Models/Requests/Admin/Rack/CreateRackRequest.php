<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Rack;

/**
 * Request for creating a rack
 */
class CreateRackRequest
{
    public string $name;
    public $locationId;
    public ?int $units;
    public ?string $description;
    public function __construct(string $name, $locationId = null, ?int $units = null, ?string $description = null)
    {
        $this->name = $name;
        $this->locationId = $locationId;
        $this->units = $units;
        $this->description = $description;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'location_id' => $this->locationId,
            'units_number' => $this->units,
            'description' => $this->description,
        ], fn($value) => $value !== null);
    }
}
