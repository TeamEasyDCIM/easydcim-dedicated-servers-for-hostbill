$(document).ready(function () {
    getSettings();
    $('.mg-select2').select2();
    $('#LocationID').on('change', function() {
        let url = window.location.href;
        let data = {
            "ajax": "1",
            "reloadSelectsForLocation": "1",
            "locationId": $('#LocationID').val(),
            "osTemplateId": $('#OsTemplateID').val(),
        }
        addLoader($('#OsTemplateID'));
        addLoader($('#diskLayoutID'));
        addLoader($('#Extras'));
        $.ajax({
            type: "GET",
            url: url,
            data: data,
            success: function(data){
                const response = JSON.parse(data);

                if (response.data.templates !== null) {
                    const osTemplatesValues = Object.values(response.data.templates)
                        .map(item =>({ id: item.id, text: item.name}));
                    // console.log(values);
                    reloadOptions($('#OsTemplateID'),osTemplatesValues);
                }else {
                    reloadOptions($('#OsTemplateID'),[]);
                }
                if (response.data.addons !== null) {
                    const extrasValues = Object.values(response.data.addons)
                        .filter(item => item.type !== 'disklayout')
                        .map(item =>({ id: item.id, text: item.description}));
                    const diskLayoutValues = Object.values(response.data.addons)
                        .filter(item => item.type === 'disklayout')
                        .map(item =>({ id: item.id, text: item.description}));
                    // console.log(values);
                    reloadOptions($('#diskLayoutID'),diskLayoutValues);
                    reloadOptions($('#Extras'),extrasValues);
                }else {
                    reloadOptions($('#diskLayoutID'),[]);
                    reloadOptions($('#Extras'),[]);
                }

            },
            error: function(error) {
                reloadOptions($('#OsTemplateID'),[]);
                reloadOptions($('#diskLayoutID'),[]);
                reloadOptions($('#Extras'),[]);
            }
        });

    });
    $('#OsTemplateID').on('change', function() {
        let url = window.location.href;
        let data = {
            "ajax": "1",
            "reloadSelectsForOsTemplate": "1",
            "locationId": $('#LocationID').val(),
            "osTemplateId": $('#OsTemplateID').val(),
        }
        addLoader($('#diskLayoutID'));
        addLoader($('#Extras'));
        $.ajax({
            type: "GET",
            url: url,
            data: data,
            success: function(data){
                const response = JSON.parse(data);
                if (response.data.addons !== null)
                {
                    const diskLayoutValues = Object.values(response.data.addons)
                        .filter(item => item.type === 'disklayout')
                        .map(item =>({ id: item.id, text: item.description}));
                    const extrasValues = Object.values(response.data.addons)
                        .filter(item => item.type !== 'disklayout')
                        .map(item =>({ id: item.id, text: item.description}));
                    // console.log(values);
                    reloadOptions($('#diskLayoutID'),diskLayoutValues);
                    reloadOptions($('#Extras'),extrasValues);
                }else {
                    reloadOptions($('#diskLayoutID'),[]);
                    reloadOptions($('#Extras'),[]);
                }

            },
            error: function(error) {
                reloadOptions($('#diskLayoutID'),[]);
                reloadOptions($('#Extras'),[]);
            }
        });

    });
});

function reloadOptions(element, options)
{
    element.select2({
        data: options
    });
}

