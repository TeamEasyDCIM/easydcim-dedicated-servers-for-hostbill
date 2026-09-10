<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Dns;

class UpdateRdnsRecordRequest
{
    public string $rdata;
    public int $ttl;
    public function __construct(string $rdata, int $ttl = 3600)
    {
        $this->rdata = $rdata;
        $this->ttl = $ttl;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'rdata' => $this->rdata,
            'ttl' => $this->ttl,
        ];
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['rdata'],
            $data['ttl'] ?? 3600
        );
    }
}
