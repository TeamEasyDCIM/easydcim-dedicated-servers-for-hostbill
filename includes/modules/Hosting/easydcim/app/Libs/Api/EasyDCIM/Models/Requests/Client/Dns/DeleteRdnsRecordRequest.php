<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Dns;

class DeleteRdnsRecordRequest
{
    public int $recordId;
    public function __construct(int $recordId)
    {
        $this->recordId = $recordId;
    }

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
            $data['recordId'] ?? $data['record_id'] ?? 0
        );
    }
}
