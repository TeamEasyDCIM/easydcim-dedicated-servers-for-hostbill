<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Graph;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Graph data containing datasets, labels, and units
 */
class GraphData
{
    /**
     * @param GraphDataset[] $datasets
     * @param string[] $labels
     * @param GraphDataUnits|array $units
     * @param GraphDataPrecision|array $precision
     */
    public function __construct(
        public ?array $datasets = [],
        public ?array $labels = [],
        public null|GraphDataUnits|array $units = [],
        public null|GraphDataPrecision|array $precision = [],
    ) {}

    public static function fromArray(array $data): self
    {
        $datasets = [];
        $datasetsData = Arr::get($data, 'datasets', []);

        if (is_array($datasetsData)) {
            foreach ($datasetsData as $dataset) {
                $datasets[] = GraphDataset::fromArray($dataset);
            }
        }

        return new self(
            datasets:  $datasets,
            labels:    Arr::get($data, 'labels', []),
            units:     GraphDataUnits::fromArray(Arr::get($data, 'units', [])),
            precision: GraphDataPrecision::fromArray(Arr::get($data, 'precision', [])),
        );
    }

    public function toArray(): array
    {
        return [
            'datasets'  => array_map(fn($dataset) => $dataset->toArray(), $this->datasets),
            'labels'    => $this->labels,
            'units'     => $this->units->toArray(),
            'precision' => $this->precision->toArray(),
        ];
    }
}
