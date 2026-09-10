<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions;

/**
 * Exception thrown when request validation fails (HTTP 422)
 * 
 * Common scenarios:
 * - Invalid request data
 * - Missing required fields
 * - Data type mismatches
 * - Business rule violations
 */
class ValidationException extends EasyDCIMException
{
    /**
     * Validation errors
     *
     * @var array<string, array<string>>
     */
    protected array $errors = [];

    public function __construct(
        string $message = 'Validation failed',
        int $code = 422,
        ?\Throwable $previous = null,
        ?array $responseBody = null,
        ?array $requestContext = null,
        array $errors = []
    ) {
        parent::__construct(
            $message,
            $code,
            $previous,
            422,
            $responseBody,
            $requestContext
        );
        $this->errors = $errors;
    }

    /**
     * Get validation errors
     *
     * @return array<string, array<string>>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Check if there are validation errors
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Get errors for a specific field
     *
     * @param string $field Field name
     * @return array<string>
     */
    public function getFieldErrors(string $field): array
    {
        return $this->errors[$field] ?? [];
    }
}
