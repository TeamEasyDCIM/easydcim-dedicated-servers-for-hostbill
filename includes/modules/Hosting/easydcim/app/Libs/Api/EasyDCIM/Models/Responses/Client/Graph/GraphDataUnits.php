<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Graph;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Graph data containing datasets, labels, and units
 */
class GraphDataUnits
{
    public ?string $traffic;
    public ?string $ping;
    public ?string $powerUsage;
    public function __construct(?string $traffic, ?string $ping, ?string $powerUsage)
    {
        $this->traffic = $traffic;
        $this->ping = $ping;
        $this->powerUsage = $powerUsage;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'traffic', 'Mbps'),
            Arr::get($data, 'ping', 'ms'),
            Arr::get($data, 'power_usage', 'Amps')
        );
    }

    public function toArray(): array
    {
        return [
            'traffic'     => $this->traffic,
            'ping'        => $this->ping,
            'power_usage' => $this->powerUsage,
        ];
    }
}
