<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Service;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class ServiceRelated
{
    /**
     * @param array<string, mixed> $metadata Flat key-value pairs
     * @param array<string> $ipAddresses Array of IP address strings
     * @param array<string, array<MetadataGroupItem>> $metadataGroups Categorized metadata groups
     */
    public function __construct(
        public ?int $id,
        public ?string $label,
        public ?string $model,
        public ?string $location,
        public ?string $rack,
        public ?string $labeledRackWithPosition,
        public ?string $deviceStatus,
        public ?int $osInstallation,
        public ?UptimeData $uptime,
        public ?array $ipAddresses,
        public ?array $metadata,
        public ?array $metadataGroups,
    ) {}

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
            id: Arr::get($data, 'id', 0),
            label: Arr::get($data, 'label', ''),
            model: Arr::get($data, 'model', ''),
            location: Arr::get($data, 'location', ''),
            rack: Arr::get($data, 'rack', ''),
            labeledRackWithPosition: Arr::get($data, 'labeled_rack_with_position', ''),
            deviceStatus: Arr::get($data, 'device_status', ''),
            osInstallation: Arr::get($data, 'os_installation', 0),
            uptime: UptimeData::fromArray(Arr::get($data, 'uptime', [])),
            ipAddresses: Arr::get($data, 'ip_addresses', []),
            metadata: Arr::get($data, 'metadata', []),
            metadataGroups: $metadataGroups,
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
