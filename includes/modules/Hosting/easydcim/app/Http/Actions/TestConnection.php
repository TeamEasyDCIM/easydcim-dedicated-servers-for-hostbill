<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Http\Actions;

use ModulesGarden\Servers\EasyDCIMv2\App\Api\ApiClientFactory;
use ModulesGarden\Servers\EasyDCIMv2\App\Api\EasyDCIMConfigFactory;

class TestConnection
{
    protected $module;

    protected $client;

    public function __construct($module)
    {
        $this->module = $module;
        $this->client = (new EasyDCIMConfigFactory())->fromParams($this->module->connection);
    }

    /**
     * Probe the API v3 health-check endpoint.
     *
     * Reaching it at all proves the base URL resolves and the bearer token is
     * accepted, which is what "test connection" needs to establish.
     */
    public function execute(): string
    {
        $api = ApiClientFactory::fromClient($this->client);

        $response = $api->admin()->system()->healthCheck();

        if (($response['success'] ?? false) === true) {
            return 'success';
        }

        $message = $response['message'] ?? 'Unknown API error';

        throw new \Exception('EasyDCIM API Error: ' . $message);
    }
}
