<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Admin;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\EasyDCIMException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\ItemModel\CreateItemModelRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\ItemModel\ListItemModelsRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\ItemModel\UpdateItemModelRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\ItemModel\ItemModelData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\ItemModel\ListItemModelsResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\ItemModel\ShowItemModelResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\SuccessResponse;

/**
 * Admin Item Models endpoints
 *
 * Manage device models and hardware templates
 */
class ItemModelsEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/admin/item-models';

    /**
     * List all item models
     *
     * @param ListItemModelsRequest|null $request
     * @return ListItemModelsResponse
     * @throws EasyDCIMException
     */
    public function list(?ListItemModelsRequest $request = null): ListItemModelsResponse
    {
        $params = $request?->toArray() ?? [];
        $response = $this->get('', $params);
        return ListItemModelsResponse::fromArray($response);
    }

    /**
     * Get ALL item models (auto-paginate)
     *
     * @param ListItemModelsRequest|null $request
     * @return array<ItemModelData> Array of all item models across all pages
     * @throws EasyDCIMException
     */
    public function listAll(?ListItemModelsRequest $request = null): array
    {
        $allItemModels = [];
        $currentPage = 1;
        $request = $request ?? new ListItemModelsRequest();

        do {
            // Set the current page
            $request = new ListItemModelsRequest(
                perPage: $request->perPage ?? 100,
                page: $currentPage,
                sortBy: $request->sortBy,
                sortDir: $request->sortDir,
                searchTerm: $request->searchTerm,
                searchOp: $request->searchOp,
                searchFields: $request->searchFields,
            );

            $response = $this->list($request);

            $allItemModels = array_merge($allItemModels, $response->data);

            $currentPage++;
        } while ($currentPage <= $response->meta->lastPage);

        return $allItemModels;
    }

    /**
     * Get a specific item model by ID
     *
     * @param int|string $id Item model ID
     * @return ShowItemModelResponse
     * @throws EasyDCIMException
     */
    public function show(int|string $id): ShowItemModelResponse
    {
        $response = $this->get((string) $id);
        return ShowItemModelResponse::fromArray($response);
    }

    /**
     * Create a new item model
     *
     * @param CreateItemModelRequest $request
     * @return ShowItemModelResponse
     * @throws EasyDCIMException
     */
    public function create(CreateItemModelRequest $request): ShowItemModelResponse
    {
        $response = $this->post('', $request->toArray());
        return ShowItemModelResponse::fromArray($response);
    }

    /**
     * Update an existing item model
     *
     * @param int|string $id Item model ID
     * @param UpdateItemModelRequest $request
     * @return ShowItemModelResponse
     * @throws EasyDCIMException
     */
    public function update(int|string $id, UpdateItemModelRequest $request): ShowItemModelResponse
    {
        $response = $this->put((string) $id, $request->toArray());
        return ShowItemModelResponse::fromArray($response);
    }

    /**
     * Delete an item model
     *
     * @param int|string $id Item model ID
     * @return SuccessResponse
     * @throws EasyDCIMException
     */
    public function destroy(int|string $id): SuccessResponse
    {
        $response = $this->delete((string) $id);
        return SuccessResponse::fromArray($response);
    }
}
