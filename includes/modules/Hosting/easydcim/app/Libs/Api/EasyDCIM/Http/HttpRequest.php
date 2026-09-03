<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Http;

/**
 * Immutable HTTP request value object.
 *
 * Stands in for the PSR-7 request the WHMCS build passes to Guzzle. HostBill
 * modules cannot rely on Guzzle or psr/http-message being autoloadable, so the
 * client carries its own request/response pair and talks cURL directly.
 */
class HttpRequest
{
    public function __construct(
        protected string $method,
        protected string $uri,
        protected array $headers = [],
        protected ?string $body = null
    ) {
        $this->method = strtoupper($method);
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return array<string, string>
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getBody(): string
    {
        return (string) $this->body;
    }

    public function hasBody(): bool
    {
        return $this->body !== null && $this->body !== '';
    }

    /**
     * Headers in the "Name: value" form cURL expects.
     *
     * @return array<int, string>
     */
    public function getHeaderLines(): array
    {
        $lines = [];

        foreach ($this->headers as $name => $value) {
            $lines[] = $name . ': ' . $value;
        }

        return $lines;
    }
}
