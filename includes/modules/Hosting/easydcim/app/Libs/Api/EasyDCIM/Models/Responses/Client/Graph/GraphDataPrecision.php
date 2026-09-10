<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Graph;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class GraphDataPrecision
{
    public ?int $traffic;
    public ?int $ping;
    public ?int $powerUsage;
    public function __construct(?int $traffic, ?int $ping, ?int $powerUsage)
    {
        $this->traffic = $traffic;
        $this->ping = $ping;
        $this->powerUsage = $powerUsage;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'traffic'),
            Arr::get($data, 'ping'),
            Arr::get($data, 'power_usage')
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
