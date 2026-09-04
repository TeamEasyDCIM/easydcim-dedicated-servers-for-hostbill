<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Helpers;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support\Arr;

/**
 * Which optional EasyDCIM extensions the connected instance actually has.
 *
 * Reverse DNS needs the DNS Manager addon and the access list needs the
 * Password Manager. Offering those sections when the addon is missing gives the
 * client a page that can only ever fail, so they are hidden instead.
 *
 * The answer is cached for the request. If the lookup itself fails the checker
 * says "yes" - a temporary API problem should degrade to the old behaviour, not
 * hide working features.
 */
class ExtensionChecker
{
    public const DNS_MANAGER = 'dns-manager';
    public const PASSWORD_MANAGER = 'password-manager';

    /**
     * @var array<string, mixed>|null
     */
    protected static $activeModules = null;

    protected static bool $fetchFailed = false;

    public static function isDnsManagerActive(EasyDCIMClient $api): bool
    {
        return self::isActive($api, self::DNS_MANAGER);
    }

    public static function isPasswordManagerActive(EasyDCIMClient $api): bool
    {
        return self::isActive($api, self::PASSWORD_MANAGER);
    }

    public static function isActive(EasyDCIMClient $api, string $module): bool
    {
        $modules = self::getActiveModules($api);

        if ($modules === null)
        {
            return true;
        }

        return array_key_exists($module, $modules);
    }

    /**
     * @return array<string, mixed>|null null when the instance could not be asked
     */
    protected static function getActiveModules(EasyDCIMClient $api): ?array
    {
        if (self::$fetchFailed)
        {
            return null;
        }

        if (self::$activeModules !== null)
        {
            return self::$activeModules;
        }

        try
        {
            $response = $api->admin()->system()->getSystemConfig();

            // The client turns transport and API errors into an error response
            // rather than throwing, so an unsuccessful call has to be caught
            // here - otherwise "could not ask" would read as "nothing active"
            // and quietly hide working features.
            if (Arr::get($response, 'success') !== true)
            {
                self::$fetchFailed = true;

                return null;
            }

            $modules = Arr::get($response, 'data.modules');

            // An instance that does not report its modules at all is treated
            // the same way: unknown, not empty.
            if (!is_array($modules))
            {
                self::$fetchFailed = true;

                return null;
            }

            return self::$activeModules = $modules;
        }
        catch (\Exception $e)
        {
            self::$fetchFailed = true;

            return null;
        }
    }

    /**
     * Test seam - the cache is static and would otherwise leak between cases.
     */
    public static function reset(): void
    {
        self::$activeModules = null;
        self::$fetchFailed = false;
    }
}
