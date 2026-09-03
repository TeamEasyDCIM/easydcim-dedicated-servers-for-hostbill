<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Admin;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\EasyDCIMException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Ipmi\BmcResetResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Ipmi\NovncConnectResponse;

class IpmiEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/admin';

    /**
     * Start a noVNC session for a device
     *
     * @param int|string $deviceId EasyDCIM device ID
     * @return NovncConnectResponse
     * @throws EasyDCIMException
     */
    public function startNoVncSession(int|string $deviceId): NovncConnectResponse
    {
        $response = $this->post($this->buildPath('ipmi', (string) $deviceId, 'novnc-connect'));
        return NovncConnectResponse::fromArray($response);
    }

    /**
     * Perform BMC cold reset on a device
     *
     * @param int|string $deviceId EasyDCIM device ID
     * @return BmcResetResponse
     * @throws EasyDCIMException
     */
    public function bmcColdReset(int|string $deviceId): BmcResetResponse
    {
        $response = $this->post($this->buildPath('ipmi', (string) $deviceId, 'bmc-reset-cold'));
        return BmcResetResponse::fromArray($response);
    }
}
