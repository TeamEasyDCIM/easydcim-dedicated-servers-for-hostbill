<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Client;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\User\AutologinRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\User\UpdatePasswordRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\User\UpdateUserRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\User\AutologinResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\User\GetAutoLoginLinkResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\User\GetUserResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\User\UpdatePasswordResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\User\UpdateUserResponse;

/**
 * Client Users endpoints
 *
 */
class UsersEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/client/user';
    protected bool $isClientEndpoint = true;

    /**
     * Autologin with token
     *
     * @param AutologinRequest $request
     * @return AutologinResponse
     */
    public function autologin(AutologinRequest $request): AutologinResponse
    {
        $response = $this->post('autologin', $request->toArray());
        return AutologinResponse::fromArray($response);
    }

    /**
     * Get authenticated user details
     *
     * @return GetUserResponse
     *
     */
    public function getAuthenticatedUser(): GetUserResponse
    {
        $response = $this->get();
        return GetUserResponse::fromArray($response);
    }

    /**
     * Update authenticated user profile
     *
     * @param UpdateUserRequest $request
     * @return UpdateUserResponse
     *
     */
    public function updateUser(UpdateUserRequest $request): UpdateUserResponse
    {
        $response = $this->put('edit', $request->toArray());
        return UpdateUserResponse::fromArray($response);
    }

    /**
     * Update authenticated user password
     *
     * @param UpdatePasswordRequest $request
     * @return UpdatePasswordResponse
     *
     */
    public function updatePassword(UpdatePasswordRequest $request): UpdatePasswordResponse
    {
        $response = $this->put('edit-password', $request->toArray());
        return UpdatePasswordResponse::fromArray($response);
    }

    /**
     * Get auto login link for authenticated user
     *
     * @return GetAutoLoginLinkResponse
     *
     */
    public function getAutoLoginLink(): GetAutoLoginLinkResponse
    {
        $response = $this->get('autologin');
        return GetAutoLoginLinkResponse::fromArray($response);
    }
}
