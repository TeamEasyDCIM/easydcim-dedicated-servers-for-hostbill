<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Group;

/**
 * Request for creating a group
 */
class CreateGroupRequest
{
    public string $title;
    public array $permissions;
    /**
     * @param string $title Group title
     * @param array<int> $permissions Array of permission IDs
     */
    public function __construct(string $title, array $permissions = [])
    {
        $this->title = $title;
        $this->permissions = $permissions;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'permissions' => $this->permissions,
        ];
    }
}
