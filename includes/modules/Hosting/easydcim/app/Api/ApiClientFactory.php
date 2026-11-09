<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Api;

use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\EasyDCIMUserBinding;
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
 * require an X-Impersonate-User header. The impersonation target is the
 * EasyDCIM user ID linked to the account (account detail "EasyDCIM Client ID",
 * see EasyDCIMUserBinding), so callers can use $api->client()->... with no
 * further setup. It is never derived from the HostBill client e-mail, which
 * clients can change themselves. With no linked user nothing is set and client
 * calls fail closed (RequestBuilder refuses them).
 */
class ApiClientFactory
{
    /**
     * @param object|null $module the module instance loaded for the account, when
     *                            one is in scope. Only then may an account that is
     *                            not linked yet be linked from its order owner.
     */
    public static function fromClient(IClient $client, $module = null): EasyDCIMClient
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

        $easydcimUserId = self::resolveImpersonatedUser($client, $api, $module);

        if ($easydcimUserId !== null) {
            $api->setImpersonateUser($easydcimUserId);
        }

        return $api;
    }

    /**
     * EasyDCIM user to impersonate for the account the adapter was built for, or
     * null outside an account context (server-level calls, cron).
     *
     * Without a module instance the stored binding is only read: writing it
     * behind the back of a module that later saves its own details would be
     * undone by that save.
     */
    protected static function resolveImpersonatedUser(IClient $client, EasyDCIMClient $api, $module = null): ?int
    {
        $accountId = (int) $client->getAccountID();

        if ($accountId <= 0) {
            return null;
        }

        try {
            $userId = EasyDCIMUserBinding::parseId(method_exists($client, 'getEasyClientID') ? $client->getEasyClientID() : null);

            if ($userId !== null) {
                return $userId;
            }

            return $module !== null
                ? EasyDCIMUserBinding::resolveForAccount($accountId, $api, $module)
                : EasyDCIMUserBinding::getForAccount($accountId);
        } catch (\Throwable $e) {
            error_log('[EasyDCIM] Could not resolve the EasyDCIM user of account #' . $accountId . ': ' . $e->getMessage());

            return null;
        }
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
