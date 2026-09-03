<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Device;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Unit data structure for device position
 *
 * Represents a single unit in a rack position with index and side information.
 */
class UnitData
{
    public function __construct(
        public ?int $unitIndex,
        public ?string $side,
    ) {}

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            unitIndex: Arr::get($data, 'unitIndex', 0),
            side: Arr::get($data, 'side', ''),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'unitIndex' => $this->unitIndex,
            'side' => $this->side,
        ];
    }
}
