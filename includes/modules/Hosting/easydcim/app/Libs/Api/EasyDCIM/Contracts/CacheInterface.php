<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Contracts;

/**
 * Simple cache interface
 */
interface CacheInterface
{
    /**
     * Retrieve an item from the cache
     *
     * @param string $key Cache key
     * @param mixed $default Default value if key not found
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * Store an item in the cache
     *
     * @param string $key Cache key
     * @param mixed $value Value to store
     * @param int|null $ttl Time to live in seconds (null for default)
     * @return bool Success status
     */
    public function set(string $key, $value, ?int $ttl = null): bool;

    /**
     * Check if an item exists in the cache
     *
     * @param string $key Cache key
     */
    public function has(string $key): bool;

    /**
     * Remove an item from the cache
     *
     * @param string $key Cache key
     * @return bool Success status
     */
    public function delete(string $key): bool;

    /**
     * Clear all items from the cache
     *
     * @return bool Success status
     */
    public function clear(): bool;

    /**
     * Get multiple cache items
     *
     * @param array<string> $keys Cache keys
     * @param mixed $default Default value for missing keys
     * @return array<string, mixed>
     */
    public function getMultiple(array $keys, $default = null): array;

    /**
     * Store multiple items in the cache
     *
     * @param array<string, mixed> $values Key-value pairs
     * @param int|null $ttl Time to live in seconds
     * @return bool Success status
     */
    public function setMultiple(array $values, ?int $ttl = null): bool;
}
