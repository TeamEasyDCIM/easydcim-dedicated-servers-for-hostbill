<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Helpers;

/**
 * ApexCharts options for the device and sensor graphs, built the way the WHMCS
 * module's Graph component builds them - its Options defaults, then what each
 * graph page (AggregateTraffic, Ping, Status, SensorGraph) adds - so both
 * modules draw the same charts from the same EasyDCIM data.
 *
 * Formatters travel as strings ("function (...) {...}", "formatters.<name>");
 * easydcimGraphs.js turns them into functions, as the WHMCS component does.
 */
class GraphOptions
{
    /**
     * Series are averaged, and labels thinned, to at most this many points.
     */
    public const TARGET_POINTS = 120;

    /**
     * Components\Graph\Constants\Colors::COLORS_SET
     */
    public const COLORS = [
        "#008FFB", "#00E396", "#FEB019", "#9B78DD", "#00A9DC",
        "#36E388", "#FBA81C", "#7362CB", "#00C3BD", "#A2E16C",
        "#F29023", "#8775D4", "#00AFD4", "#6CE27A", "#F8A01E",
        "#5F4FC1", "#00BCC5", "#D8E05E", "#F59821", "#B06CB1",
        "#00B6CC", "#00DD9E", "#ED8427", "#C46084", "#00D0AD",
        "#D8E05E", "#EF8826", "#FCAC1A", "#00A2E4", "#A2E16C",
        "#F39422", "#00D6A6", "#E7742C", "#00C9B5", "#36E388",
        "#F69C1F", "#E36830", "#00A9DC", "#00C3BD", "#E16431",
        "#FEB019", "#00B6CC", "#DE5C33", "#6CE27A", "#E46C2E",
        "#00D0AD", "#D84C38", "#FBA81C", "#E9782B", "#00E396",
    ];

    protected const SHOW_ONLY_INTEGERS = 'formatters.showOnlyIntegers';

    /**
     * Options::toArray() keeps these even when empty.
     */
    protected const REQUIRED_OPTIONS = ['chart', 'series'];

    /**
     * @param string $graph     AggregateTraffic, Ping or Status - the EasyDCIM graph type
     * @param array  $graphData GraphData::toArray(), or [] when there is none
     */
    public static function forDeviceGraph(string $graph, array $graphData): array
    {
        switch ($graph)
        {
            case 'Ping':
                return self::ping($graphData);
            case 'Status':
                return self::status($graphData);
            default:
                return self::aggregateTraffic($graphData);
        }
    }

    public static function aggregateTraffic(array $graphData): array
    {
        $options = self::deviceGraph(['gradient', 'gradient', 'gradient', 'solid'], [0.8, 0.8, 0.8, 0]);

        if (empty($graphData['labels']))
        {
            return self::toArray($options);
        }

        $options['xaxis']['categories'] = self::labels($graphData['labels']);
        $unit      = $graphData['units']['traffic'] ?? 'Mbps';
        $precision = $graphData['precision']['traffic'] ?? 2;

        $options['yaxis'] = array_merge($options['yaxis'], [
            'min'             => 0,
            'forceNiceScale'  => true,
            'tickAmount'      => 6,
            'decimalsInFloat' => $precision,
            'labels'          => ['formatter' => self::valueFormatter($precision, $unit)],
        ]);
        $options['tooltip']['y'] = ['formatter' => self::valueFormatter($precision, $unit)];

        // dataset index, name, colour - in the order WHMCS adds them
        $series = [
            [1, 'Traffic OUT', '#5396F4'],
            [0, 'Traffic IN', '#16BDCA'],
            [2, 'Traffic IN & OUT', '#31C48D'],
            [3, '95th Percentile', '#F05252'],
        ];

        foreach ($series as $definition)
        {
            list($index, $name, $color) = $definition;

            if (isset($graphData['datasets'][$index]))
            {
                $options['series'][] = self::series($name . ' (' . $unit . ')', $graphData['datasets'][$index]['data'] ?? [], $color, $precision);
            }
        }

        return self::toArray($options);
    }

