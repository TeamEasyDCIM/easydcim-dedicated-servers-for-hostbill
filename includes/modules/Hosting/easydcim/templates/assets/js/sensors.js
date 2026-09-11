/**
 * The sensors table as the WHMCS module shows it: an inline graph per sensor,
 * five sensors a page, and one scope - a preset period or custom dates - for
 * every graph, set from the table toolbar. WHMCS keeps the scope per service
 * on the server; here it is kept per service in this browser.
 */
var SENSOR_SCOPE_DEFAULT = {period: '0', bandwidthPeriod: 'td', dateStart: '', dateStop: ''};

$(document).ready(function () {
    var table = $('#sensors').DataTable({
        lengthChange: false,
        ordering: false,
        searching: true,
        info: false,
        pageLength: 5
    });

    table.on('draw', drawVisibleSensorGraphs);
    drawVisibleSensorGraphs();
});

function sensorScopeKey() {
    return 'easydcimSensorScope_' + (getUrlParameter('id') || '');
}

function getSensorScope() {
    try {
        return $.extend({}, SENSOR_SCOPE_DEFAULT, JSON.parse(localStorage.getItem(sensorScopeKey()) || '{}'));
    } catch (e) {
        return $.extend({}, SENSOR_SCOPE_DEFAULT);
    }
}

function sensorScopeParams(scope) {
    if (scope.period === '1') {
        return '&interval=custom&start=' + encodeURIComponent(scope.dateStart) + '&end=' + encodeURIComponent(scope.dateStop);
    }

    return '&interval=' + encodeURIComponent(scope.bandwidthPeriod);
}

// Only the rows of the current page are in the DOM; each graph loads once per scope.
function drawVisibleSensorGraphs() {
    var params = sensorScopeParams(getSensorScope());

    $('#sensors tbody .sensorGraph').each(function () {
        var element = $(this);

        if (element.data('drawnFor') === params) {
            return;
        }

        element.data('drawnFor', params);

        $.ajax({
            type: 'GET',
            url: window.location.href + '&ajax=1&sensorGraph=1&sensorId=' + encodeURIComponent(element.data('sensorId')) +
                '&unit=' + encodeURIComponent(element.data('unit')) + '&name=' + encodeURIComponent(element.data('name')) + params,
            success: function (data) {
                EasyDCIMGraphs.draw(element.attr('id'), EasyDCIMGraphs.parse(data));
            },
            error: function () {
                EasyDCIMGraphs.clear(element.attr('id'));
            }
        });
    });
}

// "Sensor Filters" - the WHMCS SensorsScope form: filter mode, period, dates.
function showSensorsScopeModal() {
    var scope = getSensorScope();
    var periods = [['td', 'Today'], ['yd', 'Yesterday'], ['tw', 'This Week'], ['lw', 'Last Week'],
        ['tm', 'This Month'], ['lm', 'Last Month'], ['ty', 'This Year'], ['ly', 'Last Year']];
    var periodOptions = periods.map(function (period) {
        return '<option value="' + period[0] + '"' + (scope.bandwidthPeriod === period[0] ? ' selected' : '') + '>' + period[1] + '</option>';
    }).join('');

    $('#layers').append('<div id="sensorsScopeModal" class="lu-modal show lu-modal--md">\n' +
        '    <div class="lu-modal__dialog">\n' +
        '        <div class="lu-modal__content">\n' +
        '            <div class="lu-modal__top lu-top">\n' +
        '                <div class="lu-top__title lu-type-6"><span class="lu-text-faded lu-font-weight-normal">Sensors Scope</span></div>\n' +
        '                <div class="lu-top__toolbar">\n' +
        '                    <button onclick="closeSensorsScopeModal()" aria-label="Close"\n' +
        '                            class="lu-btn lu-btn--xs lu-btn--default lu-btn--icon lu-btn--link lu-btn--plain closeModal">\n' +
        '                        <i class="lu-btn__icon lu-zmdi lu-zmdi-close"></i></button>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__body">\n' +
        '                <div id="sensorsScopeError" class="lu-alert lu-alert--danger" style="display: none;"></div>\n' +
        '                <div class="lu-form-group">\n' +
        '                    <label class="lu-form-label">Filter Mode</label>\n' +
        '                    <select id="sensorsScopePeriod" class="lu-form-control" onchange="toggleSensorsScopeMode()">\n' +
        '                        <option value="0"' + (scope.period !== '1' ? ' selected' : '') + '>Predefined Period</option>\n' +
        '                        <option value="1"' + (scope.period === '1' ? ' selected' : '') + '>From-To Date</option>\n' +
        '                    </select>\n' +
        '                </div>\n' +
        '                <div id="sensorsScopePredefined" class="lu-form-group">\n' +
        '                    <label class="lu-form-label">Period</label>\n' +
        '                    <select id="sensorsScopeBandwidthPeriod" class="lu-form-control">' + periodOptions + '</select>\n' +
        '                </div>\n' +
        '                <div id="sensorsScopeDates">\n' +
        '                    <div class="lu-form-group">\n' +
        '                        <label class="lu-form-label">Start Date</label>\n' +
        '                        <input type="datetime-local" id="sensorsScopeDateStart" class="lu-form-control" value="' + scope.dateStart + '">\n' +
        '                    </div>\n' +
        '                    <div class="lu-form-group">\n' +
        '                        <label class="lu-form-label">End Date</label>\n' +
        '                        <input type="datetime-local" id="sensorsScopeDateStop" class="lu-form-control" value="' + scope.dateStop + '">\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__actions">\n' +
        '                <button onclick="saveSensorsScope()" class="lu-btn lu-btn--success">Save Changes</button>\n' +
        '                <button onclick="closeSensorsScopeModal()" class="lu-btn lu-btn--danger lu-btn--outline lu-btn--plain closeModal">Cancel</button>\n' +
        '            </div>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '</div>');

    toggleSensorsScopeMode();
}

function toggleSensorsScopeMode() {
    var custom = $('#sensorsScopePeriod').val() === '1';

    $('#sensorsScopePredefined').toggle(!custom);
    $('#sensorsScopeDates').toggle(custom);
}

function saveSensorsScope() {
    var scope = {
        period: $('#sensorsScopePeriod').val(),
        bandwidthPeriod: $('#sensorsScopeBandwidthPeriod').val(),
        dateStart: $('#sensorsScopeDateStart').val() || '',
        dateStop: $('#sensorsScopeDateStop').val() || ''
    };

    // Same check as the WHMCS SensorsScopeProvider.
    if (scope.period === '1' && scope.dateStart && scope.dateStop && scope.dateStart > scope.dateStop) {
        $('#sensorsScopeError').text('Start date must be before end date').show();
        return;
    }

    try {
        localStorage.setItem(sensorScopeKey(), JSON.stringify(scope));
    } catch (e) {
    }

    closeSensorsScopeModal();
    drawVisibleSensorGraphs();
}

function closeSensorsScopeModal() {
    $('#sensorsScopeModal').remove();
}
