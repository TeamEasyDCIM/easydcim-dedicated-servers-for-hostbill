<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Graph;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class ExportGraphRequest
{
    public function __construct(
        public ?string              $type            = null,
        public ?string              $target          = null,
        public ?string              $start           = null,
        public ?string              $end             = null,
        public ?DeviceSelectionEnum $deviceSelection = null,
        public ?bool                $raw             = null,
        public ?string              $mode            = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'type'             => $this->type,
            'target'           => $this->target,
            'start'            => $this->start,
            'end'              => $this->end,
            'device_selection' => $this->deviceSelection?->value,
            'raw'              => $this->raw,
            'mode'             => $this->mode,
        ], fn($value) => $value !== null);
    }

    public static function fromArray(array $data): self
    {
        $deviceSelection = Arr::get($data, 'device_selection');

        return new self(
            type:            Arr::get($data, 'type'),
            target:          Arr::get($data, 'target'),
            start:           Arr::get($data, 'start'),
            end:             Arr::get($data, 'end'),
            deviceSelection: $deviceSelection ? DeviceSelectionEnum::from($deviceSelection) : null,
            raw:             Arr::get($data, 'raw'),
            mode:            Arr::get($data, 'mode'),
        );
    }
}