    public static function ping(array $graphData): array
    {
        $options = self::deviceGraph('solid', 0.3);

        if (empty($graphData['labels']))
        {
            return self::toArray($options);
        }

        $options['xaxis']['categories'] = self::labels($graphData['labels']);
        $precision = $graphData['precision']['ping'] ?? 2;

        $options['yaxis'] = array_merge($options['yaxis'], [
            'min'             => 0,
            'forceNiceScale'  => true,
            'tickAmount'      => 6,
            'decimalsInFloat' => $precision,
            'labels'          => ['formatter' => self::valueFormatter($precision, 'ms')],
        ]);
        $options['tooltip']['y'] = ['formatter' => self::valueFormatter($precision, 'ms')];

        if (isset($graphData['datasets'][0]))
        {
            $options['series'][] = self::series('Ping (ms)', $graphData['datasets'][0]['data'] ?? [], '#F05252', $precision);
        }

        return self::toArray($options);
    }

    public static function status(array $graphData): array
    {
        $options = self::deviceGraph('solid', 0.3);

        if (empty($graphData['labels']))
        {
            return self::toArray($options);
        }

        $options['xaxis']['categories'] = self::labels($graphData['labels']);
        $options['yaxis'] = array_merge($options['yaxis'], [
            'min'            => 0,
            'forceNiceScale' => true,
            'tickAmount'     => 6,
        ]);

        if (isset($graphData['datasets'][0]))
        {
            $options['series'][] = self::series('Status', $graphData['datasets'][0]['data'] ?? [], '#31C48D');
        }

        return self::toArray($options);
    }

    /**
     * The 150x35 inline graph the WHMCS sensors table draws per sensor
     * (SensorGraph: InlineGraphArea, i.e. sparkline, then inline, then area).
     *
     * @param string $unit display symbol, e.g. "°C"
     */
    public static function sensor(array $graphData, string $name, string $unit): array
    {
        $options = self::defaults('line');

        // BaseGraph::configureAsSparkline()
        $options['chart']   = array_merge($options['chart'], ['height' => 140, 'sparkline' => ['enabled' => true]]);
        $options['tooltip'] = array_merge($options['tooltip'], [
            'fixed'  => ['enabled' => false],
            'y'      => ['title' => ['formatter' => "function (seriesName) { return '' }"]],
            'marker' => ['show' => false],
        ]);
        $options['title']    = array_merge($options['title'], ['style' => ['fontSize' => '16px'], 'offsetX' => -10]);
        $options['subtitle'] = array_merge($options['subtitle'], ['style' => ['fontSize' => '12px'], 'offsetX' => -10, 'offsetY' => 20]);
        $options['stroke']['width'] = '1';
        $options['yaxis']['show']   = false;
        $options['legend']['show']  = false;

        // BaseGraph::configureAsInline() - fresh title/subtitle, 150x35
        $defaults = self::defaults('line');
        $options['title']    = $defaults['title'];
        $options['subtitle'] = $defaults['subtitle'];
        $options['tooltip']['y'] = ['title' => ['formatter' => "function (seriesName) { return '';}"]];
        $options['chart'] = array_merge($options['chart'], ['height' => '35px', 'width' => '150px']);

        // InlineGraphArea
        $options['chart']['type'] = 'area';

        // SensorGraph::loadHtml()
        $options['chart'] = array_merge($options['chart'], [
            'toolbar' => ['show' => false],
            'zoom'    => ['enabled' => true],
            'markers' => ['size' => 0, 'hover' => ['size' => 0]],
        ]);
        $options['stroke'] = array_merge($options['stroke'], ['curve' => 'smooth', 'width' => 1.3]);
        $options['fill']   = ['type' => 'gradient', 'opacity' => 0.8];
        $options['grid']['borderColor'] = '#f1f1f1';
        $options['tooltip']['intersect'] = false;
        $options['legend']['position']  = 'bottom';
        $options['xaxis']['type']        = 'datetime';

        // SensorGraph::loadData()
        if (empty($graphData['labels']))
        {
            return self::toArray($options);
        }

        $options['xaxis']['categories'] = self::labels($graphData['labels']);
        $options['yaxis'] = array_merge($options['yaxis'], [
            'min'            => 0,
            'forceNiceScale' => true,
            'tickAmount'     => 6,
            'labels'         => ['formatter' => "function (val) {\n                    return val !== undefined ? parseFloat(val).toFixed(2) + ' {$unit}' : '';\n                }"],
        ]);

        if (isset($graphData['datasets'][0]))
        {
            $options['series'][] = self::series($name, $graphData['datasets'][0]['data'] ?? [], '#0C6174');
        }

        return self::toArray($options);
    }

