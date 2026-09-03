<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions;

/**
 * Exception thrown when server error occurs (HTTP 5xx)
 * 
 * Common scenarios:
 * - Internal server error (500)
 * - Bad gateway (502)
 * - Service unavailable (503)
 * - Gateway timeout (504)
 */
class ServerException extends EasyDCIMException
{
    public function __construct(
        string $message = 'Server error occurred',
        int $code = 500,
        ?\Throwable $previous = null,
        ?int $statusCode = 500,
        ?array $responseBody = null,
        ?array $requestContext = null
    ) {
        parent::__construct(
            message: $message,
            code: $code,
            previous: $previous,
            statusCode: $statusCode,
            responseBody: $responseBody,
            requestContext: $requestContext
        );
    }
}
