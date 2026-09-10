<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Admin;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\User\CreateUserRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\User\GetUserBandwidthRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\User\ListUsersRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\User\UpdateUserRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\User\UserResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Admin\User\VerifyTokenAbilityResponse;

/**
 * Admin Users endpoints
 *
 * Manage user accounts
 */
class UsersEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/admin/users';

    /**
     * List all users
     *
     * @param ListUsersRequest|null $request
     * @return array{success: bool, data: array}
     */
    public function list(?ListUsersRequest $request = null): array
    {
        $params = ($request === null ? null : $request->toArray()) ?? [];
        return $this->get('', $params);
    }

    /**
     * Fetch user by email address
     *
     * @param string $email User email address
     * @return UserResponse
     */
    public function fetchByEmail(string $email): UserResponse
    {
        $response = $this->get('find-by-email', ['email' => $email]);
        return UserResponse::fromArray($response);
    }

    /**
     * Get a specific user
     *
     * @param int $id User ID
     * @return UserResponse
     */
    public function show($id): UserResponse
    {
        $response = $this->get((string) $id);
        return UserResponse::fromArray($response);
    }

    /**
     * Create a new user
     *
     * @param CreateUserRequest $request
     * @return UserResponse
     */
    public function create(CreateUserRequest $request): UserResponse
    {
        $response = $this->post('', $request->toArray());
        return UserResponse::fromArray($response);
    }

    /**
     * Update a user
     *
     * @param int $id User ID
     * @param UpdateUserRequest $request
     * @return array{success: bool, data: array}
     */
    public function update($id, UpdateUserRequest $request): array
    {
        return $this->put((string) $id, $request->toArray());
    }

    /**
     * Get user bandwidth usage
     *
     * @param int $id User ID
     * @param GetUserBandwidthRequest|null $request
     * @return array{success: bool, data: array}
     */
    public function bandwidth($id, ?GetUserBandwidthRequest $request = null): array
    {
        $params = ($request === null ? null : $request->toArray()) ?? [];
        return $this->post($this->buildPath((string) $id, 'bandwidth'), $params);
    }

    /**
     * Delete a user
     *
     * @param int|string $id User ID
     * @return array{success: bool, message: string}
     */
    public function destroy($id): array
    {
        return parent::delete((string) $id);
    }

    /**
     * Verify API token and check if it has the given ability
     *
     * @param string $ability Ability to check
     * @return VerifyTokenAbilityResponse
     */
    public function verifyTokenAbility(string $ability): VerifyTokenAbilityResponse
    {
        $response = $this->post('verify-token-ability', ['ability' => $ability]);
        return VerifyTokenAbilityResponse::fromArray($response);
    }
}
