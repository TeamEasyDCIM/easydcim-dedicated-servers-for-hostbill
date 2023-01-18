<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages;

use Carbon\Carbon;
//use Carbon\CarbonImmutable;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\EasyDCIM;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Models\Devices\Graph;

class Graphs
{
    /**
     * @var EasyDCIM
     */
    protected $api;

    public function __construct($api)
    {
        $this->api = $api;
    }

    public function manageEasyDCIMGraphs($getParams)
    {
        try {

            $dates = $this->getStartAndEndDateTimestamps($getParams['interval']);
            $graphModel = new Graph();
            $graphModel->setType($getParams['graphs']);
            $graphModel->setExport(1);
            $graphModel->setStart($dates['start']);
            $graphModel->setEnd($dates['end']);
            $graphData = $this->api->device->renderSpecifiedGraphs($graphModel);
            $unit = $this->getDateUnitForLabels($graphData->labels);
            $graphData->unit = $unit;
            self::jsonEncode((array)$graphData);
        } catch (\RuntimeException $e) {
        }
    }

    /**
     * @param array $data
     */
    public static function jsonEncode(array $data)
    {
        ob_clean();
        echo(json_encode([
            'data'=>$data
        ]));
        die;
    }

    /**
     * Generate date unit for labels
     *
     * @param array $labels
     * @return string
     */
    protected function getDateUnitForLabels(array $labels): string
    {
        $unit = 'day';

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

    private function getStartAndEndDateTimestamps($interval): array
    {
        $dates = [];

        switch ($interval)
        {
            case 'yd':
                $date = Carbon::now();
                $start = $date->startOfDay()->subDay()->timestamp;
                $end = $date->endOfDay()->subDay()->timestamp;
                break;
            case 'tw':
                $now = Carbon::now();
                $start = $now->startOfWeek()->timestamp;
                $end = $now->endOfWeek()->timestamp;
                break;
            case 'lw':
                $date = Carbon::now();
                $start = $date->startOfWeek()->subWeek()->timestamp;
                $end = $date->endOfWeek()->subWeek()->timestamp;
                break;
            case 'tm':
                $now = Carbon::now();
                $start = $now->startOfMonth()->timestamp;
                $end = $now->endOfMonth()->timestamp;
                break;
            case 'lm':
                $date = Carbon::now();
                $start = $date->startOfMonth()->subMonth()->timestamp;
                $end = $date->endOfMonth()->subMonth()->timestamp;
                break;
            case 'ty':
                $now = Carbon::now();
                $start = $now->startOfYear()->timestamp;
                $end = $now->endOfYear()->timestamp;
                break;
            case 'ly':
                $now = Carbon::now();
                $start = $now->startOfYear()->subYear()->timestamp;
                $end = $now->endOfYear()->subYear()->timestamp;
                break;
            default:
                $now = Carbon::now();
                $start = $now->startOfDay()->timestamp;
                $end = $now->endOfDay()->timestamp;
                break;
        }
        $dates = [
            'start'=>$start,
            'end'=>$end
        ];
        return $dates;
    }
}