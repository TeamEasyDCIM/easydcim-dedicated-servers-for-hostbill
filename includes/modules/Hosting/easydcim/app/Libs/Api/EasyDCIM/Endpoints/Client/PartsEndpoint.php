<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Client;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Parts\ListServicePartsRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Parts\ListServicePartsResponse;

/**
 * Client Parts endpoints
 */
class PartsEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/client/services';
    protected bool $isClientEndpoint = true;

    /**
     * List all parts for a specific service
     *
     * @param int|string $serviceId Service ID
     * @param ListServicePartsRequest|null $request
     * @return ListServicePartsResponse
     */
    public function listServiceParts($serviceId, ?ListServicePartsRequest $request = null): ListServicePartsResponse
    {
        $params = ($request === null ? null : $request->toArray()) ?? [];
        $response = $this->get($this->buildPath((string) $serviceId, 'parts'), $params);
        return ListServicePartsResponse::fromArray($response);
    }

    /**
     * Get ALL parts for a service (auto-paginate)
     *
     * @param int|string $serviceId Service ID
     * @param ListServicePartsRequest|null $request
     * @return array Array of all parts across all pages
     */
    public function listAllServiceParts($serviceId, ?ListServicePartsRequest $request = null): array
    {
        $allParts = [];
        $currentPage = 1;
        $request = $request ?? new ListServicePartsRequest();

        do {
            // Set the current page
            $request = new ListServicePartsRequest(
                $request->perPage ?? 100,
                $currentPage,
                $request->search
            );

            $response = $this->listServiceParts($serviceId, $request);
            $allParts = array_merge($allParts, $response->data);

            $currentPage++;
        } while ($currentPage <= $response->meta->lastPage);

        return $allParts;
    }
}
