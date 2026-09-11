$(document).ready(function () {
    // Not on this page - hidden by the product's feature switches.
    if (!document.getElementById('pingGraph')) {
        return;
    }

    loadPingGraph('td', '');

    $('#reloadpingGraph').on('click', function (e) {
        e.preventDefault();
        hidePingModal();
        let option = $('#scope2 option:selected').val();
        let range = option === 'custom'
            ? '&start=' + encodeURIComponent($('#scope2Start').val() || '') + '&end=' + encodeURIComponent($('#scope2End').val() || '')
            : '';

        loadPingGraph(option, range);
    });
});

function loadPingGraph(interval, range) {
    $.ajax({
        type: "GET",
        url: window.location.href + '&graphs=Ping&interval=' + interval + range,
        success: function (data) {
            EasyDCIMGraphs.draw('pingGraph', EasyDCIMGraphs.parse(data));
        },
        error: function () {
            EasyDCIMGraphs.clear('pingGraph');
        }
    });
}

function showPingModal() {
    $('#confirmationModal2').addClass( "show" );
}

function hidePingModal() {
    $('#confirmationModal2').removeClass( "show" );
}
