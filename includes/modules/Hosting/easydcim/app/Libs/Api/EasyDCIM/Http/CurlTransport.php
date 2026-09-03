<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Http;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Exceptions\NetworkException;

/**
 * cURL implementation of the HTTP transport.
 *
 * Replaces GuzzleHttp\Client from the WHMCS build. A connection or transport
 * level failure raises a NetworkException; every HTTP status code - including
 * 4xx and 5xx - comes back as a response for ResponseHandler to classify.
 */
class CurlTransport implements TransportInterface
{
    public function __construct(
        protected int $timeout = 30,
        protected int $connectTimeout = 10,
        protected bool $verifySsl = false
    ) {
    }

    public function send(HttpRequest $request): HttpResponse
    {
        $curl = curl_init();

        if ($curl === false) {
            throw new NetworkException('Failed to initialise cURL');
        }

        $headers = [];

        $options = [
            CURLOPT_URL            => $request->getUri(),
            CURLOPT_CUSTOMREQUEST  => $request->getMethod(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT        => $this->timeout,
            CURLOPT_CONNECTTIMEOUT => $this->connectTimeout,
            CURLOPT_SSL_VERIFYPEER => $this->verifySsl,
            CURLOPT_SSL_VERIFYHOST => $this->verifySsl ? 2 : 0,
            CURLOPT_HTTPHEADER     => $request->getHeaderLines(),
            CURLOPT_HEADERFUNCTION => static function ($handle, $line) use (&$headers) {
                $length = strlen($line);
                $parts  = explode(':', $line, 2);

                if (count($parts) === 2) {
                    $headers[strtolower(trim($parts[0]))][] = trim($parts[1]);
                }

                return $length;
            },
        ];

        if ($request->hasBody()) {
            $options[CURLOPT_POSTFIELDS] = $request->getBody();
        }

        curl_setopt_array($curl, $options);

        $body = curl_exec($curl);

        if ($body === false) {
            $error = curl_error($curl);
            $errno = curl_errno($curl);
            curl_close($curl);

            throw new NetworkException(
                sprintf('Connection failed: %s', $error !== '' ? $error : 'unknown cURL error'),
                $errno
            );
        }

        $statusCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return new HttpResponse($statusCode, (string) $body, $headers);
    }
}
