<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Graph;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class GraphDataPrecision
{
    public function __construct(
        public ?int $traffic,
        public ?int $ping,
        public ?int $powerUsage,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            traffic:    Arr::get($data, 'traffic'),
            ping:       Arr::get($data, 'ping'),
            powerUsage: Arr::get($data, 'power_usage'),
        );
    }

    public function toArray(): array
    {
        return [
            'traffic'    => $this->traffic,
            'ping'       => $this->ping,
            'power_usage' => $this->powerUsage,
        ];
    }
}
