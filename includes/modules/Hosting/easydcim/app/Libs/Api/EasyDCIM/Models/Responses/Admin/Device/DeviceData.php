<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Device;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\ItemModel\ItemModelData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\ItemType\ItemTypeData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Location\LocationData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Rack\RackData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\User\UserData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Device data structure from EasyDCIM API
 *
 * Represents complete device information including hardware specs,
 * status, metadata, and related entities (type, model, user, location, rack, parent).
 */
class DeviceData
{
    public ?int $id;
    public ?string $label;
    public ?int $productId;
    public ?int $modelId;
    public ?int $parentId;
    public ?int $typeId;
    public ?int $userId;
    public ?int $orderId;
    public ?int $locationId;
    public ?int $rackId;
    public ?int $bladeId;
    public ?int $osInstallation;
    public ?int $colocationId;
    public ?int $provisioningId;
    public ?string $image;
    public ?string $tags;
    public ?int $size;
    public ?string $sizePosition;
    public ?int $dataPorts;
    public ?int $powerSupplies;
    public ?string $manufacturer;
    public ?string $serialnumber1;
    public ?string $serialnumber2;
    public ?string $serviceTag;
    public ?string $comments;
    public ?string $description;
    public ?array $ipList;
    public $purchaseDate;
    public ?int $warrantyMonths;
    public ?string $warrantyInfo;
    public ?string $status;
    public ?int $isService;
    public ?string $serviceStatus;
    public ?string $deviceStatus;
    public ?string $function;
    public ?string $maintenanceInstruction;
    public ?string $origin;
    public $buyPrice;
    public $appdata;
    public ?string $notes;
    public ?int $locked;
    public ?string $lastDiscovered;
    public $discoveryTime;
    public ?string $lastPolled;
    public ?int $pollerDisabled;
    public $pollerTime;
    public $lastHourTraffic;
    public $lastDayTraffic;
    public $lastWeekTraffic;
    public $lastMonthTraffic;
    public $currentMonthTraffic;
    public ?string $labeledRackWithPosition;
    public ?array $metadata;
    public $deviceTraffic;
    public ?ItemTypeData $type;
    public ?ItemModelData $model;
    public ?UserData $user;
    public ?LocationData $location;
    public ?RackData $rack;
    public function __construct(?int $id, ?string $label, ?int $productId, ?int $modelId, ?int $parentId, ?int $typeId, ?int $userId, ?int $orderId, ?int $locationId, ?int $rackId, ?int $bladeId, ?int $osInstallation, ?int $colocationId, ?int $provisioningId, ?string $image, ?string $tags, ?int $size, ?string $sizePosition, ?int $dataPorts, ?int $powerSupplies, ?string $manufacturer, ?string $serialnumber1, ?string $serialnumber2, ?string $serviceTag, ?string $comments, ?string $description, ?array $ipList, $purchaseDate, ?int $warrantyMonths, ?string $warrantyInfo, ?string $status, ?int $isService, ?string $serviceStatus, ?string $deviceStatus, ?string $function, ?string $maintenanceInstruction, ?string $origin, $buyPrice, $appdata, ?string $notes, ?int $locked, ?string $lastDiscovered, $discoveryTime, ?string $lastPolled, ?int $pollerDisabled, $pollerTime, $lastHourTraffic, $lastDayTraffic, $lastWeekTraffic, $lastMonthTraffic, $currentMonthTraffic, ?string $labeledRackWithPosition, ?array $metadata = [], $deviceTraffic = null, ?ItemTypeData $type = null, ?ItemModelData $model = null, ?UserData $user = null, ?LocationData $location = null, ?RackData $rack = null)
    {
        $this->id = $id;
        $this->label = $label;
        $this->productId = $productId;
        $this->modelId = $modelId;
        $this->parentId = $parentId;
        $this->typeId = $typeId;
        $this->userId = $userId;
        $this->orderId = $orderId;
        $this->locationId = $locationId;
        $this->rackId = $rackId;
        $this->bladeId = $bladeId;
        $this->osInstallation = $osInstallation;
        $this->colocationId = $colocationId;
        $this->provisioningId = $provisioningId;
        $this->image = $image;
        $this->tags = $tags;
        $this->size = $size;
        $this->sizePosition = $sizePosition;
        $this->dataPorts = $dataPorts;
        $this->powerSupplies = $powerSupplies;
        $this->manufacturer = $manufacturer;
        $this->serialnumber1 = $serialnumber1;
        $this->serialnumber2 = $serialnumber2;
        $this->serviceTag = $serviceTag;
        $this->comments = $comments;
        $this->description = $description;
        $this->ipList = $ipList;
        $this->purchaseDate = $purchaseDate;
        $this->warrantyMonths = $warrantyMonths;
        $this->warrantyInfo = $warrantyInfo;
        $this->status = $status;
        $this->isService = $isService;
        $this->serviceStatus = $serviceStatus;
        $this->deviceStatus = $deviceStatus;
        $this->function = $function;
        $this->maintenanceInstruction = $maintenanceInstruction;
        $this->origin = $origin;
        $this->buyPrice = $buyPrice;
        $this->appdata = $appdata;
        $this->notes = $notes;
        $this->locked = $locked;
        $this->lastDiscovered = $lastDiscovered;
        $this->discoveryTime = $discoveryTime;
        $this->lastPolled = $lastPolled;
        $this->pollerDisabled = $pollerDisabled;
        $this->pollerTime = $pollerTime;
        $this->lastHourTraffic = $lastHourTraffic;
        $this->lastDayTraffic = $lastDayTraffic;
        $this->lastWeekTraffic = $lastWeekTraffic;
        $this->lastMonthTraffic = $lastMonthTraffic;
        $this->currentMonthTraffic = $currentMonthTraffic;
        $this->labeledRackWithPosition = $labeledRackWithPosition;
        $this->metadata = $metadata;
        $this->deviceTraffic = $deviceTraffic;
        $this->type = $type;
        $this->model = $model;
        $this->user = $user;
        $this->location = $location;
        $this->rack = $rack;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'id', 0),
            Arr::get($data, 'label', ''),
            Arr::get($data, 'product_id', 0),
            Arr::get($data, 'model_id', 0),
            Arr::get($data, 'parent_id', 0),
            Arr::get($data, 'type_id', 0),
            Arr::get($data, 'user_id', 0),
            Arr::get($data, 'order_id', 0),
            Arr::get($data, 'location_id', 0),
            Arr::get($data, 'rack_id', 0),
            Arr::get($data, 'blade_id', 0),
            Arr::get($data, 'os_installation', 0),
            Arr::get($data, 'colocation_id', 0),
            Arr::get($data, 'provisioning_id', 0),
            Arr::get($data, 'image'),
            Arr::get($data, 'tags'),
            Arr::get($data, 'size', 0),
            Arr::get($data, 'size_position', 'front'),
            Arr::get($data, 'data_ports', 0),
            Arr::get($data, 'power_supplies', 0),
            Arr::get($data, 'manufacturer'),
            Arr::get($data, 'serialnumber1'),
            Arr::get($data, 'serialnumber2'),
            Arr::get($data, 'service_tag'),
            Arr::get($data, 'comments'),
            Arr::get($data, 'description'),
            Arr::get($data, 'ip_addresses'),
            Arr::get($data, 'purchase_date', 'Unassigned'),
            Arr::get($data, 'warranty_months', 0),
            Arr::get($data, 'warranty_info'),
            Arr::get($data, 'status', ''),
            Arr::get($data, 'is_service', 0),
            Arr::get($data, 'service_status', ''),
            Arr::get($data, 'device_status', ''),
            Arr::get($data, 'function'),
            Arr::get($data, 'maintenance_instruction'),
            Arr::get($data, 'origin'),
            Arr::get($data, 'buy_price', 0),
            Arr::get($data, 'appdata'),
            Arr::get($data, 'notes'),
            Arr::get($data, 'locked', 0),
            Arr::get($data, 'last_discovered', 'Never'),
            Arr::get($data, 'discovery_time', 0),
            Arr::get($data, 'last_polled', ''),
            Arr::get($data, 'poller_disabled', 0),
            Arr::get($data, 'poller_time', 0),
            Arr::get($data, 'last_hour_traffic', 0),
            Arr::get($data, 'last_day_traffic', 0),
            Arr::get($data, 'last_week_traffic', 0),
            Arr::get($data, 'last_month_traffic', 0),
            Arr::get($data, 'current_month_traffic', 0),
            strip_tags((string) Arr::get($data, 'labeledRackWithPosition', '')),
            Arr::get($data, 'metadata', []),
            Arr::get($data, 'device_traffic'),
            isset($data['type']) && is_array($data['type']) ? ItemTypeData::fromArray($data['type']) : null,
            isset($data['model']) && is_array($data['model']) ? ItemModelData::fromArray($data['model']) : null,
            isset($data['user']) && is_array($data['user']) ? UserData::fromArray($data['user']) : null,
            isset($data['location']) && is_array($data['location']) ? LocationData::fromArray($data['location']) : null,
            isset($data['rack']) && is_array($data['rack']) ? RackData::fromArray($data['rack']) : null
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'product_id' => $this->productId,
            'model_id' => $this->modelId,
            'parent_id' => $this->parentId,
            'type_id' => $this->typeId,
            'user_id' => $this->userId,
            'order_id' => $this->orderId,
            'location_id' => $this->locationId,
            'rack_id' => $this->rackId,
            'blade_id' => $this->bladeId,
            'os_installation' => $this->osInstallation,
            'colocation_id' => $this->colocationId,
            'provisioning_id' => $this->provisioningId,
            'image' => $this->image,
            'tags' => $this->tags,
            'size' => $this->size,
            'size_position' => $this->sizePosition,
            'data_ports' => $this->dataPorts,
            'power_supplies' => $this->powerSupplies,
            'manufacturer' => $this->manufacturer,
            'serialnumber1' => $this->serialnumber1,
            'serialnumber2' => $this->serialnumber2,
            'service_tag' => $this->serviceTag,
            'comments' => $this->comments,
            'description' => $this->description,
            'ip_list' => $this->ipList,
            'purchase_date' => $this->purchaseDate,
            'warranty_months' => $this->warrantyMonths,
            'warranty_info' => $this->warrantyInfo,
            'status' => $this->status,
            'is_service' => $this->isService,
            'service_status' => $this->serviceStatus,
            'device_status' => $this->deviceStatus,
            'function' => $this->function,
            'maintenance_instruction' => $this->maintenanceInstruction,
            'origin' => $this->origin,
            'buy_price' => $this->buyPrice,
            'appdata' => $this->appdata,
            'notes' => $this->notes,
            'locked' => $this->locked,
            'last_discovered' => $this->lastDiscovered,
            'discovery_time' => $this->discoveryTime,
            'last_polled' => $this->lastPolled,
            'poller_disabled' => $this->pollerDisabled,
            'poller_time' => $this->pollerTime,
            'last_hour_traffic' => $this->lastHourTraffic,
            'last_day_traffic' => $this->lastDayTraffic,
            'last_week_traffic' => $this->lastWeekTraffic,
            'last_month_traffic' => $this->lastMonthTraffic,
            'current_month_traffic' => $this->currentMonthTraffic,
            'labeledRackWithPosition' => $this->labeledRackWithPosition,
            'metadata' => $this->metadata,
            'device_traffic' => $this->deviceTraffic,
            'type' => $this->type === null ? null : $this->type->toArray(),
            'model' => $this->model === null ? null : $this->model->toArray(),
            'user' => $this->user === null ? null : $this->user->toArray(),
            'location' => $this->location === null ? null : $this->location->toArray(),
            'rack' => $this->rack === null ? null : $this->rack->toArray(),
        ];
    }
}
