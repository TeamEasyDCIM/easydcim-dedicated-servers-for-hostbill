<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Client;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\IpAddress\ListIpAddressesRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\IpAddress\UpdateIpDescriptionRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\BaseResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\IpAddress\IpAddressData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\IpAddress\ListIpAddressesResponse;

/**
 * Client IP Address Management endpoints
 */
class IpAddressManagementEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/client/services';
    protected bool $isClientEndpoint = true;

    /**
     * List IP addresses for a service
     *
     * @param int|string $serviceId
     * @param ListIpAddressesRequest|null $request
     * @return ListIpAddressesResponse
     */
    public function listIpAddresses(int|string $serviceId, ?ListIpAddressesRequest $request = null): ListIpAddressesResponse
    {
        $params = $request?->toArray() ?? [];
        $response = $this->get($this->buildPath((string) $serviceId, 'ipaddresses'), $params);
        return ListIpAddressesResponse::fromArray($response);
    }

    /**
     * Get ALL IP addresses for a service (auto-paginate)
     *
     * @param int|string $serviceId
     * @param ListIpAddressesRequest|null $request
     * @return array<IpAddressData> Array of all IP addresses across all pages
     */
    public function listAllIpAddresses(int|string $serviceId, ?ListIpAddressesRequest $request = null): array
    {
        $allAddresses = [];
        $currentPage = 1;
        $request = $request ?? new ListIpAddressesRequest();

        do {
            // Set the current page
            $request = new ListIpAddressesRequest(
                perPage: $request->perPage ?? 100,
                page: $currentPage,
                search: $request->search,
            );

            $response = $this->listIpAddresses($serviceId, $request);
            $allAddresses = array_merge($allAddresses, $response->data);

            $currentPage++;
        } while ($currentPage <= $response->meta->lastPage);

        return $allAddresses;
    }

    /**
     * Update IP address description
     *
     * @param int|string $serviceId
     * @param int|string $entityId
     * @param UpdateIpDescriptionRequest $request
     * @return BaseResponse
     */
    public function updateIpDescription(
        int|string $serviceId,
        int|string $entityId,
        UpdateIpDescriptionRequest $request
    ): BaseResponse {
        $data = $request->toArray();
        $response = $this->post($this->buildPath((string) $serviceId, 'ipaddresses', (string) $entityId), $data);
        return BaseResponse::fromArray($response);
    }
}
