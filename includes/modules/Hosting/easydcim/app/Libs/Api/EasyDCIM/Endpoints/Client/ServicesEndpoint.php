<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Client;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Bandwidth\GetBandwidthRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Power\GetPowerUsageRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Service\AssignMetadataRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Service\ListServicesRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Power\PowerActionRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\BaseResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Bandwidth\GetBandwidthResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Power\GetPowerUsageResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Service\ListServicesResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Power\PowerActionResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Service\ServiceData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Service\ShowServiceResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\EasyDCIMException;

/**
 * Client Services endpoints
 */
class ServicesEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/client/services';
    protected bool $isClientEndpoint = true;

    /**
     * List all services for the authenticated user
     *
     * @param ListServicesRequest|null $request
     * @return ListServicesResponse
     * @throws EasyDCIMException
     */
    public function list(?ListServicesRequest $request = null): ListServicesResponse
    {
        $params = ($request === null ? null : $request->toArray()) ?? [];
        $response = $this->get('', $params);
        return ListServicesResponse::fromArray($response);
    }

    /**
     * Get ALL services for the authenticated user (auto-paginate)
     *
     * @param ListServicesRequest|null $request
     * @return array<ServiceData> Array of all services across all pages
     * @throws EasyDCIMException
     */
    public function listAll(?ListServicesRequest $request = null): array
    {
        $allServices = [];
        $currentPage = 1;
        $request = $request ?? new ListServicesRequest();

        do {
            // Set the current page
            $request = new ListServicesRequest(
                $request->filter,
                $request->perPage ?? 100,
                $currentPage,
                $request->sortBy,
                $request->sortDir,
                $request->searchTerm,
                $request->searchOp,
                $request->searchFields
            );

            $response = $this->list($request);
            $allServices = array_merge($allServices, $response->data);

            $currentPage++;
        } while ($currentPage <= $response->meta->lastPage);

        return $allServices;
    }

    /**
     * Get a specific service
     *
     * @param int|string $id
     * @return ShowServiceResponse
     * @throws EasyDCIMException
     */
    public function show($id): ShowServiceResponse
    {
        $response = $this->get((string) $id);
        return ShowServiceResponse::fromArray($response);
    }

    /**
     * Get bandwidth usage for a service
     *
     * @param int|string $id
     * @param GetBandwidthRequest|null $request
     * @return GetBandwidthResponse
     * @throws EasyDCIMException
     */
    public function getBandwidth($id, ?GetBandwidthRequest $request = null): GetBandwidthResponse
    {
        $data = ($request === null ? null : $request->toArray()) ?? [];
        $response = $this->post($this->buildPath((string) $id, 'bandwidth'), $data);
        return GetBandwidthResponse::fromArray($response);
    }

    /**
     * Get power usage for a service
     *
     * @param int|string $id
     * @param GetPowerUsageRequest|null $request
     * @return GetPowerUsageResponse
     * @throws EasyDCIMException
     */
    public function getPowerUsage($id, ?GetPowerUsageRequest $request = null): GetPowerUsageResponse
    {
        $data = ($request === null ? null : $request->toArray()) ?? [];
        $response = $this->post($this->buildPath((string) $id, 'powerusage'), $data);
        return GetPowerUsageResponse::fromArray($response);
    }

    /**
     * Perform power action on a service
     *
     * @param int|string $id
     * @param PowerActionRequest $request
     * @return PowerActionResponse
     */
    public function powerAction($id, PowerActionRequest $request): PowerActionResponse
    {
        $data = $request->toArray();
        $response = $this->post($this->buildPath((string) $id, 'power/action'), $data);
        return PowerActionResponse::fromArray($response);
    }

    /**
     * Assign metadata to a service
     *
     * @param int|string $id Service ID
     * @param AssignMetadataRequest $request
     * @return BaseResponse
     * @throws EasyDCIMException
     */
    public function assignMetadata($id, AssignMetadataRequest $request): BaseResponse
    {
        $response = $this->post(
            $this->buildPath((string) $id, 'assign-metadata'),
            $request->toArray()
        );
        return BaseResponse::fromArray($response);
    }
}
