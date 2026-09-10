<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Admin;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\EasyDCIMException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Field\CreateFieldRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Field\ListFieldsRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Field\UpdateFieldRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Field\FieldData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Field\ListFieldsResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Field\ShowFieldResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\SuccessResponse;

/**
 * Admin Fields endpoints
 *
 * Manage custom fields for item types
 */
class FieldsEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/admin/fields';

    /**
     * List all item type fields
     *
     * @param ListFieldsRequest|null $request
     * @return ListFieldsResponse
     * @throws EasyDCIMException
     */
    public function list(?ListFieldsRequest $request = null): ListFieldsResponse
    {
        $params = ($request === null ? null : $request->toArray()) ?? [];
        $response = $this->get('', $params);
        return ListFieldsResponse::fromArray($response);
    }

    /**
     * Get ALL fields (auto-paginate)
     *
     * @param ListFieldsRequest|null $request
     * @return array<FieldData> Array of all fields across all pages
     * @throws EasyDCIMException
     */
    public function listAll(?ListFieldsRequest $request = null): array
    {
        $allFields = [];
        $currentPage = 1;
        $request = $request ?? new ListFieldsRequest();

        do {
            // Set the current page
            $request = new ListFieldsRequest(
                $request->perPage ?? 100,
                $currentPage,
                $request->sortBy,
                $request->sortDir,
                $request->searchTerm,
                $request->searchOp,
                $request->searchFields
            );

            $response = $this->list($request);

            $allFields = array_merge($allFields, $response->data);

            $currentPage++;
        } while ($currentPage <= $response->meta->lastPage);

        return $allFields;
    }

    /**
     * Get a specific field by ID
     *
     * @param int|string $id Field ID
     * @return ShowFieldResponse
     * @throws EasyDCIMException
     */
    public function show($id): ShowFieldResponse
    {
        $response = $this->get((string) $id);
        return ShowFieldResponse::fromArray($response);
    }

    /**
     * Create a new field
     *
     * @param CreateFieldRequest $request
     * @return ShowFieldResponse
     * @throws EasyDCIMException
     */
    public function create(CreateFieldRequest $request): ShowFieldResponse
    {
        $response = $this->post('', $request->toArray());
        return ShowFieldResponse::fromArray($response);
    }

    /**
     * Update an existing field
     *
     * @param int|string $id Field ID
     * @param UpdateFieldRequest $request
     * @return ShowFieldResponse
     * @throws EasyDCIMException
     */
    public function update($id, UpdateFieldRequest $request): ShowFieldResponse
    {
        $response = $this->put((string) $id, $request->toArray());
        return ShowFieldResponse::fromArray($response);
    }

    /**
     * Delete a field
     *
     * @param int|string $id Field ID
     * @return SuccessResponse
     * @throws EasyDCIMException
     */
    public function destroy($id): SuccessResponse
    {
        $response = $this->delete((string) $id);
        return SuccessResponse::fromArray($response);
    }
}
