<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Admin;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\System\UpdateClientAreaConfigRequest;

/**
 * Admin System endpoints
 */
class SystemEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/admin';

    /**
     * Get Client Area configuration
     *
     * Returns current Client Area connection settings
     *
     * @return array{success: bool, data: array} Client Area configuration
     */
    public function getClientAreaConfig(): array
    {
        return $this->get('client-area/config');
    }

    /**
     * Update Client Area configuration
     *
     * @param UpdateClientAreaConfigRequest $request
     * @return array{success: bool, data: array} Updated configuration
     */
    public function updateClientAreaConfig(UpdateClientAreaConfigRequest $request): array
    {
        return $this->post('client-area/config', $request->toArray());
    }

    /**
     * Get system configuration
     *
     * Returns general system configuration and settings
     *
     * @return array{success: bool, data: array} System configuration
     */
    public function getSystemConfig(): array
    {
        return $this->get('system/config');
    }

    /**
     * Health check
     *
     * Check if the API is responding and system is healthy
     *
     * @return array{success: bool, data: array} Health status
     */
    public function healthCheck(): array
    {
        return $this->get('system/health-check');
    }
}
