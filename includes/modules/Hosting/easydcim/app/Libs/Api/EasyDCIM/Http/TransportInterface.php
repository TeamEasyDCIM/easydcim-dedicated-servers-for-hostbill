<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Http;

/**
 * The seam a test double replaces to exercise the client without a network.
 */
interface TransportInterface
{
    public function send(HttpRequest $request): HttpResponse;
}
