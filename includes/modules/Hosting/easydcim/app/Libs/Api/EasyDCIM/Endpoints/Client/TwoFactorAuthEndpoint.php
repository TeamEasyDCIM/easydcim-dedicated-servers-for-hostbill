<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Client;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\TwoFactor\BackupCodeRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\TwoFactor\DisableTwoFactorRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\TwoFactor\EnableTwoFactorRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\TwoFactor\StoreTwoFactorRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\TwoFactor\ValidateTwoFactorRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\TwoFactor\BackupCodeResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\TwoFactor\DisableTwoFactorResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\TwoFactor\EnableTwoFactorResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\TwoFactor\StoreTwoFactorResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\TwoFactor\ValidateTwoFactorResponse;

/**
 * Client Two-Factor Authentication endpoints
 */
class TwoFactorAuthEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/client/two-factor';
    protected bool $isClientEndpoint = true;

    /**
     * Enable two-factor authentication
     *
     * @param EnableTwoFactorRequest $request
     * @return EnableTwoFactorResponse
     */
    public function enable(EnableTwoFactorRequest $request): EnableTwoFactorResponse
    {
        $response = $this->post('enable', $request->toArray());
        return EnableTwoFactorResponse::fromArray($response);
    }

    /**
     * Disable two-factor authentication
     *
     * @param DisableTwoFactorRequest $request
     * @return DisableTwoFactorResponse
     */
    public function disable(DisableTwoFactorRequest $request): DisableTwoFactorResponse
    {
        $response = $this->post('disable', $request->toArray());
        return DisableTwoFactorResponse::fromArray($response);
    }

    /**
     * Store and verify 2FA configuration
     *
     * @param StoreTwoFactorRequest $request
     * @return StoreTwoFactorResponse
     */
    public function store(StoreTwoFactorRequest $request): StoreTwoFactorResponse
    {
        $response = $this->post('store', $request->toArray());
        return StoreTwoFactorResponse::fromArray($response);
    }

    /**
     * Validate two-factor authentication code
     *
     * @param ValidateTwoFactorRequest $request
     * @return ValidateTwoFactorResponse
     */
    public function validate(ValidateTwoFactorRequest $request): ValidateTwoFactorResponse
    {
        $response = $this->post('validate', $request->toArray());
        return ValidateTwoFactorResponse::fromArray($response);
    }

    /**
     * Generate backup code
     *
     * @param BackupCodeRequest $request
     * @return BackupCodeResponse
     */
    public function backupCode(BackupCodeRequest $request): BackupCodeResponse
    {
        $response = $this->post('backup-code', $request->toArray());
        return BackupCodeResponse::fromArray($response);
    }
}
