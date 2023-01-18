$(document).ready(function (e) {
   $('#ipAddressesTable').DataTable({
       lengthChange: false,
       ordering: false,
       searching: false,
       info:false
   });

    $('#reverseDNS').DataTable({
        lengthChange: false,
        ordering: false,
        searching: false,
        info:false
    });
});
function showReverseDNSModal(ipAddresses)
{
    let ipAddressesForSelect = '';
    $( ipAddresses ).each(function( index,value ) {
        ipAddressesForSelect += '<option value="'+value.ipAddresses+'">'+value.ipAddresses+'</option>';
    });
    const layers = $('#layers');
    layers.append('<div id="reverseDNSModal" \n' +
        '     index="createRuleModal" class="lu-modal show lu-modal--md">\n' +
        '    <div class="lu-modal__dialog">\n' +
        '        <div id="mgModalContainer" class="lu-modal__content">\n' +
        '            <div class="lu-modal__top lu-top">\n' +
        '                <div class="lu-top__title lu-type-6"><span class="lu-text-faded lu-font-weight-normal">\n' +
        '                        Create DNS Record                    </span></div>\n' +
        '                <div class="lu-top__toolbar">\n' +
        '                    <button onclick="closeReverseDNSModal()" data-dismiss="lu-modal" aria-label="Close"\n' +
        '                            class="lu-btn lu-btn--xs lu-btn--default lu-btn--icon lu-btn--link lu-btn--plain closeModal">\n' +
        '                        <i class="lu-btn__icon lu-zmdi lu-zmdi-close"></i></button>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__body">\n' +
        '                <div class="lu-row">\n' +
        '                    <div class="lu-col-md-12">\n' +
        '                        <form id="reverseDNSForm"\n' +
        '                              \n' +
        '                              index="createForm">\n' +
        '                            <div class="lu-form-group"><label class="lu-form-label">\n' +
        '                                    IP Address </label> <select name="reverseDNSIpAddress"\n' +
        '                                                               class="lu-form-control mgselect2">'+ipAddressesForSelect+'</select>\n' +
        '                                <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>\n' +
        '                            </div>\n' +
        '                            <div class="lu-form-group"><label class="lu-form-label">\n' +
        '                                    Mask <i data-title="Leave empty if you want to create only one record"\n' +
        '                                            data-toggle="lu-tooltip"\n' +
        '                                            class="lu-i-c-2x lu-zmdi lu-zmdi-help-outline lu-form-tooltip-helper lu-tooltip drop-target"><span class="tooltiptext">Leave empty if you want to create only one record</span></i></label>\n' +
        '                                <input type="text" id="reverseDNSMask" placeholder="" name="reverseDNSMask" value=""\n' +
        '                                       class="lu-form-control">\n' +
        '                                <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>\n' +
        '                            </div>\n' +
        '                            <div class="lu-form-group"><label class="lu-form-label">\n' +
        '                                    Hostname </label> <input type="text" placeholder="" id="reverseDNSHostname" name="reverseDNSHostname"\n' +
        '                                                             value="" class="lu-form-control">\n' +
        '                                <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>\n' +
        '                            </div>\n' +
        '                            <input type="hidden" name="reverseDNSTTL" value="3600"></form>\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__actions">\n' +
        '                <button onclick="reverseDNS()" class="lu-btn lu-btn--success submitForm mg-submit-form">\n' +
        '                    Create\n' +
        '                </button>\n' +
        '                <button onclick="closeReverseDNSModal()" class="lu-btn lu-btn--danger lu-btn--outline lu-btn--plain closeModal">\n' +
        '                    Cancel\n' +
        '                </button>\n' +
        '            </div>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '</div>');
    $('.mgselect2').select2({
        // placeholder: "Select Disk Layout addons",
        // allowClear: true
    });
}

function closeReverseDNSModal()
{
    $('#reverseDNSModal').remove();
}

function deleteDnsRecord(id)
{
    showReverseDNSDeleteModal(id)
}

function editDnsRecord(id,hostname)
{
    showReverseDNSEditModal(hostname,id)
}
function isInt(string) {
    return /^\d+$/.test(string);
}

function validateMask(data) {
    if (data === '')
    {
        return true;
    }

    var integerPart = data.replace(/[^0-9]/g, '');

    if (isInt(integerPart) && integerPart >= 0 && integerPart <= 32) {
        return true;
    }
    return false;
}

function validate()
{
    var form = document.getElementById("reverseDNSForm");

    var formFields = form.querySelectorAll(".lu-form-control");
    formFields.forEach(function(formField) {
        var errorMessage = formField.nextSibling;
        if (errorMessage.className === "error-message") {
            formField.parentNode.removeChild(errorMessage);
        }
        formField.style.borderColor = "";
    });

    let error = false;
    var hostnameField = document.getElementById("reverseDNSHostname");
    var hostnameRegex = /^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z0-9]|[A-Za-z0-9][A-Za-z0-9\-]*[A-Za-z0-9])$/;

    if (!hostnameRegex.test(hostnameField.value)) {
        // hostname is not valid
        error = true;
        var errorMessage = hostnameField.nextSibling;
        if (errorMessage.className === "error-message") {
            errorMessage.innerHTML = "Please provide a valid Hostname";
            errorMessage.style.color = "red";
        } else {
            // create error message element
            errorMessage = document.createElement("div");
            errorMessage.innerHTML = "Please provide a valid Hostname";
            errorMessage.className = "error-message";
            errorMessage.style.color = "red";
            hostnameField.parentNode.insertBefore(errorMessage, hostnameField.nextSibling);
        }
        hostnameField.style.borderColor = "red";
    }

    var maskField = document.getElementById("reverseDNSMask");
    if (!validateMask(maskField.value)) {
        // mask is not valid
        error = true;
        var errorMessage = maskField.nextSibling;
        if (errorMessage.className === "error-message") {
            errorMessage.innerHTML = "Please provide a valid mask in the form of a shortened CIDR mask notation";
            errorMessage.style.color = "red";
        } else {
            // create error message element
            errorMessage = document.createElement("div");
            errorMessage.innerHTML = "Please provide a valid mask in the form of a shortened CIDR mask notation";
            errorMessage.className = "error-message";
            errorMessage.style.color = "red";
            maskField.parentNode.insertBefore(errorMessage, maskField.nextSibling);
        }
        maskField.style.borderColor = "red";
    }
    return error;
}
function reverseDNS()
{
    let form = $('#reverseDNSForm');
    let serializeData = getFormData(form);
    let url = window.location.href;
    let data = {
        "ajax": "1",
        "reverseDNS": "1",
        "formdata": serializeData,
    }
    let errorStatus = validate();
    if (errorStatus === true)
    {
        return;
    }
    closeReverseDNSModal();

    $.ajax({
        type: "GET",
        url: url,
        data: data,
        success: function(data){
            // location.reload();
            let message = JSON.parse(data).data.message;
            let div = $('#infos');
            div.html('');
            div.css("display", "block");
            div.append('<div class="alert alert-info">\n' +
                '<a class="close">×</a>\n' +
                ''+message+'<br></div>')
        },
        error: function(data) {
            // location.reload();
            let error = JSON.parse(data.responseText).data.error;
            let div = $('#errors');
            div.html('');
            div.css("display", "block");
            div.append('<div class="alert alert-error">\n' +
                '<a class="close">×</a>\n' +
                ''+error+'<br></div>')
        }
    });
}

