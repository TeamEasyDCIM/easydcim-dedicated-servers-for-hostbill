<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Admin;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\EasyDCIMException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Device\AssignMetadataRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Device\CreateDeviceRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Device\DevicePowerActionRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Device\DiscoverDeviceRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Device\GetDeviceBandwidthRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Device\GetDevicePowerUsageRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Device\ListDevicesRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Device\UpdateDeviceRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Device\ListDevicesResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Device\ShowDeviceResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Bandwidth\GetBandwidthResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Power\GetPowerUsageResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\SuccessResponse;

/**
 * Admin Devices endpoints
 *
 * Manage physical and virtual devices in the datacenter
 */
class DevicesEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/admin/devices';

    /**
     * List all devices
     *
     * @param ListDevicesRequest|null $request
     * @return ListDevicesResponse
     * @throws EasyDCIMException
     */
    public function list(?ListDevicesRequest $request = null): ListDevicesResponse
    {
        $params = $request?->toArray() ?? [];
        $response = $this->get('', $params);
        return ListDevicesResponse::fromArray($response);
    }

    /**
     * Get ALL devices (auto-paginate)
     *
     * @param ListDevicesRequest|null $request
     * @return array Array of all devices across all pages
     * @throws EasyDCIMException
     */
    public function listAll(?ListDevicesRequest $request = null): array
    {
        $allDevices = [];
        $currentPage = 1;
        $request = $request ?? new ListDevicesRequest();

        do {
            // Set the current page
            $request = new ListDevicesRequest(
                perPage: $request->perPage ?? 100,
                page: $currentPage,
                sortBy: $request->sortBy,
                sortDir: $request->sortDir,
                searchTerm: $request->searchTerm,
                searchOp: $request->searchOp,
                searchFields: $request->searchFields
            );

            $response = $this->list($request);

            $allDevices = array_merge($allDevices, $response->data);

            $currentPage++;
        } while ($currentPage <= $response->meta->lastPage);

        return $allDevices;
    }

    /**
     * Get a specific device by ID
     *
     * @param int|string $id Device ID
     * @return ShowDeviceResponse
     */
    public function show(int|string $id): ShowDeviceResponse
    {
        $response = $this->get((string) $id);
        return ShowDeviceResponse::fromArray($response);
    }

    /**
     * Create a new device
     *
     * @param CreateDeviceRequest $request
     * @return ShowDeviceResponse
     * @throws EasyDCIMException
     */
    public function create(CreateDeviceRequest $request): ShowDeviceResponse
    {
        $response = $this->post('', $request->toArray());
        return ShowDeviceResponse::fromArray($response);
    }

    /**
     * Update an existing device
     *
     * @param int|string $id Device ID
     * @param UpdateDeviceRequest $request
     * @return ShowDeviceResponse
     * @throws EasyDCIMException
     */
    public function update(int|string $id, UpdateDeviceRequest $request): ShowDeviceResponse
    {
        $response = $this->put((string) $id, $request->toArray());
        return ShowDeviceResponse::fromArray($response);
    }

    /**
     * Delete a device
     *
     * @param int|string $id Device ID
     * @return SuccessResponse
     * @throws EasyDCIMException
     */
    public function destroy(int|string $id): SuccessResponse
    {
        $response = $this->delete((string) $id);
        return SuccessResponse::fromArray($response);
    }

    /**
     * Assign metadata to a device
     *
     * @param int|string $id Device ID
     * @param AssignMetadataRequest $request
     * @return SuccessResponse
     * @throws EasyDCIMException
     */
    public function assignMetadata(int|string $id, AssignMetadataRequest $request): SuccessResponse
    {
        $response = $this->post($this->buildPath((string) $id, 'metadata/assign'), $request->toArray());
        return SuccessResponse::fromArray($response);
    }

    /**
     * Force polling on a device
     *
     * @param int|string $id Device ID
     * @return SuccessResponse
     * @throws EasyDCIMException
     */
    public function forcePoll(int|string $id): SuccessResponse
    {
        $response = $this->post($this->buildPath((string) $id, 'poll'), []);
        return SuccessResponse::fromArray($response);
    }

    /**
     * Discover a device
     *
     * @param int|string $id Device ID
     * @param DiscoverDeviceRequest $request
     * @return SuccessResponse
     * @throws EasyDCIMException
     */
    public function discover(int|string $id, DiscoverDeviceRequest $request): SuccessResponse
    {
        $response = $this->post($this->buildPath((string) $id, 'discover'), $request->toArray());
        return SuccessResponse::fromArray($response);
    }

    /**
     * Perform power action on a device
     *
     * @param int|string $id Device ID
     * @param DevicePowerActionRequest $request
     * @return SuccessResponse
     * @throws EasyDCIMException
     */
    public function powerAction(int|string $id, DevicePowerActionRequest $request): SuccessResponse
    {
        $response = $this->post($this->buildPath((string) $id, 'power/action'), $request->toArray());
        return SuccessResponse::fromArray($response);
    }

    /**
     * Get device power usage
     *
     * @param int|string $id Device ID
     * @param GetDevicePowerUsageRequest $request
     * @return GetPowerUsageResponse
     * @throws EasyDCIMException
     */
    public function getPowerUsage(int|string $id, GetDevicePowerUsageRequest $request): GetPowerUsageResponse
    {
        $response = $this->post($this->buildPath((string) $id, 'power/usage'), $request->toArray());
        return GetPowerUsageResponse::fromArray($response);
    }

    /**
     * Get device bandwidth
     *
     * @param int|string $id Device ID
     * @param GetDeviceBandwidthRequest $request
     * @return GetBandwidthResponse
     */
    public function getBandwidth(int|string $id, GetDeviceBandwidthRequest $request): GetBandwidthResponse
    {
        $response = $this->post($this->buildPath((string) $id, 'bandwidth'), $request->toArray());
        return GetBandwidthResponse::fromArray($response);
    }
}
