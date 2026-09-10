<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Service;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

class ServiceData
{
    public ?int $id;
    public ?int $relatedId;
    public ?ServiceRelated $related;
    public ?string $type;
    public ?string $status;
    public ?string $createdAt;
    public ?ServiceAccessLevel $accessLevel;
    public function __construct(?int $id, ?int $relatedId, ?ServiceRelated $related, ?string $type, ?string $status, ?string $createdAt, ?ServiceAccessLevel $accessLevel = null)
    {
        $this->id = $id;
        $this->relatedId = $relatedId;
        $this->related = $related;
        $this->type = $type;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->accessLevel = $accessLevel;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $accessLevelData = Arr::get($data, 'access_level');
        $relatedData = Arr::get($data, 'related', []);

        return new self(
            Arr::get($data, 'id', 0),
            Arr::get($data, 'related_id', 0),
            ServiceRelated::fromArray($relatedData),
            Arr::get($data, 'type', ''),
            Arr::get($data, 'status', ''),
            Arr::get($data, 'created_at', ''),
            $accessLevelData ? ServiceAccessLevel::fromArray($accessLevelData) : null
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
            'access_level' => $this->accessLevel === null ? null : $this->accessLevel->toArray(),
        ];
    }
}
