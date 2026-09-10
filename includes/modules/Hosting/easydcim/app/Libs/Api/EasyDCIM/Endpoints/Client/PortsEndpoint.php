<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Client;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Ports\ListServicePortsRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Ports\ListServicePortsResponse;

/**
 * Client Ports endpoints
 */
class PortsEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/client/services';
    protected bool $isClientEndpoint = true;

    /**
     * List all network ports for a specific service
     *
     * @param int|string $serviceId Service ID
     * @param ListServicePortsRequest|null $request
     * @return ListServicePortsResponse
     */
    public function listServicePorts($serviceId, ?ListServicePortsRequest $request = null): ListServicePortsResponse
    {
        $params = ($request === null ? null : $request->toArray()) ?? [];
        $response = $this->get($this->buildPath((string) $serviceId, 'ports'), $params);
        return ListServicePortsResponse::fromArray($response);
    }

    /**
     * Get ALL network ports for a service (auto-paginate)
     *
     * @param int|string $serviceId Service ID
     * @param ListServicePortsRequest|null $request
     * @return array Array of all ports across all pages
     */
    public function listAllServicePorts($serviceId, ?ListServicePortsRequest $request = null): array
    {
        $allPorts = [];
        $currentPage = 1;
        $request = $request ?? new ListServicePortsRequest();

        do {
            // Set the current page
            $request = new ListServicePortsRequest(
                $request->withTraffic,
                $request->perPage ?? 100,
                $currentPage,
                $request->search
            );

            $response = $this->listServicePorts($serviceId, $request);
            $allPorts = array_merge($allPorts, $response->data);

            $currentPage++;
        } while ($currentPage <= $response->meta->lastPage);

        return $allPorts;
    }
}
