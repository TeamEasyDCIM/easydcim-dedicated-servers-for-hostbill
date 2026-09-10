<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions;

/**
 * Exception thrown when a resource is not found (HTTP 404)
 * 
 * Common scenarios:
 * - Requested resource does not exist
 * - Invalid endpoint path
 * - Resource has been deleted
 */
class NotFoundException extends EasyDCIMException
{
    public function __construct(
        string $message = 'Requested resource not found',
        int $code = 404,
        ?\Throwable $previous = null,
        ?array $responseBody = null,
        ?array $requestContext = null
    ) {
        parent::__construct(
            $message,
            $code,
            $previous,
            404,
            $responseBody,
            $requestContext
        );
    }
}
