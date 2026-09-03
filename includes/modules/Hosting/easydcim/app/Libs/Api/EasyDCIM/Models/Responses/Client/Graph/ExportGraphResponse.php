<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Graph;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Response model for graph export endpoint
 */
class ExportGraphResponse
{
    public function __construct(
        public ?bool $success = false,
        public ?GraphData $data = null,
    ) {}

    public static function fromArray(array $response): self
    {
        $data = null;
        $responseData = Arr::get($response, 'data');

        if (is_array($responseData)) {
            $data = GraphData::fromArray($responseData);
        }

        return new self(
            success: Arr::get($response, 'success', false),
            data: $data,
        );
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'data' => $this->data?->toArray(),
        ];
    }
}
