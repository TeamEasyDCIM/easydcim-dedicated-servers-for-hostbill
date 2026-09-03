<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Admin;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\EasyDCIMException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\UsageCollector\UpdateLimitsRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\UsageCollector\GetLimitsResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\SuccessResponse;

/**
 * Admin Usage Collector endpoints
 *
 * Manage device usage limits (bandwidth, percentile, etc.)
 */
class UsageCollectorEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/admin/usage-collector';

    /**
     * Get device bandwidth/usage limits
     *
     * @param int|string $deviceId Device ID
     * @return GetLimitsResponse
     * @throws EasyDCIMException
     */
    public function getLimits(int|string $deviceId): GetLimitsResponse
    {
        $response = $this->get($this->buildPath((string) $deviceId, 'limits'));
        return GetLimitsResponse::fromArray($response);
    }

    /**
     * Update device bandwidth/usage limits
     *
     * @param int|string $deviceId Device ID
     * @param UpdateLimitsRequest $request
     * @return SuccessResponse
     */
    public function updateLimits(int|string $deviceId, UpdateLimitsRequest $request): SuccessResponse
    {
        $response = $this->put($this->buildPath((string) $deviceId, 'limits'), $request->toArray());
        return SuccessResponse::fromArray($response);
    }
}
