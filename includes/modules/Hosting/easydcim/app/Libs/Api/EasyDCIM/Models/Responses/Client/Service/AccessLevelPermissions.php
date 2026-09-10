<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Service;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class AccessLevelPermissions
{
    public ?array $baseFeatures;
    public ?array $metadata;
    public ?array $graphs;
    public ?array $serverActions;
    /**
     * @param array<string> $baseFeatures
     * @param array<string> $metadata
     * @param array<string> $graphs
     * @param array<string> $serverActions
     */
    public function __construct(?array $baseFeatures, ?array $metadata, ?array $graphs, ?array $serverActions)
    {
        $this->baseFeatures = $baseFeatures;
        $this->metadata = $metadata;
        $this->graphs = $graphs;
        $this->serverActions = $serverActions;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'base_features', []),
            Arr::get($data, 'metadata', []),
            Arr::get($data, 'graphs', []),
            Arr::get($data, 'server_actions', [])
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'base_features' => $this->baseFeatures,
            'metadata' => $this->metadata,
            'graphs' => $this->graphs,
            'server_actions' => $this->serverActions,
        ];
    }
}
