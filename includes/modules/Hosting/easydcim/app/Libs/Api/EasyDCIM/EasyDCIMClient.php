<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Auth\BearerTokenAuthenticator;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Client\Configuration;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Client\RequestBuilder;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Client\ResponseHandler;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Contracts\AuthenticatorInterface;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Contracts\ClientInterface;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Contracts\ConfigurationInterface;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Admin\AdminEndpointFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Authorization\AuthorizationEndpoint;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Endpoints\Client\ClientEndpointFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\EasyDCIMException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\NetworkException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Http\CurlTransport;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Http\HttpRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Http\TransportInterface;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\ApiResponse;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Logger;

/**
 * Main EasyDCIM API v3 client.
 *
 * HostBill port of the WHMCS client. Two things differ:
 *
 *  - transport is cURL, not Guzzle, because HostBill modules cannot rely on
 *    Guzzle being autoloadable and this module vendors no dependencies;
 *  - impersonation is always explicit. The WHMCS build sniffs the logged-in
 *    client out of the framework; here the caller passes the client's email,
 *    which HostBill already hands the module as $module->getClient().
 *
 * Usage:
 * ```php
 * $client = new EasyDCIMClient(Configuration::fromConnection($module->connection));
 *
 * $locations = $client->admin()->locations()->list();
 *
 * $client->setImpersonateUser('client@example.com');
 * $records = $client->client()->dnsManagement()->listRdnsRecords($serviceId);
 * ```
 */
class EasyDCIMClient implements ClientInterface
{
    protected Configuration $config;
    protected TransportInterface $transport;
    protected RequestBuilder $requestBuilder;
    protected ResponseHandler $responseHandler;
    protected ?AuthenticatorInterface $authenticator = null;

    /**
     * @param ConfigurationInterface  $config
     * @param TransportInterface|null $transport Injection seam for tests
     */
    public function __construct(ConfigurationInterface $config, ?TransportInterface $transport = null)
    {
        $this->config = $config;

        if ($this->config->getToken() !== null) {
            $this->authenticator = new BearerTokenAuthenticator($this->config->getToken());
        }

        $this->transport = $transport ?? new CurlTransport(
            $this->config->getTimeout(),
            $this->config->getConnectTimeout(),
            $this->config->shouldVerifySsl()
        );

        $this->requestBuilder  = new RequestBuilder($this->config, $this->authenticator);
        $this->responseHandler = new ResponseHandler();
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $path, array $query = []): ApiResponse
    {
        return $this->sendRequest($this->requestBuilder->get($path, $query));
    }

    /**
     * {@inheritDoc}
     */
    public function post(string $path, array $data = []): ApiResponse
    {
        return $this->sendRequest($this->requestBuilder->post($path, $data));
    }

    /**
     * {@inheritDoc}
     */
    public function put(string $path, array $data = []): ApiResponse
    {
        return $this->sendRequest($this->requestBuilder->put($path, $data));
    }

    /**
     * {@inheritDoc}
     */
    public function delete(string $path): ApiResponse
    {
        return $this->sendRequest($this->requestBuilder->delete($path));
    }

    /**
     * Send an HTTP request and normalise whatever comes back into an ApiResponse.
     *
     * Nothing throws out of here: transport failures and API errors alike become
     * an error ApiResponse, so callers only ever branch on isSuccess().
     */
    protected function sendRequest(HttpRequest $request): ApiResponse
    {
        $method = $request->getMethod();
        $uri    = $request->getUri();

        $parsedBody = null;
        if ($request->hasBody()) {
            $parsedBody = json_decode($request->getBody(), true) ?? $request->getBody();
        }

        $this->logRequest($method, $uri, $parsedBody);

        try {
            $response = $this->transport->send($request);
            $result   = $this->responseHandler->handle($response);

            $this->logResponse($method, $uri, $response->getStatusCode(), $result);

            return ApiResponse::fromArray($result);
        } catch (NetworkException $e) {
            $this->logError($method, $uri, $e);

            return ApiResponse::error(
                $e->getMessage(),
                'NetworkException',
                'connection_failed'
            );
        } catch (EasyDCIMException $e) {
            $this->logError($method, $uri, $e);

            $responseBody = (array) $e->getResponseBody();
            $errors       = Arr::get($responseBody, 'errors');

            return ApiResponse::error(
                $e->getMessage(),
                get_class($e),
                $e->getCode(),
                Arr::get($responseBody, 'data'),
                !empty($errors) ? (array) $errors : null
            );
        }
    }

