<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Client;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Power\ListServicePowerPortsRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Power\PerformPortActionRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Power\ListServicePowerPortsResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Power\PerformPortActionResponse;

/**
 * Client Power Ports endpoints
 */
class PowerPortsEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/client/services';
    protected bool $isClientEndpoint = true;

    /**
     * List all power ports for a specific service
     *
     * @param int|string $serviceId Service ID
     * @param ListServicePowerPortsRequest|null $request
     * @return ListServicePowerPortsResponse
     */
    public function listServicePowerPorts(int|string $serviceId, ?ListServicePowerPortsRequest $request = null): ListServicePowerPortsResponse
    {
        $params = $request?->toArray() ?? [];
        $response = $this->get($this->buildPath((string) $serviceId, 'power-ports'), $params);
        return ListServicePowerPortsResponse::fromArray($response);
    }

    /**
     * Get ALL power ports for a service (auto-paginate)
     *
     * @param int|string $serviceId Service ID
     * @param ListServicePowerPortsRequest|null $request
     * @return array Array of all power ports across all pages
     */
    public function listAllServicePowerPorts(int|string $serviceId, ?ListServicePowerPortsRequest $request = null): array
    {
        $allPowerPorts = [];
        $currentPage = 1;
        $request = $request ?? new ListServicePowerPortsRequest();

        do {
            // Set the current page
            $request = new ListServicePowerPortsRequest(
                perPage: $request->perPage ?? 100,
                page: $currentPage,
                search: $request->search,
            );

            $response = $this->listServicePowerPorts($serviceId, $request);
            $allPowerPorts = array_merge($allPowerPorts, $response->data);

            $currentPage++;
        } while ($currentPage <= $response->meta->lastPage);

        return $allPowerPorts;
    }

    /**
     * Perform an action on a specific power port
     *
     * @param int|string $serviceId Service ID
     * @param PerformPortActionRequest $request
     * @return PerformPortActionResponse
     */
    public function performPortAction(int|string $serviceId, PerformPortActionRequest $request): PerformPortActionResponse
    {
        $response = $this->post(
            $this->buildPath((string) $serviceId, 'power-ports/action'),
            $request->toArray()
        );
        return PerformPortActionResponse::fromArray($response);
    }
}
