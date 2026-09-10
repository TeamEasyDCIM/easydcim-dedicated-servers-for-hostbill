<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\ItemModel;

/**
 * Request for creating an item model
 */
class CreateItemModelRequest
{
    public string $name;
    public int $typeId;
    public int $locationId;
    public ?string $label;
    public ?string $status;
    public ?string $description;
    public ?bool $isPart;
    public ?bool $mountable;
    public ?string $manufacturer;
    public ?string $position;
    public ?int $size;
    public ?string $image;
    public ?string $serialnumber1;
    public ?string $serialnumber2;
    public ?string $serviceTag;
    public ?string $comments;
    public ?string $notes;
    public ?string $purchaseDate;
    public ?int $warrantyMonths;
    public ?string $warrantyInfo;
    public ?string $function;
    public ?string $maintenanceInstruction;
    public ?string $origin;
    public ?float $buyPrice;
    public function __construct(string $name, int $typeId, int $locationId, ?string $label = null, ?string $status = null, ?string $description = null, ?bool $isPart = null, ?bool $mountable = null, ?string $manufacturer = null, ?string $position = null, ?int $size = null, ?string $image = null, ?string $serialnumber1 = null, ?string $serialnumber2 = null, ?string $serviceTag = null, ?string $comments = null, ?string $notes = null, ?string $purchaseDate = null, ?int $warrantyMonths = null, ?string $warrantyInfo = null, ?string $function = null, ?string $maintenanceInstruction = null, ?string $origin = null, ?float $buyPrice = null)
    {
        $this->name = $name;
        $this->typeId = $typeId;
        $this->locationId = $locationId;
        $this->label = $label;
        $this->status = $status;
        $this->description = $description;
        $this->isPart = $isPart;
        $this->mountable = $mountable;
        $this->manufacturer = $manufacturer;
        $this->position = $position;
        $this->size = $size;
        $this->image = $image;
        $this->serialnumber1 = $serialnumber1;
        $this->serialnumber2 = $serialnumber2;
        $this->serviceTag = $serviceTag;
        $this->comments = $comments;
        $this->notes = $notes;
        $this->purchaseDate = $purchaseDate;
        $this->warrantyMonths = $warrantyMonths;
        $this->warrantyInfo = $warrantyInfo;
        $this->function = $function;
        $this->maintenanceInstruction = $maintenanceInstruction;
        $this->origin = $origin;
        $this->buyPrice = $buyPrice;
    }

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
