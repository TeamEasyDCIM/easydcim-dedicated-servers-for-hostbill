<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions;

/**
 * Exception thrown when network/connection issues occur
 * 
 * Common scenarios:
 * - Connection timeout
 * - DNS resolution failed
 * - SSL/TLS errors
 * - Network unreachable
 * - Connection refused
 */
class NetworkException extends EasyDCIMException
{
    public function __construct(
        string $message = 'Network error occurred',
        int $code = 0,
        ?\Throwable $previous = null,
        ?array $requestContext = null
    ) {
        parent::__construct(
            $message,
            $code,
            $previous,
            null,
            null,
            $requestContext
        );
    }
}
