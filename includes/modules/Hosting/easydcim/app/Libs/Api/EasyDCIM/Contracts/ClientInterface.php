<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Contracts;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\ApiResponse;

/**
 * Interface for the main EasyDCIM API client
 */
interface ClientInterface
{
    /**
     * Get the configuration instance
     */
    public function getConfiguration(): ConfigurationInterface;

    /**
     * Get the HTTP client instance
     */
    public function getHttpClient(): object;

    /**
     * Send a GET request
     *
     * @param string $path API endpoint path
     * @param array<string, mixed> $query Query parameters
     * @return ApiResponse Standardized response object
     */
    public function get(string $path, array $query = []): ApiResponse;

    /**
     * Send a POST request
     *
     * @param string $path API endpoint path
     * @param array<string, mixed> $data Request body data
     * @return ApiResponse Standardized response object
     */
    public function post(string $path, array $data = []): ApiResponse;

    /**
     * Send a PUT request
     *
     * @param string $path API endpoint path
     * @param array<string, mixed> $data Request body data
     * @return ApiResponse Standardized response object
     */
    public function put(string $path, array $data = []): ApiResponse;

    /**
     * Send a DELETE request
     *
     * @param string $path API endpoint path
     * @return ApiResponse Standardized response object
     */
    public function delete(string $path): ApiResponse;

    /**
     * Set the user to impersonate (Client endpoints only)
     *
     * @param int|string $user User ID or email address
     * @return self
     */
    public function setImpersonateUser($user): self;

    /**
     * Clear the impersonation setting
     *
     * @return self
     */
    public function clearImpersonation(): self;
}
