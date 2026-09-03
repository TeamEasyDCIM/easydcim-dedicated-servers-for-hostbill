<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Port;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Port data model
 */
class PortData
{
    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?string $description = null,
        public ?int $itemId = null,
        public ?int $colocationId = null,
        public ?int $connectedItem = null,
        public ?int $connectedPort = null,
        public ?int $portNumber = null,
        public ?int $portIndex = null,
        public ?string $portMode = null,
        public ?string $portLabel = null,
        public ?string $userLabel = null,
        public ?string $speed = null,
        public ?string $highSpeed = null,
        public ?string $ifType = null,
        public ?string $physaddress = null,
        public ?int $pullable = null,
        public ?int $primary = null,
        public ?int $vlan = null,
        public ?string $opstate = null,
        public ?string $adminstate = null,
        public ?string $type = null,
        public ?string $createdAt = null,
        public ?string $updatedAt = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: Arr::get($data, 'id') !== null ? (int) Arr::get($data, 'id') : null,
            name: Arr::get($data, 'name'),
            description: Arr::get($data, 'description'),
            itemId: Arr::get($data, 'item_id') !== null ? (int) Arr::get($data, 'item_id') : null,
            colocationId: Arr::get($data, 'colocation_id') !== null ? (int) Arr::get($data, 'colocation_id') : null,
            connectedItem: Arr::get($data, 'connected_item') !== null ? (int) Arr::get($data, 'connected_item') : null,
            connectedPort: Arr::get($data, 'connected_port') !== null ? (int) Arr::get($data, 'connected_port') : null,
            portNumber: Arr::get($data, 'port_number') !== null ? (int) Arr::get($data, 'port_number') : null,
            portIndex: Arr::get($data, 'port_index') !== null ? (int) Arr::get($data, 'port_index') : null,
            portMode: Arr::get($data, 'port_mode'),
            portLabel: Arr::get($data, 'port_label'),
            userLabel: Arr::get($data, 'user_label'),
            speed: Arr::get($data, 'speed'),
            highSpeed: Arr::get($data, 'high_speed'),
            ifType: Arr::get($data, 'if_type'),
            physaddress: Arr::get($data, 'physaddress'),
            pullable: Arr::get($data, 'pullable') !== null ? (int) Arr::get($data, 'pullable') : null,
            primary: Arr::get($data, 'primary') !== null ? (int) Arr::get($data, 'primary') : null,
            vlan: Arr::get($data, 'vlan') !== null ? (int) Arr::get($data, 'vlan') : null,
            opstate: Arr::get($data, 'opstate'),
            adminstate: Arr::get($data, 'adminstate'),
            type: Arr::get($data, 'type'),
            createdAt: Arr::get($data, 'created_at'),
            updatedAt: Arr::get($data, 'updated_at'),
        );
    }
}
