<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Client;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\EasyDCIMException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\PasswordManagement\ListAccessDetailsRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\PasswordManagement\ListAccessDetailsResponse;

/**
 * Client Password Management endpoints
 */
class PasswordManagementEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/client';
    protected bool $isClientEndpoint = true;

    /**
     * List access details for a service
     *
     * @param ListAccessDetailsRequest|null $request
     * @return ListAccessDetailsResponse
     */
    public function listAccessDetails(?ListAccessDetailsRequest $request = null): ListAccessDetailsResponse
    {
        $params = ($request === null ? null : $request->toArray()) ?? [];
        $response = $this->get($this->buildPath('pm/access'), $params);
        return ListAccessDetailsResponse::fromArray($response);
    }

    /**
     * Get ALL access details for a service (auto-paginate)
     *
     * @param ListAccessDetailsRequest|null $request
     * @return array Array of all access details across all pages
     */
    public function listAllAccessDetails(?ListAccessDetailsRequest $request = null): array
    {
        $allDetails = [];
        $currentPage = 1;
        $request = $request ?? new ListAccessDetailsRequest();

        do {
            $request = new ListAccessDetailsRequest(
                $request->perPage ?? 100,
                $currentPage,
                $request->sortBy,
                $request->sortDir,
                $request->searchTerm,
                $request->searchOp,
                $request->searchFields
            );

            $response = $this->listAccessDetails($request);
            $allDetails = array_merge($allDetails, $response->data);

            $currentPage++;
        } while ($currentPage <= $response->meta->lastPage);

        return $allDetails;
    }
}
