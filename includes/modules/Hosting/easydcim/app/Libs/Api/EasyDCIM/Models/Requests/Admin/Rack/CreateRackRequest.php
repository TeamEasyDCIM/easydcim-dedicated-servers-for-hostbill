<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Rack;

/**
 * Request for creating a rack
 */
class CreateRackRequest
{
    public function __construct(
        public string $name,
        public int|string|null $locationId = null,
        public ?int $units = null,
        public ?string $description = null,
    ) {}

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
