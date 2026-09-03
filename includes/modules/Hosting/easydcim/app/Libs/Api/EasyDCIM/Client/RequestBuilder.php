<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Client;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Http\HttpRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Contracts\AuthenticatorInterface;

/**
 * Builds HTTP requests for the API
 */
class RequestBuilder
{
    protected Configuration $config;
    protected ?AuthenticatorInterface $authenticator;
    protected bool $isClientEndpoint = false;

    /**
     * Additional headers to include in requests
     *
     * @var array<string, string>
     */
    protected array $additionalHeaders = [];

    public function __construct(
        Configuration $config,
        ?AuthenticatorInterface $authenticator = null
    ) {
        $this->config = $config;
        $this->authenticator = $authenticator;
    }

    /**
     * Build a GET request
     *
     * @param string $path
     * @param array<string, mixed> $query
     * @return HttpRequest
     */
    public function get(string $path, array $query = []): HttpRequest
    {
        $url = $this->buildUrl($path, $query);
        return $this->buildRequest('GET', $url);
    }

    /**
     * Build a POST request
     *
     * @param string $path
     * @param array<string, mixed> $data
     * @return HttpRequest
     */
    public function post(string $path, array $data = []): HttpRequest
    {
        $url = $this->buildUrl($path);
        return $this->buildRequest('POST', $url, $data);
    }

    /**
     * Build a PUT request
     *
     * @param string $path
     * @param array<string, mixed> $data
     * @return HttpRequest
     */
    public function put(string $path, array $data = []): HttpRequest
    {
        $url = $this->buildUrl($path);
        return $this->buildRequest('PUT', $url, $data);
    }

    /**
     * Build a DELETE request
     *
     * @param string $path
     * @return HttpRequest
     */
    public function delete(string $path): HttpRequest
    {
        $url = $this->buildUrl($path);
        return $this->buildRequest('DELETE', $url);
    }

    /**
     * Build a PATCH request
     *
     * @param string $path
     * @param array<string, mixed> $data
     * @return HttpRequest
     */
    public function patch(string $path, array $data = []): HttpRequest
    {
        $url = $this->buildUrl($path);
        return $this->buildRequest('PATCH', $url, $data);
    }

    /**
     * Build the complete URL
     *
     * @param string $path
     * @param array<string, mixed> $query
     * @return string
     */
    protected function buildUrl(string $path, array $query = []): string
    {
        $baseUrl = $this->config->getBaseUrl();
        $path = ltrim($path, '/');
        $url = "{$baseUrl}/{$path}";

        if (!empty($query)) {
            $queryString = http_build_query($query);
            $url .= '?' . $queryString;
        }

        return $url;
    }

    /**
     * Build the HTTP request
     *
     * @param string $method
     * @param string $url
     * @param array<string, mixed>|null $data
     * @return HttpRequest
     */
    protected function buildRequest(string $method, string $url, ?array $data = null): HttpRequest
    {
        $headers = $this->buildHeaders();
        $body = null;

        if ($data !== null && !empty($data)) {
            try {
                $body = json_encode($data, JSON_THROW_ON_ERROR);
            } catch (\JsonException $e) {
                throw new \InvalidArgumentException(
                    'Failed to encode request data as JSON: ' . $e->getMessage(),
                    0,
                    $e
                );
            }
        }

        return new HttpRequest($method, $url, $headers, $body);
    }

    /**
     * Build request headers
     *
     * @return array<string, string>
     */
    protected function buildHeaders(): array
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'User-Agent' => 'EasyDCIM-PHP-Client/1.0',
        ];

        // Add authentication headers
        if ($this->authenticator !== null) {
            $headers = $this->authenticator->addAuthenticationHeaders($headers);
        }

        // Add impersonation header for Client endpoints (REQUIRED for security)
        if ($this->isClientEndpoint) {
            $impersonateUser = $this->config->getImpersonateUser();
            if ($impersonateUser === null || $impersonateUser === '') {
                throw new \RuntimeException(
                    'Client API request failed: No client email or ID provided for impersonation. ' .
                    'Please ensure a valid client is logged in or set the client identifier manually.'
                );
            }
            $headers['X-Impersonate-User'] = (string) $impersonateUser;
        }

        // Add any additional headers
        $headers = array_merge($headers, $this->additionalHeaders);

        return $headers;
    }

    /**
     * Set whether this is a client endpoint (for impersonation)
     *
     * @param bool $isClientEndpoint
     * @return self
     */
    public function setIsClientEndpoint(bool $isClientEndpoint): self
    {
        $this->isClientEndpoint = $isClientEndpoint;
        return $this;
    }

    /**
     * Add custom headers to the request
     *
     * @param array<string, string> $headers
     * @return self
     */
    public function withHeaders(array $headers): self
    {
        $this->additionalHeaders = array_merge($this->additionalHeaders, $headers);
        return $this;
    }

    /**
     * Add a single header to the request
     *
     * @param string $name
     * @param string $value
     * @return self
     */
    public function withHeader(string $name, string $value): self
    {
        $this->additionalHeaders[$name] = $value;
        return $this;
    }

    /**
     * Clear additional headers
     *
     * @return self
     */
    public function clearHeaders(): self
    {
        $this->additionalHeaders = [];
        return $this;
    }

    /**
     * Set the authenticator
     *
     * @param AuthenticatorInterface|null $authenticator
     * @return self
     */
    public function setAuthenticator(?AuthenticatorInterface $authenticator): self
    {
        $this->authenticator = $authenticator;
        return $this;
    }

    /**
     * Create a new instance with impersonation enabled
     *
     * @param int|string $user
     * @return self
     */
    public function withImpersonation(int|string $user): self
    {
        $instance = clone $this;
        $instance->config->setImpersonateUser($user);
        return $instance;
    }

    /**
     * Create a new instance with impersonation disabled
     *
     * @return self
     */
    public function withoutImpersonation(): self
    {
        $instance = clone $this;
        $instance->config->setImpersonateUser(null);
        return $instance;
    }
}
