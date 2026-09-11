<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages;

use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Graph\ExportGraphRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Interfaces\IClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\DateRange;
use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\GraphOptions;

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

    /**
     * Answer the graph script with ready ApexCharts options - see GraphOptions.
     * Like the WHMCS graph pages, a failed or empty export still gets the
     * chart's options, just without series.
     */
    public function manageEasyDCIMGraphs($getParams)
    {
        $graph = (string) ($getParams['graphs'] ?? '');

        try {
            $deviceId = $this->client->getEasyServerID();
            $dates = DateRange::resolve((string) ($getParams['interval'] ?? 'td'), $getParams['start'] ?? null, $getParams['end'] ?? null);

            // EasyDCIM accepts only "Y-m-d H:i:s" here (date_format rule); a timestamp is refused.
            $graphData = $this->api->admin()->graphs()->export($deviceId, new ExportGraphRequest($graph, self::TARGET_DEVICE, date('Y-m-d H:i:s', $dates['start']), date('Y-m-d H:i:s', $dates['end']), null, false));

            $options = GraphOptions::forDeviceGraph($graph, $graphData->toArray());
        } catch (\Throwable $e) {
            $options = GraphOptions::forDeviceGraph($graph, []);
        }

        self::jsonEncode(['options' => $options]);
    }

    public static function jsonEncode(array $data)
    {
        ob_clean();
        echo(json_encode([
            'data'=>$data
        ]));
        die;
    }


}
