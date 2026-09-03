<?php



namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Base class for all API response wrappers.
 *
 * Provides the standard success/status/message/error/errors fields and helpers.
 * Subclasses add their own typed $data / $meta properties and override
 * fromArray() / toArray() to handle them.
 */
class BaseResponse
{
    public function __construct(
        public ?bool $success = null,
        public ?string $status = null,
        public ?string $message = null,
        public array $error = [],
        public ?array $errors = null,
    ) {}

    /**
     * @param array<string, mixed> $response
     * @return static
     */
    public static function fromArray(array $response): static
    {
        $errors = Arr::get($response, 'errors');

        return new static(
            success: Arr::get($response, 'success', false),
            status:  Arr::get($response, 'status', ''),
            message: Arr::get($response, 'message', ''),
            error:   (array) (Arr::get($response, 'error') ?? []),
            errors:  is_array($errors) ? $errors : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = [
            'success' => $this->success,
            'status'  => $this->status,
            'message' => $this->message,
        ];

        if (!empty($this->error)) {
            $result['error'] = $this->error;
        }

        if ($this->errors !== null) {
            $result['errors'] = $this->errors;
        }

        return $result;
    }

    /**
     * Whether the response contains field-level validation errors.
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Get field-level validation errors.
     *
     * @return array<string, array<string>>|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Flat human-readable summary of validation errors.
     *
     * Example: "type: The selected type is invalid.; name: The name field is required."
     */
    public function getErrorsSummary(): string
    {
        if (empty($this->errors)) {
            return '';
        }

        $parts = [];
        foreach ($this->errors as $field => $messages) {
            $parts[] = $field . ': ' . implode(', ', (array) $messages);
        }

        return implode('; ', $parts);
    }
}