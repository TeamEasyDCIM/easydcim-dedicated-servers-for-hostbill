<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Group;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Group data structure
 */
class GroupData
{
    public function __construct(
        public ?int $id,
        public ?string $title,
        public ?array $permissions = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: Arr::get($data, 'id', 0),
            title: Arr::get($data, 'title', ''),
            permissions: Arr::get($data, 'permissions'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = [
            'id' => $this->id,
            'title' => $this->title,
        ];

        if ($this->permissions !== null) {
            $result['permissions'] = $this->permissions;
        }

        return $result;
    }
}
