/**
 * Rebuild - the WHMCS ReinstallWidget: the server details, the Rebuild Server /
 * Cancel Installation toolbar button, a status check every 10 seconds, and the
 * RebuildForm - the template first, then the fields that template needs.
 */
var RebuildPage = (function ($) {
    'use strict';

    var RELOAD_INTERVAL = 10000;
    var t = EdcUi.t;

    function widget() {
        return $('#reinstallWidget');
    }

    function init() {
        EdcUi.table('#reinstallTable .lu-t-c', {search: false, pagination: false});
    }

    function reload() {
        EdcUi.reload('#reinstallWidget', init);
    }

    // What the WHMCS toolbar compares between checks: idle, or the install message.
    function signature(info) {
        return info && info.installing ? 'installing:' + (info.installationMessage || '') : 'idle';
    }

    function poll() {
        $.ajax({type: 'GET', url: window.location.href.split('#')[0] + '&ajax=1&reloadRebuild=1'}).done(function (raw) {
            var info;
            try {
                info = JSON.parse(raw).data;
            } catch (e) {
                return;
            }
            if (signature(info) !== widget().attr('data-edc-signature')) {
                reload();
            }
        });
    }

    function templates() {
        try {
            return JSON.parse(widget().attr('data-edc-templates') || '[]') || [];
        } catch (e) {
            return [];
        }
    }

    // "domain (dedicated IP) - title", as the WHMCS rebuild modals are titled.
    function title(suffix) {
        var base = widget().attr('data-edc-title') || '';
        return (base ? base + ' - ' : '') + suffix;
    }

    function options(list) {
        return $.map(list || [], function (item) {
            return [[item.key, item.value]];
        });
    }

    function templateFields(container, data, dropdownParent) {
        var windows = !!data.isWindows;
        container.append(
            EdcUi.field.text({name: 'rebuildUsername', label: t('username'), value: windows ? 'Administrator' : (data.username || ''), readonly: windows}),
            EdcUi.field.password({name: 'rebuildPassword', label: t('password')})
        );
        if (!windows) {
            container.append(EdcUi.field.password({name: 'rebuildRootSSHPassword', label: t('root_password')}));
            if (data.sshKeys && data.sshKeys.length) {
                container.append(EdcUi.field.select({
                    name: 'rebuildSshKeys',
                    label: t('ssh_keys_field'),
                    multiple: true,
                    options: options(data.sshKeys),
                    value: $.map(data.sshKeys, function (key) {
                        return key['default'] ? String(key.key) : null;
                    })
                }));
            }
        }
        if (data.diskLayout && data.diskLayout.length) {
            container.append(EdcUi.field.select({name: 'rebuildDiskLayout', label: t('disk_layout'), placeholder: '', options: options(data.diskLayout)}));
        }
        if (data.extras && data.extras.length) {
            container.append(EdcUi.field.select({name: 'rebuildExtras', label: t('extras'), multiple: true, options: options(data.extras)}));
        }
        EdcUi.initFields(container, dropdownParent);
    }

    function formErrors(values) {
        var errors = {
            templateCaId: values.templateCaId ? '' : t('field_required'),
            rebuildHostname: $.trim(values.rebuildHostname) !== '' ? '' : t('field_required')
        };
        if (values.rebuildUsername !== undefined) {
            errors.rebuildUsername = $.trim(values.rebuildUsername) === '' ? t('field_required')
                : (values.rebuildUsername === 'root' ? t('invalid_username') : '');
        }
        if (values.rebuildPassword !== undefined) {
            errors.rebuildPassword = values.rebuildPassword ? '' : t('field_required');
        }
        if (values.rebuildRootSSHPassword !== undefined) {
            errors.rebuildRootSSHPassword = values.rebuildRootSSHPassword ? '' : t('field_required');
        }
        return errors;
    }

    function rebuild() {
        var extra = $('<div></div>');
        var modal = EdcUi.modal({
            type: 'edit',
            title: title(t('rebuild_server')),
            body: [
                EdcUi.field.select({
                    name: 'templateCaId',
                    label: t('os_template'),
                    placeholder: '',
                    options: $.map(templates(), function (template) {
                        return [[template.id, template.Description]];
                    })
                }),
                EdcUi.field.text({name: 'rebuildHostname', label: t('hostname'), value: widget().attr('data-edc-hostname')}),
                extra
            ],
            onSubmit: function (api) {
                var values = api.values();
                if (api.errors(formErrors(values))) {
                    return;
                }
                EdcUi.submitModal(api, '&ajax=1&rebuild=1', values, reload);
            }
        });
        // The WHMCS form reloads when the template changes; here the fields are swapped.
        modal.form.find('select[name="templateCaId"]').on('change', function () {
            var id = $(this).val();
            extra.empty();
            if (!id) {
                return;
            }
            modal.busy(true);
            EdcUi.request('&ajax=1&osTemplateID=' + encodeURIComponent(id), function (data) {
                modal.busy(false);
                templateFields(extra, data, modal.el);
            }, function (data) {
                modal.busy(false);
                EdcUi.notify('error', data.error || '');
            });
        });
    }

    function cancel() {
        EdcUi.modal({
            type: 'edit',
            title: title(t('cancel_installation')),
            body: [EdcUi.alert('warning', $('<div></div>').text(t('cancel_confirm')).html())],
            onSubmit: function (api) {
                EdcUi.submitModal(api, '&ajax=1&cancelInstallation=1', {}, reload);
            }
        });
    }

    $(document).on('click', '#reinstallWidget [data-edc-action]', function (e) {
        e.preventDefault();
        if ($(this).attr('data-edc-action') === 'rebuild') {
            rebuild();
        } else {
            cancel();
        }
    });

    $(function () {
        init();
        setInterval(poll, RELOAD_INTERVAL);
    });

    return {init: init};
})(jQuery);
