<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Device;

/**
 * Request for updating a device
 */
class UpdateDeviceRequest
{
    public ?string $label;
    public ?int $model;
    public ?int $location;
    public ?int $parent;
    public ?int $client;
    public ?int $rack;
    public ?int $position;
    public ?string $sizePosition;
    public ?bool $isPart;
    public ?string $manufacturer;
    public ?string $serialnumber1;
    public ?string $serviceTag;
    public ?string $comments;
    public ?string $description;
    public ?string $purchaseDate;
    public ?int $warrantyMonths;
    public ?string $warrantyInfo;
    public ?string $status;
    public ?string $function;
    public ?string $origin;
    public ?float $buyPrice;
    public ?array $appdata;
    public ?string $notes;
    public ?array $metadata;
    /**
     * @param string|null $label Device label
     * @param int|null $model Model ID
     * @param int|null $location Location ID
     * @param int|null $parent Parent device ID
     * @param int|null $client Client/User ID
     * @param int|null $rack Rack ID
     * @param int|null $position Rack position
     * @param string|null $sizePosition Size position (front/back)
     * @param bool|null $isPart Is this a part
     * @param string|null $manufacturer Manufacturer name
     * @param string|null $serialnumber1 Serial number 1
     * @param string|null $serviceTag Service tag
     * @param string|null $comments Comments
     * @param string|null $description Description
     * @param string|null $purchaseDate Purchase date
     * @param int|null $warrantyMonths Warranty months
     * @param string|null $warrantyInfo Warranty info
     * @param string|null $status Device status
     * @param string|null $function Device function
     * @param string|null $origin Origin
     * @param float|null $buyPrice Purchase price
     * @param array|null $appdata Application data
     * @param string|null $notes Notes
     * @param array<array>|null $metadata Array of metadata (metadata_id, value, raw_value)
     */
    public function __construct(?string $label = null, ?int $model = null, ?int $location = null, ?int $parent = null, ?int $client = null, ?int $rack = null, ?int $position = null, ?string $sizePosition = null, ?bool $isPart = null, ?string $manufacturer = null, ?string $serialnumber1 = null, ?string $serviceTag = null, ?string $comments = null, ?string $description = null, ?string $purchaseDate = null, ?int $warrantyMonths = null, ?string $warrantyInfo = null, ?string $status = null, ?string $function = null, ?string $origin = null, ?float $buyPrice = null, ?array $appdata = null, ?string $notes = null, ?array $metadata = null)
    {
        $this->label = $label;
        $this->model = $model;
        $this->location = $location;
        $this->parent = $parent;
        $this->client = $client;
        $this->rack = $rack;
        $this->position = $position;
        $this->sizePosition = $sizePosition;
        $this->isPart = $isPart;
        $this->manufacturer = $manufacturer;
        $this->serialnumber1 = $serialnumber1;
        $this->serviceTag = $serviceTag;
        $this->comments = $comments;
        $this->description = $description;
        $this->purchaseDate = $purchaseDate;
        $this->warrantyMonths = $warrantyMonths;
        $this->warrantyInfo = $warrantyInfo;
        $this->status = $status;
        $this->function = $function;
        $this->origin = $origin;
        $this->buyPrice = $buyPrice;
        $this->appdata = $appdata;
        $this->notes = $notes;
        $this->metadata = $metadata;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'label' => $this->label,
            'model' => $this->model,
            'location' => $this->location,
            'parent' => $this->parent,
            'client' => $this->client,
            'rack' => $this->rack,
            'position' => $this->position,
            'size_position' => $this->sizePosition,
            'is_part' => $this->isPart,
            'manufacturer' => $this->manufacturer,
            'serialnumber1' => $this->serialnumber1,
            'service_tag' => $this->serviceTag,
            'comments' => $this->comments,
            'description' => $this->description,
            'purchase_date' => $this->purchaseDate,
            'warranty_months' => $this->warrantyMonths,
            'warranty_info' => $this->warrantyInfo,
            'status' => $this->status,
            'function' => $this->function,
            'origin' => $this->origin,
            'buy_price' => $this->buyPrice,
            'appdata' => $this->appdata,
            'notes' => $this->notes,
            'metadata' => $this->metadata,
        ], fn($value) => $value !== null);
    }
}
