<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Admin;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\EasyDCIMException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\ItemType\CreateItemTypeRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\ItemType\ListItemTypesRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\ItemType\UpdateItemTypeRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\ItemType\ItemTypeData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\ItemType\ListItemTypesResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\ItemType\ShowItemTypeResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\SuccessResponse;

/**
 * Admin Item Types endpoints
 *
 * Manage device types and categories
 */
class ItemTypesEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/admin/types';

    /**
     * List all item types
     *
     * @param ListItemTypesRequest|null $request
     * @return ListItemTypesResponse
     * @throws EasyDCIMException
     */
    public function list(?ListItemTypesRequest $request = null): ListItemTypesResponse
    {
        $params = $request?->toArray() ?? [];
        $response = $this->get('', $params);
        return ListItemTypesResponse::fromArray($response);
    }

    /**
     * Get ALL item types (auto-paginate)
     *
     * @param ListItemTypesRequest|null $request
     * @return array<ItemTypeData> Array of all item types across all pages
     * @throws EasyDCIMException
     */
    public function listAll(?ListItemTypesRequest $request = null): array
    {
        $allItemTypes = [];
        $currentPage = 1;
        $request = $request ?? new ListItemTypesRequest();

        do {
            // Set the current page
            $request = new ListItemTypesRequest(
                perPage: $request->perPage ?? 100,
                page: $currentPage,
                sortBy: $request->sortBy,
                sortDir: $request->sortDir,
                searchTerm: $request->searchTerm,
                searchOp: $request->searchOp,
                searchFields: $request->searchFields,
            );

            $response = $this->list($request);

            $allItemTypes = array_merge($allItemTypes, $response->data);

            $currentPage++;
        } while ($currentPage <= $response->meta->lastPage);

        return $allItemTypes;
    }

    /**
     * Get a specific item type by ID
     *
     * @param int|string $id Item type ID
     * @return ShowItemTypeResponse
     * @throws EasyDCIMException
     */
    public function show(int|string $id): ShowItemTypeResponse
    {
        $response = $this->get((string) $id);
        return ShowItemTypeResponse::fromArray($response);
    }

    /**
     * Create a new item type
     *
     * @param CreateItemTypeRequest $request
     * @return ShowItemTypeResponse
     * @throws EasyDCIMException
     */
    public function create(CreateItemTypeRequest $request): ShowItemTypeResponse
    {
        $response = $this->post('', $request->toArray());
        return ShowItemTypeResponse::fromArray($response);
    }

    /**
     * Update an existing item type
     *
     * @param int|string $id Item type ID
     * @param UpdateItemTypeRequest $request
     * @return ShowItemTypeResponse
     * @throws EasyDCIMException
     */
    public function update(int|string $id, UpdateItemTypeRequest $request): ShowItemTypeResponse
    {
        $response = $this->put((string) $id, $request->toArray());
        return ShowItemTypeResponse::fromArray($response);
    }

    /**
     * Delete an item type
     *
     * @param int|string $id Item type ID
     * @return SuccessResponse
     * @throws EasyDCIMException
     */
    public function destroy(int|string $id): SuccessResponse
    {
        $response = $this->delete((string) $id);
        return SuccessResponse::fromArray($response);
    }
}
