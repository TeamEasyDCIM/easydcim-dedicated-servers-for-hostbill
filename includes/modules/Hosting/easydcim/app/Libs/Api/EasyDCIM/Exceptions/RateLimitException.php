<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions;

/**
 * Exception thrown when rate limit is exceeded (HTTP 429)
 * 
 * Common scenarios:
 * - Too many requests in a given time period
 * - API quota exceeded
 * - Need to wait before retrying
 */
class RateLimitException extends EasyDCIMException
{
    /**
     * Number of seconds to wait before retrying
     */
    protected ?int $retryAfter = null;

    /**
     * Current rate limit
     */
    protected ?int $rateLimit = null;

    /**
     * Remaining requests in current window
     */
    protected ?int $remaining = null;

    public function __construct(
        string $message = 'Rate limit exceeded',
        int $code = 429,
        ?\Throwable $previous = null,
        ?array $responseBody = null,
        ?array $requestContext = null,
        ?int $retryAfter = null,
        ?int $rateLimit = null,
        ?int $remaining = null
    ) {
        parent::__construct(
            message: $message,
            code: $code,
            previous: $previous,
            statusCode: 429,
            responseBody: $responseBody,
            requestContext: $requestContext
        );
        $this->retryAfter = $retryAfter;
        $this->rateLimit = $rateLimit;
        $this->remaining = $remaining;
    }

    /**
     * Get the number of seconds to wait before retrying
     */
    public function getRetryAfter(): ?int
    {
        return $this->retryAfter;
    }

    /**
     * Get the rate limit
     */
    public function getRateLimit(): ?int
    {
        return $this->rateLimit;
    }

    /**
     * Get remaining requests in current window
     */
    public function getRemaining(): ?int
    {
        return $this->remaining;
    }
}
