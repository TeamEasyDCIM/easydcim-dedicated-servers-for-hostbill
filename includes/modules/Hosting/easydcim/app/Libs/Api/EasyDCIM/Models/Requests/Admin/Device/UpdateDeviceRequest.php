<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Device;

/**
 * Request for updating a device
 */
class UpdateDeviceRequest
{
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
    public function __construct(
        public ?string $label = null,
        public ?int $model = null,
        public ?int $location = null,
        public ?int $parent = null,
        public ?int $client = null,
        public ?int $rack = null,
        public ?int $position = null,
        public ?string $sizePosition = null,
        public ?bool $isPart = null,
        public ?string $manufacturer = null,
        public ?string $serialnumber1 = null,
        public ?string $serviceTag = null,
        public ?string $comments = null,
        public ?string $description = null,
        public ?string $purchaseDate = null,
        public ?int $warrantyMonths = null,
        public ?string $warrantyInfo = null,
        public ?string $status = null,
        public ?string $function = null,
        public ?string $origin = null,
        public ?float $buyPrice = null,
        public ?array $appdata = null,
        public ?string $notes = null,
        public ?array $metadata = null,
    ) {}

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
