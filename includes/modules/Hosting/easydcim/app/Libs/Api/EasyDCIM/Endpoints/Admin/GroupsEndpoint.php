<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Admin;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\EasyDCIMException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Group\CreateGroupRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Group\ListGroupsRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Group\UpdateGroupRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Group\ListGroupsResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Group\ShowGroupResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\SuccessResponse;

/**
 * Admin Groups endpoints
 *
 * Manage user groups and permissions
 */
class GroupsEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/admin/groups';

    /**
     * List all groups
     *
     * @param ListGroupsRequest|null $request
     * @return ListGroupsResponse
     * @throws EasyDCIMException
     */
    public function list(?ListGroupsRequest $request = null): ListGroupsResponse
    {
        $params = ($request === null ? null : $request->toArray()) ?? [];
        $response = $this->get('', $params);
        return ListGroupsResponse::fromArray($response);
    }

    /**
     * Get ALL groups (auto-paginate)
     *
     * @param ListGroupsRequest|null $request
     * @return array Array of all groups across all pages
     * @throws EasyDCIMException
     */
    public function listAll(?ListGroupsRequest $request = null): array
    {
        $allGroups = [];
        $currentPage = 1;
        $request = $request ?? new ListGroupsRequest();

        do {
            // Set the current page
            $request = new ListGroupsRequest(
                $request->perPage ?? 100,
                $currentPage,
                $request->sortBy,
                $request->sortDir,
                $request->searchTerm,
                $request->searchOp,
                $request->searchFields
            );

            $response = $this->list($request);

            $allGroups = array_merge($allGroups, $response->data);

            $currentPage++;
        } while ($currentPage <= $response->meta->lastPage);

        return $allGroups;
    }

    /**
     * Get a specific group by ID
     *
     * @param int|string $id Group ID
     * @return ShowGroupResponse
     * @throws EasyDCIMException
     */
    public function show($id): ShowGroupResponse
    {
        $response = $this->get((string) $id);
        return ShowGroupResponse::fromArray($response);
    }

    /**
     * Create a new group
     *
     * @param CreateGroupRequest $request
     * @return ShowGroupResponse
     * @throws EasyDCIMException
     */
    public function create(CreateGroupRequest $request): ShowGroupResponse
    {
        $response = $this->post('', $request->toArray());
        return ShowGroupResponse::fromArray($response);
    }

    /**
     * Update an existing group
     *
     * @param int|string $id Group ID
     * @param UpdateGroupRequest $request
     * @return ShowGroupResponse
     * @throws EasyDCIMException
     */
    public function update($id, UpdateGroupRequest $request): ShowGroupResponse
    {
        $response = $this->put((string) $id, $request->toArray());
        return ShowGroupResponse::fromArray($response);
    }

    /**
     * Delete a group
     *
     * @param int|string $id Group ID
     * @return SuccessResponse
     * @throws EasyDCIMException
     */
    public function destroy($id): SuccessResponse
    {
        $response = $this->delete((string) $id);
        return SuccessResponse::fromArray($response);
    }
}
