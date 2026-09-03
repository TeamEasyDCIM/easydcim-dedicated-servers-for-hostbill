<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\ItemModel;

/**
 * Request for updating an item model
 */
class UpdateItemModelRequest
{
    public function __construct(
        public ?string $name = null,
        public ?int $typeId = null,
        public ?int $locationId = null,
        public ?string $label = null,
        public ?string $status = null,
        public ?string $description = null,
        public ?bool $isPart = null,
        public ?bool $mountable = null,
        public ?string $manufacturer = null,
        public ?string $position = null,
        public ?int $size = null,
        public ?string $image = null,
        public ?string $serialnumber1 = null,
        public ?string $serialnumber2 = null,
        public ?string $serviceTag = null,
        public ?string $comments = null,
        public ?string $notes = null,
        public ?string $purchaseDate = null,
        public ?int $warrantyMonths = null,
        public ?string $warrantyInfo = null,
        public ?string $function = null,
        public ?string $maintenanceInstruction = null,
        public ?string $origin = null,
        public ?float $buyPrice = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'type_id' => $this->typeId,
            'location_id' => $this->locationId,
            'label' => $this->label,
            'status' => $this->status,
            'description' => $this->description,
            'is_part' => $this->isPart,
            'mountable' => $this->mountable,
            'manufacturer' => $this->manufacturer,
            'position' => $this->position,
            'size' => $this->size,
            'image' => $this->image,
            'serialnumber1' => $this->serialnumber1,
            'serialnumber2' => $this->serialnumber2,
            'service_tag' => $this->serviceTag,
            'comments' => $this->comments,
            'notes' => $this->notes,
            'purchase_date' => $this->purchaseDate,
            'warranty_months' => $this->warrantyMonths,
            'warranty_info' => $this->warrantyInfo,
            'function' => $this->function,
            'maintenance_instruction' => $this->maintenanceInstruction,
            'origin' => $this->origin,
            'buy_price' => $this->buyPrice,
        ], fn($value) => $value !== null);
    }
}
