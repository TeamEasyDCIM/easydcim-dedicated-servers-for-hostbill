<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Graph;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Represents a single dataset in graph data
 */
class GraphDataset
{
    public ?array $data;
    public ?string $dataset_name;
    public function __construct(?array $data = [], ?string $dataset_name = null)
    {
        $this->data = $data;
        $this->dataset_name = $dataset_name;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'data', []),
            Arr::get($data, 'dataset_name') ?? Arr::get($data, 'datasetName')
        );
    }

    public function toArray(): array
    {
        return [
            'data' => $this->data,
            'dataset_name' => $this->dataset_name,
        ];
    }
}
