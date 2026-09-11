/**
 * The sensors table as the WHMCS module shows it: an inline graph per sensor,
 * five sensors a page, search on name and class, and one period - preset or
 * From-To dates - for every graph, set with "Sensors Scope" in the toolbar.
 */
var SensorsPage = (function ($) {
    'use strict';

    // Field names of the WHMCS SensorsScope form.
    var NAMES = {mode: 'period', scope: 'bandwidthPeriod', start: 'dateStart', end: 'dateStop'};
    var STORE = 'sensor_scope';
    var t = EdcUi.t;
    var list = null;

    // Only the rows of the current page are drawn; each graph loads once per period.
    function drawGraphs(rows) {
        var query = EdcUi.periodQuery(EdcUi.loadSettings(STORE, NAMES), NAMES);
        $(rows).find('.sensorGraph').each(function () {
            var element = $(this);
            if (element.data('drawnFor') === query) {
                return;
            }
            element.data('drawnFor', query);
            $.ajax({
                type: 'GET',
                url: window.location.href.split('#')[0] + '&ajax=1&sensorGraph=1&sensorId=' + encodeURIComponent(element.data('sensorId')) +
                    '&unit=' + encodeURIComponent(element.data('unit')) + '&name=' + encodeURIComponent(element.data('name')) + query,
                success: function (data) {
                    EasyDCIMGraphs.draw(element.attr('id'), EasyDCIMGraphs.parse(data));
                },
                error: function () {
                    EasyDCIMGraphs.clear(element.attr('id'));
                }
            });
        });
    }

    $(document).on('click', '#sensorsScopeButton', function (e) {
        e.preventDefault();
        EdcUi.scopeModal({
            title: t('sensors_scope_modal'),
            store: STORE,
            names: NAMES,
            customLabel: t('from_to_date'),
            onSaved: function () {
                list.draw();
            }
        });
    });

    $(function () {
        list = EdcUi.table('#sensorsTable .lu-t-c', {search: true, searchable: [0, 2], perPage: 5, onDraw: drawGraphs});
    });

    return {};
})(jQuery);