    protected function logRequest(string $method, string $uri, $body): void
    {
        Logger::info("{$method} {$this->extractActionFromUri($uri)}", "API Request: {$method} {$uri}", [
            'method' => $method,
            'uri'    => $uri,
            'body'   => $body,
        ]);
    }

    protected function logResponse(string $method, string $uri, int $statusCode, array $result): void
    {
        $action  = $this->extractActionFromUri($uri);
        $success = Arr::get($result, 'success', true);
        $context = ['method' => $method, 'uri' => $uri, 'status_code' => $statusCode, 'response' => $result];

        if ($success === false) {
            Logger::error("{$method} {$action}", "API Response: {$method} {$uri} - {$statusCode}", $context);
            return;
        }

        Logger::info("{$method} {$action}", "API Response: {$method} {$uri} - {$statusCode}", $context);
    }

    protected function logError(string $method, string $uri, \Throwable $exception): void
    {
        Logger::error(
            "{$method} {$this->extractActionFromUri($uri)}",
            "API Error: {$method} {$uri} - {$exception->getMessage()}",
            ['method' => $method, 'uri' => $uri],
            $exception
        );
    }

    /**
     * Turn "https://host/api/v3/admin/devices/12" into "admin.devices.12" for logs.
     */
    protected function extractActionFromUri(string $uri): string
    {
        $path = parse_url($uri, PHP_URL_PATH) ?? $uri;
        $path = preg_replace('#^/api/v\d+/#', '', $path);

        return str_replace('/', '.', trim((string) $path, '/'));
    }

    /**
     * {@inheritDoc}
     */
    public function setImpersonateUser($user): self
    {
        $this->config->setImpersonateUser($user);
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function clearImpersonation(): self
    {
        $this->config->setImpersonateUser(null);
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getConfiguration(): ConfigurationInterface
    {
        return $this->config;
    }

    /**
     * {@inheritDoc}
     */
    public function getHttpClient(): object
    {
        return $this->transport;
    }

    public function getRequestBuilder(): RequestBuilder
    {
        return $this->requestBuilder;
    }

    public function getResponseHandler(): ResponseHandler
    {
        return $this->responseHandler;
    }

    public function getAuthenticator(): ?AuthenticatorInterface
    {
        return $this->authenticator;
    }

    public function setAuthenticator(?AuthenticatorInterface $authenticator): self
    {
        $this->authenticator = $authenticator;
        $this->requestBuilder->setAuthenticator($authenticator);
        return $this;
    }

    public function setToken(string $token): self
    {
        $this->config->set('token', $token);
        $this->authenticator = new BearerTokenAuthenticator($token);
        $this->requestBuilder->setAuthenticator($this->authenticator);
        return $this;
    }

    /**
     * Cached endpoint factories
     * @var array<string, object>
     */
    private array $endpointFactories = [];

    /**
     * Access admin endpoints.
     *
     * ```php
     * $locations = $client->admin()->locations()->list();
     * ```
     */
    public function admin(): AdminEndpointFactory
    {
        $this->requestBuilder->setIsClientEndpoint(false);

        if (!isset($this->endpointFactories['admin'])) {
            $this->endpointFactories['admin'] = new AdminEndpointFactory($this);
        }

        return $this->endpointFactories['admin'];
    }

    /**
     * Access client endpoints.
     *
     * Client endpoints act on behalf of an EasyDCIM user, so an impersonation
     * target must already be set - call setImpersonateUser() with the HostBill
     * client's email first, or RequestBuilder will refuse to build the request.
     *
     * ```php
     * $client->setImpersonateUser($clientEmail);
     * $services = $client->client()->services()->list();
     * ```
     */
    public function client(): ClientEndpointFactory
    {
        $this->requestBuilder->setIsClientEndpoint(true);

        if (!isset($this->endpointFactories['client'])) {
            $this->endpointFactories['client'] = new ClientEndpointFactory($this);
        }

        return $this->endpointFactories['client'];
    }

    /**
     * Access authorization endpoints.
     */
    public function authorization(): AuthorizationEndpoint
    {
        $this->requestBuilder->setIsClientEndpoint(false);

        if (!isset($this->endpointFactories['authorization'])) {
            $this->endpointFactories['authorization'] = new AuthorizationEndpoint($this);
        }

        return $this->endpointFactories['authorization'];
    }

    /**
     * Create a client straight from a HostBill server connection array.
     */
    public static function fromConnection(array $connection, ?TransportInterface $transport = null): self
    {
        return new self(Configuration::fromConnection($connection), $transport);
    }
}
