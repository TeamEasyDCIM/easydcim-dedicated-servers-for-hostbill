<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Dns;

class UpdateRdnsRecordRequest
{
    public function __construct(
        public string $rdata,
        public int $ttl = 3600,
    ) {}

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
            rdata: $data['rdata'],
            ttl: $data['ttl'] ?? 3600,
        );
    }
}
