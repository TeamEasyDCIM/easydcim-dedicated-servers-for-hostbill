<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Dns;

class DeleteRdnsRecordRequest
{
    public function __construct(
        public int $recordId,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'recordId' => $this->recordId,
        ];
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            recordId: $data['recordId'] ?? $data['record_id'] ?? 0,
        );
    }
}
