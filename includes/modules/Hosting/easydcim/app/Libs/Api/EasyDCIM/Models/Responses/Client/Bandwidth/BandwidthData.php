<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Bandwidth;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class BandwidthData
{
    public ?array $raw;
    public ?string $bwTotal;
    public ?string $bwIn;
    public ?string $bwOut;
    public ?string $perc95th;
    public ?string $perc95thIn;
    public ?string $perc95thOut;
    /**
     * @param array<string, array{rrd: string, bytes: int}> $raw
     */
    public function __construct(?array $raw, ?string $bwTotal, ?string $bwIn, ?string $bwOut, ?string $perc95th, ?string $perc95thIn, ?string $perc95thOut)
    {
        $this->raw = $raw;
        $this->bwTotal = $bwTotal;
        $this->bwIn = $bwIn;
        $this->bwOut = $bwOut;
        $this->perc95th = $perc95th;
        $this->perc95thIn = $perc95thIn;
        $this->perc95thOut = $perc95thOut;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'raw', []),
            Arr::get($data, 'BW_TOTAL', '0'),
            Arr::get($data, 'BW_IN', '0'),
            Arr::get($data, 'BW_OUT', '0'),
            Arr::get($data, '95TH_PERC', '0'),
            Arr::get($data, '95TH_PERC_IN', '0'),
            Arr::get($data, '95TH_PERC_OUT', '0')
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'raw' => $this->raw,
            'BW_TOTAL' => $this->bwTotal,
            'BW_IN' => $this->bwIn,
            'BW_OUT' => $this->bwOut,
            '95TH_PERC' => $this->perc95th,
            '95TH_PERC_IN' => $this->perc95thIn,
            '95TH_PERC_OUT' => $this->perc95thOut,
        ];
    }
}
