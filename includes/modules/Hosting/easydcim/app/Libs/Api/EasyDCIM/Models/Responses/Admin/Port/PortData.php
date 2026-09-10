<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Port;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Port data model
 */
class PortData
{
    public ?int $id;
    public ?string $name;
    public ?string $description;
    public ?int $itemId;
    public ?int $colocationId;
    public ?int $connectedItem;
    public ?int $connectedPort;
    public ?int $portNumber;
    public ?int $portIndex;
    public ?string $portMode;
    public ?string $portLabel;
    public ?string $userLabel;
    public ?string $speed;
    public ?string $highSpeed;
    public ?string $ifType;
    public ?string $physaddress;
    public ?int $pullable;
    public ?int $primary;
    public ?int $vlan;
    public ?string $opstate;
    public ?string $adminstate;
    public ?string $type;
    public ?string $createdAt;
    public ?string $updatedAt;
    public function __construct(?int $id = null, ?string $name = null, ?string $description = null, ?int $itemId = null, ?int $colocationId = null, ?int $connectedItem = null, ?int $connectedPort = null, ?int $portNumber = null, ?int $portIndex = null, ?string $portMode = null, ?string $portLabel = null, ?string $userLabel = null, ?string $speed = null, ?string $highSpeed = null, ?string $ifType = null, ?string $physaddress = null, ?int $pullable = null, ?int $primary = null, ?int $vlan = null, ?string $opstate = null, ?string $adminstate = null, ?string $type = null, ?string $createdAt = null, ?string $updatedAt = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->itemId = $itemId;
        $this->colocationId = $colocationId;
        $this->connectedItem = $connectedItem;
        $this->connectedPort = $connectedPort;
        $this->portNumber = $portNumber;
        $this->portIndex = $portIndex;
        $this->portMode = $portMode;
        $this->portLabel = $portLabel;
        $this->userLabel = $userLabel;
        $this->speed = $speed;
        $this->highSpeed = $highSpeed;
        $this->ifType = $ifType;
        $this->physaddress = $physaddress;
        $this->pullable = $pullable;
        $this->primary = $primary;
        $this->vlan = $vlan;
        $this->opstate = $opstate;
        $this->adminstate = $adminstate;
        $this->type = $type;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'id') !== null ? (int) Arr::get($data, 'id') : null,
            Arr::get($data, 'name'),
            Arr::get($data, 'description'),
            Arr::get($data, 'item_id') !== null ? (int) Arr::get($data, 'item_id') : null,
            Arr::get($data, 'colocation_id') !== null ? (int) Arr::get($data, 'colocation_id') : null,
            Arr::get($data, 'connected_item') !== null ? (int) Arr::get($data, 'connected_item') : null,
            Arr::get($data, 'connected_port') !== null ? (int) Arr::get($data, 'connected_port') : null,
            Arr::get($data, 'port_number') !== null ? (int) Arr::get($data, 'port_number') : null,
            Arr::get($data, 'port_index') !== null ? (int) Arr::get($data, 'port_index') : null,
            Arr::get($data, 'port_mode'),
            Arr::get($data, 'port_label'),
            Arr::get($data, 'user_label'),
            Arr::get($data, 'speed'),
            Arr::get($data, 'high_speed'),
            Arr::get($data, 'if_type'),
            Arr::get($data, 'physaddress'),
            Arr::get($data, 'pullable') !== null ? (int) Arr::get($data, 'pullable') : null,
            Arr::get($data, 'primary') !== null ? (int) Arr::get($data, 'primary') : null,
            Arr::get($data, 'vlan') !== null ? (int) Arr::get($data, 'vlan') : null,
            Arr::get($data, 'opstate'),
            Arr::get($data, 'adminstate'),
            Arr::get($data, 'type'),
            Arr::get($data, 'created_at'),
            Arr::get($data, 'updated_at')
        );
    }
}
