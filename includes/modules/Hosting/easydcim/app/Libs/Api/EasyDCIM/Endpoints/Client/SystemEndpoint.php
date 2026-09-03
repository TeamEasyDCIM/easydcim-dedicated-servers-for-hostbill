<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Client;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\System\GetSystemSettingsResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\System\GetTranslationsResponse;

/**
 * Client System endpoints
 */
class SystemEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/client';
    protected bool $isClientEndpoint = true;

    /**
     * Get translations for a specific locale
     *
     * @param string $locale
     * @return GetTranslationsResponse
     */
    public function getTranslations(string $locale): GetTranslationsResponse
    {
        $response = $this->get($this->buildPath('system/translations', $locale));
        return GetTranslationsResponse::fromArray($response);
    }

    /**
     * Show system configuration
     *
     * @return GetSystemSettingsResponse
     */
    public function getSystemSettings(): GetSystemSettingsResponse
    {
        $response = $this->get('system-settings');
        return GetSystemSettingsResponse::fromArray($response);
    }
}
