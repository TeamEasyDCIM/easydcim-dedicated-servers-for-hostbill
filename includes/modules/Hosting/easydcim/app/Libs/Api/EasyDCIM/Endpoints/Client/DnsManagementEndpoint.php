<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Client;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\EasyDCIMException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Dns\CreateRdnsRecordRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Dns\ListRdnsRecordsRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Dns\UpdateRdnsRecordRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\BaseResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Dns\ListRdnsRecordsResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Dns\RdnsRecordData;

/**
 * Client DNS Management endpoints
 */
class DnsManagementEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/client/services';
    protected bool $isClientEndpoint = true;

    /**
     * List rDNS records for a service
     *
     * @param int|string $serviceId
     * @param ListRdnsRecordsRequest|null $request
     * @return ListRdnsRecordsResponse
     * @throws EasyDCIMException
     */
    public function listRdnsRecords(int|string $serviceId, ?ListRdnsRecordsRequest $request = null): ListRdnsRecordsResponse
    {
        $params = $request?->toArray() ?? [];
        $response = $this->get($this->buildPath((string) $serviceId, 'rdns'), $params);
        return ListRdnsRecordsResponse::fromArray($response);
    }

    /**
     * Get ALL rDNS records for a service (auto-paginate)
     *
     * @param int|string $serviceId
     * @param ListRdnsRecordsRequest|null $request
     * @return array<RdnsRecordData> Array of all rDNS records across all pages
     * @throws EasyDCIMException
     */
    public function listAllRdnsRecords(int|string $serviceId, ?ListRdnsRecordsRequest $request = null): array
    {
        $allRecords = [];
        $currentPage = 1;
        $request = $request ?? new ListRdnsRecordsRequest();

        do {
            // Set the current page
            $request = new ListRdnsRecordsRequest(
                perPage: $request->perPage ?? 100,
                page: $currentPage,
                search: $request->search,
            );

            $response = $this->listRdnsRecords($serviceId, $request);
            $allRecords = array_merge($allRecords, $response->data);

            $currentPage++;
        } while ($currentPage <= $response->meta->lastPage);

        return $allRecords;
    }

    /**
     * Create a new rDNS record
     *
     * @param int|string $serviceId
     * @param CreateRdnsRecordRequest $request
     * @return BaseResponse
     * @throws EasyDCIMException
     */
    public function createRdnsRecord(int|string $serviceId, CreateRdnsRecordRequest $request): BaseResponse
    {
        $response = $this->post($this->buildPath((string) $serviceId, 'rdns'), $request->toArray());
        return BaseResponse::fromArray($response);
    }

    /**
     * Update an rDNS record
     *
     * @param int|string $serviceId
     * @param int|string $recordId
     * @param UpdateRdnsRecordRequest $request
     * @return BaseResponse
     * @throws EasyDCIMException
     */
    public function updateRdnsRecord(
        int|string $serviceId,
        int|string $recordId,
        UpdateRdnsRecordRequest $request
    ): BaseResponse {
        $response = $this->post($this->buildPath((string) $serviceId, 'rdns', (string) $recordId), $request->toArray());
        return BaseResponse::fromArray($response);
    }

    /**
     * Delete an rDNS record
     *
     * @param int|string $serviceId
     * @param int|string $recordId
     * @return BaseResponse
     * @throws EasyDCIMException
     */
    public function deleteRdnsRecord(int|string $serviceId, int|string $recordId): BaseResponse
    {
        $response = $this->delete($this->buildPath((string) $serviceId, 'rdns', (string) $recordId));
        return BaseResponse::fromArray($response);
    }
}
