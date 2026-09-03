<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions;

use Throwable;

/**
 * Base exception for all EasyDCIM API exceptions
 */
class EasyDCIMException extends \Exception
{
    /**
     * HTTP status code (if applicable)
     */
    protected ?int $statusCode = null;

    /**
     * Response body from API
     */
    protected ?array $responseBody = null;

    /**
     * Request context
     */
    protected ?array $requestContext = null;

    public function __construct(
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null,
        ?int $statusCode = null,
        ?array $responseBody = null,
        ?array $requestContext = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->statusCode = $statusCode;
        $this->responseBody = $responseBody;
        $this->requestContext = $requestContext;
    }

    /**
     * Get HTTP status code
     */
    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    /**
     * Get response body
     *
     * @return array<string, mixed>|null
     */
    public function getResponseBody(): ?array
    {
        return $this->responseBody;
    }

    /**
     * Get request context
     *
     * @return array<string, mixed>|null
     */
    public function getRequestContext(): ?array
    {
        return $this->requestContext;
    }

    /**
     * Check if this is an HTTP error
     */
    public function isHttpError(): bool
    {
        return $this->statusCode !== null && $this->statusCode >= 400;
    }

    /**
     * Check if this is a client error (4xx)
     */
    public function isClientError(): bool
    {
        return $this->statusCode !== null && $this->statusCode >= 400 && $this->statusCode < 500;
    }

    /**
     * Check if this is a server error (5xx)
     */
    public function isServerError(): bool
    {
        return $this->statusCode !== null && $this->statusCode >= 500;
    }

    /**
     * Get a formatted error message with context
     */
    public function getDetailedMessage(): string
    {
        $message = $this->getMessage();

        if ($this->statusCode !== null) {
            $message .= " [HTTP {$this->statusCode}]";
        }

        if ($this->responseBody !== null && isset($this->responseBody['message'])) {
            $message .= " - API Message: {$this->responseBody['message']}";
        }

        return $message;
    }
}
