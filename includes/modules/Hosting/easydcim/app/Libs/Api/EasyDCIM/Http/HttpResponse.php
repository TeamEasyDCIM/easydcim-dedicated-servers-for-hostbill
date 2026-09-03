<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Http;

/**
 * Immutable HTTP response value object.
 *
 * Exposes the subset of the PSR-7 response API that ResponseHandler relies on.
 */
class HttpResponse
{
    /**
     * @param array<string, array<int, string>> $headers
     */
    public function __construct(
        protected int $statusCode,
        protected string $body = '',
        protected array $headers = [],
        protected string $reasonPhrase = ''
    ) {
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function hasHeader(string $name): bool
    {
        return isset($this->headers[strtolower($name)]);
    }

    public function getHeaderLine(string $name): string
    {
        $name = strtolower($name);

        return isset($this->headers[$name]) ? implode(', ', $this->headers[$name]) : '';
    }
}
