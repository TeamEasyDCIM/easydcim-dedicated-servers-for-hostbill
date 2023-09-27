let popup = false;
$(document).ready(function (e) {
    $('#rebuildTable').DataTable({
        lengthChange: false,
        ordering: false,
        searching: false,
        info:false
    });
    let instalationStatus = $('#instalationStatusForReload').val();
    let currentInstaltionStatus = instalationStatus;
    setInterval(function(a){
        let url = window.location.href;
        if (popup === false)
        {
            $.ajax({
                type: "GET",
                url: url + '&ajax=1&reloadRebuild=1',
                success: function(data){
                    currentInstaltionStatus = JSON.parse(data).data.installationStatus
                    if (currentInstaltionStatus != a)
                    {
                        location.reload();
                    }
                },
                error: function(data) {
                }
            });
        }
    }, 15000, instalationStatus);
});
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

function rebuild()
{
    let form = $('#rebuildForm');
    let serializeData = getFormData(form);
    let url = window.location.href;
    closeModal();

    $.ajax({
        type: "GET",
        url: url + '&ajax=1&rebuild=1&' + $.param({formdata: serializeData}),
        success: function(data){
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

function generateCIModal(e,installationInformation)
{
    popup = true;
    const layers = $('#layers');
    layers.append('<div id="confirmationModal" class="lu-modal show lu-modal--info modal--sm modal--zoomIn">\n' +
        '        <div class="lu-modal__dialog">\n' +
        '            <div id="mgModalContainer" class="lu-modal__content">\n' +
        '                <div class="lu-modal__top lu-top">\n' +
        '                    <div class="lu-top__title lu-type-6 lu-text-faded">\n' +
        '                        '+installationInformation.hostname+' ('+installationInformation.hostInformation+') - Cancel OS Installation\n' +
        '                    </div>\n' +
        '                    <div class="lu-top__toolbar">\n' +
        '                        <button data-dismiss="lu-modal" onclick="closeModal()" aria-label="Close"\n' +
        '                                class="lu-btn lu-btn--xs lu-btn--default lu-btn--icon lu-btn--link lu-btn--plain closeModal">\n' +
        '                            <i class="lu-btn__icon lu-zmdi lu-zmdi-close"></i></button>\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '                <div class="lu-modal__body lu-m-b-0x"><div class="lu-form-group">\n' +
        '\n' +
        '                   Are you sure you want to abort the installation process? \n' +
        '</div>\n' +
        '\n' +
        '                <div class="lu-modal__actions">\n' +
        '                    <button onclick="cancelInstalation()" class="lu-btn lu-btn--primary submitForm mg-submit-form">\n' +
        '                        Cancel Installation\n' +
        '                    </button>\n' +
        '                    <button class="lu-btn lu-btn--danger lu-btn--outline lu-btn--plain closeModal" onclick="closeModal()">\n' +
        '                        Cancel\n' +
        '                    </button>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '        </div>\n' +
        '    </div>');
}

function cancelInstalation()
{
    let url = window.location.href;
    closeModal();
    $.ajax({
        type: "GET",
        url: url + '&ajax=1&cancelInstallation=1',
        success: function(data){
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

function generatePassword(e)
{
    let input = $(e)[0].parentElement.children[0];
    let length = 8;
    var randKey = "";
    var avChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < length; i++) {
        randKey += avChars.charAt(Math.floor(Math.random() * avChars.length));
    }

    $(input).val(randKey);
}

function closeModal()
{
    $('#confirmationModal').remove();
    popup = false;
}

function generateRBModal(e,instaltionInformation,CaTemplates)
{
    popup = true;
    generateRebuildModal(instaltionInformation,CaTemplates);
    $('.mgselect2Templates').select2({
        placeholder: "Select a template",
    });
    $('#templateRebuildSelect').on('change',function () {
        let selectedTemplateId = $('#templateRebuildSelect option:selected').val();
        let rebuildForm = $('#rebuildForm');
        let extrasDiv = $('#extrasDiv');
        let diskLayoutDiv = $('#diskLayoutDiv');
        if (extrasDiv.length != 0)
        {
            extrasDiv.remove();
        }
        if (diskLayoutDiv.length != 0)
        {
            diskLayoutDiv.remove();
        }
        $( CaTemplates ).each(function( index,value ) {
            if (value.id == selectedTemplateId)
            {

                if (value.diskLayout.length != 0)
                {
                    let diskLayout = '<option></option>';

                    $( value.diskLayout ).each(function( index,value ) {
                        diskLayout += '<option value="'+value.key+'">'+value.value+'</option>';
                    });

                    let divForDiskLayout = '<div id="diskLayoutDiv" class="lu-form-group"><label class="lu-form-label text-black"> Disk Layout </label> <select id="diskLayoutSelect" name="rebuildDiskLayout"\n' +
                        '                                                                                      class="lu-form-control"\n' +
                        '                                                                                                         tabindex="-1">'+diskLayout+'</select>\n' +
                        '        <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>\n' +
                        '</div>';
                    rebuildForm.append(divForDiskLayout);
                    $('#diskLayoutSelect').select2({
                        placeholder: "Select Disk Layout addons",
                        // allowClear: true
                    });
                }
                if (value.extras.length != 0)
                {
                    let extras = '';

                    $( value.extras ).each(function( index,value ) {
                        extras += '<option value="'+value.key+'">'+value.value+'</option>';
                    });
                    let divForExtras = '<div id="extrasDiv" class="lu-form-group"><label class="lu-form-label text-black">Extras </label> <select id="extrasSelect" multiple="multiple" name="rebuildExtras" \n' +
                        '    class="lu-form-control">'+extras+'</select>\n' +
                        '    <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>\n' +
                        '</div>';
                    rebuildForm.append(divForExtras);
                    // // $('#extrasSelect').select2({
                    // //     placeholder: "Select Extras Addons",
                    // //     // allowClear: true
                    // // });
                    // $("#extrasSelect").select2({
                    //     data:[{id:0,text:'enhancement'},{id:1,text:'bug'},{id:2,text:'duplicate'},{id:3,text:'invalid'},{id:4,text:'wontfix'}]
                    // });
                }
            }
        });
    })
}

function generateRebuildModal(instaltionInformation,CaTemplates) {
    let caTemplates = '<option></option>';
    let username = instaltionInformation.username;
    let hostname = instaltionInformation.hostname;
    let sshPassword = instaltionInformation.sshPassword;
    let sshRootPassword = instaltionInformation.sshRootPassword;
    $( CaTemplates ).each(function( index,value ) {
        caTemplates += '<option value="'+value.id+'">'+value.Description+'</option>';
    });

    const layers = $('#layers');
    layers.append('<div id="confirmationModal" class="lu-modal show lu-modal--info modal--sm modal--zoomIn">\n' +
        '        <div class="lu-modal__dialog">\n' +
        '            <div id="mgModalContainer" class="lu-modal__content">\n' +
        '                <div class="lu-modal__top lu-top">\n' +
        '                    <div class="lu-top__title lu-type-6 lu-text-faded">\n' +
        '                        '+hostname+' ('+instaltionInformation.hostInformation+') - Reinstall OS\n' +
        '                    </div>\n' +
        '                    <div class="lu-top__toolbar">\n' +
        '                        <button data-dismiss="lu-modal" onclick="closeModal()" aria-label="Close"\n' +
        '                                class="lu-btn lu-btn--xs lu-btn--default lu-btn--icon lu-btn--link lu-btn--plain closeModal">\n' +
        '                            <i class="lu-btn__icon lu-zmdi lu-zmdi-close"></i></button>\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '                <div class="lu-modal__body lu-m-b-0x"><div class="lu-form-group"><div class="lu-alert lu-alert--danger">\n' +
        '    <div class="lu-alert__body">\n' +
        '        <b>Warning:</b> Reinstallation of OS will result in all the current data located on the server to be lost.\n' +
        '    </div>\n' +
        '</div>\n' +
        '                    <form id="rebuildForm">\n' +
        '                        <div class="lu-form-group"><label class="lu-form-label text-black">OS Template</label> ' +
        '                       <select id="templateRebuildSelect" name="templateCaId"\n' +
        '                                                                                      class="lu-form-control mgselect2Templates"\n' +
        '                           >'+caTemplates+'</select>\n' +
        '                       <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>\n' +
        '                       </div>' +
        '                       <div class="lu-form-group"><label class="lu-form-label text-black">\n' +
        '                                Hostname </label> <input type="text" placeholder="" name="rebuildHostname" value="'+hostname+'"\n' +
        '                                                         class="lu-form-control">\n' +
        '                            <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>\n' +
        '                        </div>\n' +
        '                        <div class="lu-form-group"><label class="lu-form-label text-black">\n' +
        '                                Username </label> <input type="text" placeholder="" name="rebuildUsername" value="'+username+'"\n' +
        '                                                         class="lu-form-control">\n' +
        '                            <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>\n' +
        '                        </div>\n' +
        '                        <div class="lu-form-group"><label class="lu-form-label text-black">\n' +
        '                                Password </label>\n' +
        '                            <div class="lu-input-group"><input value="'+sshPassword+'" type="text" placeholder="" name="rebuildPassword"\n' +
        '                                                               class="lu-form-control">\n' +
        '                                <button type="button" onclick="generatePassword(this)" class="lu-input-group__btn lu-btn lu-btn--default"><span\n' +
        '                                            class="lu-btn__text">Generate</span></button>\n' +
        '                            </div>\n' +
        '                            <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>\n' +
        '                        </div>\n' +
        '                        <div class="lu-form-group"><label class="lu-form-label text-black">\n' +
        '                                Root SSH Password </label>\n' +
        '                            <div class="lu-input-group"><input value="'+sshRootPassword+'" type="text" placeholder="" name="rebuildRootSSHPassword"\n' +
        '                                                               class="lu-form-control">\n' +
        '                                <button type="button" onclick="generatePassword(this)" class="lu-input-group__btn lu-btn lu-btn--default"><span\n' +
        '                                            class="lu-btn__text">Generate</span></button>\n' +
        '                            </div>\n' +
        '                            <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>\n' +
        '                        </div>\n' +
        '                   </form>\n' +
        '                </div>\n' +
        '                <div class="lu-modal__actions">\n' +
        '                    <button onclick="rebuild()" class="lu-btn lu-btn--primary submitForm mg-submit-form">\n' +
        '                        Reinstall OS\n' +
        '                    </button>\n' +
        '                    <button class="lu-btn lu-btn--danger lu-btn--outline lu-btn--plain closeModal" onclick="closeModal()">\n' +
        '                        Cancel\n' +
        '                    </button>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '        </div>\n' +
        '    </div>');
}