function getFormData(form){
    var o = {};
    var a = form.serializeArray();
    $.each(a, function() {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
}

function showReverseDNSEditModal(hostname,id)
{
    const layers = $('#layers');
    layers.append('<div id="reverseDNSModal" \n' +
        '     index="createRuleModal" class="lu-modal show lu-modal--md">\n' +
        '    <div class="lu-modal__dialog">\n' +
        '        <div id="mgModalContainer" class="lu-modal__content">\n' +
        '            <div class="lu-modal__top lu-top">\n' +
        '                <div class="lu-top__title lu-type-6"><span class="lu-text-faded lu-font-weight-normal">\n' +
        '                        Update Record                  </span></div>\n' +
        '                <div class="lu-top__toolbar">\n' +
        '                    <button onclick="closeReverseDNSModal()" data-dismiss="lu-modal" aria-label="Close"\n' +
        '                            class="lu-btn lu-btn--xs lu-btn--default lu-btn--icon lu-btn--link lu-btn--plain closeModal">\n' +
        '                        <i class="lu-btn__icon lu-zmdi lu-zmdi-close"></i></button>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__body">\n' +
        '                <div class="lu-row">\n' +
        '                    <div class="lu-col-md-12">\n' +
        '                        <form id="editForm"\n' +
        '                              \n' +
        '                              index="createForm">\n' +
        '                            <div class="lu-form-group"><label class="lu-form-label">\n' +
        '                                    Hostname </label> <input type="text" placeholder="" name="reverseDNSHostname"\n' +
        '                                                             value="'+hostname+'" class="lu-form-control">\n' +
        '                                <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>\n' +
        '                            </div>\n' +
        '                            <input type="hidden" name="editId" value="'+id+'"></form>\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__actions">\n' +
        '                <button onclick="editDNS()" class="lu-btn lu-btn--success submitForm mg-submit-form">\n' +
        '                    Update\n' +
        '                </button>\n' +
        '                <button onclick="closeReverseDNSModal()" class="lu-btn lu-btn--danger lu-btn--outline lu-btn--plain closeModal">\n' +
        '                    Cancel\n' +
        '                </button>\n' +
        '            </div>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '</div>');
}

function showReverseDNSDeleteModal(id)
{
    const layers = $('#layers');
    layers.append('<div id="reverseDNSModal" class="lu-modal show lu-modal--info modal--sm modal--zoomIn">\n' +
        '    <div class="lu-modal__dialog">\n' +
        '        <div id="mgModalContainer" class="lu-modal__content">\n' +
        '            <div class="lu-modal__top lu-top"><i class="lu-top__icon lu-zmdi lu-zmdi-alert-circle-o lu-text-danger"></i>\n' +
        '                <div class="lu-top__title lu-type-4 lu-text-danger">\n' +
        '                    Delete DNS Record\n' +
        '                </div>\n' +
        '                <div class="lu-top__toolbar">\n' +
        '                    <button onclick="closeReverseDNSModal()" data-dismiss="lu-modal" aria-label="Close"\n' +
        '                            class="lu-btn lu-btn--xs lu-btn--default lu-btn--icon lu-btn--link lu-btn--plain closeModal">\n' +
        '                        <i class="lu-btn__icon lu-zmdi lu-zmdi-close"></i></button>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__body">\n' +
        '\n' +
        '                Are you sure that you want to delete a record. This process cannot be undone\n' +
        '\n' +
        '                <form id="deleteForm"\n' +
        '                      onsubmit="return false;"><input type="hidden"\n' +
        '                       name="deleteId" value="'+id+'">\n' +
        '                </form>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__actions">\n' +
        '                <button onclick="deleteDNS()" class="lu-btn lu-btn--danger submitForm">\n' +
        '                    Delete\n' +
        '                </button>\n' +
        '                <button onclick="closeReverseDNSModal()" class="lu-btn lu-btn--danger lu-btn--outline lu-btn--plain closeModal">\n' +
        '                    Cancel\n' +
        '                </button>\n' +
        '            </div>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '</div>');
}

function editDNS()
{
    let form = $('#editForm');
    let serializeData = getFormData(form);
    let url = window.location.href;
    let data = {
        "ajax": "1",
        "editDNS": "1",
        "formdata": serializeData,
    }

    $.ajax({
        type: "GET",
        url: url,
        data: data,
        success: function(data){
            // location.reload();
            let message = JSON.parse(data).data.message;
            closeReverseDNSModal()
            let div = $('#infos');
            div.html('');
            div.css("display", "block");
            div.append('<div class="alert alert-info">\n' +
                '<a class="close">×</a>\n' +
                ''+message+'<br></div>')
        },
        error: function(data) {
            // location.reload();
            let error = JSON.parse(data.responseText).data.error;
            closeReverseDNSModal()
            let div = $('#errors');
            div.html('');
            div.css("display", "block");
            div.append('<div class="alert alert-error">\n' +
                '<a class="close">×</a>\n' +
                ''+error+'<br></div>')
        }
    });
}

function deleteDNS()
{
    let form = $('#deleteForm');
    let serializeData = getFormData(form);
    let url = window.location.href;
    let data = {
        "ajax": "1",
        "deleteDNS": "1",
        "formdata": serializeData,
    }

    $.ajax({
        type: "GET",
        url: url,
        data: data,
        success: function(data){
            // location.reload();
            let message = JSON.parse(data).data.message;
            closeReverseDNSModal()
            let div = $('#infos');
            div.html('');
            div.css("display", "block");
            div.append('<div class="alert alert-info">\n' +
                '<a class="close">×</a>\n' +
                ''+message+'<br></div>')
        },
        error: function(data) {
            // location.reload();
            let error = JSON.parse(data.responseText).data.error;
            closeReverseDNSModal()
            let div = $('#errors');
            div.html('');
            div.css("display", "block");
            div.append('<div class="alert alert-error">\n' +
                '<a class="close">×</a>\n' +
                ''+error+'<br></div>')
        }
    });
}