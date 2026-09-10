<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Device;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Position data structure for device placement in rack
 *
 * Represents device position with units array and outside rack flag.
 */
class PositionData
{
    public ?array $units;
    public ?bool $outsideRack;
    /**
     * @param array<UnitData> $units Array of unit positions
     * @param bool $outsideRack Whether device is positioned outside the rack
     */
    public function __construct(?array $units, ?bool $outsideRack)
    {
        $this->units = $units;
        $this->outsideRack = $outsideRack;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $units = [];
        foreach (Arr::get($data, 'units', []) as $unitData) {
            if (is_array($unitData)) {
                $units[] = UnitData::fromArray($unitData);
            }
        }

        return new self(
            $units,
            Arr::get($data, 'outsideRack', false)
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'units' => array_map(fn($unit) => $unit->toArray(), $this->units),
            'outsideRack' => $this->outsideRack,
        ];
    }
}
