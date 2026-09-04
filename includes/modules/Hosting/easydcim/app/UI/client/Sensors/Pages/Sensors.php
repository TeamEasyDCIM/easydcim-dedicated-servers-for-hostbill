<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\client\Sensors\Pages;

use Carbon\Carbon;
use ModulesGarden\Servers\EasyDCIMv2\App\Api\ServiceContext;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Graph\ExportGraphRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Sensors\ListSensorsRequest;

/**
 * Hardware sensor readings for the account's service.
 *
 * Sensors are service-scoped in API v3 and have no admin counterpart, so every
 * call runs as the impersonated user.
 */
class Sensors
{
    /**
     * Sensor units as EasyDCIM names them, mapped to display symbols.
     */
    public static $unitMap = [
        'Celsius'  => '°C',
        'RPM'      => 'RPM',
        'Watts'    => 'W',
        'Voltages' => 'V',
        'Percent'  => '%',
    ];

    /**
     * Sensor type to the badge class the client area styles it with.
     */
    protected static $typeClassMap = [
        'Power'   => 'lu-label--info',
        'Thermal' => 'lu-label--danger',
    ];

    protected const TYPE_CLASS_DEFAULT = 'lu-label--success';

    /**
     * A sensor graph is drawn against the sensor itself, not the device.
     */
    protected const GRAPH_TYPE = 'Sensor';
    protected const GRAPH_TARGET = 'itemSensor';

    /**
     * @var EasyDCIMClient
     */
    protected $api;

    /**
     * @var ServiceContext
     */
    protected $context;

    public function __construct($api, ServiceContext $context)
    {
        $this->api = $api;
        $this->context = $context;
    }

    /**
     * Rows for the widget table.
     */
    public function getData(): array
    {
        $data = [];

        foreach ($this->getSensors() as $sensor)
        {
            $unit = self::$unitMap[$sensor->unit ?? ''] ?? '';

            $data[] = [
                'id'         => $sensor->id,
                'name'       => $sensor->name ?? '',
                'type'       => $sensor->type ?? '',
                'typeClass'  => self::$typeClassMap[$sensor->type ?? ''] ?? self::TYPE_CLASS_DEFAULT,
                'class'      => $sensor->class ?? '',
                'unit'       => $unit,
                'reading'    => trim(($sensor->reading ?? '') . ' ' . $unit),
                'lastPolled' => $sensor->lastPolled ?? '',
            ];
        }

        return $data;
    }

    /**
     * @return array<\ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Responses\Client\Sensors\SensorData>
     */
    protected function getSensors(): array
    {
        try {
            return $this->api->client()->sensors()->listAll(
                $this->context->requireServiceId(),
                new ListSensorsRequest()
            );
        } catch (\Exception $ex) {
            return [];
        }
    }

    public function getJSONSensors()
    {
        self::jsonEncode([
            'result' => $this->getData()
        ]);
    }

    /**
     * Readings over time for one sensor, in the shape the chart script wants.
     */
    public function getGraph($getParams)
    {
        try {
            $sensorId = $getParams['sensorId'] ?? null;

            if (empty($sensorId)) {
                $this->fail('Sensor ID is required.');
            }

            $dates = $this->getStartAndEndDateTimestamps($getParams['interval'] ?? 'td');

            $graphData = $this->api->client()->graphs()->export($sensorId, new ExportGraphRequest(
                type: self::GRAPH_TYPE,
                target: self::GRAPH_TARGET,
                start: (string) $dates['start'],
                end: (string) $dates['end'],
                raw: false
            ));

            $data = $graphData->toArray();
            $data['unit'] = $this->getDateUnitForLabels((array) $graphData->labels);

            self::jsonEncode($data);
        } catch (\Exception $e) {
            $this->fail($e->getMessage() ?: 'The sensor graph could not be loaded.');
        }
    }

    protected function fail(string $message): void
    {
        header('HTTP/1.1 400 Bad Request');
        self::jsonEncode(['error' => $message]);
    }

    public static function jsonEncode(array $data)
    {
        ob_clean();
        echo(json_encode([
            'data' => $data
        ]));
        die;
    }

    /**
     * Chart.js time axis unit that suits the span the labels cover.
     */
    protected function getDateUnitForLabels(array $labels): string
    {
        if (empty($labels)) {
            return 'day';
        }

        $startDate = new Carbon(reset($labels));
        $endDate = new Carbon(end($labels));
        $diffHours = $startDate->diffInHours($endDate);

        if ($diffHours > 0 && $diffHours <= 48) {
            return 'hour';
        }

        if ($diffHours <= 168) {
            return 'day';
        }

        if ($diffHours <= 744) {
            return 'week';
        }

        if ($diffHours <= 8760) {
            return 'month';
        }

        return 'year';
    }

    /**
     * Each bound comes from its own copy of "now" - Carbon mutates in place.
     */
    protected function getStartAndEndDateTimestamps($interval): array
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
