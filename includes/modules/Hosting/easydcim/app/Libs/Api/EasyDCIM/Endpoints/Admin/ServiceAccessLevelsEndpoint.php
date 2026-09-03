<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Admin;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\EasyDCIMException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\ServiceAccessLevel\ListServiceAccessLevelsRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Service\ListServicesRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\ServiceAccessLevel\ListServiceAccessLevelsResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\ServiceAccessLevel\ServiceAccessLevelData;

/**
 * Admin Service Access Levels endpoints
 *
 * Manage service access levels for client area
 */
class ServiceAccessLevelsEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/admin/service-access-levels';

    /**
     * List all service access levels
     *
     * @param ListServiceAccessLevelsRequest|null $request
     * @return ListServiceAccessLevelsResponse
     * @throws EasyDCIMException
     */
    public function list(?ListServiceAccessLevelsRequest $request = null): ListServiceAccessLevelsResponse
    {
        $params = $request?->toArray() ?? [];
        return ListServiceAccessLevelsResponse::fromArray($this->get('', $params));
    }

    /**
     * Get ALL services for the authenticated user (auto-paginate)
     *
     * @param ListServiceAccessLevelsRequest|null $request
     * @return array<ServiceAccessLevelData> Array of all services across all pages
     * @throws EasyDCIMException
     */
    public function listAll(?ListServiceAccessLevelsRequest $request = null): array
    {
        $allAccessLevels = [];
        $currentPage = 1;
        $request = $request ?? new ListServiceAccessLevelsRequest();

        do {
            // Set the current page
            $request = new ListServiceAccessLevelsRequest(
                perPage: $request->perPage ?? 100,
                page: $currentPage,
                sortBy: $request->sortBy,
                sortDir: $request->sortDir,
                searchTerm: $request->searchTerm,
                searchOp: $request->searchOp,
                searchFields: $request->searchFields,
            );

            $response = $this->list($request);

            $allAccessLevels = array_merge($allAccessLevels, $response->data);

            $currentPage++;
        } while ($currentPage <= $response->meta->lastPage);

        return $allAccessLevels;
    }
}
