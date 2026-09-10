<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Group;

/**
 * Request for updating a group
 */
class UpdateGroupRequest
{
    public ?string $title;
    public ?array $permissions;
    /**
     * @param string|null $title Group title
     * @param array<int>|null $permissions Array of permission IDs
     */
    public function __construct(?string $title = null, ?array $permissions = null)
    {
        $this->title = $title;
        $this->permissions = $permissions;
    }

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
