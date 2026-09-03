<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Contracts;

/**
 * Interface for API configuration management
 */
interface ConfigurationInterface
{
    /**
     * Get the base URL for the API
     */
    public function getBaseUrl(): string;

    /**
     * Get the bearer token for authentication
     */
    public function getToken(): ?string;

    /**
     * Get the request timeout in seconds
     */
    public function getTimeout(): int;

    /**
     * Get the number of retry attempts for failed requests
     */
    public function getRetryAttempts(): int;

    /**
     * Check if SSL verification is enabled
     */
    public function shouldVerifySsl(): bool;

    /**
     * Get the log level
     */
    public function getLogLevel(): string;

    /**
     * Get the cache TTL in seconds
     */
    public function getCacheTtl(): int;

    /**
     * Get the user to impersonate (if set)
     *
     * @return int|string|null User ID, email, or null
     */
    public function getImpersonateUser(): int|string|null;

    /**
     * Set the user to impersonate
     *
     * @param int|string|null $user User ID, email, or null to clear
     * @return self
     */
    public function setImpersonateUser(int|string|null $user): self;

    /**
     * Get a configuration value by key
     *
     * @param string $key Configuration key
     * @param mixed $default Default value if key not found
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * Check if a configuration key exists
     *
     * @param string $key Configuration key
     */
    public function has(string $key): bool;

    /**
     * Convert configuration to array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array;
}