function addLoader(element)
{
    var selectizeInput = '<div class="selectize-input lu-form-control ajax items full has-options has-items"><div class="lu-preloader lu-preloader--sm mg-selectize-loader"></div></div>';
    element.html('');
    element.siblings('.select2-container').html('');
    element.siblings('.select2-container').append(selectizeInput);
}
function createConfigurableOptions(e){
    let btn = $(e);
    $(btn).buttonLoader('start');
    let url = window.location.href;
    let data = {
        "ajax": "1",
        "createConfigurableOptions": "1",
    }
    $.ajax({
        type: "GET",
        url: url,
        data: data,
        success: function(data){
            let message = JSON.parse(data).data.success
            $(btn).buttonLoader('stop');
            $('body').append('<ul class="messenger messenger-fixed messenger-on-bottom messenger-on-right messenger-theme-flat">\n' +
                '    <li class="messenger-message-slot messenger-shown messenger-first">\n' +
                '        <div class="messenger-message message alert info message-info alert-info">\n' +
                '            <button type="button" class="messenger-close" data-dismiss="alert">×</button>\n' +
                '            <div class="messenger-message-inner">'+message+'</div>\n' +
                '            <div class="messenger-spinner">\n' +
                '    <span class="messenger-spinner-side messenger-spinner-side-left">\n' +
                '        <span class="messenger-spinner-fill"></span>\n' +
                '    </span>\n' +
                '                <span class="messenger-spinner-side messenger-spinner-side-right">\n' +
                '        <span class="messenger-spinner-fill"></span>\n' +
                '    </span>\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </li>\n' +
                '</ul>')
        },
        error: function(error) {
            let errorMessage = JSON.parse(error.responseText).data.error;
            $(btn).buttonLoader('stop');

            $('body').append('<ul class="messenger messenger-fixed messenger-on-bottom messenger-on-right messenger-theme-flat">\n' +
                '    <li class="messenger-message-slot messenger-shown messenger-first">\n' +
                '        <div class="messenger-message message alert alert-error">\n' +
                '            <button type="button" class="messenger-close" data-dismiss="alert">×</button>\n' +
                '            <div class="messenger-message-inner">'+errorMessage+'</div>\n' +
                '            <div class="messenger-spinner">\n' +
                '    <span class="messenger-spinner-side messenger-spinner-side-left">\n' +
                '        <span class="messenger-spinner-fill"></span>\n' +
                '    </span>\n' +
                '                <span class="messenger-spinner-side messenger-spinner-side-right">\n' +
                '        <span class="messenger-spinner-fill"></span>\n' +
                '    </span>\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </li>\n' +
                '</ul>')
        }
    });
}
function appendPartsModal()
{
    const layers = $('#layers');
    layers.append('<div id="confirmationModal"  class="lu-modal show lu-modal--md">\n' +
        '    <div class="lu-modal__dialog">\n' +
        '        <div id="mgModalContainer" class="lu-modal__content">\n' +
        '            <div class="lu-modal__top lu-top">\n' +
        '                <div class="lu-top__title lu-type-6"><span class="lu-text-faded lu-font-weight-normal">\n' +
        '                        Add Part Requirement                    </span></div>\n' +
        '                <div class="lu-top__toolbar">\n' +
        '                    <button onclick="closeModal()" data-dismiss="lu-modal" aria-label="Close"\n' +
        '                            class="lu-btn lu-btn--xs lu-btn--default lu-btn--icon lu-btn--link lu-btn--plain closeModal">\n' +
        '                        <i class="lu-btn__icon lu-zmdi lu-zmdi-close"></i></button>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__body">\n' +
        '                <div class="lu-row">\n' +
        '                    <div class="lu-col-md-12">\n' +
        '                        <form id="addPartForm">\n' +
        '                            <div class="lu-form-group">\n' +
        '                               <label class="lu-form-label">\n' +
        '                                    Choose Part\n' +
        '                               </label>\n' +
        '                                <select name="partsType" class="mg-select2" tabindex="-1">\n' +
        '                                   <option value="HDD">HDD</option>\n' +
        '                                   <option value="SSD">SSD</option>\n' +
        '                                   <option value="RAM">RAM</option>\n' +
        '                                   <option value="CPU">CPU</option>\n' +
        '                               </select>\n' +
        '                            <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>\n' +
        '                           </div>\n' +
        '                        </form>\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__actions">\n' +
        '                <button onclick="additionalPartsAppend(event)" class="lu-btn lu-btn--success">\n' +
        '                    Add\n' +
        '                </button>\n' +
        '                <button onclick="closeModal()" class="lu-btn lu-btn--danger lu-btn--outline lu-btn--plain closeModal">\n' +
        '                    Cancel\n' +
        '                </button>\n' +
        '            </div>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '</div>');
    $('.mg-select2').select2();

}

function additionalPartsAppend(e)
{
    e.preventDefault();
    let form = $('#addPartForm');
    let serializeData = getFormData(form);
    let type = serializeData.partsType;
    let url = window.location.href;
    let data = {
        "ajax": "1",
        "partType": type,
    }
    closeModal();

    if (type != 'default')
    {
        $.ajax({
            type: "GET",
            url: url,
            data: data,
            success: function(data){
                let part = JSON.parse(data).data;
                $('div#additionalPartsRow').append(rowToAppend(part,type))
                $('.mg-select2-after').select2();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
            }
        });
    }
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

function rowToAppend(part,type)
{
    let labelForSize = 'Size [MB]';
    if (type == 'CPU')
    {
        labelForSize = 'CPU Cores'
    }
    let options = '';
    options += '<option value="default" selected>Any Model</option>'
    $( part ).each(function( index,value ) {
        options += '<option value="'+value.key+'">'+value.value+'</option>';
    });
    let div = '<div class="lu-row lu-m-b-2x">\n' +
        '        <div class="lu-col-md-7">\n' +
        '                <input type="hidden" name="options[parts][type][]" value="'+type+'">\n' +
        '                <label>'+type+'</label><select name="options[parts][model][]" class="mg-select2-after">\n' +
        '\n' +  options +
        '                </select>\n' +
        '        </div>\n' +
        '        <div class="lu-col-md-4">\n' +
        '                <label for="partsSize">'+labelForSize+'</label><input id="partsSize" type="text" name="options[parts][size][]" value="" class="lu-form-control">\n' +
        '        </div>\n' +
        '        <div class="lu-col-md-1">\n' +
        '                <a style="margin-top: 25px\n' +
        '\n" href="javascript:;" data-toggle="lu-tooltip" onclick="removePartsRow(this)" data-title="Remove" class="lu-btn lu-btn--sm lu-btn--danger lu-btn--link lu-btn--icon lu-btn--plain lu-tooltip drop-target drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center">\n' +
        '                        <i class="lu-btn__icon lu-zmdi lu-zmdi-delete"></i>\n' +
        '                </a>\n' +
        '        </div>\n' +
        '</div>';
    return div;
}

function closeModal()
{
    $('#confirmationModal').remove();
}

function removePartsRow(removeButton)
{
    $(removeButton).closest('.lu-row').remove();
}

function getSettings()
{
    let url = window.location.href;
    let data = {
        "getSettings": "1",
    }
    $.ajax({
        type: "GET",
        url: url,
        data: data,
        success: function(data){
            let parts = JSON.parse(data).data;
            $( parts.type ).each(function( index,value ) {
                additionalPartsAppendSettings(value,parts.model[index],parts.size[index]);
                // console.log(parts.model[index]);
                // console.log(parts.size[index]);
                // console.log(value);
            });
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
        }
    });

}

function additionalPartsAppendSettings(type,modelId,size)
{
    let url = window.location.href;
    let data = {
        "partType": type,
        "id": getUrlParameter('id')
    }
    if (type != 'default')
    {
        $.ajax({
            type: "GET",
            url: url,
            data: data,
            success: function(data){
                let part = JSON.parse(data).data;
                $('div#additionalPartsRow').append(rowToAppendSettings(part,type,modelId,size))
                $('.mg-select2-after').select2();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
            }
        });
    }
}

function rowToAppendSettings(part,type,modelId,size)
{
    let labelForSize = 'Size [MB]';
    if (type == 'CPU')
    {
        labelForSize = 'CPU Cores'
    }
    let options = '';
    if (modelId == 'default')
    {
        options += '<option value="default" selected>Any Model</option>'
    }else
    {
        options += '<option value="default">Any Model</option>'
    }
    $( part ).each(function( index,value ) {
        let selected = '';
        if (value.key == modelId)
        {
            selected = 'selected';
        }
        options += '<option value="'+value.key+'"'+selected+'>'+value.value+'</option>';
    });
    let div = '<div class="lu-row lu-m-b-2x">\n' +
        '        <div class="lu-col-md-7">\n' +
        '                <input type="hidden" name="options[parts][type][]" value="'+type+'">\n' +
        '                <label>'+type+'</label><select name="options[parts][model][]" class="mg-select2-after">\n' +
        '\n' +  options +
        '                </select>\n' +
        '        </div>\n' +
        '        <div class="lu-col-md-4">\n' +
        '                <label for="partsSize">'+labelForSize+'</label><input id="partsSize" type="text" name="options[parts][size][]" value="'+size+'" class="lu-form-control">\n' +
        '        </div>\n' +
        '        <div class="lu-col-md-1">\n' +
        '                <a style="margin-top: 25px\n' +
        '\n" href="javascript:;" data-toggle="lu-tooltip" onclick="removePartsRow(this)" data-title="Remove" class="lu-btn lu-btn--sm lu-btn--danger lu-btn--link lu-btn--icon lu-btn--plain lu-tooltip drop-target drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center">\n' +
        '                        <i class="lu-btn__icon lu-zmdi lu-zmdi-delete"></i>\n' +
        '                </a>\n' +
        '        </div>\n' +
        '</div>';
    return div;
}

function appendConfigurableOptionsPartsModal()
{
    const layers = $('#layers');
    layers.append('<div id="confirmationConfigurableOptionsModal"  class="lu-modal show lu-modal--md">\n' +
        '    <div class="lu-modal__dialog">\n' +
        '        <div id="mgModalContainer" class="lu-modal__content">\n' +
        '            <div class="lu-modal__top lu-top">\n' +
        '                <div class="lu-top__title lu-type-6"><span class="lu-text-faded lu-font-weight-normal">\n' +
        '                        Create Configurable Options For Parts                    </span></div>\n' +
        '                <div class="lu-top__toolbar">\n' +
        '                    <button onclick="closeConfigurableOptionsModal()" data-dismiss="lu-modal" aria-label="Close"\n' +
        '                            class="lu-btn lu-btn--xs lu-btn--default lu-btn--icon lu-btn--link lu-btn--plain closeModal">\n' +
        '                        <i class="lu-btn__icon lu-zmdi lu-zmdi-close"></i></button>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__body">\n' +
        '                <div class="lu-row">\n' +
        '                    <div class="lu-col-md-12">\n' +
        '                        <form id="addConfigurableOptionsPartForm">\n' +
        '                            <div class="lu-form-group">\n' +
        '                               <label class="lu-form-label">\n' +
        '                                    Part Type\n' +
        '                               </label>\n' +
        '                                <select name="partsType" class="partTypeOption" tabindex="-1">\n' +
        '                                   <option></option>\n' +
        '                                   <option value="8">HDD</option>\n' +
        '                                   <option value="9">SSD</option>\n' +
        '                                   <option value="10">RAM</option>\n' +
        '                                   <option value="11">CPU</option>\n' +
        '                               </select>\n' +
        '                            <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>\n' +
        '                           </div>\n' +        '                            <div class="lu-form-group">\n' +
        '                               <label class="lu-form-label">\n' +
        '                                    Part Model\n' +
        '                               </label>\n' +
        '                               <select name="partsModel" class="partModelOption" tabindex="-1">\n' +
        '                                <option></option>\n' +
        '                               </select>\n' +
        '                            <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>\n' +
        '                           </div>\n' +
        '                        </form>\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__actions">\n' +
        '                <button onclick="addConfigurableOptionForPart(event)" class="lu-btn lu-btn--success">\n' +
        '                    Create\n' +
        '                </button>\n' +
        '                <button onclick="closeConfigurableOptionsModal()" class="lu-btn lu-btn--danger lu-btn--outline lu-btn--plain closeModal">\n' +
        '                    Cancel\n' +
        '                </button>\n' +
        '            </div>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '</div>');
    let partTypeOption = $('.partTypeOption');
    let partModelOption = $('.partModelOption');
    partTypeOption.select2({
        placeholder: "Choose Type",
        allowClear: true
    });
    partModelOption.select2({
        placeholder: "Choose Type First",
        allowClear: true
    });
    partTypeOption.on("select2:select", function (e) {
        partModelOption.empty();

        let partTypeName = e.params.data.text;
        let partTypeId = e.params.data.id;
        let url = window.location.href;
        let data = {
            "partTypeName": partTypeName,
            "partTypeId": partTypeId,
            "id": getUrlParameter('id')
        }
        $.ajax({
            type: 'GET',
            url: url,
            data: data
        }).then(function (data) {
            let option = new Option('Any Model', 'default', false, false);
            partModelOption.append(option)
            let models = JSON.parse(data).data;
            $( models ).each(function( index,value ) {
                let option = new Option(value.value, value.key, false, false);
                partModelOption.append(option)
            });
        });
    });

}

function closeConfigurableOptionsModal()
{
    $('#confirmationConfigurableOptionsModal').remove();
}

function addConfigurableOptionForPart(e)
{
    e.preventDefault();
    let form = $('#addConfigurableOptionsPartForm');
    let serializeData = getFormData(form);
    let url = window.location.href;
    let data = {
        "ajax": "1",
        "createConfigurableOptionsForParts": "1",
        "configurableOptionPartModel": serializeData.partsModel,
        "configurableOptionPartModelName": $('.partModelOption option:selected').text(),
        "configurableOptionPartType": serializeData.partsType,
        "configurableOptionPartTypeName": $('.partTypeOption option:selected').text(),
    }

    $.ajax({
        type: "GET",
        url: url,
        data: data,
        success: function(data){
            let message = JSON.parse(data).data.success
            closeConfigurableOptionsModal()
            $('body').append('<ul class="messenger messenger-fixed messenger-on-bottom messenger-on-right messenger-theme-flat">\n' +
                '    <li class="messenger-message-slot messenger-shown messenger-first">\n' +
                '        <div class="messenger-message message alert info message-info alert-info">\n' +
                '            <button type="button" class="messenger-close" data-dismiss="alert">×</button>\n' +
                '            <div class="messenger-message-inner">'+message+'</div>\n' +
                '            <div class="messenger-spinner">\n' +
                '    <span class="messenger-spinner-side messenger-spinner-side-left">\n' +
                '        <span class="messenger-spinner-fill"></span>\n' +
                '    </span>\n' +
                '                <span class="messenger-spinner-side messenger-spinner-side-right">\n' +
                '        <span class="messenger-spinner-fill"></span>\n' +
                '    </span>\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </li>\n' +
                '</ul>');

        },
        error: function(error) {
            let errorMessage = JSON.parse(error.responseText).data.error;
            $('body').append('<ul class="messenger messenger-fixed messenger-on-bottom messenger-on-right messenger-theme-flat">\n' +
                '    <li class="messenger-message-slot messenger-shown messenger-first">\n' +
                '        <div class="messenger-message message alert alert-error">\n' +
                '            <button type="button" class="messenger-close" data-dismiss="alert">×</button>\n' +
                '            <div class="messenger-message-inner">'+errorMessage+'</div>\n' +
                '            <div class="messenger-spinner">\n' +
                '    <span class="messenger-spinner-side messenger-spinner-side-left">\n' +
                '        <span class="messenger-spinner-fill"></span>\n' +
                '    </span>\n' +
                '                <span class="messenger-spinner-side messenger-spinner-side-right">\n' +
                '        <span class="messenger-spinner-fill"></span>\n' +
                '    </span>\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </li>\n' +
                '</ul>')
        }
    });

}

function appendConfigurableOptionsMetadataModal(e)
{
    let btn = $(e);
    $(btn).buttonLoader('start');
    let url = window.location.href;
    let data = {
        "metadataSelect": 1,
        "id": getUrlParameter('id')
    }
    $.ajax({
        type: 'GET',
        url: url,
        data: data
    }).then(function (data) {
        $(btn).buttonLoader('stop');
        const layers = $('#layers');
        layers.append('<div id="confirmationConfigurableOptionsModal"  class="lu-modal show lu-modal--md">\n' +
            '    <div class="lu-modal__dialog">\n' +
            '        <div id="mgModalContainer" class="lu-modal__content">\n' +
            '            <div class="lu-modal__top lu-top">\n' +
            '                <div class="lu-top__title lu-type-6"><span class="lu-text-faded lu-font-weight-normal">\n' +
            '                        Create Configurable Option For Metadata\n' +
            '                    </span></div>\n' +
            '                <div class="lu-top__toolbar">\n' +
            '                    <button onclick="closeConfigurableOptionsModal()" data-dismiss="lu-modal" aria-label="Close"\n' +
            '                            class="lu-btn lu-btn--xs lu-btn--default lu-btn--icon lu-btn--link lu-btn--plain closeModal">\n' +
            '                        <i class="lu-btn__icon lu-zmdi lu-zmdi-close"></i></button>\n' +
            '                </div>\n' +
            '            </div>\n' +
            '            <div class="lu-modal__body">\n' +
            '                <div class="lu-row">\n' +
            '                    <div class="lu-col-md-12">\n' +
            '                        <form id="addConfigurableOptionsMetadataForm">\n' +
            '                            <div class="lu-form-group">\n' +
            '                               <label class="lu-form-label">\n' +
            '                                    Metadata Configurable Option\n' +
            '                               </label>\n' +
            '                                <select name="metadataType" class="metadataTypeOption" tabindex="-1">\n' +
            '                                   <option></option>\n' +
            '                               </select>\n' +
            '                           </div>\n' +
            '                        </form>\n' +
            '                    </div>\n' +
            '                </div>\n' +
            '            </div>\n' +
            '            <div class="lu-modal__actions">\n' +
            '                <button onclick="addConfigurableOptionForMetadata(event)" class="lu-btn lu-btn--success">\n' +
            '                    Create\n' +
            '                </button>\n' +
            '                <button onclick="closeConfigurableOptionsModal()" class="lu-btn lu-btn--danger lu-btn--outline lu-btn--plain closeModal">\n' +
            '                    Cancel\n' +
            '                </button>\n' +
            '            </div>\n' +
            '        </div>\n' +
            '    </div>\n' +
            '</div>');
        let metadataTypeOption = $('.metadataTypeOption');
        metadataTypeOption.select2({
            placeholder: "Choose Metadata",
            allowClear: true
        });
        let metadata = JSON.parse(data).data;
        $( metadata ).each(function( index,value ) {
            let option = new Option(value.label, value.id, false, false);
            metadataTypeOption.append(option)
        });
    });

}

function addConfigurableOptionForMetadata(e)
{
    e.preventDefault();
    let form = $('#addConfigurableOptionsMetadataForm');
    let serializeData = getFormData(form);
    let url = window.location.href;
    let data = {
        "ajax": "1",
        "createConfigurableOptionsForMetadata": "1",
        "configurableOptionMetadataId": serializeData.metadataType,
    }

    $.ajax({
        type: "GET",
        url: url,
        data: data,
        success: function(data){
            let message = JSON.parse(data).data.success
            closeConfigurableOptionsModal()
            $('body').append('<ul class="messenger messenger-fixed messenger-on-bottom messenger-on-right messenger-theme-flat">\n' +
                '    <li class="messenger-message-slot messenger-shown messenger-first">\n' +
                '        <div class="messenger-message message alert info message-info alert-info">\n' +
                '            <button type="button" class="messenger-close" data-dismiss="alert">×</button>\n' +
                '            <div class="messenger-message-inner">'+message+'</div>\n' +
                '            <div class="messenger-spinner">\n' +
                '    <span class="messenger-spinner-side messenger-spinner-side-left">\n' +
                '        <span class="messenger-spinner-fill"></span>\n' +
                '    </span>\n' +
                '                <span class="messenger-spinner-side messenger-spinner-side-right">\n' +
                '        <span class="messenger-spinner-fill"></span>\n' +
                '    </span>\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </li>\n' +
                '</ul>');

        },
        error: function(error) {
            let errorMessage = JSON.parse(error.responseText).data.error;
            $('body').append('<ul class="messenger messenger-fixed messenger-on-bottom messenger-on-right messenger-theme-flat">\n' +
                '    <li class="messenger-message-slot messenger-shown messenger-first">\n' +
                '        <div class="messenger-message message alert alert-error">\n' +
                '            <button type="button" class="messenger-close" data-dismiss="alert">×</button>\n' +
                '            <div class="messenger-message-inner">'+errorMessage+'</div>\n' +
                '            <div class="messenger-spinner">\n' +
                '    <span class="messenger-spinner-side messenger-spinner-side-left">\n' +
                '        <span class="messenger-spinner-fill"></span>\n' +
                '    </span>\n' +
                '                <span class="messenger-spinner-side messenger-spinner-side-right">\n' +
                '        <span class="messenger-spinner-fill"></span>\n' +
                '    </span>\n' +
                '            </div>\n' +
                '        </div>\n' +
                '    </li>\n' +
                '</ul>')
        }
    });

}


function appendMetadataModal(e)
{
    let btn = $(e);
    $(btn).buttonLoader('start');
    let url = window.location.href;
    let data = {
        "metadataSelect": 1,
        "id": getUrlParameter('id')
    }
    $.ajax({
        type: 'GET',
        url: url,
        data: data
    }).then(function (data) {
        $(btn).buttonLoader('stop');
        const layers = $('#layers');
        layers.append('<div id="confirmationModal"  class="lu-modal show lu-modal--md">\n' +
            '    <div class="lu-modal__dialog">\n' +
            '        <div id="mgModalContainer" class="lu-modal__content">\n' +
            '            <div class="lu-modal__top lu-top">\n' +
            '                <div class="lu-top__title lu-type-6"><span class="lu-text-faded lu-font-weight-normal">\n' +
            '                        Add Metadata Requirement\n' +
            '                    </span></div>\n' +
            '                <div class="lu-top__toolbar">\n' +
            '                    <button onclick="closeModal()" data-dismiss="lu-modal" aria-label="Close"\n' +
            '                            class="lu-btn lu-btn--xs lu-btn--default lu-btn--icon lu-btn--link lu-btn--plain closeModal">\n' +
            '                        <i class="lu-btn__icon lu-zmdi lu-zmdi-close"></i></button>\n' +
            '                </div>\n' +
            '            </div>\n' +
            '            <div class="lu-modal__body">\n' +
            '                <div class="lu-row">\n' +
            '                    <div class="lu-col-md-12">\n' +
            '                        <form id="addMetadataForm">\n' +
            '                            <div class="lu-form-group">\n' +
            '                               <label class="lu-form-label">\n' +
            '                                    Metadata Requirement\n' +
            '                               </label>\n' +
            '                                <select name="metadataType" class="metadataTypeOption" tabindex="-1">\n' +
            '                                   <option></option>\n' +
            '                               </select>\n' +
            '                           </div>\n' +
            '                        </form>\n' +
            '                    </div>\n' +
            '                </div>\n' +
            '            </div>\n' +
            '            <div class="lu-modal__actions">\n' +
            '                <button onclick="additionalMetadataAppend(event)" class="lu-btn lu-btn--success">\n' +
            '                    Create\n' +
            '                </button>\n' +
            '                <button onclick="closeModal()" class="lu-btn lu-btn--danger lu-btn--outline lu-btn--plain closeModal">\n' +
            '                    Cancel\n' +
            '                </button>\n' +
            '            </div>\n' +
            '        </div>\n' +
            '    </div>\n' +
            '</div>');
        let metadataTypeOption = $('.metadataTypeOption');
        metadataTypeOption.select2({
            placeholder: "Choose Metadata",
            allowClear: true
        });
        let metadata = JSON.parse(data).data;
        $( metadata ).each(function( index,value ) {
            let option = new Option(value.label, value.id, false, false);
            metadataTypeOption.append(option)
        });
    });
}

function additionalMetadataAppend(e)
{
    e.preventDefault();
    let form = $('#addMetadataForm');
    let serializeData = getFormData(form);
    let type = serializeData.metadataType;
    let url = window.location.href;
    let data = {
        "ajax": "1",
        "metadataType": type,
    }
    closeModal();

    if (type != 'default')
    {
        $.ajax({
            type: "GET",
            url: url,
            data: data,
            success: function(data){
                let metadata = JSON.parse(data).data.fieldData;
                $('div#additionalMetadataRow').append(metadataRowToAppend(metadata))
                $('.mg-select2-after').select2();
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
            }
        });
    }
}

function metadataRowToAppend(metadata)
{
    if (metadata.element === 'dropdown')
    {
        let options = '';
        $.each(metadata.options,function( index,value ) {
            options += '<option value="'+index+'">'+value+'</option>';
        });
        let div = '<div class="lu-row lu-m-b-2x">\n' +
            '        <div class="lu-col-md-11">\n' +
            '                <label>'+metadata.label+'</label><select name="options[metadata]['+metadata.id+']" class="mg-select2-after">\n' +
            '\n' +  options +
            '                </select>\n' +
            '        </div>\n' +
            '        <div class="lu-col-md-1">\n' +
            '                <a style="margin-top: 25px\n' +
            '\n" href="javascript:;" data-toggle="lu-tooltip" onclick="removePartsRow(this)" data-title="Remove" class="lu-btn lu-btn--sm lu-btn--danger lu-btn--link lu-btn--icon lu-btn--plain lu-tooltip drop-target drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center">\n' +
            '                        <i class="lu-btn__icon lu-zmdi lu-zmdi-delete"></i>\n' +
            '                </a>\n' +
            '        </div>\n' +
            '</div>';
        return div;
    }else{
        let div = '<div class="lu-row lu-m-b-2x">\n' +
            '        <div class="lu-col-md-11">\n' +
            '                <label>'+metadata.label+'</label><input name="options[metadata]['+metadata.id+']" class="lu-form-control">\n' +
            '        </div>\n' +
            '        <div class="lu-col-md-1">\n' +
            '                <a style="margin-top: 25px\n' +
            '\n" href="javascript:;" data-toggle="lu-tooltip" onclick="removePartsRow(this)" data-title="Remove" class="lu-btn lu-btn--sm lu-btn--danger lu-btn--link lu-btn--icon lu-btn--plain lu-tooltip drop-target drop-element-attached-bottom drop-element-attached-center drop-target-attached-top drop-target-attached-center">\n' +
            '                        <i class="lu-btn__icon lu-zmdi lu-zmdi-delete"></i>\n' +
            '                </a>\n' +
            '        </div>\n' +
            '</div>';
        return div;
    }

}
