<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages;

use Carbon\Carbon;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Graph\ExportGraphRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Interfaces\IClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\DateRange;

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

            $dates = DateRange::resolve((string) ($getParams['interval'] ?? 'td'), $getParams['start'] ?? null, $getParams['end'] ?? null);

            $graphData = $this->api->admin()->graphs()->export($deviceId, new ExportGraphRequest($getParams['graphs'], self::TARGET_DEVICE, (string) $dates['start'], (string) $dates['end'], null, false));

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

}
