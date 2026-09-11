$(document).ready(function () {
    // Not on this page - hidden by the product's feature switches.
    if (!document.getElementById('aggregateTraffic')) {
        return;
    }

    loadAggregateTrafficGraph('td', '');

    $('#reloadAggregateTraffic').on('click', function (e) {
        e.preventDefault();
        hideTrafficModal();
        let option = $('#scope3 option:selected').val();
        let range = option === 'custom'
            ? '&start=' + encodeURIComponent($('#scope3Start').val() || '') + '&end=' + encodeURIComponent($('#scope3End').val() || '')
            : '';

        loadAggregateTrafficGraph(option, range);
    });
});

function loadAggregateTrafficGraph(interval, range) {
    $.ajax({
        type: "GET",
        url: window.location.href + '&graphs=AggregateTraffic&interval=' + interval + range,
        success: function (data) {
            EasyDCIMGraphs.draw('aggregateTraffic', EasyDCIMGraphs.parse(data));
        },
        error: function () {
            EasyDCIMGraphs.clear('aggregateTraffic');
        }
    });
}

function showTrafficModal() {
    $('#confirmationModal1').addClass( "show" );
}

function hideTrafficModal() {
    $('#confirmationModal1').removeClass( "show" );
}
