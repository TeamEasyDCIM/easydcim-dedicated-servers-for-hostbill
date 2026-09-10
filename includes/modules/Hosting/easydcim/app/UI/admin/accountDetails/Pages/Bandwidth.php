<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\admin\accountDetails\Pages;

use Carbon\Carbon;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Admin\Device\GetDeviceBandwidthRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\EasyDCIM\Interfaces\IClient;

class Bandwidth
{
    /**
     * The intervals the table shows, in display order.
     *
     * API v2 returned every interval from a single call. API v3 takes an
     * explicit date range instead, so each row is fetched on its own.
     */
    protected const INTERVALS = [
        'last_1hour'    => 'Last Hour',
        'last_6hours'   => 'Last 6 Hours',
        'last_1day'     => 'Last Day',
        'last_2days'    => 'Last Two Days',
        'last_1week'    => 'Last Week',
        'last_1month'   => 'Last Month',
        'last_6months'  => 'Last Six Months',
        'last_1year'    => 'Last Year',
        'current_month' => 'Current Month',
    ];

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

    public function getData(): ?array
    {
        $deviceId = $this->client->getEasyServerID();

        if (empty($deviceId))
        {
            return [];
        }

        $data = [];
        $end = Carbon::now();

        foreach (self::INTERVALS as $interval => $label)
        {
            $bandwidth = $this->fetch($deviceId, $this->getStartDate($interval, $end), $end);

            if ($bandwidth === null)
            {
                continue;
            }

            $data[] = [
                'bandwidthInterval' => $label,
                'bandwidthIn'       => $bandwidth->bwIn,
                'bandwidthOut'      => $bandwidth->bwOut,
                'bandwidthTotal'    => $bandwidth->bwTotal,
            ];
        }

        return $data;
    }

    /**
     * @return \ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Bandwidth\BandwidthData|null
     */
    protected function fetch($deviceId, Carbon $start, Carbon $end)
    {
        try
        {
            $response = $this->api->admin()->devices()->getBandwidth($deviceId, new GetDeviceBandwidthRequest(
                $start->toDateTimeString(),
                $end->toDateTimeString()
            ));

            return $response->data;
        }
        catch (\Exception $e)
        {
            return null;
        }
    }

    protected function getStartDate(string $interval, Carbon $end): Carbon
    {
        $start = $end->copy();

        switch ($interval)
        {
            case 'last_1hour':
                return $start->subHour();
            case 'last_6hours':
                return $start->subHours(6);
            case 'last_1day':
                return $start->subDay();
            case 'last_2days':
                return $start->subDays(2);
            case 'last_1week':
                return $start->subWeek();
            case 'last_1month':
                return $start->subMonth();
            case 'last_6months':
                return $start->subMonths(6);
            case 'last_1year':
                return $start->subYear();
            case 'current_month':
            default:
                return $start->startOfMonth();
        }
    }
}
