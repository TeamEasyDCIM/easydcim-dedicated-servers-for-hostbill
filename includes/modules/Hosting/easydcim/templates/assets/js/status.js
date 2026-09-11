$(document).ready(function () {
    // Not on this page - hidden by the product's feature switches.
    if (!document.getElementById('statusGraph')) {
        return;
    }

    loadStatusGraph('td', '');

    $('#reloadstatusGraph').on('click', function (e) {
        e.preventDefault();
        hideStatusModal();
        let option = $('#scope option:selected').val();
        let range = option === 'custom'
            ? '&start=' + encodeURIComponent($('#scopeStart').val() || '') + '&end=' + encodeURIComponent($('#scopeEnd').val() || '')
            : '';

        loadStatusGraph(option, range);
    });
});

function loadStatusGraph(interval, range) {
    $.ajax({
        type: "GET",
        url: window.location.href + '&graphs=Status&interval=' + interval + range,
        success: function (data) {
            EasyDCIMGraphs.draw('statusGraph', EasyDCIMGraphs.parse(data));
        },
        error: function () {
            EasyDCIMGraphs.clear('statusGraph');
        }
    });
}

function showStatusModal() {
    $('#confirmationModal3').addClass( "show" );
}

function hideStatusModal() {
    $('#confirmationModal3').removeClass( "show" );
}
