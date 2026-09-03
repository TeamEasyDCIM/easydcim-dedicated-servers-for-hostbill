<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Admin;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\EasyDCIMException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Group\ListPermissionsResponse;

/**
 * Admin Permissions endpoints
 *
 * Manage system permissions
 */
class PermissionsEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/admin/permissions';

    /**
     * List all available permissions
     *
     * @return ListPermissionsResponse
     * @throws EasyDCIMException
     */
    public function list(): ListPermissionsResponse
    {
        $response = $this->get('');
        return ListPermissionsResponse::fromArray($response);
    }

    /**
     * Get ALL permissions (alias for list since there's no pagination)
     *
     * @return array Array of all permissions
     * @throws EasyDCIMException
     */
    public function listAll(): array
    {
        $response = $this->list();
        return $response->data;
    }
}
