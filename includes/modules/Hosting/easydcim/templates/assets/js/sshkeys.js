/**
 * SSH Keys - the WHMCS SshKeys table and its modals (CreateSSHKeyForm,
 * UpdateSSHKeyForm, DeleteSSHKeyForm, SetSSHKeyAsDefaultForm).
 */
var SshKeysPage = (function ($) {
    'use strict';

    // A quick check before the round trip; the module validates the key again.
    var OPENSSH_KEY = /^(ssh-rsa|ssh-dss|ssh-ed25519|sk-ssh-ed25519@openssh\.com|ecdsa-sha2-nistp(256|384|521)|sk-ecdsa-sha2-nistp256@openssh\.com)\s+[A-Za-z0-9+\/]+={0,3}(\s+.*)?$/;
    var t = EdcUi.t;
    var list = null;

    function init() {
        list = EdcUi.table('#sshKeysTable .lu-t-c', {search: true, searchable: [1, 2]}, list ? list.state() : null);
    }

    function reload() {
        EdcUi.reload('#sshKeysTable', init);
    }

    function keyErrors(values) {
        var key = $.trim(values.sshKey);
        return {
            name: $.trim(values.name) === '' ? t('field_required') : '',
            sshKey: key === '' ? t('field_required') : (OPENSSH_KEY.test(key) ? '' : t('ssh_invalid_key'))
        };
    }

    function keyFields(row) {
        return [
            EdcUi.field.text({name: 'name', label: t('ssh_name'), value: row ? row.attr('data-name') : ''}),
            EdcUi.field.textarea({name: 'sshKey', label: t('ssh_key'), value: row ? row.attr('data-ssh-key') : ''}),
            EdcUi.field.switcher({name: 'default', label: t('ssh_is_default'), checked: row ? row.attr('data-default') === '1' : false})
        ];
    }

    function create() {
        EdcUi.modal({
            type: 'edit',
            title: t('ssh_create_modal'),
            body: [EdcUi.alert('info', $('<div></div>').text(t('ssh_message')).html())].concat(keyFields(null)),
            onSubmit: function (modal) {
                var values = modal.values();
                if (modal.errors(keyErrors(values))) {
                    return;
                }
                EdcUi.submitModal(modal, '&ajax=1&createSshKey=1', values, reload);
            }
        });
    }

    function update(row) {
        EdcUi.modal({
            type: 'edit',
            title: t('ssh_update_modal'),
            body: keyFields(row).concat([EdcUi.field.hidden('updateId', row.attr('data-id'))]),
            onSubmit: function (modal) {
                var values = modal.values();
                if (modal.errors(keyErrors(values))) {
                    return;
                }
                EdcUi.submitModal(modal, '&ajax=1&editSshKey=1', values, reload);
            }
        });
    }

    function confirm(title, alertType, text, query, values) {
        EdcUi.modal({
            type: 'edit',
            title: title,
            body: [EdcUi.alert(alertType, $('<div></div>').text(text).html())],
            onSubmit: function (modal) {
                EdcUi.submitModal(modal, query, values, reload);
            }
        });
    }

    $(document).on('click', '#sshKeysTable [data-edc-action]', function (e) {
        e.preventDefault();
        var action = $(this).attr('data-edc-action');
        var row = $(this).closest('tr');
        if (action === 'create') {
            create();
        } else if (action === 'update') {
            update(row);
        } else if (action === 'delete') {
            confirm(t('ssh_delete_modal'), 'warning', t('ssh_confirm_delete'), '&ajax=1&deleteSshKey=1', {deleteId: row.attr('data-id')});
        } else if (action === 'default') {
            confirm(t('ssh_default_modal'), 'info', t('ssh_confirm_default'), '&ajax=1&defaultSshKey=1', {defaultId: row.attr('data-id')});
        }
    });

    $(init);

    return {init: init};
})(jQuery);
