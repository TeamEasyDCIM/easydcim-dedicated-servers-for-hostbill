<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Group;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Group data structure
 */
class GroupData
{
    public ?int $id;
    public ?string $title;
    public ?array $permissions;
    public function __construct(?int $id, ?string $title, ?array $permissions = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->permissions = $permissions;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'id', 0),
            Arr::get($data, 'title', ''),
            Arr::get($data, 'permissions')
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
