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
     * @param string|null $startDate custom range start: a date, or a date and time
     * @param string|null $endDate   custom range end
     * @return array{start: int, end: int}
     */
    public static function resolve(string $interval, ?string $startDate = null, ?string $endDate = null): array
    {
        if ($interval === self::CUSTOM && !empty($startDate) && !empty($endDate))
        {
            // [moment, has a time of day] - the pickers send a date, or a date and time as WHMCS does
            $from = [Carbon::parse($startDate), strpos($startDate, ':') !== false];
            $to   = [Carbon::parse($endDate), strpos($endDate, ':') !== false];

            // Tolerate the two being picked the wrong way round.
            if ($to[0]->lessThan($from[0]))
            {
                list($from, $to) = [$to, $from];
            }

            // A bare date covers its whole day; a date with a time is taken as given.
            $start = $from[1] ? $from[0] : $from[0]->startOfDay();
            $end   = $to[1] ? $to[0] : $to[0]->endOfDay();

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
