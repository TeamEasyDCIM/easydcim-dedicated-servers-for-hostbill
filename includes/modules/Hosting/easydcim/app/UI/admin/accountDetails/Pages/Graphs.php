<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages;

use Carbon\Carbon;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Graph\ExportGraphRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Interfaces\IClient;

class Graphs
{
    /**
     * What EasyDCIM calls the thing the graph is drawn for.
     */
    protected const TARGET_DEVICE = 'device';

    /**
     * @var EasyDCIMClient
     */
    protected $api;

    /**
     * @var IClient
     */
    protected $client;

    public function __construct($api, $client)
    {
        $this->api = $api;
        $this->client = $client;
    }

    public function manageEasyDCIMGraphs($getParams)
    {
        try {
            $deviceId = $this->client->getEasyServerID();

            if (empty($deviceId)) {
                self::jsonEncode(['labels' => [], 'datasets' => []]);
            }

            $dates = $this->getStartAndEndDateTimestamps($getParams['interval']);

            $graphData = $this->api->admin()->graphs()->export($deviceId, new ExportGraphRequest(
                type: $getParams['graphs'],
                target: self::TARGET_DEVICE,
                start: (string) $dates['start'],
                end: (string) $dates['end'],
                raw: false
            ));

            $data = $graphData->toArray();
            $data['unit'] = $this->getDateUnitForLabels((array) $graphData->labels);

            self::jsonEncode($data);
        } catch (\RuntimeException $e) {
        }
    }

    public static function jsonEncode(array $data)
    {
        ob_clean();
        echo(json_encode([
            'data'=>$data
        ]));
        die;
    }

    protected function getDateUnitForLabels(array $labels): string
    {
        $unit = 'day';

        if (empty($labels)) {
            return $unit;
        }

        $startDate = new Carbon(reset($labels));
        $endDate = new Carbon(end($labels));
        $diffHours = $startDate->diffInHours($endDate);

        if($diffHours > 0 && $diffHours <= 48) {
            $unit = 'hour';
        } elseif($diffHours > 48 && $diffHours <= 168) {
            $unit = 'day';
        } elseif($diffHours > 168 && $diffHours <= 744) {
            $unit = 'week';
        }elseif($diffHours > 744 && $diffHours <= 8760) {
            $unit = 'month';
        }elseif($diffHours > 8760) {
            $unit = 'year';
        }

        return $unit;
    }

    /**
     * Start/end timestamps for a named interval.
     *
     * Carbon mutates in place, so each bound is taken from its own copy of
     * "now" - v2 chained both off one instance, which made the end of every
     * "yesterday"-style range land a day before its start.
     */
    private function getStartAndEndDateTimestamps($interval): array
    {
        $now = Carbon::now();

        switch ($interval)
        {
            case 'yd':
                $start = $now->copy()->subDay()->startOfDay()->timestamp;
                $end = $now->copy()->subDay()->endOfDay()->timestamp;
                break;
            case 'tw':
                $start = $now->copy()->startOfWeek()->timestamp;
                $end = $now->copy()->endOfWeek()->timestamp;
                break;
            case 'lw':
                $start = $now->copy()->subWeek()->startOfWeek()->timestamp;
                $end = $now->copy()->subWeek()->endOfWeek()->timestamp;
                break;
            case 'tm':
                $start = $now->copy()->startOfMonth()->timestamp;
                $end = $now->copy()->endOfMonth()->timestamp;
                break;
            case 'lm':
                $start = $now->copy()->subMonth()->startOfMonth()->timestamp;
                $end = $now->copy()->subMonth()->endOfMonth()->timestamp;
                break;
            case 'ty':
                $start = $now->copy()->startOfYear()->timestamp;
                $end = $now->copy()->endOfYear()->timestamp;
                break;
            case 'ly':
                $start = $now->copy()->subYear()->startOfYear()->timestamp;
                $end = $now->copy()->subYear()->endOfYear()->timestamp;
                break;
            default:
                $start = $now->copy()->startOfDay()->timestamp;
                $end = $now->copy()->endOfDay()->timestamp;
                break;
        }

        return [
            'start' => $start,
            'end'   => $end
        ];
    }
}
