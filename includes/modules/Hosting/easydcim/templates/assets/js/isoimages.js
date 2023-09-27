let isoImageDatatable;
$(document).ready(function (e) {
    isoImageDatatable = $('#isoImages').DataTable({
        lengthChange: false,
        ordering: false,
        searching: false,
        info:false,
    });

    $('#isoImages_wrapper').css('overflow', 'unset')
});

function showIsoImagesModal()
{
    const layers = $('#layers');
    layers.append('<div id="createIsoImagesModal" class="lu-modal show lu-modal--md">\n' +
        '    <div class="lu-modal__dialog">\n' +
        '        <div id="mgModalContainer" class="lu-modal__content">\n' +
        '            <div class="lu-modal__top lu-top">\n' +
        '                <div class="lu-top__title lu-type-6"><span class="lu-text-faded lu-font-weight-normal">\n' +
        '                        Add ISO Image                    </span></div>\n' +
        '                <div class="lu-top__toolbar">\n' +
        '                    <button data-dismiss="lu-modal" aria-label="Close"\n' +
        '                            class="lu-btn lu-btn--xs lu-btn--default lu-btn--icon lu-btn--link lu-btn--plain closeModal" onclick="closeCreateIsoImagesModal()">\n' +
        '                        <i class="lu-btn__icon lu-zmdi lu-zmdi-close"></i></button>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__body">\n' +
        '                <div class="lu-row">\n' +
        '                    <div class="lu-col-md-12">\n' +
        '                        <div class="lu-alert lu-alert--sm lu-alert--info lu-alert--faded modal-alert-top">\n' +
        '                            <div class="lu-alert__body">\n' +
        '                                ISO images are used to manually install the operating system. If you want to use an ISO\n' +
        '                                image, you cannot perform an automatic OS installation within EasyDCIM. Available ISO\n' +
        '                                images are accessible when a noVNC session is used. The images will be automatically\n' +
        '                                mounted when creating a noVNC session in the “/home/iso” directory.\n' +
        '                            </div>\n' +
        '                        </div>\n' +
        '                        <form id="createIsoImage">\n' +
        '                            <div class="lu-form-group"><label class="lu-form-label">\n' +
        '                                Name </label> <input id="name" type="text" placeholder="Windows" name="name" value=""\n' +
        '                                                     class="lu-form-control">\n' +
        '                                <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>\n' +
        '                            </div>\n' +
        '                            <div class="lu-form-group"><label class="lu-form-label">\n' +
        '                                ISO URL </label> <input id="iso_url" type="text" placeholder="https://example.com/test.iso"\n' +
        '                                                        name="iso_url" value="" class="lu-form-control">\n' +
        '                                <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>\n' +
        '                            </div>\n' +
        '                        </form>\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__actions">\n' +
        '                <button onclick="createIsoImage()" class="lu-btn lu-btn--success submitForm mg-submit-form">\n' +
        '                    Confirm\n' +
        '                </button>\n' +
        '                <button class="lu-btn lu-btn--danger lu-btn--outline lu-btn--plain closeModal" onclick="closeCreateIsoImagesModal()">\n' +
        '                    Cancel\n' +
        '                </button>\n' +
        '            </div>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '</div>');
}

function closeCreateIsoImagesModal()
{
    $('#createIsoImagesModal').remove();
}

function createIsoImage()
{
    let form = $('#createIsoImage');
    let serializeData = getFormData(form);
    console.log(serializeData);
    let url = window.location.href;
    let errorStatus = validate();
    if (errorStatus === true)
    {
        return;
    }
    closeCreateIsoImagesModal();

    $.ajax({
        type: "GET",
        url: url + '&ajax=1&createIsoImage=1&' + $.param({formdata: serializeData}),
        success: function(data){
            // location.reload();
            let message = JSON.parse(data).data.message;
            let div = $('#infos');
            div.html('');
            div.css("display", "block");
            div.append('<div class="alert alert-info">\n' +
                '<a class="close">×</a>\n' +
                ''+message+'<br></div>')
            let pntf_opts = {}
            pntf_opts.text = message;
            pntf_opts.type = 'info';
            if (typeof PNotify !== 'undefined') {
                new PNotify(pntf_opts);
            }
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
            let pntf_opts = {}
            pntf_opts.text = error;
            pntf_opts.type = 'error';
            if (typeof PNotify !== 'undefined') {
                new PNotify(pntf_opts);
            }
        }
    });
}

function validate()
{
    var form = document.getElementById("createIsoImage");

    var formFields = form.querySelectorAll(".lu-form-control");
    formFields.forEach(function(formField) {
        var errorMessage = formField.nextSibling;
        if (errorMessage.className === "error-message") {
            formField.parentNode.removeChild(errorMessage);
        }
        formField.style.borderColor = "";
    });

    let error = false;
    var nameField = document.getElementById("name");
    console.log(nameField.value.toString())
    if (nameField.value.toString() === '') {
        // hostname is not valid
        error = true;
        var errorMessage = nameField.nextSibling;
        if (errorMessage.className === "error-message") {
            errorMessage.innerHTML = "This Field Cannot Be Empty";
            errorMessage.style.color = "red";
        } else {
            // create error message element
            errorMessage = document.createElement("div");
            errorMessage.innerHTML = "This Field Cannot Be Empty";
            errorMessage.className = "error-message";
            errorMessage.style.color = "red";
            nameField.parentNode.insertBefore(errorMessage, nameField.nextSibling);
        }
        nameField.style.borderColor = "red";
    }

    var isoURLField = document.getElementById("iso_url");
    if (!validateIsoUrl(isoURLField.value)) {
        // mask is not valid
        error = true;
        var errorMessage = isoURLField.nextSibling;
        if (errorMessage.className === "error-message") {
            errorMessage.innerHTML = "Please provide a valid ISO URL";
            errorMessage.style.color = "red";
        } else {
            // create error message element
            errorMessage = document.createElement("div");
            errorMessage.innerHTML = "Please provide a valid ISO URL";
            errorMessage.className = "error-message";
            errorMessage.style.color = "red";
            isoURLField.parentNode.insertBefore(errorMessage, isoURLField.nextSibling);
        }
        isoURLField.style.borderColor = "red";
    }
    return error;
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

function validateIsoUrl(data) {
    const isoUrlRegex = /^https?:\/\/[a-z0-9-\.]+(:[0-9]+)?(\/[a-z0-9-_\.\/]+)*\/[a-z0-9-_\.]+\.iso(\?[a-z0-9-_=&]+)?(#[a-z0-9-]+)?$/i;

    return isoUrlRegex.test(data);
}

function editIsoImageModal(id,name,isoUrl)
{
    const layers = $('#layers');
    layers.append('<div id="editIsoImagesModal" class="lu-modal show lu-modal--md">\n' +
        '    <div class="lu-modal__dialog">\n' +
        '        <div id="mgModalContainer" class="lu-modal__content">\n' +
        '            <div class="lu-modal__top lu-top">\n' +
        '                <div class="lu-top__title lu-type-6"><span class="lu-text-faded lu-font-weight-normal">\n' +
        '                        Update ISO Image                    </span></div>\n' +
        '                <div class="lu-top__toolbar">\n' +
        '                    <button data-dismiss="lu-modal" aria-label="Close"\n' +
        '                            class="lu-btn lu-btn--xs lu-btn--default lu-btn--icon lu-btn--link lu-btn--plain closeModal" onclick="closeEditIsoImagesModal()">\n' +
        '                        <i class="lu-btn__icon lu-zmdi lu-zmdi-close"></i></button>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__body">\n' +
        '                <div class="lu-row">\n' +
        '                    <div class="lu-col-md-12">\n' +
        '                        <form id="editIsoImage">\n' +
        '                            <div class="lu-form-group"><label class="lu-form-label">\n' +
        '                                Name </label> <input id="name" type="text" placeholder="Windows" name="name" value="'+name+'"\n' +
        '                                                     class="lu-form-control">\n' +
        '                                <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>\n' +
        '                            </div>\n' +
        '                            <div class="lu-form-group"><label class="lu-form-label">\n' +
        '                                ISO URL </label> <input disabled="disabled" id="iso_url" type="text" placeholder="https://example.com/test.iso"\n' +
        '                                                        name="iso_url" value="'+isoUrl+'" class="lu-form-control"><input type="hidden" name="updateId" value="'+id+'" class="lu-form-control">\n' +
        '                                <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>\n' +
        '                            </div>\n' +
        '                        </form>\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__actions">\n' +
        '                <button onclick="editIsoImage()" class="lu-btn lu-btn--success submitForm mg-submit-form">\n' +
        '                    Confirm\n' +
        '                </button>\n' +
        '                <button class="lu-btn lu-btn--danger lu-btn--outline lu-btn--plain closeModal" onclick="closeEditIsoImagesModal()">\n' +
        '                    Cancel\n' +
        '                </button>\n' +
        '            </div>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '</div>');
}

function closeEditIsoImagesModal()
{
    $('#editIsoImagesModal').remove();
}

function editIsoImage()
{
    let form = $('#editIsoImage');
    let serializeData = getFormData(form);
    console.log(serializeData);
    let url = window.location.href;
    let errorStatus = validateEdit();
    if (errorStatus === true)
    {
        return;
    }
    closeEditIsoImagesModal();

    $.ajax({
        type: "GET",
        url: url + '&ajax=1&editIsoImage=1&' + $.param({formdata: serializeData}),
        success: function(data){
            // location.reload();
            let message = JSON.parse(data).data.message;
            let div = $('#infos');
            div.html('');
            div.css("display", "block");
            div.append('<div class="alert alert-info">\n' +
                '<a class="close">×</a>\n' +
                ''+message+'<br></div>')
            let pntf_opts = {}
            pntf_opts.text = message;
            pntf_opts.type = 'info';
            if (typeof PNotify !== 'undefined') {
                new PNotify(pntf_opts);
            }
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
            let pntf_opts = {}
            pntf_opts.text = error;
            pntf_opts.type = 'error';
            if (typeof PNotify !== 'undefined') {
                new PNotify(pntf_opts);
            }
        }
    });
}

function validateEdit()
{
    var form = document.getElementById("editIsoImage");

    var formFields = form.querySelectorAll(".lu-form-control");
    formFields.forEach(function(formField) {
        var errorMessage = formField.nextSibling;
        if (errorMessage.className === "error-message") {
            formField.parentNode.removeChild(errorMessage);
        }
        formField.style.borderColor = "";
    });

    let error = false;
    var nameField = document.getElementById("name");
    if (nameField.value.toString() === '') {
        // hostname is not valid
        error = true;
        var errorMessage = nameField.nextSibling;
        if (errorMessage.className === "error-message") {
            errorMessage.innerHTML = "This Field Cannot Be Empty";
            errorMessage.style.color = "red";
        } else {
            // create error message element
            errorMessage = document.createElement("div");
            errorMessage.innerHTML = "This Field Cannot Be Empty";
            errorMessage.className = "error-message";
            errorMessage.style.color = "red";
            nameField.parentNode.insertBefore(errorMessage, nameField.nextSibling);
        }
        nameField.style.borderColor = "red";
    }

    return error;
}

function deleteIsoImageModal(id)
{
    const layers = $('#layers');
    layers.append('<div id="deleteIsoImageModal" class="lu-modal show lu-modal--info modal--sm modal--zoomIn">\n' +
        '    <div class="lu-modal__dialog">\n' +
        '        <div id="mgModalContainer" class="lu-modal__content">\n' +
        '            <div class="lu-modal__top lu-top"><i class="lu-top__icon lu-zmdi lu-zmdi-alert-circle-o lu-text-danger"></i>\n' +
        '                <div class="lu-top__title lu-type-5 lu-text-danger">\n' +
        '                    Delete ISO Image\n' +
        '                </div>\n' +
        '                <div class="lu-top__toolbar">\n' +
        '                    <button data-dismiss="lu-modal" aria-label="Close"\n' +
        '                            class="lu-btn lu-btn--xs lu-btn--default lu-btn--icon lu-btn--link lu-btn--plain closeModal" onclick="closeDeleteIsoImagesModal()">\n' +
        '                        <i class="lu-btn__icon lu-zmdi lu-zmdi-close"></i></button>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__body">\n' +
        '\n' +
        '                Are you sure that you want to delete this ISO Image?\n' +
        '\n' +
        '                <form id="deleteIsoImage">' +
        '                   <input type="hidden" name="deleteId" value="'+id+'">\n' +
        '                </form>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__actions">\n' +
        '                <button class="lu-btn lu-btn--danger submitForm" onclick="deleteIsoImage()">\n' +
        '                    Delete\n' +
        '                </button>\n' +
        '                <button class="lu-btn lu-btn--danger lu-btn--outline lu-btn--plain closeModal" onclick="closeDeleteIsoImagesModal()">\n' +
        '                    Cancel\n' +
        '                </button>\n' +
        '            </div>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '</div>');
}

function closeDeleteIsoImagesModal()
{
    console.log('test');
    $('#deleteIsoImageModal').remove();
}

function deleteIsoImage()
{
    let form = $('#deleteIsoImage');
    let serializeData = getFormData(form);
    console.log(serializeData);
    let url = window.location.href;
    closeDeleteIsoImagesModal();

    $.ajax({
        type: "GET",
        url: url + '&ajax=1&deleteIsoImage=1&' + $.param({formdata: serializeData}),
        success: function(data){
            // location.reload();
            let message = JSON.parse(data).data.message;
            let div = $('#infos');
            div.html('');
            div.css("display", "block");
            div.append('<div class="alert alert-info">\n' +
                '<a class="close">×</a>\n' +
                ''+message+'<br></div>')
            let pntf_opts = {}
            pntf_opts.text = message;
            pntf_opts.type = 'info';
            if (typeof PNotify !== 'undefined') {
                new PNotify(pntf_opts);
            }
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
            let pntf_opts = {}
            pntf_opts.text = error;
            pntf_opts.type = 'error';
            if (typeof PNotify !== 'undefined') {
                new PNotify(pntf_opts);
            }
        }
    });
}






