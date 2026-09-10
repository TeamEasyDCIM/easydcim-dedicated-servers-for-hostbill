<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Service;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class ServiceRelated
{
    public ?int $id;
    public ?string $label;
    public ?string $model;
    public ?string $location;
    public ?string $rack;
    public ?string $labeledRackWithPosition;
    public ?string $deviceStatus;
    public ?int $osInstallation;
    public ?UptimeData $uptime;
    public ?array $ipAddresses;
    public ?array $metadata;
    public ?array $metadataGroups;
    /**
     * @param array<string, mixed> $metadata Flat key-value pairs
     * @param array<string> $ipAddresses Array of IP address strings
     * @param array<string, array<MetadataGroupItem>> $metadataGroups Categorized metadata groups
     */
    public function __construct(?int $id, ?string $label, ?string $model, ?string $location, ?string $rack, ?string $labeledRackWithPosition, ?string $deviceStatus, ?int $osInstallation, ?UptimeData $uptime, ?array $ipAddresses, ?array $metadata, ?array $metadataGroups)
    {
        $this->id = $id;
        $this->label = $label;
        $this->model = $model;
        $this->location = $location;
        $this->rack = $rack;
        $this->labeledRackWithPosition = $labeledRackWithPosition;
        $this->deviceStatus = $deviceStatus;
        $this->osInstallation = $osInstallation;
        $this->uptime = $uptime;
        $this->ipAddresses = $ipAddresses;
        $this->metadata = $metadata;
        $this->metadataGroups = $metadataGroups;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $metadataGroupsRaw = Arr::get($data, 'metadataGroups', []);
        $metadataGroups = [];
        foreach ($metadataGroupsRaw as $groupName => $items) {
            $metadataGroups[$groupName] = array_map(
                fn($item) => MetadataGroupItem::fromArray($item),
                $items
            );
        }

        return new self(
            Arr::get($data, 'id', 0),
            Arr::get($data, 'label', ''),
            Arr::get($data, 'model', ''),
            Arr::get($data, 'location', ''),
            Arr::get($data, 'rack', ''),
            Arr::get($data, 'labeled_rack_with_position', ''),
            Arr::get($data, 'device_status', ''),
            Arr::get($data, 'os_installation', 0),
            UptimeData::fromArray(Arr::get($data, 'uptime', [])),
            Arr::get($data, 'ip_addresses', []),
            Arr::get($data, 'metadata', []),
            $metadataGroups
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        // Convert metadataGroups back to arrays
        $metadataGroups = [];
        foreach ($this->metadataGroups as $groupName => $items) {
            $metadataGroups[$groupName] = array_map(
                fn($item) => $item->toArray(),
                $items
            );
        }

        return [
            'id' => $this->id,
            'label' => $this->label,
            'model' => $this->model,
            'location' => $this->location,
            'rack' => $this->rack,
            'device_status' => $this->deviceStatus,
            'os_installation' => $this->osInstallation,
            'uptime' => $this->uptime->toArray(),
            'ip_addresses' => $this->ipAddresses,
            'metadata' => $this->metadata,
            'metadataGroups' => $metadataGroups,
        ];
    }
}
