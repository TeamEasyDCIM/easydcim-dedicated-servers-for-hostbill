$(document).ready(function () {
    $('#sshKeys').DataTable({
        lengthChange: false,
        ordering: false,
        searching: false,
        info: false
    });
});

function closeSshKeyModal() {
    $('#sshKeyModal').remove();
}

function getSshKeyFormData(form) {
    var o = {};
    $.each(form.serializeArray(), function () {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    // Unchecked checkboxes are not serialized; send the flag explicitly.
    o.default = form.find('input[name="default"]').is(':checked') ? '1' : '';
    return o;
}

function sshKeyNotify(message, type) {
    var div = $(type === 'error' ? '#errors' : '#infos');
    div.html('');
    div.css('display', 'block');
    div.append('<div class="alert alert-' + (type === 'error' ? 'error' : 'info') + '">\n' +
        '<a class="close">×</a>\n' + message + '<br></div>');

    if (typeof PNotify !== 'undefined') {
        new PNotify({text: message, type: type});
    }
}

function sshKeyRequest(action, serializeData) {
    var url = window.location.href;

    $.ajax({
        type: 'GET',
        url: url + '&ajax=1&' + action + '=1&' + $.param({formdata: serializeData}),
        success: function (data) {
            sshKeyNotify(JSON.parse(data).data.message, 'info');
            location.reload();
        },
        error: function (data) {
            sshKeyNotify(JSON.parse(data.responseText).data.error, 'error');
        }
    });
}

/**
 * Reject obviously malformed keys before the round trip; the module validates
 * again server side.
 */
function validateSshKeyForm(form, keyRequired) {
    var error = false;
    form.find('.error-message').remove();
    form.find('.lu-form-control').css('borderColor', '');

    var name = form.find('[name="name"]');
    if ($.trim(name.val()) === '') {
        showSshKeyFieldError(name, 'The key name cannot be empty');
        error = true;
    }

    var key = form.find('[name="sshKey"]');
    var keyValue = $.trim(key.val());

    if (keyValue === '') {
        if (keyRequired) {
            showSshKeyFieldError(key, 'The SSH key cannot be empty');
            error = true;
        }
    } else if (!/^(ssh-rsa|ssh-dss|ssh-ed25519|sk-ssh-ed25519@openssh\.com|ecdsa-sha2-nistp(256|384|521)|sk-ecdsa-sha2-nistp256@openssh\.com)\s+[A-Za-z0-9+\/]+={0,3}(\s+.*)?$/.test(keyValue)) {
        showSshKeyFieldError(key, 'This value must be a valid SSH public key in OpenSSH format');
        error = true;
    }

    return error;
}

function showSshKeyFieldError(field, message) {
    var err = document.createElement('div');
    err.className = 'error-message';
    err.style.color = 'red';
    err.textContent = message;
    field[0].parentNode.insertBefore(err, field[0].nextSibling);
    field.css('borderColor', 'red');
}

function showSshKeyModal() {
    $('#layers').append('<div id="sshKeyModal" index="createSshKeyModal" class="lu-modal show lu-modal--md">\n' +
        '    <div class="lu-modal__dialog">\n' +
        '        <div id="mgModalContainer" class="lu-modal__content">\n' +
        '            <div class="lu-modal__top lu-top">\n' +
        '                <div class="lu-top__title lu-type-6"><span class="lu-text-faded lu-font-weight-normal">Add SSH Key</span></div>\n' +
        '                <div class="lu-top__toolbar">\n' +
        '                    <button onclick="closeSshKeyModal()" data-dismiss="lu-modal" aria-label="Close"\n' +
        '                            class="lu-btn lu-btn--xs lu-btn--default lu-btn--icon lu-btn--link lu-btn--plain closeModal">\n' +
        '                        <i class="lu-btn__icon lu-zmdi lu-zmdi-close"></i></button>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__body">\n' +
        '                <div class="lu-row">\n' +
        '                    <div class="lu-col-md-12">\n' +
        '                        <form id="sshKeyForm" index="createForm">\n' +
        '                            <div class="lu-form-group"><label class="lu-form-label">Name</label>\n' +
        '                                <input type="text" name="name" value="" class="lu-form-control">\n' +
        '                                <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>\n' +
        '                            </div>\n' +
        '                            <div class="lu-form-group"><label class="lu-form-label">SSH Public Key</label>\n' +
        '                                <textarea name="sshKey" rows="5" class="lu-form-control" placeholder="ssh-ed25519 AAAA... user@host"></textarea>\n' +
        '                                <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>\n' +
        '                            </div>\n' +
        '                            <div class="lu-form-check lu-m-b-2x"><label><span class="lu-form-text">Set as default</span>\n' +
        '                                <div class="lu-switch"><input type="checkbox" name="default" class="lu-switch__checkbox">\n' +
        '                                    <span class="lu-switch__container"><span class="lu-switch__handle"></span></span></div>\n' +
        '                            </label></div>\n' +
        '                        </form>\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__actions">\n' +
        '                <button onclick="createSshKey()" class="lu-btn lu-btn--success submitForm mg-submit-form">Create</button>\n' +
        '                <button onclick="closeSshKeyModal()" class="lu-btn lu-btn--danger lu-btn--outline lu-btn--plain closeModal">Cancel</button>\n' +
        '            </div>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '</div>');
}

function createSshKey() {
    var form = $('#sshKeyForm');

    if (validateSshKeyForm(form, true)) {
        return;
    }

    var data = getSshKeyFormData(form);
    closeSshKeyModal();
    sshKeyRequest('createSshKey', data);
}

function editSshKey(id, name) {
    $('#layers').append('<div id="sshKeyModal" index="editSshKeyModal" class="lu-modal show lu-modal--md">\n' +
        '    <div class="lu-modal__dialog">\n' +
        '        <div id="mgModalContainer" class="lu-modal__content">\n' +
        '            <div class="lu-modal__top lu-top">\n' +
        '                <div class="lu-top__title lu-type-6"><span class="lu-text-faded lu-font-weight-normal">Update SSH Key</span></div>\n' +
        '                <div class="lu-top__toolbar">\n' +
        '                    <button onclick="closeSshKeyModal()" data-dismiss="lu-modal" aria-label="Close"\n' +
        '                            class="lu-btn lu-btn--xs lu-btn--default lu-btn--icon lu-btn--link lu-btn--plain closeModal">\n' +
        '                        <i class="lu-btn__icon lu-zmdi lu-zmdi-close"></i></button>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__body">\n' +
        '                <div class="lu-row">\n' +
        '                    <div class="lu-col-md-12">\n' +
        '                        <form id="sshKeyForm" index="editForm">\n' +
        '                            <div class="lu-form-group"><label class="lu-form-label">Name</label>\n' +
        '                                <input type="text" name="name" value="' + name + '" class="lu-form-control">\n' +
        '                                <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>\n' +
        '                            </div>\n' +
        '                            <div class="lu-form-group"><label class="lu-form-label">SSH Public Key\n' +
        '                                <i data-title="Leave empty to keep the current key" data-toggle="lu-tooltip"\n' +
        '                                   class="lu-i-c-2x lu-zmdi lu-zmdi-help-outline lu-form-tooltip-helper lu-tooltip drop-target"><span class="tooltiptext">Leave empty to keep the current key</span></i></label>\n' +
        '                                <textarea name="sshKey" rows="5" class="lu-form-control"></textarea>\n' +
        '                                <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>\n' +
        '                            </div>\n' +
        '                            <input type="hidden" name="updateId" value="' + id + '">\n' +
        '                        </form>\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__actions">\n' +
        '                <button onclick="updateSshKey()" class="lu-btn lu-btn--success submitForm mg-submit-form">Update</button>\n' +
        '                <button onclick="closeSshKeyModal()" class="lu-btn lu-btn--danger lu-btn--outline lu-btn--plain closeModal">Cancel</button>\n' +
        '            </div>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '</div>');
}

function updateSshKey() {
    var form = $('#sshKeyForm');

    if (validateSshKeyForm(form, false)) {
        return;
    }

    var data = getSshKeyFormData(form);
    closeSshKeyModal();
    sshKeyRequest('editSshKey', data);
}

function setSshKeyAsDefault(id) {
    sshKeyRequest('defaultSshKey', {defaultId: id});
}

function deleteSshKey(id) {
    $('#layers').append('<div id="sshKeyModal" class="lu-modal show lu-modal--info modal--sm modal--zoomIn">\n' +
        '    <div class="lu-modal__dialog">\n' +
        '        <div id="mgModalContainer" class="lu-modal__content">\n' +
        '            <div class="lu-modal__top lu-top"><i class="lu-top__icon lu-zmdi lu-zmdi-alert-circle-o lu-text-danger"></i>\n' +
        '                <div class="lu-top__title lu-type-4 lu-text-danger">Delete SSH Key</div>\n' +
        '                <div class="lu-top__toolbar">\n' +
        '                    <button onclick="closeSshKeyModal()" data-dismiss="lu-modal" aria-label="Close"\n' +
        '                            class="lu-btn lu-btn--xs lu-btn--default lu-btn--icon lu-btn--link lu-btn--plain closeModal">\n' +
        '                        <i class="lu-btn__icon lu-zmdi lu-zmdi-close"></i></button>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__body">\n' +
        '                Are you sure that you want to delete this SSH key? This process cannot be undone.\n' +
        '            </div>\n' +
        '            <div class="lu-modal__actions">\n' +
        '                <button onclick="confirmDeleteSshKey(\'' + id + '\')" class="lu-btn lu-btn--danger submitForm mg-submit-form">Delete</button>\n' +
        '                <button onclick="closeSshKeyModal()" class="lu-btn lu-btn--default lu-btn--outline lu-btn--plain closeModal">Cancel</button>\n' +
        '            </div>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '</div>');
}

function confirmDeleteSshKey(id) {
    closeSshKeyModal();
    sshKeyRequest('deleteSshKey', {deleteId: id});
}
