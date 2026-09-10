<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Graph;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class ExportGraphRequest
{
    public ?string $type;
    public ?string $target;
    public ?string $start;
    public ?string $end;
    public ?DeviceSelectionEnum $deviceSelection;
    public ?bool $raw;
    public ?string $mode;
    public function __construct(?string              $type            = null, ?string              $target          = null, ?string              $start           = null, ?string              $end             = null, ?DeviceSelectionEnum $deviceSelection = null, ?bool                $raw             = null, ?string              $mode            = null)
    {
        $this->type = $type;
        $this->target = $target;
        $this->start = $start;
        $this->end = $end;
        $this->deviceSelection = $deviceSelection;
        $this->raw = $raw;
        $this->mode = $mode;
    }

    public function toArray(): array
    {
        return array_filter([
            'type'             => $this->type,
            'target'           => $this->target,
            'start'            => $this->start,
            'end'              => $this->end,
            'device_selection' => $this->deviceSelection === null ? null : $this->deviceSelection->value,
            'raw'              => $this->raw,
            'mode'             => $this->mode,
        ], fn($value) => $value !== null);
    }

    public static function fromArray(array $data): self
    {
        $deviceSelection = Arr::get($data, 'device_selection');

        return new self(
            Arr::get($data, 'type'),
            Arr::get($data, 'target'),
            Arr::get($data, 'start'),
            Arr::get($data, 'end'),
            $deviceSelection ? DeviceSelectionEnum::from($deviceSelection) : null,
            Arr::get($data, 'raw'),
            Arr::get($data, 'mode')
        );
    }
}
