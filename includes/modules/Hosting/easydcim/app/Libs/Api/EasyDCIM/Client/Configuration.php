<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Client;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Contracts\ConfigurationInterface;

/**
 * Configuration management for EasyDCIM API client
 *
 * Supports configuration from:
 * 1. WHMCS Params facade (serverhostname, serverpassword, etc.)
 * 2. Server model (EasyDCIMv2 server from database)
 * 3. Manual array configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Configuration values
     *
     * @var array<string, mixed>
     */
    protected array $config = [];

    /**
     * Create a new Configuration instance
     *
     * @param array<string, mixed> $config Configuration array
     */
    public function __construct(array $config = [])
    {
        $this->config = array_merge($this->getDefaults(), $config);
    }

    /**
     * Get default configuration values
     *
     * @return array<string, mixed>
     */
    protected function getDefaults(): array
    {
        return [
            'timeout' => 30,
            'retry_attempts' => 3,
            'connect_timeout' => 10,
            'verify_ssl' => false,
            'debug' => false,
            'enable_logging' => true,
            'log_sensitive_data' => false,
            'max_log_length' => 10000,
            'validation_strict_mode' => false,
            'log_level' => 'info',
            'cache_ttl' => 3600,
            'impersonate_user' => null,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getBaseUrl(): string
    {
        return rtrim($this->config['base_url'] ?? '', '/');
    }

    /**
     * {@inheritDoc}
     */
    public function getToken(): ?string
    {
        return $this->config['token'] ?? null;
    }

    /**
     * {@inheritDoc}
     */
    public function getTimeout(): int
    {
        return $this->config['timeout'] ?? 30;
    }

    /**
     * {@inheritDoc}
     */
    public function getRetryAttempts(): int
    {
        return $this->config['retry_attempts'] ?? 3;
    }

    /**
     * {@inheritDoc}
     */
    public function shouldVerifySsl(): bool
    {
        return $this->config['verify_ssl'] ?? false;
    }

    /**
     * {@inheritDoc}
     */
    public function getLogLevel(): string
    {
        return $this->config['log_level'] ?? 'info';
    }

    /**
     * {@inheritDoc}
     */
    public function getCacheTtl(): int
    {
        return $this->config['cache_ttl'] ?? 3600;
    }

    /**
     * {@inheritDoc}
     */
    public function getImpersonateUser()
    {
        return $this->config['impersonate_user'] ?? null;
    }

    /**
     * {@inheritDoc}
     */
    public function setImpersonateUser($user): self
    {
        $this->config['impersonate_user'] = $user;
        return $this;
    }

    /**
     * Get connection timeout
     */
    public function getConnectTimeout(): int
    {
        return $this->config['connect_timeout'] ?? 10;
    }

    /**
     * Check if debug mode is enabled
     */
    public function isDebug(): bool
    {
        return $this->config['debug'] ?? false;
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }

    /**
     * {@inheritDoc}
     */
    public function has(string $key): bool
    {
        return isset($this->config[$key]);
    }

    /**
     * Set a configuration value
     *
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function set(string $key, $value): self
    {
        $this->config[$key] = $value;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return $this->config;
    }

    /**
     * Create configuration from WHMCS context
     *
     * Attempts to load configuration in the following order:
     * 1. From Params facade (serverhostname, serverpassword, etc.)
     * 2. From Server model (first EasyDCIMv2 server in database)
     *
     * @return self
     */
    /**
     * Build a configuration from a HostBill server connection array.
     *
     * HostBill hands modules the server record as ip/host/username/password/secure
     * (see easydcim::connect()). The password field holds the EasyDCIM API token -
     * the same convention the WHMCS build uses for `serverpassword`.
     *
     * @param array $connection HostBill $module->connection
     */
    public static function fromConnection(array $connection): self
    {
        $hostname = $connection['host'] ?: ($connection['ip'] ?? '');

        if (empty($hostname)) {
            throw new \RuntimeException('API: Server IP and hostname is empty.');
        }

        $token = $connection['password'] ?? '';

        if (empty($token)) {
            throw new \RuntimeException('API: Server API Key is empty.');
        }

        return new self([
            'base_url'   => self::buildBaseUrl($hostname, $connection['secure'] ?? false),
            'token'      => $token,
            'verify_ssl' => false,
        ]);
    }

    public static function fromArray(array $config): self
    {
        return new self($config);
    }

    /**
     * Build base URL from hostname and secure flag
     *
     * @param string $hostname
     * @param bool|string $secure
     * @return string
     */
    private static function buildBaseUrl(string $hostname, $secure): string
    {
        $isSecure = in_array(strtolower((string) $secure), ['on', '1', 'true', 'yes'], true);
        $protocol = $isSecure ? 'https' : 'http';

        return "{$protocol}://" . rtrim($hostname, '/');
    }
}
