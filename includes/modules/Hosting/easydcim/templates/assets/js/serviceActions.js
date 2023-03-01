function getUrlParameter(sParam) {
    let sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
}

function generateServiceActionsModal(e,message,action)
{
    $('#page-modal-cover').remove();
    generateCSRModal(message,action);
    const modalGenerateCsr = $('#modalGenerateCsr');
    const pageModalCover = $('#page-modal-cover');
    showCSRModal(pageModalCover, modalGenerateCsr);
    hideCSRModal(pageModalCover, modalGenerateCsr);
    submitCSRModal(action,pageModalCover,modalGenerateCsr);

}

function submitCSRModal(action,pageModalCover,modalGenerateCsr) {
    $('#submitModalBtn'+action).on('click', function () {
        modalGenerateCsr.find('input').val("");
        $('#action').val("generateCSR");
        pageModalCover.css({"visibility" : "hidden", "opacity": "0"});
        modalGenerateCsr.hide();
        let url = window.location.href;
        closeModal()
        $.ajax({
            url: url + '&deviceButtonsAction='+action,
            type: 'GET',
            success:function(data){
                let result = JSON.parse(data);
                let message = result.data.success;
                let div = $('#infos');
                div.html('');
                div.css("display", "block");
                div.append('<div class="alert alert-info">\n' +
                    '<a class="close">×</a>\n' +
                    ''+message+'<br></div>')
                pntf_opts.text = message;
                pntf_opts.type = 'info';
                new PNotify(pntf_opts);
                if (result.data.hasOwnProperty('url'))
                {
                    window.open(result.data.url,'_blank');
                }
            },
            error:function(data){
                let errors = JSON.parse(data.responseText);
                let error = errors.data.errors;
                let div = $('#errors');
                div.html('');
                div.css("display", "block");
                div.append('<div class="alert alert-error">\n' +
                    '<a class="close">×</a>\n' +
                    ''+error+'<br></div>')
                pntf_opts.text = error;
                pntf_opts.type = 'error';
                new PNotify(pntf_opts);
            },
        });
    });
}

function showCSRModal(pageModalCover, modalGenerateCsr)
{
    pageModalCover.css({"visibility" : "visible", "opacity": "1"});
    modalGenerateCsr.css({"visibility" : "visible", "top" : "10%px",  "opacity" : "1"});
    modalGenerateCsr.show();
}

function hideCSRModal(pageModalCover, modalGenerateCsr)
{
    $('#closeCrossBtn').off().on('click', function () {
        modalGenerateCsr.find('input').val("");
        $('#action').val("generateCSR");
        pageModalCover.css({"visibility" : "hidden", "opacity": "0"});
        modalGenerateCsr.hide();
    });

    $('#closeModalBtn').off().on('click', function () {
        modalGenerateCsr.find('input').val("");
        $('#action').val("generateCSR");
        pageModalCover.css({"visibility" : "hidden", "opacity": "0"});
        modalGenerateCsr.hide();
    });
}
function generateCSRModal(message,action) {
    let title = '';
    switch (action) {
        case 'boot':
            title = 'Boot';
            break;
        case 'shutdown':
            title = 'Shutdown';
            break;
        case 'reboot':
            title = 'Reboot';
            break;
        case 'bmcColdReset':
            title = 'BMC Cold Reset';
            break;
        case 'enableRescueMode':
            title = 'Enable Rescue Mode';
            break;
        case 'kvmConsole':
            title = 'KVM Console';
            break;
        case 'noVNCConsole':
            title = 'NO VNC Console';
            break;

    }
    const layers = $('#layers');
    layers.append('<div id="confirmationModal" class="lu-modal show lu-modal--info modal--sm modal--zoomIn">\n' +
        '    <div class="lu-modal__dialog">\n' +
        '        <div id="mgModalContainer" class="lu-modal__content">\n' +
        '            <div class="lu-modal__top lu-top"><i class="lu-top__icon lu-zmdi lu-zmdi-info-outline lu-text-success"></i>\n' +
        '                <div class="lu-top__title lu-type-4 lu-text-success">\n' +
        '                    ' + title + '\n' +
        '                </div>\n' +
        '                <div class="lu-top__toolbar">\n' +
        '                    <button onclick="closeModal()" data-dismiss="lu-modal" aria-label="Close"\n' +
        '                            class="lu-btn lu-btn--xs lu-btn--default lu-btn--icon lu-btn--link lu-btn--plain closeModal">\n' +
        '                        <i class="lu-btn__icon lu-zmdi lu-zmdi-close"></i></button>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__body">\n' +
        '\n' +
        '                '+message+'\n' +
        '\n' +
        '                <form id="modalGenerateCsrForm' + action + '"></form>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__actions">\n' +
        '                <button id="submitModalBtn' + action + '" class="lu-btn lu-btn--success submitForm mg-submit-form">\n' +
        '                    Confirm\n' +
        '                </button>\n' +
        '                <button class="lu-btn lu-btn--danger lu-btn--outline lu-btn--plain closeModal" onclick="closeModal()">\n' +
        '                    Cancel\n' +
        '                </button>\n' +
        '            </div>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '</div>');
}

function closeModal()
{
    $('#confirmationModal').remove();
}

