<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Contracts\ClientInterface;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\ApiResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Base class for all endpoint classes
 * 
 * Provides common functionality for making API requests
 */
abstract class AbstractEndpoint
{
    protected ClientInterface $client;

    /**
     * Base path for this endpoint (e.g., 'api/v3/admin/locations')
     */
    protected string $basePath = '';

    /**
     * Whether this is a client endpoint (for impersonation support)
     */
    protected bool $isClientEndpoint = false;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Make a GET request
     *
     * @param string $path
     * @param array<string, mixed> $query
     * @return array<string, mixed>
     */
    protected function get(string $path = '', array $query = []): array
    {
        $fullPath = $this->buildFullPath($path);
        $response = $this->client->get($fullPath, $query);
        return $response->toArray();
    }

    /**
     * Make a POST request
     *
     * @param string $path
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    protected function post(string $path = '', array $data = []): array
    {
        $fullPath = $this->buildFullPath($path);
        $response = $this->client->post($fullPath, $data);
        return $response->toArray();
    }

    /**
     * Make a PUT request
     *
     * @param string $path
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    protected function put(string $path = '', array $data = []): array
    {
        $fullPath = $this->buildFullPath($path);
        $response = $this->client->put($fullPath, $data);
        return $response->toArray();
    }

    /**
     * Make a DELETE request
     *
     * @param string $path
     * @return array<string, mixed>
     */
    protected function delete(string $path = ''): array
    {
        $fullPath = $this->buildFullPath($path);
        $response = $this->client->delete($fullPath);
        return $response->toArray();
    }

    /**
     * Build path segments into a string (without basePath)
     *
     * @param string ...$segments
     * @return string
     */
    protected function buildPath(string ...$segments): string
    {
        $parts = array_filter($segments);
        return implode('/', array_map(fn($part) => trim($part, '/'), $parts));
    }

    /**
     * Build the full path for the request (includes basePath)
     *
     * @param string ...$segments
     * @return string
     */
    protected function buildFullPath(string ...$segments): string
    {
        $parts = array_filter(array_merge([$this->basePath], $segments));
        return implode('/', array_map(fn($part) => trim($part, '/'), $parts));
    }

    /**
     * Extract data from response
     *
     * @param array<string, mixed> $response
     * @return mixed
     */
    protected function extractData(array $response)
    {
        return Arr::get($response, 'data', $response);
    }

    /**
     * Check if this is a client endpoint
     */
    public function isClientEndpoint(): bool
    {
        return $this->isClientEndpoint;
    }

    /**
     * Get the base path
     */
    public function getBasePath(): string
    {
        return $this->basePath;
    }

    /**
     * Get the client instance
     */
    protected function getClient(): ClientInterface
    {
        return $this->client;
    }
}
