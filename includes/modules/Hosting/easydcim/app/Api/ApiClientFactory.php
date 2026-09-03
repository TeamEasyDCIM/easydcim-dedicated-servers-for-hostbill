<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Api;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Client\Configuration;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Logger;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Interfaces\IClient;

/**
 * Builds the EasyDCIM API v3 client out of a ClientAdapter.
 *
 * ClientAdapter already resolved the base URL (scheme + host) and the API token
 * from the HostBill server record, so this only has to validate them and hand
 * the pair to Configuration.
 *
 * Client-scoped v3 endpoints (`api/v3/client/...`) act on behalf of a user and
 * require an X-Impersonate-User header. The impersonation target is set here
 * from the HostBill client's email, so callers can use $api->client()->... with
 * no further setup.
 */
class ApiClientFactory
{
    public static function fromClient(IClient $client): EasyDCIMClient
    {
        if (!$client->getServerHostname()) {
            throw new \Exception('API: Server IP and hostname is empty.');
        }

        if (!$client->getServerAPIKey()) {
            throw new \Exception('API: Server API Key is empty.');
        }

        // The product's "Debug" switch turns API request/response logging on.
        self::enableLogging(self::isDebugEnabled($client));

        $api = new EasyDCIMClient(Configuration::fromArray([
            'base_url'   => $client->getServerHostname(),
            'token'      => $client->getServerAPIKey(),
            'verify_ssl' => false,
        ]));

        $email = $client->getEmail();

        if (!empty($email)) {
            $api->setImpersonateUser($email);
        }

        return $api;
    }

    /**
     * Turn API request/response logging on for this request.
     *
     * Driven by the product's "Debug" option, so a live installation stays quiet.
     */
    public static function enableLogging(bool $enabled = true): void
    {
        Logger::enable($enabled);
    }

    /**
     * Not every context carries a product configuration - the server-level
     * connection test, for one - so a missing flag simply means "off".
     */
    protected static function isDebugEnabled(IClient $client): bool
    {
        if (!method_exists($client, 'getBaseFeatures')) {
            return false;
        }

        $features = $client->getBaseFeatures();

        return is_array($features) && !empty($features['debug']);
    }
}
