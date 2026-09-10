<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Graph;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Response model for graph export endpoint
 */
class ExportGraphResponse
{
    public ?bool $success;
    public ?GraphData $data;
    public function __construct(?bool $success = false, ?GraphData $data = null)
    {
        $this->success = $success;
        $this->data = $data;
    }

    public static function fromArray(array $response): self
    {
        $data = null;
        $responseData = Arr::get($response, 'data');

        if (is_array($responseData)) {
            $data = GraphData::fromArray($responseData);
        }

        return new self(
            Arr::get($response, 'success', false),
            $data
        );
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'data' => $this->data === null ? null : $this->data->toArray(),
        ];
    }
}
