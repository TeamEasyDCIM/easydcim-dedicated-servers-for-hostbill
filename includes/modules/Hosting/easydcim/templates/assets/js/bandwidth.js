$(document).ready(function () {
    if (!document.getElementById('bandwidthRows')) {
        return;
    }

    loadBandwidth('td');

    $('#reloadBandwidth').on('click', function () {
        loadBandwidth($('#bandwidthScope').val());
    });
});

/**
 * Bandwidth for one period - a preset or custom dates, as the WHMCS module's
 * admin bandwidth filter offers - instead of a fixed table of intervals.
 */
function loadBandwidth(interval) {
    let range = interval === 'custom'
        ? '&start=' + encodeURIComponent($('#bandwidthStart').val() || '') + '&end=' + encodeURIComponent($('#bandwidthEnd').val() || '')
        : '';
    let body = $('#bandwidthRows');

    body.html('<tr role="row"><td colspan="4">Loading...</td></tr>');

    $.ajax({
        type: 'GET',
        url: window.location.href + '&bandwidthPeriod=1&interval=' + encodeURIComponent(interval) + range,
        success: function (data) {
            let rows = JSON.parse(data).data.rows || [];

            body.html('');

            if (rows.length === 0) {
                body.html('<tr role="row"><td colspan="4">No data for this period.</td></tr>');
                return;
            }

            $(rows).each(function (index, row) {
                body.append($('<tr role="row">')
                    .append($('<td>').text(row.bandwidthInterval))
                    .append($('<td>').text(row.bandwidthIn))
                    .append($('<td>').text(row.bandwidthOut))
                    .append($('<td>').text(row.bandwidthTotal)));
            });
        },
        error: function () {
            body.html('<tr role="row"><td colspan="4">The bandwidth could not be loaded.</td></tr>');
        }
    });
}
