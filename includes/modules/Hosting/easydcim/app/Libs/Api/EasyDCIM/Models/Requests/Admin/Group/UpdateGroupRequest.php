<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Group;

/**
 * Request for updating a group
 */
class UpdateGroupRequest
{
    /**
     * @param string|null $title Group title
     * @param array<int>|null $permissions Array of permission IDs
     */
    public function __construct(
        public ?string $title = null,
        public ?array $permissions = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter([
            'title' => $this->title,
            'permissions' => $this->permissions,
        ], fn($value) => $value !== null);
    }
}
