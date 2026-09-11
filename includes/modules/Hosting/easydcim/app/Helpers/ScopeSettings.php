<?php

namespace ModulesGarden\Servers\EasyDCIMv2\App\Helpers;

use Illuminate\Database\Capsule\Manager as DB;

/**
 * The period filters of the graphs, the Bandwidth widget and the sensors, kept
 * per service the way the WHMCS module keeps them in its ModuleSettings: one row
 * per filter and service under the same key ("aggregateTraffic_scope_12"),
 * shared by the admin and the client area.
 *
 * The table comes from the module's install() and upgrade() hooks, and is also
 * created on the first save: HostBill calls upgrade() only when the major
 * version changes, so an installation already on 2.0.x never runs it.
 */
class ScopeSettings
{
    public const TABLE = 'hb_easydcim_settings';

    /**
     * Filter => its fields as the WHMCS forms name them (mode, period, start,
     * end), whether an end before the start is refused (the bandwidth and
     * sensors providers check it, the graph provider does not) and the lang
     * keys of its answers.
     */
    protected const STORES = [
        'aggregateTraffic_scope' => [
            'fields' => ['period', 'graphScope', 'start_date', 'end_date'],
            'checkOrder' => false, 'saved' => 'graph_settings_saved', 'failed' => 'graph_settings_save_failed',
        ],
        'ping_scope' => [
            'fields' => ['period', 'graphScope', 'start_date', 'end_date'],
            'checkOrder' => false, 'saved' => 'graph_settings_saved', 'failed' => 'graph_settings_save_failed',
        ],
        'status_scope' => [
            'fields' => ['period', 'graphScope', 'start_date', 'end_date'],
            'checkOrder' => false, 'saved' => 'graph_settings_saved', 'failed' => 'graph_settings_save_failed',
        ],
        'bandwidth_scope' => [
            'fields' => ['period', 'bandwidthScope', 'start_date', 'end_date'],
            'checkOrder' => true, 'saved' => 'bandwidth_settings_saved', 'failed' => 'bandwidth_settings_save_failed',
        ],
        'sensor_scope' => [
            'fields' => ['period', 'bandwidthPeriod', 'dateStart', 'dateStop'],
            'checkOrder' => true, 'saved' => 'sensors_filters_updated', 'failed' => 'sensors_settings_save_failed',
        ],
    ];

    protected const PERIODS = ['td', 'yd', 'tw', 'lw', 'tm', 'lm', 'ty', 'ly'];

    public static function createTable(): void
    {
        DB::statement(
            'CREATE TABLE IF NOT EXISTS `' . self::TABLE . '` (
                `setting` VARCHAR(191) NOT NULL,
                `value` TEXT NULL,
                `updated_at` DATETIME NULL,
                PRIMARY KEY (`setting`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8'
        );
    }

    /**
     * A service's saved filters by name; filters never saved are left out. Until
     * the table exists nothing has been saved, so a failed read counts as empty.
     */
    public static function forService($serviceId): array
    {
        if (empty($serviceId)) {
            return [];
        }

        $names = [];
        foreach (array_keys(self::STORES) as $store) {
            $names[self::key($store, $serviceId)] = $store;
        }

        try {
            $rows = DB::select(
                'SELECT `setting`, `value` FROM `' . self::TABLE . '` WHERE `setting` IN (' . implode(',', array_fill(0, count($names), '?')) . ')',
                array_keys($names)
            );
        } catch (\Throwable $e) {
            return [];
        }

        $settings = [];
        foreach ($rows as $row) {
            $row = (object) $row;
            $value = json_decode((string) $row->value, true);
            if (is_array($value) && isset($names[$row->setting])) {
                $settings[$names[$row->setting]] = $value;
            }
        }

        return $settings;
    }

    /**
     * The saved filters as the page gets them (data-edc-scopes).
     */
    public static function json($serviceId): string
    {
        return (string) json_encode((object) self::forService($serviceId));
    }

    /**
     * Save one filter sent by the filter modal and answer the way the WHMCS
     * providers do (GraphSettingsProvider, BandwidthScopeProvider,
     * SensorsScopeProvider). Ends the request.
     */
    public static function handleSave($serviceId, array $request): void
    {
        $lang = UiLang::strings();
        $store = (string) ($request['store'] ?? '');

        if (!isset(self::STORES[$store])) {
            self::respond(['error' => $lang['settings_unknown'] ?? 'Undefined Action'], false);
        }
        if (empty($serviceId)) {
            self::respond(['error' => $lang['service_not_found'] ?? 'Service not found'], false);
        }

        $definition = self::STORES[$store];
        list($mode, , $start, $end) = $definition['fields'];
        $values = self::sanitize($definition['fields'], (array) ($request['formdata'] ?? []));

        if ($definition['checkOrder'] && $values[$mode] === '1' && $values[$start] !== '' && $values[$end] !== '' && $values[$start] > $values[$end]) {
            self::respond(['error' => $lang['start_date_before_end_date'] ?? 'Start date must be before end date'], false);
        }

        try {
            self::store(self::key($store, $serviceId), $values);
        } catch (\Throwable $e) {
            self::respond(['error' => $lang[$definition['failed']] ?? 'Failed to save the settings'], false);
        }

        self::respond(['message' => $lang[$definition['saved']] ?? '', 'values' => $values]);
    }

    /**
     * Only the four fields of a filter, each with a value the pages can use.
     */
    protected static function sanitize(array $fields, array $input): array
    {
        list($mode, $scope, $start, $end) = $fields;
        $period = (string) ($input[$scope] ?? '');

        return [
            $mode  => (string) ($input[$mode] ?? '0') === '1' ? '1' : '0',
            $scope => in_array($period, self::PERIODS, true) ? $period : 'td',
            $start => self::date($input[$start] ?? ''),
            $end   => self::date($input[$end] ?? ''),
        ];
    }

    /**
     * "Y-m-d H:i:s", as the date-time pickers send it; anything else is dropped.
     */
    protected static function date($value): string
    {
        $value = (string) $value;
        $date = \DateTime::createFromFormat('Y-m-d H:i:s', $value);

        return $date !== false && $date->format('Y-m-d H:i:s') === $value ? $value : '';
    }

    protected static function store(string $key, array $values): void
    {
        try {
            self::write($key, $values);
        } catch (\Throwable $e) {
            // Most likely the table is not there yet (see the class comment).
            self::createTable();
            self::write($key, $values);
        }
    }

    protected static function write(string $key, array $values): void
    {
        $json = json_encode($values);
        $now = date('Y-m-d H:i:s');
        $exists = DB::select('SELECT `setting` FROM `' . self::TABLE . '` WHERE `setting` = ?', [$key]);

        if (!empty($exists)) {
            DB::update('UPDATE `' . self::TABLE . '` SET `value` = ?, `updated_at` = ? WHERE `setting` = ?', [$json, $now, $key]);
        } else {
            DB::insert('INSERT INTO `' . self::TABLE . '` (`setting`, `value`, `updated_at`) VALUES (?, ?, ?)', [$key, $json, $now]);
        }
    }

    protected static function key(string $store, $serviceId): string
    {
        return $store . '_' . (int) $serviceId;
    }

    protected static function respond(array $data, bool $success = true): void
    {
        if (!$success) {
            header('HTTP/1.1 400 Bad Request');
        }
        if (ob_get_length() !== false) {
            ob_clean();
        }
        echo json_encode(['data' => $data]);
        die;
    }
}
