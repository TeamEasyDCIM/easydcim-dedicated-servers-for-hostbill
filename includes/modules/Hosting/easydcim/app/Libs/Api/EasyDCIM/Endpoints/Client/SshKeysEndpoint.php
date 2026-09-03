<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Client;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\AbstractEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\EasyDCIMException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\SshKey\CreateSshKeyRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\SshKey\ListSshKeysRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\SshKey\UpdateSshKeyRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\BaseResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\SshKey\ListSshKeysResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\SshKey\SshKeyData;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\SshKey\SshKeyResponse;

/**
 * Client SSH Keys endpoints
 */
class SshKeysEndpoint extends AbstractEndpoint
{
    protected string $basePath = 'api/v3/client/user/ssh-keys';
    protected bool $isClientEndpoint = true;

    /**
     * List all SSH keys for the authenticated user
     *
     * @param ListSshKeysRequest|null $request
     * @return ListSshKeysResponse
     * @throws EasyDCIMException
     */
    public function list(?ListSshKeysRequest $request = null): ListSshKeysResponse
    {
        $params = $request?->toArray() ?? [];
        $response = $this->get('', $params);
        return ListSshKeysResponse::fromArray($response);
    }

    /**
     * Get ALL SSH keys for the authenticated user (auto-paginate)
     *
     * @param ListSshKeysRequest|null $request
     * @return array<SshKeyData> Array of all SSH keys across all pages
     * @throws EasyDCIMException
     */
    public function listAll(?ListSshKeysRequest $request = null): array
    {
        $allKeys = [];
        $currentPage = 1;
        $request = $request ?? new ListSshKeysRequest();

        do {
            // Set the current page
            $request = new ListSshKeysRequest(
                perPage: $request->perPage ?? 100,
                page: $currentPage,
                search: $request->search,
            );

            $response = $this->list($request);
            $allKeys = array_merge($allKeys, $response->data);

            $currentPage++;
        } while ($currentPage <= $response->meta->lastPage);

        return $allKeys;
    }

    /**
     * Create a new SSH key
     *
     * @param CreateSshKeyRequest $request
     * @return SshKeyResponse
     * @throws EasyDCIMException
     */
    public function create(CreateSshKeyRequest $request): SshKeyResponse
    {
        $data = $request->toArray();
        $response = $this->post('', $data);
        return SshKeyResponse::fromArray($response);
    }

    /**
     * Update an SSH key
     *
     * @param int|string $id
     * @param UpdateSshKeyRequest $request
     * @return SshKeyResponse
     */
    public function update(int|string $id, UpdateSshKeyRequest $request): SshKeyResponse
    {
        $data = $request->toArray();
        $response = $this->put((string) $id, $data);
        return SshKeyResponse::fromArray($response);
    }

    /**
     * Set an SSH key as default
     *
     * @param int|string $id
     * @return SshKeyResponse
     */
    public function setAsDefault(int|string $id): SshKeyResponse
    {
        $response = $this->post($this->buildPath((string) $id, 'set-as-default'));
        return SshKeyResponse::fromArray($response);
    }

    /**
     * Delete an SSH key
     *
     * @param int|string $id
     * @return BaseResponse
     */
    public function destroy(int|string $id): BaseResponse
    {
        $response = $this->delete((string) $id);
        return BaseResponse::fromArray($response);
    }
}