    /**
     * Port of Components\Graph\Helpers\GraphDataAverager::average().
     */
    public static function average(array $data, int $targetCount = self::TARGET_POINTS, int $decimalsToRound = 0): array
    {
        $originalCount = count($data);

        if ($originalCount <= $targetCount)
        {
            return $data;
        }

        $averagedData = [];
        $groupSize = $originalCount / $targetCount;

        for ($i = 0; $i < $targetCount; $i++)
        {
            $startIndex = (int) ($i * $groupSize);
            $endIndex   = (int) (($i + 1) * $groupSize);
            $group      = array_slice($data, $startIndex, $endIndex - $startIndex);

            $averagedData[] = round(array_sum($group) / count($group), $decimalsToRound);
        }

        return $averagedData;
    }

    /**
     * Port of BaseGraph::setLabels(): numeric labels are averaged, others thinned.
     */
    public static function labels(array $labels, int $targetCount = self::TARGET_POINTS): array
    {
        if ($labels && is_numeric(reset($labels)))
        {
            return self::average($labels, $targetCount);
        }

        if (count($labels) > $targetCount)
        {
            $labels    = array_values($labels);
            $groupSize = count($labels) / $targetCount;
            $picked    = [];

            for ($i = 0; $i < $targetCount; $i++)
            {
                $picked[] = $labels[(int) ($i * $groupSize)];
            }

            return $picked;
        }

        return $labels;
    }

    /**
     * Components\Graph\Models\Options defaults, as Options::toArray() emits them.
     */
    protected static function defaults(string $type): array
    {
        return [
            'chart'      => [
                'type'       => $type,
                'toolbar'    => ['show' => false],
                'zoom'       => ['enabled' => false],
                'fontFamily' => 'Roboto, sans-serif',
                'foreColor'  => '#505459',
            ],
            'colors'     => self::COLORS,
            'series'     => [],
            'title'      => ['style' => ['fontSize' => '14px']],
            'subtitle'   => ['style' => ['fontSize' => '12px']],
            'xaxis'      => ['categories' => [], 'tickAmount' => 30],
            'yaxis'      => ['show' => true, 'title' => ['text' => ''], 'labels' => ['formatter' => self::SHOW_ONLY_INTEGERS]],
            'dataLabels' => ['enabled' => false],
            'fill'       => [],
            'legend'     => [
                'show'                => true,
                'showForSingleSeries' => true,
                'position'            => 'top',
                'horizontalAlign'     => 'center',
                'markers'             => ['shape' => 'circle'],
            ],
            'tooltip'    => ['enabled' => true],
            'stroke'     => ['width' => 2],
            'grid'       => ['show' => true],
        ];
    }

    /**
     * What AggregateTraffic, Ping and Status share in loadHtml().
     *
     * @param string|array $fillType
     * @param float|array  $fillOpacity
     */
    protected static function deviceGraph($fillType, $fillOpacity): array
    {
        $options = self::defaults('area');

        $options['chart'] = array_merge($options['chart'], [
            'toolbar' => ['show' => false],
            'zoom'    => ['enabled' => true],
            // WHMCS sets markers under "chart", where ApexCharts does not look
            // for them - kept as-is so the rendered chart matches.
            'markers' => ['size' => 0, 'hover' => ['size' => 0]],
        ]);
        $options['stroke'] = array_merge($options['stroke'], ['curve' => 'smooth', 'width' => 2]);
        $options['fill']   = ['type' => $fillType, 'opacity' => $fillOpacity];
        $options['grid']['borderColor'] = '#f1f1f1';
        $options['tooltip'] = array_merge($options['tooltip'], ['shared' => true, 'intersect' => false]);
        $options['legend']['position'] = 'bottom';
        $options['xaxis']['labels'] = ['show' => false];

        return $options;
    }

    /**
     * Port of Series\ExtendedSeries::getSeries().
     */
    protected static function series(string $name, array $data, string $color, int $decimalsToRound = 0): array
    {
        return [
            'name'  => $name,
            'data'  => self::average($data, self::TARGET_POINTS, $decimalsToRound),
            'color' => $color,
        ];
    }

    protected static function valueFormatter($precision, string $unit): string
    {
        return "function (val) {\n                    return val !== undefined ? parseFloat(val.toFixed({$precision})) + ' {$unit}' : '';\n                }";
    }

    /**
     * Options::toArray(): drop empty sections except the required ones.
     */
    protected static function toArray(array $options): array
    {
        return array_filter($options, function ($value, $key) {
            return in_array($key, self::REQUIRED_OPTIONS, true) || !empty($value);
        }, ARRAY_FILTER_USE_BOTH);
    }
}
