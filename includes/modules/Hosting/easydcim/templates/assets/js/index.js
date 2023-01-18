$(document).ready(function (e) {
    triggSwitcherAction();
})

function changePasswordElement(event) {
    let element = $(event);
    let type = $(element[0].parentElement.children[0]).attr('type');
    if(type === "password"){
        $(event).removeClass('lu-zmdi-eye-off');
        $(event).addClass('lu-zmdi-eye');
        $(element[0].parentElement.children[0]).prop('type', 'text')
    }
    else{
        $(event).addClass('lu-zmdi-eye-off');
        $(event).removeClass('lu-zmdi-eye');
        $(element[0].parentElement.children[0]).prop('type', 'password')
    }
}


function getSettings()
{
    let url = window.location.href;
    let data = {
        "action":'module-settings',
        "namespace": "ModulesGarden_Servers_EasyDCIMv2_App_UI_Admin_ProductConfig_Fields_AdditionalParts",
        "ajax": "1",
        "loadData": "1",
        "getSettings": "1",
        "id": getUrlParameter('id')
    }
    $.ajax({
        type: "GET",
        url: url.split('?')[0],
        data: data,
        success: function(data){
            let parts = JSON.parse(data).data;
            $( parts.type ).each(function( index,value ) {
                additionalPartsAppendSettings(value,parts.model[index],parts.size[index]);
            });
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
        }
    });

}

/**
 *
 * @description trigg switcher change event action
 * @returns {undefined}
 */
function triggSwitcherAction()
{
    $('.configSelectAllButton').each(function (key, selectAllButton) {

        let section = $('#' + selectAllButton.parentElement.parentElement.parentElement.parentElement.id);
        let inputs = section.find('input');

        checkAndSetMainSwitcher(inputs);
    });
}


function checkSection(vueControler, params, event)
{
    if(!event.currentTarget)
    {
        return;
    }

    var div = event.currentTarget.parentElement.parentElement.parentElement.parentElement;
    let selectAllSwitcher = $(div).find('input')[0];
    let inputs = $(div).find('input');
    for (const input of inputs) {
        input.checked =  selectAllSwitcher.checked;
    };
}

function checkOptionUnderSection(event)
{
    if(!event.currentTarget)
    {
        return;
    }

    var allInputs  = $(event.currentTarget.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement).find('input');
    var inputsToCheck = $(event.currentTarget.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement).find('input');

    for (const input of inputsToCheck) {
        if(input.checked == false)
        {
            allInputs[0].checked = false;

            return;
        }
    }

    allInputs[0].checked = true;

}


function checkAndSetMainSwitcher(inputs)
{
    var checked = true;

    inputs.each(function(key,input){
        if(input.checked == false && key !== 0)
        {
            checked = false;
        }
    });

    checked == false ? $(inputs[0]).removeAttr('checked') : $(inputs[0]).attr('checked', 'true');
}

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

function generateModal(e,message,action)
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
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                deviceButtonsAction : action
            },
            success:function(data){
                let result = JSON.parse(data);
                const body = $('body');
                body.append('<ul class="messenger messenger-fixed messenger-on-bottom messenger-on-right messenger-theme-flat"><li class="messenger-message-slot messenger-shown messenger-first messenger-last">\n' +
                    '    <div class="messenger-message message alert info message-info alert-info">\n' +
                    '        <button type="button" class="messenger-close" data-dismiss="alert">×</button>\n' +
                    '        <div class="messenger-message-inner">'+result.data.success+'</div>\n' +
                    '        <div class="messenger-spinner">\n' +
                    '    <span class="messenger-spinner-side messenger-spinner-side-left">\n' +
                    '        <span class="messenger-spinner-fill"></span>\n' +
                    '    </span>\n' +
                    '            <span class="messenger-spinner-side messenger-spinner-side-right">\n' +
                    '        <span class="messenger-spinner-fill"></span>\n' +
                    '    </span>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '</li></ul>');
                if (result.data.hasOwnProperty('url'))
                {
                    window.open(result.data.url,'_blank');
                }
            },
            error:function(data){
                const body = $('body');
                let errors = JSON.parse(data.responseText);
                body.append('<ul class="messenger messenger-fixed messenger-on-bottom messenger-on-right messenger-theme-flat"><li class="messenger-message-slot messenger-shown messenger-last">\n' +
                    '    <div class="messenger-message message alert error message-error alert-error">\n' +
                    '        <button type="button" class="messenger-close" data-dismiss="alert">×</button>\n' +
                    '        <div class="messenger-message-inner">'+errors.data.errors+'</div>\n' +
                    '        <div class="messenger-spinner">\n' +
                    '    <span class="messenger-spinner-side messenger-spinner-side-left">\n' +
                    '        <span class="messenger-spinner-fill"></span>\n' +
                    '    </span>\n' +
                    '            <span class="messenger-spinner-side messenger-spinner-side-right">\n' +
                    '        <span class="messenger-spinner-fill"></span>\n' +
                    '    </span>\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '</li></ul>');
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
    const body = $('body');
    body.append(
        '\
        <div id="page-modal-cover" style="visibility: hidden; opacity: 0">\n\
        <div class="open" id="modalGenerateCsr" style="visibility: hidden; top: 0px; opacity: 0">\n\
            <div class="testmodal">\n\
                <div class="modal-content panel panel-primary">\n\
                    <div class="modal-header panel-heading">\n\
                        <button type="button" class="close" id="closeCrossBtn" data-dismiss="modal">\n\
                            <span aria-hidden="true">&times;</span>\n\
                            <span class="sr-only">Close</span>\n\
                        </button>\n\
                        <h4 class="modal-title">' + title + '</h4>\n\
                    </div>\n\
                    <form id="modalGenerateCsrForm' + action + '">\n\
                    <div class="modal-body panel-body" id="modalgenerateCsrBody">\n\
                        <div class="alert alert-danger hidden" id="modalgenerateCsrDanger">\n\
                            <strong>Error!</strong> <span></span>\n\
                        </div>\n\
                        <form>\n\
                            <div class="col-md-1"></div>\n\
                              <div class="col-md-10" style="width:80%;">\n\
                                   <span class="message">' + message + '</span>\n\
                              </div>\n\
                            <div class="col-md-1"></div>\n\
                    </div>\n\
                    <div class="modal-footer panel-footer">\n\
                        <button type="button" id="submitModalBtn' + action + '" class="btn btn-primary">\n\
                            ' + 'Confirm' + '\n\
                        </button>\n\
                        <button type="button" class="btn btn-default" id="closeModalBtn" data-dismiss="modal">\n\
                            ' + 'Cancel' + '\n\
                        </button>\n\
                    </div>\n\
                    </form>\n\
                </div>\n\
            </div>\
       </div>\
       </div>'
    );
}

