<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Admin;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\EasyDCIMException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Location\CreateLocationRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Location\ListLocationsRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Location\UpdateLocationRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Location\ListLocationsResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Location\LocationData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Location\ShowLocationResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\SuccessResponse;

/**
 * Admin Locations endpoints
 */
class LocationsEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/admin/locations';

    /**
     * List all locations
     *
     * @param ListLocationsRequest|null $request
     * @return ListLocationsResponse
     * @throws EasyDCIMException
     */
    public function list(?ListLocationsRequest $request = null): ListLocationsResponse
    {
        $params = ($request === null ? null : $request->toArray()) ?? [];
        $response = $this->get('', $params);
        return ListLocationsResponse::fromArray($response);
    }

    /**
     * Get ALL locations (auto-paginate)
     *
     * @param ListLocationsRequest|null $request
     * @return array<LocationData> Array of all locations across all pages
     * @throws EasyDCIMException
     */
    public function listAll(?ListLocationsRequest $request = null): array
    {
        $allLocations = [];
        $currentPage = 1;
        $request = $request ?? new ListLocationsRequest();

        do {
            // Set the current page
            $request = new ListLocationsRequest(
                $request->perPage ?? 100,
                $currentPage,
                $request->search
            );

            $response = $this->list($request);

            $allLocations = array_merge($allLocations, $response->data);

            $currentPage++;
        } while ($currentPage <= $response->meta->lastPage);

        return $allLocations;
    }

    /**
     * Get a specific location by ID
     *
     * @param int|string $id Location ID
     * @return ShowLocationResponse
     * @throws EasyDCIMException
     */
    public function show($id): ShowLocationResponse
    {
        $response = $this->get((string) $id);
        return ShowLocationResponse::fromArray($response);
    }

    /**
     * Create a new location
     *
     * @param CreateLocationRequest $request
     * @return ShowLocationResponse
     * @throws EasyDCIMException
     */
    public function create(CreateLocationRequest $request): ShowLocationResponse
    {
        $response = $this->post('', $request->toArray());
        return ShowLocationResponse::fromArray($response);
    }

    /**
     * Update an existing location
     *
     * @param int|string $id Location ID
     * @param UpdateLocationRequest $request
     * @return ShowLocationResponse
     * @throws EasyDCIMException
     */
    public function update($id, UpdateLocationRequest $request): ShowLocationResponse
    {
        $response = $this->put((string) $id, $request->toArray());
        return ShowLocationResponse::fromArray($response);
    }

    /**
     * Delete a location
     *
     * @param int|string $id Location ID
     * @return SuccessResponse
     * @throws EasyDCIMException
     */
    public function destroy($id): SuccessResponse
    {
        $response = $this->delete((string) $id);
        return SuccessResponse::fromArray($response);
    }
}
