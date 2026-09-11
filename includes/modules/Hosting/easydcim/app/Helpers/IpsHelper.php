<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Helpers;

/**
 * The WHMCS module's IpsHelper (App\Support\Helpers\IpsHelper) for PHP 7.4:
 * which addresses of a service can carry a reverse DNS record.
 */
class IpsHelper
{
    /**
     * Usable addresses: single IPv4 addresses as given, IPv4 subnets without the
     * network, gateway and broadcast address, touching ranges merged into
     * "first–last"; anything that is not IPv4 follows unchanged.
     */
    public static function listUsableIPsFromArray($ipArray): array
    {
        $ipv4Ranges = [];
        $nonIpv4 = [];

        foreach ($ipArray as $ipRange) {
            if (strpos($ipRange, '/') !== false) {
                list($network, $mask) = explode('/', $ipRange);

                if (strpos($network, ':') === false) {
                    $longMask = -1 << (32 - intval($mask));
                    $startIP = ip2long($network) & $longMask;
                    $endIP = $startIP | (~$longMask & 0xFFFFFFFF);
                    $usableStart = $startIP + 2; // skip network + gateway
                    $usableEnd = $endIP - 1;     // skip broadcast

                    if ($usableStart <= $usableEnd) {
                        $ipv4Ranges[] = [$usableStart, $usableEnd];
                    }
                } else {
                    $nonIpv4[] = $ipRange;
                }
            } else {
                $long = ip2long($ipRange);
                if ($long !== false) {
                    $ipv4Ranges[] = [$long, $long];
                } else {
                    $nonIpv4[] = $ipRange;
                }
            }
        }

        usort($ipv4Ranges, function ($a, $b) {
            return $a[0] <=> $b[0];
        });

        $merged = [];
        foreach ($ipv4Ranges as list($start, $end)) {
            if (!empty($merged) && $start <= end($merged)[1] + 1) {
                $merged[count($merged) - 1][1] = max(end($merged)[1], $end);
            } else {
                $merged[] = [$start, $end];
            }
        }

        $ranges = [];
        foreach ($merged as list($start, $end)) {
            $ranges[] = $start === $end
                ? long2ip($start)
                : long2ip($start) . '–' . long2ip($end);
        }

        return array_merge($ranges, $nonIpv4);
    }

    /**
     * Whether an address is one of the service's: equal to a listed address, or a
     * usable address of a listed IPv4 subnet.
     */
    public static function isIpInPool(string $ip, array $rawIpArray): bool
    {
        $long = ip2long($ip);

        foreach ($rawIpArray as $ipRange) {
            $ipRange = trim($ipRange);

            if (empty($ipRange)) {
                continue;
            }

            if (strpos($ipRange, '/') !== false) {
                list($network, $mask) = explode('/', $ipRange, 2);

                if ($long !== false && strpos($network, ':') === false) {
                    $longMask = -1 << (32 - intval($mask));
                    $startIP = ip2long($network) & $longMask;
                    $endIP = $startIP | (~$longMask & 0xFFFFFFFF);
                    $usableStart = $startIP + 2;
                    $usableEnd = $endIP - 1;

                    if ($usableStart <= $usableEnd && $long >= $usableStart && $long <= $usableEnd) {
                        return true;
                    }
                }
            } else {
                if ($long !== false && ip2long($ipRange) === $long) {
                    return true;
                }

                if ($long === false && $ip === $ipRange) {
                    return true;
                }
            }
        }

        return false;
    }
}
