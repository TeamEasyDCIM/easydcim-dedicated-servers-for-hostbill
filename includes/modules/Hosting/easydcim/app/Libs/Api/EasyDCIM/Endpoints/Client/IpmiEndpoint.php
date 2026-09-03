<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Client;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\EasyDCIMException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Ipmi\CloseSessionRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Ipmi\GetConsoleInformationRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Ipmi\UpdateSessionActivityRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\BaseResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Ipmi\BmcResetResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Ipmi\GetConsoleInformationResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Ipmi\NovncConnectResponse;

/**
 * Client IPMI endpoints
 */
class IpmiEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/client';
    protected bool $isClientEndpoint = true;

    /**
     * Perform BMC cold reset
     *
     * @param int|string $serviceId Service ID
     * @return BmcResetResponse
     * @throws EasyDCIMException
     */
    public function bmcColdReset(int|string $serviceId): BmcResetResponse
    {
        $response = $this->post($this->buildPath('services', (string) $serviceId, 'ipmi/bmc-reset-cold'));
        return BmcResetResponse::fromArray($response);
    }

    /**
     * Start a noVNC session
     *
     * @param int|string $serviceId Service ID
     * @return NovncConnectResponse
     * @throws EasyDCIMException
     */
    public function startNoVncSession(int|string $serviceId): NovncConnectResponse
    {
        $response = $this->post($this->buildPath('services', (string) $serviceId, 'ipmi/novnc-connect'));
        return NovncConnectResponse::fromArray($response);
    }

    /**
     * Show IPMI console session information
     *
     * @param GetConsoleInformationRequest $request
     * @return GetConsoleInformationResponse
     * @throws EasyDCIMException
     */
    public function getConsoleInformation(GetConsoleInformationRequest $request): GetConsoleInformationResponse
    {
        $response = $this->post('ipmi/console/information', $request->toArray());
        return GetConsoleInformationResponse::fromArray($response);
    }

    /**
     * Update IPMI session activity
     *
     * @param UpdateSessionActivityRequest $request
     * @return BaseResponse
     * @throws EasyDCIMException
     */
    public function updateSessionActivity(UpdateSessionActivityRequest $request): BaseResponse
    {
        $response = $this->post('ipmi/console/activity', $request->toArray());
        return BaseResponse::fromArray($response);
    }

    /**
     * Close IPMI session
     *
     * @param CloseSessionRequest $request
     * @return BaseResponse
     * @throws EasyDCIMException
     */
    public function closeSession(CloseSessionRequest $request): BaseResponse
    {
        $response = $this->post('ipmi/console/close', $request->toArray());
        return BaseResponse::fromArray($response);
    }
}
