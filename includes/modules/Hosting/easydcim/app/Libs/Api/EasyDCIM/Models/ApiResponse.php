<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Standardized API Response
 *
 * Provides a consistent response structure for all API calls.
 * All API methods return this object instead of raw arrays.
 *
 * Implements ArrayAccess for backward compatibility with code that uses array syntax.
 *
 * @package ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models
 */
class ApiResponse implements \ArrayAccess
{
    public bool $success;
    public string $status;
    public string $message;
    public $data;
    public ?array $error;
    public ?array $errors;
    public ?array $meta;
    /**
     * @param bool $success Whether the request was successful
     * @param string $status Status code/message (success, error, etc.)
     * @param string $message Human-readable message
     * @param mixed $data Response data (can be array, object, null)
     * @param array<string, mixed>|null $error Error details if failed
     * @param array<string, array<string>>|null $errors Field-level validation errors (e.g. ['type' => ['The selected type is invalid.']])
     * @param array<string, mixed>|null $meta Metadata (pagination, etc.)
     */
    public function __construct(bool $success, string $status, string $message, $data = null, ?array $error = null, ?array $errors = null, ?array $meta = null)
    {
        $this->success = $success;
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
        $this->error = $error;
        $this->errors = $errors;
        $this->meta = $meta;
    }

    /**
     * Create response from array
     *
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['success'] ?? true,
            $data['status'] ?? 'success',
            $data['message'] ?? '',
            $data['data'] ?? null,
            $data['error'] ?? null,
            isset($data['errors']) && is_array($data['errors']) ? $data['errors'] : null,
            $data['meta'] ?? null
        );
    }

    /**
     * Create successful response
     *
     * @param mixed $data
     * @param string $message
     * @param array<string, mixed>|null $meta
     * @return self
     */
    public static function success($data = null, string $message = 'Success', ?array $meta = null): self
    {
        return new self(true, 'success', $message, $data, null, null, $meta);
    }

    /**
     * Create error response
     *
     * @param string $message
     * @param string|null $errorType
     * @param string|int|null $errorCode
     * @param mixed $data
     * @return self
     */
    public static function error(
        string $message,
        ?string $errorType = null,
        $errorCode = null,
        $data = null,
        ?array $errors = null
    ): self {
        $error = [];
        if ($errorType !== null) {
            $error['type'] = $errorType;
        }
        if ($errorCode !== null) {
            $error['code'] = $errorCode;
        }

        return new self(
            false,
            'error',
            $message,
            $data,
            !empty($error) ? $error : null,
            $errors,
            null
        );
    }

    /**
     * Check if response was successful
     *
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success === true;
    }

    /**
     * Check if response was an error
     *
     * @return bool
     */
    public function isError(): bool
    {
        return $this->success === false;
    }

    /**
     * Check if response has data
     *
     * @return bool
     */
    public function hasData(): bool
    {
        return $this->data !== null;
    }

    /**
     * Check if response has error details
     *
     * @return bool
     */
    public function hasError(): bool
    {
        return $this->error !== null;
    }

    /**
     * Check if response has field-level validation errors
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Get field-level validation errors
     *
     * @return array<string, array<string>>|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Get validation errors as a flat human-readable string
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

    /**
     * Check if response has metadata
     *
     * @return bool
     */
    public function hasMeta(): bool
    {
        return $this->meta !== null;
    }

    /**
     * Get error type
     *
     * @return string|null
     */
    public function getErrorType(): ?string
    {
        if ($this->error === null) {
            return null;
        }
        return $this->error['type'] ?? null;
    }

    /**
     * Get error code
     *
     * @return string|int|null
     */
    public function getErrorCode()
    {
        if ($this->error === null) {
            return null;
        }
        return $this->error['code'] ?? null;
    }

    /**
     * Get data or default value
     *
     * @param mixed $default
     * @return mixed
     */
    public function getData($default = null)
    {
        return $this->data ?? $default;
    }

    /**
     * Convert to array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = [
            'success' => $this->success,
            'status' => $this->status,
            'message' => $this->message,
        ];

        if ($this->data !== null) {
            $result['data'] = $this->data;
        }

        if ($this->error !== null) {
            $result['error'] = $this->error;
        }

        if ($this->errors !== null) {
            $result['errors'] = $this->errors;
        }

        if ($this->meta !== null) {
            $result['meta'] = $this->meta;
        }

        return $result;
    }

    /**
     * Magic method to check if property exists
     *
     * @param string $name
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return isset($this->$name);
    }

    /**
     * Convert to JSON string
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * Get string representation
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }

    /**
     * ArrayAccess: Check if offset exists
     *
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        $array = $this->toArray();
        return Arr::has($array, $offset);
    }

    /**
     * ArrayAccess: Get offset value
     *
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        $array = $this->toArray();
        return Arr::get($array, $offset);
    }

    /**
     * ArrayAccess: Set offset value (not allowed)
     *
     * @param mixed $offset
     * @param mixed $value
     * @return void
     * @throws \RuntimeException
     */
    public function offsetSet($offset, $value): void
    {
        throw new \RuntimeException('ApiResponse is immutable and cannot be modified');
    }

    /**
     * ArrayAccess: Unset offset (not allowed)
     *
     * @param mixed $offset
     * @return void
     * @throws \RuntimeException
     */
    public function offsetUnset($offset): void
    {
        throw new \RuntimeException('ApiResponse is immutable and cannot be modified');
    }
}
