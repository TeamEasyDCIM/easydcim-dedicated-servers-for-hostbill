// Status graph and its "Filter Graph" period (WHMCS Graph/Pages/Status).
$(function () {
    EdcUi.graphPanel({element: 'statusGraph', graph: 'Status', store: 'status_scope', button: '#statusGraphScope'});
});
