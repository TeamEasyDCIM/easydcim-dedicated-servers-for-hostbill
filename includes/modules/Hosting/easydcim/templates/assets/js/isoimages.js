/**
 * ISO Images - the WHMCS IsoImages table and its Create / Update / Delete modals
 * (CreateIsoImageForm, UpdateIsoImageForm, DeleteIsoImageForm).
 */
var IsoImagesPage = (function ($) {
    'use strict';

    // Forms/Validators/IsoUrlValidator
    var ISO_URL = /^https?:\/\/[a-z0-9-\.]+(:[0-9]+)?(\/[a-z0-9-_\.\/]+)*\/[a-z0-9-_\.]+\.iso(\?[a-z0-9-_=&]+)?(#[a-z0-9-]+)?$/i;
    var t = EdcUi.t;
    var list = null;

    function init() {
        list = EdcUi.table('#isoImagesTable .lu-t-c', {search: true, searchable: [0, 1]}, list ? list.state() : null);
    }

    function reload() {
        EdcUi.reload('#isoImagesTable', init);
    }

    function create() {
        EdcUi.modal({
            type: 'edit',
            title: t('iso_create_modal'),
            body: [
                EdcUi.field.text({name: 'name', label: t('iso_name'), placeholder: 'Linux'}),
                EdcUi.field.text({name: 'iso_url', label: t('iso_url'), placeholder: 'https://example.com/test.iso'})
            ],
            onSubmit: function (modal) {
                var values = modal.values();
                var url = $.trim(values.iso_url);
                if (modal.errors({
                    name: $.trim(values.name) === '' ? t('field_required') : '',
                    iso_url: url === '' ? t('field_required') : (ISO_URL.test(url) ? '' : t('iso_invalid_url'))
                })) {
                    return;
                }
                EdcUi.submitModal(modal, '&ajax=1&createIsoImage=1', values, reload);
            }
        });
    }

    function update(row) {
        EdcUi.modal({
            type: 'edit',
            title: t('iso_update_modal'),
            body: [
                EdcUi.field.text({name: 'name', label: t('iso_name'), value: row.attr('data-name')}),
                EdcUi.field.text({name: 'iso_url', label: t('iso_url'), value: row.attr('data-iso-url'), disabled: true}),
                EdcUi.field.hidden('updateId', row.attr('data-id'))
            ],
            onSubmit: function (modal) {
                var values = modal.values();
                if (modal.errors({name: $.trim(values.name) === '' ? t('field_required') : ''})) {
                    return;
                }
                EdcUi.submitModal(modal, '&ajax=1&editIsoImage=1', values, reload);
            }
        });
    }

    function remove(row) {
        EdcUi.modal({
            type: 'edit',
            title: t('iso_delete_modal'),
            body: [
                EdcUi.alert('warning', $('<div></div>').text(t('iso_confirm_delete')).html()),
                EdcUi.field.hidden('deleteId', row.attr('data-id'))
            ],
            onSubmit: function (modal) {
                EdcUi.submitModal(modal, '&ajax=1&deleteIsoImage=1', modal.values(), reload);
            }
        });
    }

    $(document).on('click', '#isoImagesTable [data-edc-action]', function (e) {
        e.preventDefault();
        var action = $(this).attr('data-edc-action');
        var row = $(this).closest('tr');
        if (action === 'create') {
            create();
        } else if (action === 'update') {
            update(row);
        } else if (action === 'delete') {
            remove(row);
        }
    });

    $(init);

    return {init: init};
})(jQuery);
