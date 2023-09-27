$(document).ready(function (e) {
    $('#serverInformation').DataTable({
        lengthChange: false,
        ordering: false,
        searching: false,
        info: false
    });
});

function  showChangeHostnameModal(hostname)
{
    const layers = $('#layers');
    layers.append('<div id="confirmationModal" class="lu-modal show lu-modal--info modal--sm modal--zoomIn">\n' +
        '        <div class="lu-modal__dialog">\n' +
        '            <div id="mgModalContainer" class="lu-modal__content">\n' +
        '                <div class="lu-modal__top lu-top"><i class="lu-top__icon lu-zmdi lu-zmdi-info-outline lu-text-success"></i>\n' +
        '                    <div class="lu-top__title lu-type-4 lu-text-success">\n' +
        '                        Change Hostname\n' +
        '                    </div>\n' +
        '                    <div class="lu-top__toolbar">\n' +
        '                        <button data-dismiss="lu-modal" onclick="closeModal()" aria-label="Close"\n' +
        '                                class="lu-btn lu-btn--xs lu-btn--default lu-btn--icon lu-btn--link lu-btn--plain closeModal">\n' +
        '                            <i class="lu-btn__icon lu-zmdi lu-zmdi-close"></i></button>\n' +
        '                    </div>\n' +
        '                </div>\n' +
        '                <div class="lu-modal__body">\n' +
        '                    <form id="changeHostname">\n' +
        '                        <div class="lu-form-group"><label class="lu-form-label">\n' +
        '                                Hostname </label> <input type="text" placeholder="" name="changeHostname" value="'+hostname+'"\n' +
        '                                                         class="lu-form-control">\n' +
        '                            <div hidden="hidden" class="lu-form-feedback lu-form-feedback--icon"></div>\n' +
        '                        </div>\n' +
        '                        </form>\n' +
        '                </div>\n' +
        '                <div class="lu-modal__actions">\n' +
        '                    <button onclick="changeHostname(event)" class="lu-btn lu-btn--success submitForm mg-submit-form">\n' +
        '                        Confirm\n' +
        '                    </button>\n' +
        '                    <button class="lu-btn lu-btn--danger lu-btn--outline lu-btn--plain closeModal" onclick="closeModal()">\n' +
        '                        Cancel\n' +
        '                    </button>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '        </div>\n' +
        '    </div>');
}

function closeModal()
{
    $('#confirmationModal').remove();
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

function changeHostname(e)
{
    e.preventDefault();
    let form = $('#changeHostname');
    let serializeData = getFormData(form);
    let url = window.location.href;
    closeModal()

    $.ajax({
        type: "GET",
        url: url + '&ajax=1&changeHostname=1&' + $.param({formdata: serializeData}),
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

