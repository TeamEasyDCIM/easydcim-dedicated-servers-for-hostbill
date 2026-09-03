<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Service;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class AccessLevelPermissions
{
    /**
     * @param array<string> $baseFeatures
     * @param array<string> $metadata
     * @param array<string> $graphs
     * @param array<string> $serverActions
     */
    public function __construct(
        public ?array $baseFeatures,
        public ?array $metadata,
        public ?array $graphs,
        public ?array $serverActions,
    ) {}

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            baseFeatures: Arr::get($data, 'base_features', []),
            metadata: Arr::get($data, 'metadata', []),
            graphs: Arr::get($data, 'graphs', []),
            serverActions: Arr::get($data, 'server_actions', []),
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
