/**
 * Change Hostname, from the Service Information widget toolbar.
 */
$(document).on('click', '[data-edc-change-hostname]', function (e) {
    e.preventDefault();
    EdcUi.modal({
        type: 'edit',
        title: EdcUi.t('change_hostname'),
        body: [EdcUi.field.text({name: 'changeHostname', label: EdcUi.t('hostname'), value: $(this).attr('data-edc-change-hostname')})],
        onSubmit: function (modal) {
            var values = modal.values();
            if (modal.errors({changeHostname: $.trim(values.changeHostname) === '' ? EdcUi.t('field_required') : ''})) {
                return;
            }
            EdcUi.submitModal(modal, '&ajax=1&changeHostname=1', values, function () {
                EdcUi.reload('#serverInformationWidget', function () {
                    EdcUi.initInfoTables('#serverInformationWidget');
                });
            });
        }
    });
});
