<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Admin;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\EasyDCIMException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Rack\CreateRackRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Rack\ListRacksRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Rack\UpdateRackRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\SuccessResponse;

/**
 * Admin Racks endpoints
 *
 * Manage server racks
 */
class RacksEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/admin/racks';

    /**
     * List all racks
     *
     * @param ListRacksRequest|null $request
     * @return array
     * @throws EasyDCIMException
     */
    public function list(?ListRacksRequest $request = null): array
    {
        $params = $request?->toArray() ?? [];
        return $this->get('', $params);
    }

    /**
     * Get ALL racks (auto-paginate)
     *
     * @param ListRacksRequest|null $request
     * @return array Array of all racks across all pages
     * @throws EasyDCIMException
     */
    public function listAll(?ListRacksRequest $request = null): array
    {
        $allRacks = [];
        $currentPage = 1;
        $request = $request ?? new ListRacksRequest();

        do {
            // Set the current page
            $request = new ListRacksRequest(
                perPage: $request->perPage ?? 100,
                page: $currentPage,
                sortBy: $request->sortBy,
                sortDir: $request->sortDir,
                searchTerm: $request->searchTerm,
                searchOp: $request->searchOp,
                searchFields: $request->searchFields
            );

            $response = $this->list($request);

            if (isset($response['data']) && is_array($response['data'])) {
                $allRacks = array_merge($allRacks, $response['data']);
            }

            $currentPage++;
            $lastPage = $response['meta']['last_page'] ?? 1;
        } while ($currentPage <= $lastPage);

        return $allRacks;
    }

    /**
     * Get a specific rack
     *
     * @param int|string $id Rack ID
     * @return array
     * @throws EasyDCIMException
     */
    public function show(int|string $id): array
    {
        return $this->get((string) $id);
    }

    /**
     * Create a new rack
     *
     * @param CreateRackRequest $request
     * @return array
     * @throws EasyDCIMException
     */
    public function create(CreateRackRequest $request): array
    {
        return $this->post('', $request->toArray());
    }

    /**
     * Update a rack
     *
     * @param int|string $id Rack ID
     * @param UpdateRackRequest $request
     * @return array
     * @throws EasyDCIMException
     */
    public function update(int|string $id, UpdateRackRequest $request): array
    {
        return $this->put((string) $id, $request->toArray());
    }

    /**
     * Delete a rack
     *
     * @param int|string $id Rack ID
     * @return SuccessResponse
     * @throws EasyDCIMException
     */
    public function destroy(int|string $id): SuccessResponse
    {
        $response = parent::delete((string) $id);
        return SuccessResponse::fromArray($response);
    }
}
