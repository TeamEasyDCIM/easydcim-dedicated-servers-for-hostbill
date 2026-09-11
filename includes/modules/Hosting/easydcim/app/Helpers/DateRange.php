<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Helpers;

use Carbon\Carbon;

/**
 * Start/end timestamps for the period pickers on the graph, bandwidth and
 * sensor views: the WHMCS module's preset periods plus a custom date range.
 *
 * Each bound comes from its own copy of "now" - Carbon mutates in place.
 */
class DateRange
{
    public const CUSTOM = 'custom';

    /**
     * @param string      $interval  td, yd, tw, lw, tm, lm, ty, ly or "custom"
     * @param string|null $startDate custom range start, any date Carbon parses
     * @param string|null $endDate   custom range end
     * @return array{start: int, end: int}
     */
    public static function resolve(string $interval, ?string $startDate = null, ?string $endDate = null): array
    {
        if ($interval === self::CUSTOM && !empty($startDate) && !empty($endDate))
        {
            $start = Carbon::parse($startDate)->startOfDay();
            $end   = Carbon::parse($endDate)->endOfDay();

            // Tolerate the two dates being picked the wrong way round.
            if ($end->lessThan($start))
            {
                $later = $start->copy();
                $start = $end->copy()->startOfDay();
                $end   = $later->endOfDay();
            }

            return ['start' => $start->timestamp, 'end' => $end->timestamp];
        }

        $now = Carbon::now();

        switch ($interval)
        {
            case 'yd':
                $start = $now->copy()->subDay()->startOfDay();
                $end   = $now->copy()->subDay()->endOfDay();
                break;
            case 'tw':
                $start = $now->copy()->startOfWeek();
                $end   = $now->copy()->endOfWeek();
                break;
            case 'lw':
                $start = $now->copy()->subWeek()->startOfWeek();
                $end   = $now->copy()->subWeek()->endOfWeek();
                break;
            case 'tm':
                $start = $now->copy()->startOfMonth();
                $end   = $now->copy()->endOfMonth();
                break;
            case 'lm':
                $start = $now->copy()->subMonth()->startOfMonth();
                $end   = $now->copy()->subMonth()->endOfMonth();
                break;
            case 'ty':
                $start = $now->copy()->startOfYear();
                $end   = $now->copy()->endOfYear();
                break;
            case 'ly':
                $start = $now->copy()->subYear()->startOfYear();
                $end   = $now->copy()->subYear()->endOfYear();
                break;
            default:
                $start = $now->copy()->startOfDay();
                $end   = $now->copy()->endOfDay();
                break;
        }

        return ['start' => $start->timestamp, 'end' => $end->timestamp];
    }
}
