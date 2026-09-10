<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Client;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\AuthenticationException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\AuthorizationException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\EasyDCIMException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\NotFoundException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\RateLimitException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\ServerException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\ValidationException;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Http\HttpResponse;

/**
 * Handles API response parsing and error handling
 * 
 * Standard EasyDCIM API Response Format:
 * {
 *   "success": true,
 *   "status": "success",
 *   "message": "success",
 *   "data": { ... }
 * }
 */
class ResponseHandler
{
    /**
     * Handle the HTTP response
     *
     * @param HttpResponse $response
     * @return array<string, mixed>
     * @throws EasyDCIMException
     */
    public function handle(HttpResponse $response): array
    {
        $statusCode = $response->getStatusCode();
        $body = $response->getBody();

        // Check for HTTP errors
        if ($statusCode >= 400) {
            $this->handleError($response, $body);
        }

        // Parse JSON response
        $data = $this->parseJson($body);

        // Check API-level success
        // Note: If 'success' field is missing, we assume success (backwards compatibility)
        // If 'success' field exists and is explicitly false, treat as error
        $success = Arr::get($data, 'success');
        if ($success === false) {
            $this->handleApiError($data, $statusCode);
        }

        return $data;
    }

    /**
     * Handle HTTP error responses
     *
     * @param HttpResponse $response
     * @param string $body
     * @throws EasyDCIMException
     */
    protected function handleError(HttpResponse $response, string $body): void
    {
        $statusCode = $response->getStatusCode();
        $data = $this->parseJson($body);
        
        $message = $this->extractErrorMessage($data, $statusCode);
        $requestContext = $this->buildRequestContext($response);

        switch (true) {
            case $statusCode === 401:
                throw new AuthenticationException($message, 401, null, $data, $requestContext);
            case $statusCode === 403:
                throw new AuthorizationException($message, 403, null, $data, $requestContext);
            case $statusCode === 404:
                throw new NotFoundException($message, 404, null, $data, $requestContext);
            case $statusCode === 422:
                throw new ValidationException($message, 422, null, $data, $requestContext, (array) (Arr::get($data, 'errors') ?? []));
            case $statusCode === 429:
                throw new RateLimitException($message, 429, null, $data, $requestContext, $this->extractRetryAfter($response), $this->extractRateLimit($response), $this->extractRateLimitRemaining($response));
            case $statusCode >= 500:
                throw new ServerException($message, 500, null, $statusCode, $data, $requestContext);
            default:
                throw new EasyDCIMException($message, 0, null, $statusCode, $data, $requestContext);
        }
    }

    /**
     * Handle API-level errors (when success=false)
     *
     * @param array<string, mixed> $data
     * @param int $statusCode
     * @throws EasyDCIMException
     */
    protected function handleApiError(array $data, int $statusCode): void
    {
        $message = Arr::get($data, 'message', 'API request failed');

        throw new EasyDCIMException($message, 0, null, $statusCode, $data);
    }

    /**
     * Parse JSON response body
     *
     * @param string $body
     * @return array<string, mixed>
     */
    protected function parseJson(string $body): array
    {
        if (empty($body)) {
            return [];
        }

        try {
            $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
            return is_array($data) ? $data : [];
        } catch (\JsonException $e) {
            return [
                'success' => false,
                'message' => 'Failed to parse JSON response',
                'raw_body' => $body,
            ];
        }
    }

    /**
     * Extract error message from response data
     *
     * @param array<string, mixed> $data
     * @param int $statusCode
     * @return string
     */
    protected function extractErrorMessage(array $data, int $statusCode): string
    {
        // Try to get message from response
        $message = Arr::get($data, 'message');
        if (is_string($message) && !empty($message)) {
            return $message;
        }

        // Try to get error from response
        $error = Arr::get($data, 'error');
        if (is_string($error) && !empty($error)) {
            return $error;
        }

        // Fallback to HTTP status code message
        return $this->getHttpStatusMessage($statusCode);
    }

    /**
     * Get HTTP status message
     *
     * @param int $statusCode
     * @return string
     */
    protected function getHttpStatusMessage(int $statusCode): string
    {
        $messages = [
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            422 => 'Unprocessable Entity',
            429 => 'Too Many Requests',
            500 => 'Internal Server Error',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
        ];

        return $messages[$statusCode] ?? "HTTP Error {$statusCode}";
    }

    /**
     * Build request context for exception
     *
     * @param HttpResponse $response
     * @return array<string, mixed>
     */
    protected function buildRequestContext(HttpResponse $response): array
    {
        return [
            'status_code' => $response->getStatusCode(),
            'reason_phrase' => $response->getReasonPhrase(),
            'headers' => $response->getHeaders(),
        ];
    }

    /**
     * Extract Retry-After header value
     *
     * @param HttpResponse $response
     * @return int|null
     */
    protected function extractRetryAfter(HttpResponse $response): ?int
    {
        if ($response->hasHeader('Retry-After')) {
            $value = $response->getHeaderLine('Retry-After');
            return is_numeric($value) ? (int) $value : null;
        }
        return null;
    }

    /**
     * Extract rate limit from headers
     *
     * @param HttpResponse $response
     * @return int|null
     */
    protected function extractRateLimit(HttpResponse $response): ?int
    {
        $headers = ['X-RateLimit-Limit', 'RateLimit-Limit', 'X-Rate-Limit'];
        
        foreach ($headers as $header) {
            if ($response->hasHeader($header)) {
                $value = $response->getHeaderLine($header);
                return is_numeric($value) ? (int) $value : null;
            }
        }
        
        return null;
    }

    /**
     * Extract remaining rate limit from headers
     *
     * @param HttpResponse $response
     * @return int|null
     */
    protected function extractRateLimitRemaining(HttpResponse $response): ?int
    {
        $headers = ['X-RateLimit-Remaining', 'RateLimit-Remaining', 'X-Rate-Remaining'];
        
        foreach ($headers as $header) {
            if ($response->hasHeader($header)) {
                $value = $response->getHeaderLine($header);
                return is_numeric($value) ? (int) $value : null;
            }
        }
        
        return null;
    }

    /**
     * Extract data from standard API response format
     *
     * @param array<string, mixed> $response
     * @return mixed
     */
    public function extractData(array $response)
    {
        // If response has 'data' key, return it
        return Arr::get($response, 'data', $response);
    }

    /**
     * Check if response was successful
     *
     * @param array<string, mixed> $response
     * @return bool
     */
    public function isSuccessful(array $response): bool
    {
        return Arr::get($response, 'success', true) === true;
    }

    /**
     * Get message from response
     *
     * @param array<string, mixed> $response
     * @return string|null
     */
    public function getMessage(array $response): ?string
    {
        return Arr::get($response, 'message');
    }
}
