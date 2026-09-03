<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support;

/**
 * Lightweight logger for the API client.
 *
 * The WHMCS build logs through the module framework's logging service. HostBill
 * modules have no equivalent, so requests and responses are written to the PHP
 * error log and only while logging has been switched on - which the module does
 * from the product's "Debug" option.
 */
class Logger
{
    protected static bool $enabled = false;

    public static function enable(bool $enabled = true): void
    {
        self::$enabled = $enabled;
    }

    public static function isEnabled(): bool
    {
        return self::$enabled;
    }

    public static function info(string $action, string $message, array $context = []): void
    {
        self::write('INFO', $action, $message, $context);
    }

    public static function warning(string $action, string $message, array $context = []): void
    {
        self::write('WARNING', $action, $message, $context);
    }

    public static function error(string $action, string $message, array $context = [], ?\Throwable $exception = null): void
    {
        if ($exception !== null) {
            $context['exception'] = $exception->getMessage();
        }

        self::write('ERROR', $action, $message, $context);
    }

    protected static function write(string $level, string $action, string $message, array $context): void
    {
        if (!self::$enabled) {
            return;
        }

        $encoded = json_encode(self::mask($context));

        error_log(sprintf('[EasyDCIM][%s][%s] %s %s', $level, $action, $message, $encoded === false ? '' : $encoded));
    }

    /**
     * Never let credentials reach the log.
     */
    protected static function mask(array $context): array
    {
        $secrets = ['password', 'password_confirmation', 'root_password', 'token', 'apikey', 'api_key'];

        array_walk_recursive($context, static function (&$value, $key) use ($secrets) {
            if (is_string($key) && in_array(strtolower($key), $secrets, true)) {
                $value = '***';
            }
        });

        return $context;
    }
}
