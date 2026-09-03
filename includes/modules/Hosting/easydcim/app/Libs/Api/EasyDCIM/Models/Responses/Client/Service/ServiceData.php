<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Service;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class ServiceData
{
    public function __construct(
        public ?int $id,
        public ?int $relatedId,
        public ?ServiceRelated $related,
        public ?string $type,
        public ?string $status,
        public ?string $createdAt,
        public ?ServiceAccessLevel $accessLevel = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $accessLevelData = Arr::get($data, 'access_level');
        $relatedData = Arr::get($data, 'related', []);

        return new self(
            id: Arr::get($data, 'id', 0),
            relatedId: Arr::get($data, 'related_id', 0),
            related: ServiceRelated::fromArray($relatedData),
            type: Arr::get($data, 'type', ''),
            status: Arr::get($data, 'status', ''),
            createdAt: Arr::get($data, 'created_at', ''),
            accessLevel: $accessLevelData ? ServiceAccessLevel::fromArray($accessLevelData) : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'related_id' => $this->relatedId,
            'related' => $this->related->toArray(),
            'type' => $this->type,
            'status' => $this->status,
            'created_at' => $this->createdAt,
            'access_level' => $this->accessLevel?->toArray(),
        ];
    }
}
