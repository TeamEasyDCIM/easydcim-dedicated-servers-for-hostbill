<?php


namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Admin;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\EasyDCIMException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation\CreateIsoImageRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation\CreateOsAddonRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation\CreateOsTemplateRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation\FindProvisioningServerRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation\InstallOsRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation\ListIsoImagesRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation\ListOsAddonsRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation\ListOsTemplatesRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation\ListProvisioningHistoryRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation\ListProvisioningTasksRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation\ShowOsTemplateRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation\UpdateDeviceConfigurationRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation\UpdateIsoImageRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation\UpdateOsAddonRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\OsInstallation\UpdateOsTemplateRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation\IsoImageData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation\ListIsoImagesResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation\ListOsAddonsResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation\ListOsTemplatesResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation\ListProvisioningHistoryResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation\ListProvisioningTasksResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation\OsAddonData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation\OsTemplateData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation\ProvisioningHistoryData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation\ProvisioningServerResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation\ProvisioningTaskData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation\RescueModeStatusResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation\ShowDeviceConfigurationResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation\ShowIsoImageResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation\ShowOsAddonResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation\ShowOsInstallationResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\OsInstallation\ShowOsTemplateResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\SuccessResponse;

/**
 * Admin OS Installation endpoints
 *
 * Manage ISO images, OS templates, addons, and device OS installations
 */
class OsInstallationEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/admin/os';

    // ==================== ISO Images ====================

    /**
     * List all ISO images
     *
     * @param ListIsoImagesRequest|null $request
     * @return ListIsoImagesResponse
     * @throws EasyDCIMException
     */
    public function listIsoImages(?ListIsoImagesRequest $request = null): ListIsoImagesResponse
    {
        $params = $request?->toArray() ?? [];
        $response = $this->get('isoimages', $params);
        return ListIsoImagesResponse::fromArray($response);
    }

    /**
     * Get ALL ISO images (auto-paginate)
     *
     * @param ListIsoImagesRequest|null $request
     * @return array<IsoImageData> Array of all ISO images across all pages
     * @throws EasyDCIMException
     */
    public function listAllIsoImages(?ListIsoImagesRequest $request = null): array
    {
        $allIsoImages = [];
        $currentPage = 1;
        $request = $request ?? new ListIsoImagesRequest();

        do {
            $request = new ListIsoImagesRequest(
                perPage: $request->perPage ?? 100,
                page: $currentPage,
                sortBy: $request->sortBy,
                sortDir: $request->sortDir,
                searchTerm: $request->searchTerm,
                searchOp: $request->searchOp,
                searchFields: $request->searchFields,
            );

            $response = $this->listIsoImages($request);

            $allIsoImages = array_merge($allIsoImages, $response->data);

            $currentPage++;
        } while ($currentPage <= $response->meta->lastPage);

        return $allIsoImages;
    }

    /**
     * Get a specific ISO image by ID
     *
     * @param int|string $id ISO image ID
     * @return ShowIsoImageResponse
     * @throws EasyDCIMException
     */
    public function showIsoImage(int|string $id): ShowIsoImageResponse
    {
        $response = $this->get("isoimages/{$id}");
        return ShowIsoImageResponse::fromArray($response);
    }

    /**
     * Create a new ISO image
     *
     * @param CreateIsoImageRequest $request
     * @return ShowIsoImageResponse
     * @throws EasyDCIMException
     */
    public function createIsoImage(CreateIsoImageRequest $request): ShowIsoImageResponse
    {
        $response = $this->post('isoimages', $request->toArray());
        return ShowIsoImageResponse::fromArray($response);
    }

    /**
     * Update an existing ISO image
     *
     * @param int|string $id ISO image ID
     * @param UpdateIsoImageRequest $request
     * @return ShowIsoImageResponse
     * @throws EasyDCIMException
     */
    public function updateIsoImage(int|string $id, UpdateIsoImageRequest $request): ShowIsoImageResponse
    {
        $response = $this->put("isoimages/{$id}", $request->toArray());
        return ShowIsoImageResponse::fromArray($response);
    }

    /**
     * Delete an ISO image
     *
     * @param int|string $id ISO image ID
     * @return SuccessResponse
     * @throws EasyDCIMException
     */
    public function deleteIsoImage(int|string $id): SuccessResponse
    {
        $response = $this->delete("isoimages/{$id}");
        return SuccessResponse::fromArray($response);
    }

    // ==================== OS Templates ====================

    /**
     * List all OS templates
     *
     * @param ListOsTemplatesRequest|null $request
     * @return ListOsTemplatesResponse
     */
    public function listOsTemplates(?ListOsTemplatesRequest $request = null): ListOsTemplatesResponse
    {
        $params = $request?->toArray() ?? [];
        $response = $this->get('templates', $params);
        return ListOsTemplatesResponse::fromArray($response);
    }

    /**
     * Get ALL OS templates (auto-paginate)
     *
     * @param ListOsTemplatesRequest|null $request
     * @return array<OsTemplateData> Array of all OS templates across all pages
     */
    public function listAllOsTemplates(?ListOsTemplatesRequest $request = null): array
    {
        $allOsTemplates = [];
        $currentPage = 1;
        $request = $request ?? new ListOsTemplatesRequest();

        do {
            $request = new ListOsTemplatesRequest(
                perPage: $request->perPage ?? 100,
                page: $currentPage,
                sortBy: $request->sortBy,
                sortDir: $request->sortDir,
                searchTerm: $request->searchTerm,
                searchOp: $request->searchOp,
                searchFields: $request->searchFields,
                withAddons: $request->withAddons,
            );

            $response = $this->listOsTemplates($request);

            $allOsTemplates = array_merge($allOsTemplates, $response->data);

            $currentPage++;
        } while ($currentPage <= $response->meta->lastPage);

        return $allOsTemplates;
    }

    /**
     * Get a specific OS template by ID
     *
     * @param int|string $id OS template ID
     * @param ShowOsTemplateRequest|null $request
     * @return ShowOsTemplateResponse
     */
    public function showOsTemplate(int|string $id, ?ShowOsTemplateRequest $request = null): ShowOsTemplateResponse
    {
        $params = $request?->toArray() ?? [];
        $response = $this->get("templates/{$id}", $params);
        return ShowOsTemplateResponse::fromArray($response);
    }

    /**
     * Create a new OS template
     *
     * @param CreateOsTemplateRequest $request
     * @return ShowOsTemplateResponse
     * @throws EasyDCIMException
     */
    public function createOsTemplate(CreateOsTemplateRequest $request): ShowOsTemplateResponse
    {
        $response = $this->post('templates', $request->toArray());
        return ShowOsTemplateResponse::fromArray($response);
    }

    /**
     * Update an existing OS template
     *
     * @param int|string $id OS template ID
     * @param UpdateOsTemplateRequest $request
     * @return ShowOsTemplateResponse
     * @throws EasyDCIMException
     */
    public function updateOsTemplate(int|string $id, UpdateOsTemplateRequest $request): ShowOsTemplateResponse
    {
        $response = $this->put("templates/{$id}", $request->toArray());
        return ShowOsTemplateResponse::fromArray($response);
    }

    /**
     * Delete an OS template
     *
     * @param int|string $id OS template ID
     * @return SuccessResponse
     * @throws EasyDCIMException
     */
    public function deleteOsTemplate(int|string $id): SuccessResponse
    {
        $response = $this->delete("templates/{$id}");
        return SuccessResponse::fromArray($response);
    }

    // ==================== OS Addons ====================

    /**
     * List all OS addons
     *
     * @param ListOsAddonsRequest|null $request
     * @return ListOsAddonsResponse
     */
    public function listOsAddons(?ListOsAddonsRequest $request = null): ListOsAddonsResponse
    {
        $params = $request?->toArray() ?? [];
        $response = $this->get('addons', $params);
        return ListOsAddonsResponse::fromArray($response);
    }

    /**
     * Get ALL OS addons (auto-paginate)
     *
     * @param ListOsAddonsRequest|null $request
     * @return array<OsAddonData> Array of all OS addons across all pages
     */
    public function listAllOsAddons(?ListOsAddonsRequest $request = null): array
    {
        $allOsAddons = [];
        $currentPage = 1;
        $request = $request ?? new ListOsAddonsRequest();

        do {
            $request = new ListOsAddonsRequest(
                perPage: $request->perPage ?? 100,
                page: $currentPage,
                sortBy: $request->sortBy,
                sortDir: $request->sortDir,
                searchTerm: $request->searchTerm,
                searchOp: $request->searchOp,
                searchFields: $request->searchFields,
                templateId: $request->templateId,
            );

            $response = $this->listOsAddons($request);

            $allOsAddons = array_merge($allOsAddons, $response->data);

            $currentPage++;
        } while ($currentPage <= $response->meta->lastPage);

        return $allOsAddons;
    }

    /**
     * Get a specific OS addon by ID
     *
     * @param int|string $id OS addon ID
     * @return ShowOsAddonResponse
     * @throws EasyDCIMException
     */
    public function showOsAddon(int|string $id): ShowOsAddonResponse
    {
        $response = $this->get("addons/{$id}");
        return ShowOsAddonResponse::fromArray($response);
    }

    /**
     * Create a new OS addon
     *
     * @param CreateOsAddonRequest $request
     * @return ShowOsAddonResponse
     * @throws EasyDCIMException
     */
    public function createOsAddon(CreateOsAddonRequest $request): ShowOsAddonResponse
    {
        $response = $this->post('addons', $request->toArray());
        return ShowOsAddonResponse::fromArray($response);
    }

    /**
     * Update an existing OS addon
     *
     * @param int|string $id OS addon ID
     * @param UpdateOsAddonRequest $request
     * @return ShowOsAddonResponse
     * @throws EasyDCIMException
     */
    public function updateOsAddon(int|string $id, UpdateOsAddonRequest $request): ShowOsAddonResponse
    {
        $response = $this->put("addons/{$id}", $request->toArray());
        return ShowOsAddonResponse::fromArray($response);
    }

    /**
     * Delete an OS addon
     *
     * @param int|string $id OS addon ID
     * @return SuccessResponse
     * @throws EasyDCIMException
     */
    public function deleteOsAddon(int|string $id): SuccessResponse
    {
        $response = $this->delete("addons/{$id}");
        return SuccessResponse::fromArray($response);
    }

    // ==================== OS Installation & Device Management ====================

    /**
     * Install OS on a device
     *
     * @param int|string $deviceId Device ID
     * @param InstallOsRequest $request
     * @return ShowOsInstallationResponse
     * @throws EasyDCIMException
     */
    public function installOs(int|string $deviceId, InstallOsRequest $request): ShowOsInstallationResponse
    {
        $response = $this->post("{$deviceId}/install", $request->toArray());
        return ShowOsInstallationResponse::fromArray($response);
    }

    /**
     * Cancel OS installation
     *
     * @param int|string $deviceId Device ID
     * @return SuccessResponse
     * @throws EasyDCIMException
     */
    public function cancelOsInstallation(int|string $deviceId): SuccessResponse
    {
        $response = $this->post("{$deviceId}/cancel");
        return SuccessResponse::fromArray($response);
    }

    /**
     * Get OS installation information
     *
     * @param int|string $deviceId Device ID
     * @return ShowOsInstallationResponse
     * @throws EasyDCIMException
     */
    public function getOsInstallationInfo(int|string $deviceId): ShowOsInstallationResponse
    {
        $response = $this->get("{$deviceId}/install/information");
        return ShowOsInstallationResponse::fromArray($response);
    }

    /**
     * Enable rescue mode
     *
     * @param int|string $deviceId Device ID
     * @return ShowOsInstallationResponse
     * @throws EasyDCIMException
     */
    public function enableRescueMode(int|string $deviceId): ShowOsInstallationResponse
    {
        $response = $this->post("{$deviceId}/rescue/enable");
        return ShowOsInstallationResponse::fromArray($response);
    }

    /**
     * Get rescue mode status
     *
     * @param int|string $deviceId Device ID
     * @return RescueModeStatusResponse
     * @throws EasyDCIMException
     */
    public function getRescueModeStatus(int|string $deviceId): RescueModeStatusResponse
    {
        $response = $this->get("{$deviceId}/rescue/status");
        return RescueModeStatusResponse::fromArray($response);
    }

    /**
     * Show device configuration
     *
     * @param int|string $deviceId Device ID
     * @return ShowDeviceConfigurationResponse
     * @throws EasyDCIMException
     */
    public function showDeviceConfiguration(int|string $deviceId): ShowDeviceConfigurationResponse
    {
        $response = $this->get("{$deviceId}/configuration");
        return ShowDeviceConfigurationResponse::fromArray($response);
    }

    /**
     * Update device configuration
     *
     * @param int|string $deviceId Device ID
     * @param UpdateDeviceConfigurationRequest $request
     * @return ShowDeviceConfigurationResponse
     * @throws EasyDCIMException
     */
    public function updateDeviceConfiguration(int|string $deviceId, UpdateDeviceConfigurationRequest $request): ShowDeviceConfigurationResponse
    {
        $response = $this->post("{$deviceId}/configuration", $request->toArray());
        return ShowDeviceConfigurationResponse::fromArray($response);
    }

    /**
     * Find OS provisioning server
     *
     * @param int|string $id ID
     * @param FindProvisioningServerRequest|null $request
     * @return ProvisioningServerResponse
     */
    public function findProvisioningServer(int|string $id, ?FindProvisioningServerRequest $request = null): ProvisioningServerResponse
    {
        $params = $request?->toArray() ?? [];
        $response = $this->get("{$id}/provisioning/server", $params);
        return ProvisioningServerResponse::fromArray($response);
    }

    /**
     * List provisioning tasks
     *
     * @param ListProvisioningTasksRequest|null $request
     * @return ListProvisioningTasksResponse
     * @throws EasyDCIMException
     */
    public function listProvisioningTasks(?ListProvisioningTasksRequest $request = null): ListProvisioningTasksResponse
    {
        $params = $request?->toArray() ?? [];
        $response = $this->get('provisioning/tasks', $params);
        return ListProvisioningTasksResponse::fromArray($response);
    }

    /**
     * Get ALL provisioning tasks (auto-paginate)
     *
     * @param ListProvisioningTasksRequest|null $request
     * @return array<ProvisioningTaskData> Array of all provisioning tasks across all pages
     * @throws EasyDCIMException
     */
    public function listAllProvisioningTasks(?ListProvisioningTasksRequest $request = null): array
    {
        $allTasks = [];
        $currentPage = 1;
        $request = $request ?? new ListProvisioningTasksRequest();

        do {
            $request = new ListProvisioningTasksRequest(
                perPage: $request->perPage ?? 100,
                page: $currentPage,
                sortBy: $request->sortBy,
                sortDir: $request->sortDir,
                searchTerm: $request->searchTerm,
                searchOp: $request->searchOp,
                searchFields: $request->searchFields,
            );

            $response = $this->listProvisioningTasks($request);

            $allTasks = array_merge($allTasks, $response->data);

            $currentPage++;
        } while ($currentPage <= $response->meta->lastPage);

        return $allTasks;
    }

    /**
     * List provisioning history
     *
     * @param ListProvisioningHistoryRequest|null $request
     * @return ListProvisioningHistoryResponse
     * @throws EasyDCIMException
     */
    public function listProvisioningHistory(?ListProvisioningHistoryRequest $request = null): ListProvisioningHistoryResponse
    {
        $params = $request?->toArray() ?? [];
        $response = $this->get('provisioning/history', $params);
        return ListProvisioningHistoryResponse::fromArray($response);
    }

    /**
     * Get ALL provisioning history (auto-paginate)
     *
     * @param ListProvisioningHistoryRequest|null $request
     * @return array<ProvisioningHistoryData> Array of all provisioning history across all pages
     * @throws EasyDCIMException
     */
    public function listAllProvisioningHistory(?ListProvisioningHistoryRequest $request = null): array
    {
        $allHistory = [];
        $currentPage = 1;
        $request = $request ?? new ListProvisioningHistoryRequest();

        do {
            $request = new ListProvisioningHistoryRequest(
                perPage: $request->perPage ?? 100,
                page: $currentPage,
                sortBy: $request->sortBy,
                sortDir: $request->sortDir,
                searchTerm: $request->searchTerm,
                searchOp: $request->searchOp,
                searchFields: $request->searchFields,
            );

            $response = $this->listProvisioningHistory($request);

            $allHistory = array_merge($allHistory, $response->data);

            $currentPage++;
        } while ($currentPage <= $response->meta->lastPage);

        return $allHistory;
    }
}
