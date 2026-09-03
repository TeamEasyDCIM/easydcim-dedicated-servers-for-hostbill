<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Support;

/**
 * Minimal dot-notation array helper.
 *
 * The WHMCS build of this library leans on Illuminate\Support\Arr. HostBill does
 * not guarantee Illuminate is autoloadable from a module, and this module ships
 * no vendor dependencies, so the two methods the API library actually uses
 * (get/has) are implemented here instead.
 */
class Arr
{
    /**
     * Read a value out of an array using "dot" notation.
     *
     * @param array|\ArrayAccess $array
     * @param string|int|null    $key
     * @param mixed              $default
     * @return mixed
     */
    public static function get($array, $key, $default = null)
    {
        if (!is_array($array) && !$array instanceof \ArrayAccess) {
            return $default;
        }

        if ($key === null) {
            return $array;
        }

        if (self::exists($array, $key)) {
            return $array[$key];
        }

        if (!is_string($key) || strpos($key, '.') === false) {
            return $default;
        }

        foreach (explode('.', $key) as $segment) {
            if (!self::accessible($array) || !self::exists($array, $segment)) {
                return $default;
            }
            $array = $array[$segment];
        }

        return $array;
    }

    /**
     * @param array|\ArrayAccess $array
     * @param string|int|null    $key
     */
    public static function has($array, $key): bool
    {
        if (!self::accessible($array) || $key === null) {
            return false;
        }

        if (self::exists($array, $key)) {
            return true;
        }

        if (!is_string($key) || strpos($key, '.') === false) {
            return false;
        }

        foreach (explode('.', $key) as $segment) {
            if (!self::accessible($array) || !self::exists($array, $segment)) {
                return false;
            }
            $array = $array[$segment];
        }

        return true;
    }

    protected static function accessible($value): bool
    {
        return is_array($value) || $value instanceof \ArrayAccess;
    }

    protected static function exists($array, $key): bool
    {
        if ($array instanceof \ArrayAccess) {
            return $array->offsetExists($key);
        }

        return is_array($array) && array_key_exists($key, $array);
    }
}
