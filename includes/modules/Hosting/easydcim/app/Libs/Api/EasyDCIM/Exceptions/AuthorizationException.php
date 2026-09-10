<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions;

/**
 * Exception thrown when authorization fails (HTTP 403)
 * 
 * Common scenarios:
 * - Account is inactive or banned
 * - Unauthorized admin access only
 * - User does not have appropriate rights for this action
 * - Insufficient permissions
 */
class AuthorizationException extends EasyDCIMException
{
    public function __construct(
        string $message = 'Authorization failed - insufficient permissions',
        int $code = 403,
        ?\Throwable $previous = null,
        ?array $responseBody = null,
        ?array $requestContext = null
    ) {
        parent::__construct(
            $message,
            $code,
            $previous,
            403,
            $responseBody,
            $requestContext
        );
    }
}
