/**
 * Reverse DNS - the WHMCS ReverseDNS table and its modals: CreateForm with the
 * "Available IP Addresses" box, UpdateForm, DeleteModal and MassDeleteModal.
 * The fields are validated by the module, as the WHMCS validators do it, and
 * their messages are shown under the fields.
 */
var ReverseDnsPage = (function ($) {
    'use strict';

    var t = EdcUi.t;
    var list = null;

    function init() {
        list = EdcUi.table('#reverseDNSTable .lu-t-c', {
            search: true,
            searchable: [0, 1],
            mass: {
                buttons: [$('<button type="button" class="lu-btn lu-btn--sm lu-btn--link lu-btn--icon lu-btn--plain lu-btn--danger lu-tooltip" data-toggle="lu-tooltip"></button>')
                    .attr('data-title', t('delete'))
                    .append('<i class="lu-btn__icon lu-zmdi lu-zmdi-delete"></i>', $('<span class="tooltiptext"></span>').text(t('delete')))],
                onClick: massDelete
            }
        }, list ? list.state() : null);
    }

    function reload() {
        EdcUi.reload('#reverseDNSTable', init);
    }

    // The usable addresses of the service (WHMCS IpsHelper::listUsableIPsFromArray).
    function addresses() {
        try {
            return JSON.parse($('#reverseDNSTable').attr('data-edc-ips') || '[]') || [];
        } catch (e) {
            return [];
        }
    }

    function ipBox() {
        var ips = addresses();
        var box = $('<div class="lu-alert lu-alert--faded lu-alert--info lu-ed-ip-box"></div>');
        if (!ips.length) {
            return box.append($('<span class="lu-ed-no-ip"></span>').text(t('rdns_no_ips')));
        }
        var items = $('<div class="lu-ed-ip-list"></div>');
        $.each(ips, function (i, ip) {
            items.append($('<span class="lu-ed-ip-item"></span>').text(ip));
        });
        return box.append($('<div class="lu-ed-ip-info"></div>')
            .append($('<span class="lu-ed-ip-header"></span>').text(t('rdns_available_ips')), items));
    }

    function create() {
        EdcUi.modal({
            type: 'edit',
            title: t('rdns_create_modal'),
            body: [
                ipBox(),
                EdcUi.field.text({name: 'reverseDNSIpAddress', label: t('rdns_ip'), placeholder: '192.168.1.100 or 2001::db8::2:1'}),
                EdcUi.field.text({name: 'reverseDNSMask', label: t('rdns_cidr'), placeholder: '32'}),
                EdcUi.field.text({name: 'reverseDNSHostname', label: t('rdns_hostname'), placeholder: 'example.com'}),
                EdcUi.field.hidden('reverseDNSTTL', '3600')
            ],
            onSubmit: function (modal) {
                EdcUi.submitModal(modal, '&ajax=1&reverseDNS=1', modal.values(), reload);
            }
        });
    }

    function update(row) {
        EdcUi.modal({
            type: 'edit',
            title: t('rdns_update_modal'),
            body: [
                EdcUi.field.text({name: 'hostname', label: t('rdns_hostname'), placeholder: 'example.com', value: row.attr('data-hostname')}),
                EdcUi.field.hidden('recordId', row.attr('data-id'))
            ],
            onSubmit: function (modal) {
                EdcUi.submitModal(modal, '&ajax=1&editDNS=1', modal.values(), reload);
            }
        });
    }

    function remove(row) {
        EdcUi.modal({
            type: 'edit',
            title: t('rdns_delete_modal'),
            body: [
                EdcUi.alert('warning', $('<div></div>').text(t('rdns_confirm_delete')).html()),
                EdcUi.field.hidden('recordId', row.attr('data-id'))
            ],
            onSubmit: function (modal) {
                EdcUi.submitModal(modal, '&ajax=1&deleteDNS=1', modal.values(), reload);
            }
        });
    }

    function massDelete(ids) {
        if (!ids.length) {
            return;
        }
        EdcUi.modal({
            type: 'edit',
            title: t('rdns_mass_delete_modal'),
            body: [EdcUi.alert('warning', $('<div></div>').text(t('rdns_confirm_mass_delete')).html())],
            onSubmit: function (modal) {
                modal.busy(true);
                EdcUi.request('&ajax=1&massDeleteDNS=1&' + $.param({ids: ids}), function (data) {
                    modal.close();
                    EdcUi.notify('info', data.message);
                    reload();
                }, function (data) {
                    modal.busy(false);
                    EdcUi.notify('error', data.error || '');
                });
            }
        });
    }

    $(document).on('click', '#reverseDNSTable [data-edc-action]', function (e) {
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
