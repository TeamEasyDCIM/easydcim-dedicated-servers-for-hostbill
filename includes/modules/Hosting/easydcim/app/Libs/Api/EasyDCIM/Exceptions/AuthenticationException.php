<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions;

/**
 * Exception thrown when authentication fails (HTTP 401)
 * 
 * Common scenarios:
 * - Missing bearer token
 * - Invalid bearer token
 * - Token expired
 * - Token not provided
 */
class AuthenticationException extends EasyDCIMException
{
    public function __construct(
        string $message = 'Authentication failed',
        int $code = 401,
        ?\Throwable $previous = null,
        ?array $responseBody = null,
        ?array $requestContext = null
    ) {
        parent::__construct(
            $message,
            $code,
            $previous,
            401,
            $responseBody,
            $requestContext
        );
    }
}
