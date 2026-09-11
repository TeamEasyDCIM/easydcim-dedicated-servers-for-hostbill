<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\UI\client\Sensors\Pages;

use ModulesGarden\Servers\EasyDCIMv2\App\Api\ServiceContext;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\EasyDCIMClient;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Graph\ExportGraphRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Libs\Api\EasyDCIM\Models\Requests\Client\Sensors\ListSensorsRequest;
use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\DateRange;
use ModulesGarden\Servers\EasyDCIMv2\App\Helpers\GraphOptions;

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
        'Power'   => 'lu-badge--info',
        'Thermal' => 'lu-badge--danger',
    ];

    protected const TYPE_CLASS_DEFAULT = 'lu-badge--success';

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
        $sensorId = $getParams['sensorId'] ?? null;

        if (empty($sensorId)) {
            $this->fail('Sensor ID is required.');
        }

        $name = (string) ($getParams['name'] ?? '');
        $unit = (string) ($getParams['unit'] ?? '');

        // As the WHMCS SensorGraph: a failed export still draws the empty graph.
        try {
            $dates = DateRange::resolve((string) ($getParams['interval'] ?? 'td'), $getParams['start'] ?? null, $getParams['end'] ?? null);

            $graphData = $this->api->client()->graphs()->export($sensorId, new ExportGraphRequest(self::GRAPH_TYPE, self::GRAPH_TARGET, date('Y-m-d H:i:s', $dates['start']), date('Y-m-d H:i:s', $dates['end']), null, false));

            $options = GraphOptions::sensor($graphData->toArray(), $name, $unit);
        } catch (\Throwable $e) {
            $options = GraphOptions::sensor([], $name, $unit);
        }

        self::jsonEncode(['options' => $options]);
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


}
