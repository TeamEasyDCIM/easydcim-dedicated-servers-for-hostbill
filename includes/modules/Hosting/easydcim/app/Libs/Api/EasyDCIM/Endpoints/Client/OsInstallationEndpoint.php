<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Client;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\EasyDCIMException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\OsInstallation\CreateIsoImageRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\OsInstallation\InstallOsRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\OsInstallation\ListAddonsRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\OsInstallation\ListIsoImagesRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\OsInstallation\ListTemplatesRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\OsInstallation\UpdateIsoImageRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\OsInstallation\CancelInstallationResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\OsInstallation\ClientIsoImageData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\OsInstallation\CreateIsoImageResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\OsInstallation\DeleteIsoImageResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\OsInstallation\EnableRescueModeResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\OsInstallation\GetOsInstallationInfoResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\OsInstallation\GetRescueModeStatusResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\OsInstallation\InstallOsResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\OsInstallation\ListIsoImagesResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\OsInstallation\ListOsAddonsResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\OsInstallation\ListOsTemplatesResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\OsInstallation\OsAddonData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\OsInstallation\OsTemplateData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\OsInstallation\UpdateIsoImageResponse;

/**
 * Client OS Installation endpoints
 */
class OsInstallationEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/client';
    protected bool $isClientEndpoint = true;

    /**
     * List ISO images
     *
     * @param ListIsoImagesRequest|null $request
     * @return ListIsoImagesResponse
     */
    public function listIsoImages(?ListIsoImagesRequest $request = null): ListIsoImagesResponse
    {
        $params = ($request === null ? null : $request->toArray()) ?? [];
        $response = $this->get('os/isoimages', $params);
        return ListIsoImagesResponse::fromArray($response);
    }

    /**
     * Get ALL ISO images (auto-paginate)
     *
     * @param ListIsoImagesRequest|null $request
     * @return array<ClientIsoImageData> Array of all ISO images across all pages
     */
    public function listAllIsoImages(?ListIsoImagesRequest $request = null): array
    {
        $allImages = [];
        $currentPage = 1;
        $request = $request ?? new ListIsoImagesRequest();

        do {
            // Set the current page
            $request = new ListIsoImagesRequest(
                $request->perPage ?? 100,
                $currentPage,
                $request->sortBy,
                $request->sortDir,
                $request->searchTerm,
                $request->searchOp,
                $request->searchFields
            );

            $response = $this->listIsoImages($request);
            $allImages = array_merge($allImages, $response->data);

            $currentPage++;
        } while ($currentPage <= $response->meta->lastPage);

        return $allImages;
    }

    /**
     * Create a new ISO image
     *
     * @param CreateIsoImageRequest $request
     * @return CreateIsoImageResponse
     */
    public function createIsoImage(CreateIsoImageRequest $request): CreateIsoImageResponse
    {
        $response = $this->post('os/isoimages', $request->toArray());
        return CreateIsoImageResponse::fromArray($response);
    }

    /**
     * Update an ISO image
     *
     * @param int|string $id ISO image ID
     * @param UpdateIsoImageRequest $request
     * @return UpdateIsoImageResponse
     */
    public function updateIsoImage($id, UpdateIsoImageRequest $request): UpdateIsoImageResponse
    {
        $response = $this->put($this->buildPath('os/isoimages', (string) $id), $request->toArray());
        return UpdateIsoImageResponse::fromArray($response);
    }

    /**
     * Delete an ISO image
     *
     * @param int|string $id ISO image ID
     * @return DeleteIsoImageResponse
     */
    public function deleteIsoImage($id): DeleteIsoImageResponse
    {
        $response = $this->delete($this->buildPath('os/isoimages', (string) $id));
        return DeleteIsoImageResponse::fromArray($response);
    }

    /**
     * List OS templates for a service
     *
     * @param int|string $serviceId Service ID
     * @param ListTemplatesRequest|null $request
     * @return ListOsTemplatesResponse
     */
    public function listTemplates($serviceId, ?ListTemplatesRequest $request = null): ListOsTemplatesResponse
    {
        $params = ($request === null ? null : $request->toArray()) ?? [];
        $response = $this->get($this->buildPath('services', (string) $serviceId, 'os/templates'), $params);
        return ListOsTemplatesResponse::fromArray($response);
    }

    /**
     * Get ALL OS templates for a service (auto-paginate)
     *
     * @param int|string $serviceId Service ID
     * @param ListTemplatesRequest|null $request
     * @return array<OsTemplateData> Array of all templates across all pages
     */
    public function listAllTemplates($serviceId, ?ListTemplatesRequest $request = null): array
    {
        $allTemplates = [];
        $currentPage = 1;
        $request = $request ?? new ListTemplatesRequest();

        do {
            // Set the current page
            $request = new ListTemplatesRequest(
                $request->withAddons,
                $request->perPage ?? 100,
                $currentPage,
                $request->sortBy,
                $request->sortDir,
                $request->searchTerm,
                $request->searchOp,
                $request->searchFields
            );

            $response = $this->listTemplates($serviceId, $request);
            $allTemplates = array_merge($allTemplates, $response->data);

            $currentPage++;
        } while ($currentPage <= $response->meta->lastPage);

        return $allTemplates;
    }

    /**
     * List OS addons for a service
     *
     * @param int|string $serviceId Service ID
     * @param ListAddonsRequest|null $request
     * @return ListOsAddonsResponse
     */
    public function listAddons($serviceId, ?ListAddonsRequest $request = null): ListOsAddonsResponse
    {
        $params = ($request === null ? null : $request->toArray()) ?? [];
        $response = $this->get($this->buildPath('services', (string) $serviceId, 'os/addons'), $params);
        return ListOsAddonsResponse::fromArray($response);
    }

    /**
     * Get ALL OS addons for a service (auto-paginate)
     *
     * @param int|string $serviceId Service ID
     * @param ListAddonsRequest|null $request
     * @return array<OsAddonData> Array of all addons across all pages
     */
    public function listAllAddons($serviceId, ?ListAddonsRequest $request = null): array
    {
        $allAddons = [];
        $currentPage = 1;
        $request = $request ?? new ListAddonsRequest();

        do {
            // Set the current page
            $request = new ListAddonsRequest(null, $request->perPage ?? 100, $currentPage, null, null, $request->searchTerm);

            $response = $this->listAddons($serviceId, $request);
            $allAddons = array_merge($allAddons, $response->data);

            $currentPage++;
        } while ($currentPage <= $response->meta->lastPage);

        return $allAddons;
    }

    /**
     * Install OS on a device
     *
     * @param int|string $serviceId Service ID
     * @param InstallOsRequest $request
     * @return InstallOsResponse
     */
    public function installOs($serviceId, InstallOsRequest $request): InstallOsResponse
    {
        $response = $this->post($this->buildPath('services', (string) $serviceId, 'os/install'), $request->toArray());
        return InstallOsResponse::fromArray($response);
    }

    /**
     * Cancel OS installation
     *
     * @param int|string $serviceId Service ID
     * @return CancelInstallationResponse
     */
    public function cancelInstallation($serviceId): CancelInstallationResponse
    {
        $response = $this->post($this->buildPath('services', (string) $serviceId, 'os/cancel'));
        return CancelInstallationResponse::fromArray($response);
    }

    /**
     * Get OS installation information
     *
     * @param int|string $serviceId Service ID
     * @return GetOsInstallationInfoResponse
     */
    public function getInstallationInfo($serviceId): GetOsInstallationInfoResponse
    {
        $response = $this->get($this->buildPath('services', (string) $serviceId, 'os/install/information'));
        return GetOsInstallationInfoResponse::fromArray($response);
    }

    /**
     * Enable rescue mode
     *
     * @param int|string $serviceId Service ID
     * @return EnableRescueModeResponse
     */
    public function enableRescueMode($serviceId): EnableRescueModeResponse
    {
        $response = $this->post($this->buildPath('services', (string) $serviceId, 'os/rescue/enable'));
        return EnableRescueModeResponse::fromArray($response);
    }

    /**
     * Get rescue mode status
     *
     * @param int|string $serviceId Service ID
     * @return GetRescueModeStatusResponse
     */
    public function getRescueModeStatus($serviceId): GetRescueModeStatusResponse
    {
        $response = $this->get($this->buildPath('services', (string) $serviceId, 'os/rescue/status'));
        return GetRescueModeStatusResponse::fromArray($response);
    }
}
