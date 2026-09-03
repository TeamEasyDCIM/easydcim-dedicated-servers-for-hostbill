<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Admin;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\EasyDCIMException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Port\ListPortsRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\Port\ListPortsResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\SuccessResponse;

/**
 * Admin Ports endpoints
 *
 * Manage device network ports
 */
class PortsEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/admin/ports';

    /**
     * List ports with optional filtering
     *
     * @param ListPortsRequest|null $request
     * @return ListPortsResponse
     * @throws EasyDCIMException
     */
    public function list(?ListPortsRequest $request = null): ListPortsResponse
    {
        $params = $request?->toArray() ?? [];
        $response = $this->get('', $params);
        return ListPortsResponse::fromArray($response);
    }

    /**
     * Get ports for a specific device
     *
     * @param int|string $deviceId Device ID (item_id)
     * @return ListPortsResponse
     * @throws EasyDCIMException
     */
    public function getByDeviceId(int|string $deviceId): ListPortsResponse
    {
        $request = new ListPortsRequest(
            searchTerm: (string) $deviceId,
            searchFields: 'item_id',
            perPage: 100
        );

        return $this->list($request);
    }

    /**
     * Enable a port
     *
     * @param int|string $portId Port ID
     * @return SuccessResponse
     * @throws EasyDCIMException
     */
    public function enable(int|string $portId): SuccessResponse
    {
        $response = $this->post($this->buildPath((string) $portId, 'enable'), []);
        return SuccessResponse::fromArray($response);
    }

    /**
     * Disable a port
     *
     * @param int|string $portId Port ID
     * @return SuccessResponse
     * @throws EasyDCIMException
     */
    public function disable(int|string $portId): SuccessResponse
    {
        $response = $this->post($this->buildPath((string) $portId, 'disable'), []);
        return SuccessResponse::fromArray($response);
    }
}
