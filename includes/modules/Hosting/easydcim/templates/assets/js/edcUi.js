/**
 * The WHMCS module's UI components, rebuilt for the HostBill templates.
 *
 * WHMCS draws its pages with the ModulesGarden Vue components; HostBill renders
 * the rows server side, so this file adds the same behaviour and markup around
 * them:
 *  - table():  components/DataTable - search box, page buttons, page size
 *              buttons (5/10/20/50/100/infinity), "No records found", mass
 *              action bar with the "N Items Selected" counter.
 *  - modal():  components/Modal - ModalEdit and the ModalSuccess / ModalDanger /
 *              ModalWarning confirmations with their buttons.
 *  - field.*:  the form builder's fields (label + tooltip, selects, switcher,
 *              date-time picker, password with "Generate").
 *  - scopeModal(): the period filters (Filter Mode / Period / Start and End
 *              Date) of the graphs, the bandwidth table and the sensors.
 *
 * Strings come from window.EdcLang ("edcUi" in the module lang file).
 */
var EdcUi = (function ($) {
    'use strict';

    var INFINITE_LENGTH = 99999999;
    var PAGE_LENGTHS = [5, 10, 20, 50, 100];
    var PERIODS = [['td', 'today'], ['yd', 'yesterday'], ['tw', 'this_week'], ['lw', 'last_week'],
        ['tm', 'this_month'], ['lm', 'last_month'], ['ty', 'this_year'], ['ly', 'last_year']];
    // components/RandomStringGeneratorButton defaults
    var PASSWORD_ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+{}[];:"<>,./?';
    var PASSWORD_LENGTH = 10;

    function t(key) {
        var strings = window.EdcLang || {};
        return strings[key] !== undefined ? strings[key] : key;
    }

    function pageUrl() {
        return window.location.href.split('#')[0];
    }

    function parse(raw) {
        try {
            return (typeof raw === 'string' ? JSON.parse(raw) : raw).data || {};
        } catch (e) {
            return {};
        }
    }

    /* ------------------------------------------------------------------ */
    /* Messages - HostBill's own message boxes and PNotify                 */
    /* ------------------------------------------------------------------ */

    function notify(type, message) {
        var error = type === 'error';
        if (!message) {
            return;
        }
        var box = $(error ? '#errors' : '#infos');
        box.html('').css('display', 'block')
            .append($('<div></div>').addClass(error ? 'alert alert-error' : 'alert alert-info')
                .append('<a class="close">×</a>', document.createTextNode(message), '<br>'));
        if (typeof PNotify !== 'undefined') {
            new PNotify({text: message, type: error ? 'error' : 'info'});
        }
    }

    /**
     * Call the module on the current page (the way every widget here does) and
     * report the outcome. done/fail get the "data" part of the JSON answer.
     */
    function request(query, done, fail) {
        return $.ajax({type: 'GET', url: pageUrl() + query})
            .done(function (raw) {
                if (done) {
                    done(parse(raw));
                }
            })
            .fail(function (xhr) {
                var data = parse(xhr.responseText);
                if (fail) {
                    fail(data);
                    return;
                }
                notify('error', data.error || data.errors || '');
            });
    }

    /**
     * WHMCS reloads a single component after an action (ReloadById). Here the
     * page is fetched again and only the given element is swapped.
     */
    function reload(selector, after) {
        $.get(pageUrl(), function (html) {
            // DOMParser runs no scripts and does not depend on the page's jQuery version.
            var fresh = new DOMParser().parseFromString(html, 'text/html').querySelector(selector);
            var current = $(selector).first();
            if (fresh && current.length) {
                current.replaceWith(document.importNode(fresh, true));
            }
            if (after) {
                after();
            }
        }, 'text');
    }

    /* ------------------------------------------------------------------ */
    /* Form fields - components/Form builders                              */
    /* ------------------------------------------------------------------ */

    function tooltip(text) {
        return $('<i class="lu-i-c-2x lu-form-tooltip-helper lu-tooltip lu-zmdi lu-zmdi-help-outline" data-toggle="lu-tooltip"></i>')
            .attr('data-title', text)
            .append($('<span class="tooltiptext"></span>').text(text));
    }

    function group(label, control, help) {
        var labelEl = $('<label class="lu-form-label"></label>').text(label + ' ');
        if (help) {
            labelEl.append(tooltip(help));
        }
        return $('<div class="lu-form-group"></div>').append(labelEl, control);
    }

    // Typed dates may lack the seconds; the filters keep "YYYY-MM-DD HH:mm:ss" as WHMCS does.
    function fromPickerValue(value) {
        if (!value) {
            return '';
        }
        value = value.replace('T', ' ');
        return value.length === 16 ? value + ':00' : value;
    }

    function generatePassword() {
        var password = '';
        for (var i = 0; i < PASSWORD_LENGTH; i++) {
            password += PASSWORD_ALPHABET.charAt(Math.floor(Math.random() * PASSWORD_ALPHABET.length));
        }
        return password;
    }

    var field = {
        text: function (o) {
            var input = $('<input type="text" class="lu-form-control">')
                .attr({name: o.name, placeholder: o.placeholder || ''})
                .val(o.value === undefined || o.value === null ? '' : o.value);
            input.prop('disabled', !!o.disabled).prop('readonly', !!o.readonly);
            return group(o.label, input, o.tooltip);
        },
        textarea: function (o) {
            var input = $('<textarea class="lu-form-control" rows="5"></textarea>')
                .attr({name: o.name, placeholder: o.placeholder || ''})
                .val(o.value || '');
            return group(o.label, input, o.tooltip);
        },
        select: function (o) {
            var select = $('<select class="lu-form-control"></select>').attr('name', o.name).prop('multiple', !!o.multiple);
            if (o.placeholder !== undefined && !o.multiple) {
                select.append($('<option value=""></option>').text(o.placeholder));
            }
            $.each(o.options || [], function (i, option) {
                select.append($('<option></option>').attr('value', option[0]).text(option[1]));
            });
            if (o.value !== undefined && o.value !== null) {
                select.val(o.value);
            }
            return group(o.label, select, o.tooltip);
        },
        // components/DatePicker (DateTimePicker): a calendar icon, a clear icon on hover.
        datetime: function (o) {
            var input = $('<input type="text" class="lu-form-control" autocomplete="off" data-edc-datetime="1">')
                .attr('name', o.name)
                .val(o.value || '');
            var picker = $('<div class="edc-datepicker"></div>')
                .toggleClass('has-value', !!o.value)
                .append(input, '<i class="lu-zmdi lu-zmdi-calendar edc-datepicker__icon"></i>', '<i class="lu-zmdi lu-zmdi-close edc-datepicker__clear"></i>');
            return group(o.label, picker, o.tooltip);
        },
        password: function (o) {
            var input = $('<input type="text" class="lu-form-control">').attr('name', o.name).val(o.value || '');
            var button = $('<button type="button" class="lu-btn lu-btn--default"></button>')
                .append($('<span class="btn__text"></span>').text(t('generate')))
                .on('click', function (e) {
                    e.preventDefault();
                    input.val(generatePassword()).trigger('input');
                });
            return group(o.label, $('<div class="lu-input-group"></div>').append(input, button), o.tooltip);
        },
        // components/Switcher: the text, then the switch, inside one label.
        switcher: function (o) {
            var input = $('<input type="checkbox" value="1" class="lu-switch__checkbox no-icheck lu-form-control">')
                .attr('name', o.name)
                .prop('checked', !!o.checked);
            var text = $('<span class="lu-form-text"></span>').text(o.label);
            if (o.tooltip) {
                text.append(' ', tooltip(o.tooltip));
            }
            var switchEl = $('<div class="lu-switch"></div>')
                .append(input, '<span class="lu-switch__container"><span class="lu-switch__handle"></span></span>');
            return $('<div class="lu-form-group lu-form-check lu-m-b-2x"></div>')
                .append($('<label class="lu-form-label"></label>').append(text, switchEl));
        },
        hidden: function (name, value) {
            return $('<input type="hidden">').attr('name', name).val(value === undefined || value === null ? '' : value);
        }
    };

    // components/Alert - the text is markup in WHMCS as well (v-html).
    function alertBox(type, html, extraClass) {
        return $('<div class="lu-alert"></div>')
            .addClass('lu-alert--' + type)
            .addClass(extraClass || '')
            .append($('<div class="lu-alert__body"></div>').html(html));
    }

    /**
     * The libraries behind the fields: flatpickr for the date-time pickers (WHMCS
     * uses vue2-datepicker) and Tom Select, the successor of the selectize WHMCS
     * uses, for every dropdown. Neither depends on the page's jQuery version -
     * HostBill themes ship jQuery 1.7 to 1.9, too old for select2 4.
     */
    function initFields(scope) {
        scope = $(scope);
        if (window.flatpickr) {
            scope.find('input[data-edc-datetime]').each(function () {
                var input = $(this);
                var box = input.closest('.edc-datepicker');
                if (this._flatpickr) {
                    return;
                }
                var picker = window.flatpickr(this, {
                    enableTime: true,
                    enableSeconds: true,
                    time_24hr: true,
                    dateFormat: 'Y-m-d H:i:S',
                    allowInput: true,
                    disableMobile: true,
                    onChange: function (dates, text) {
                        box.toggleClass('has-value', text !== '');
                    }
                });
                input.on('input', function () {
                    box.toggleClass('has-value', this.value !== '');
                });
                box.find('.edc-datepicker__icon').on('click', function () {
                    picker.open();
                });
                box.find('.edc-datepicker__clear').on('click', function (e) {
                    e.preventDefault();
                    picker.clear();
                    box.removeClass('has-value');
                });
            });
        }
        if (window.TomSelect) {
            scope.find('select').each(function () {
                if (this.tomselect) {
                    return;
                }
                var multiple = this.multiple;
                // Tom Select copies the select's classes onto its wrapper; the
                // form-control frame belongs on its inner control instead.
                $(this).removeClass('lu-form-control');
                new window.TomSelect(this, {
                    plugins: multiple ? ['remove_button'] : [],
                    create: false,
                    maxOptions: null,
                    allowEmptyOption: true,
                    closeAfterSelect: !multiple
                });
            });
        }
    }

    function formValues(form) {
        var values = {};
        form.find('input, select, textarea').each(function () {
            var input = $(this);
            var name = input.attr('name');
            if (!name || input.prop('disabled')) {
                return;
            }
            if (input.is(':checkbox')) {
                values[name] = input.is(':checked') ? '1' : '';
                return;
            }
            var value = input.val();
            if (input.attr('data-edc-datetime')) {
                value = fromPickerValue(value);
            }
            values[name] = value === null ? (input.prop('multiple') ? [] : '') : value;
        });
        return values;
    }

    /**
     * Field errors the way components/FormGroup shows them, plus the form
     * level message WHMCS pops up. Returns true when there was any error.
     */
    function showErrors(form, errors) {
        form.find('.lu-form-group').removeClass('lu-is-error').children('.lu-form-feedback').remove();
        var any = false;
        $.each(errors, function (name, message) {
            if (!message) {
                return;
            }
            any = true;
            form.find('[name="' + name + '"]').first().closest('.lu-form-group')
                .addClass('lu-is-error')
                .append($('<div class="lu-form-feedback lu-form-feedback--icon"></div>').text(message));
        });
        if (any) {
            notify('error', t('form_validation_error'));
        }
        return any;
    }

    /* ------------------------------------------------------------------ */
    /* Modals - components/Modal                                           */
    /* ------------------------------------------------------------------ */

    var MODAL_TYPES = {
        edit: {submit: 'lu-btn lu-btn--plain lu-btn--success', action: false},
        success: {submit: 'lu-btn lu-btn--plain lu-btn--success', action: true},
        danger: {submit: 'lu-btn lu-btn--plain lu-btn--danger', action: true},
        warning: {submit: 'lu-btn lu-btn--plain lu-btn--warning', action: true}
    };

    /**
     * options: type (edit|success|danger|warning), title, body (elements),
     * submit / cancel (button texts), onSubmit(api), onOpen(api).
     * api: el, form, values(), errors(map), busy(bool), close().
     */
    function modal(options) {
        var type = MODAL_TYPES[options.type] ? options.type : 'edit';
        var action = MODAL_TYPES[type].action;
        var el = $('<div class="lu-modal show modal--zoomIn"></div>').toggleClass('lu-modal--info', action);
        var dialog = $('<div class="lu-modal__dialog"></div>').appendTo(el);
        var preloader = $('<div class="lu-preloader-container lu-preloader-container--full-screen lu-preloader-container--overlay"><div class="lu-preloader lu-preloader--sm"></div></div>')
            .hide()
            .appendTo(dialog);
        var content = $('<div class="lu-modal__content"></div>').appendTo(dialog);

        var top = $('<div class="lu-modal__top lu-top"></div>').appendTo(content);
        if (action) {
            top.append($('<i class="lu-top__icon lu-zmdi"></i>')
                .addClass(type === 'danger' ? 'lu-zmdi-alert-circle-o' : 'lu-zmdi-info-outline')
                .addClass('lu-text-' + type));
        }
        top.append($('<div class="lu-top__title"></div>')
            .addClass(action ? 'lu-text-' + type + ' lu-type-4' : 'lu-type-6')
            .append($('<span></span>').toggleClass('lu-font-weight-normal', !action).text(options.title || '')));
        var close = $('<button type="button" aria-label="Close" class="lu-btn lu-btn--xs lu-btn--default lu-btn--icon lu-btn--link lu-btn--plain closeModal"><i class="lu-btn__icon lu-zmdi lu-zmdi-close"></i></button>');
        top.append($('<div class="lu-top__toolbar"></div>').append(close));

        var form = $('<form class="lu-w-100" onsubmit="return false;"></form>');
        $.each(options.body || [], function (i, item) {
            if (item) {
                form.append(item);
            }
        });
        $('<div class="lu-modal__body"></div>').append(form).appendTo(content);

        var submit = $('<button type="button"></button>').addClass(MODAL_TYPES[type].submit)
            .append($('<span class="lu-btn__text"></span>').text(options.submit || t('confirm')));
        var cancel = $('<button type="button" class="lu-btn lu-btn--danger lu-btn--outline"></button>')
            .append($('<span class="lu-btn__text"></span>').text(options.cancel || t('cancel')));
        $('<div class="lu-modal__actions"></div>').append(submit, cancel).appendTo(content);

        var api = {
            el: el,
            form: form,
            values: function () {
                return formValues(form);
            },
            errors: function (map) {
                return showErrors(form, map);
            },
            busy: function (on) {
                preloader.toggle(!!on);
                // The label stays, and the width with it: the spinner is laid over it (mg_styles.css).
                submit.prop('disabled', !!on).toggleClass('edc-btn-loading', !!on).children('.edc-btn-spinner').remove();
                if (on) {
                    submit.append('<span class="edc-btn-spinner" aria-hidden="true"></span>');
                }
            },
            close: function () {
                el.remove();
            }
        };

        close.on('click', api.close);
        cancel.on('click', api.close);
        submit.on('click', function () {
            if (options.onSubmit) {
                options.onSubmit(api);
            } else {
                api.close();
            }
        });
        form.on('keydown', 'input', function (e) {
            if (e.which === 13) {
                e.preventDefault();
                submit.trigger('click');
            }
        });

        var container = $('#layers');
        (container.length ? container.first() : $('body')).append(el);
        initFields(form);
        if (options.onOpen) {
            options.onOpen(api);
        }
        return api;
    }

    /**
     * Submit a modal's values to the module; on success close it, show the
     * message and run after(); on failure keep it open and show the error.
     */
    function submitModal(api, query, values, after) {
        api.busy(true);
        request(query + '&' + $.param({formdata: values}), function (data) {
            api.close();
            notify('info', data.message);
            if (after) {
                after(data);
            }
        }, function (data) {
            api.busy(false);
            // Field messages from the module's validators, shown as WHMCS shows them.
            if (data.fields) {
                api.errors(data.fields);
                return;
            }
            notify('error', data.error || data.errors || '');
        });
    }

    /* ------------------------------------------------------------------ */
    /* Tables - components/DataTable                                       */
    /* ------------------------------------------------------------------ */

    // The page list of components/DataTable (updatePagesMap), unchanged.
    function pagesMap(curPage, allPages) {
        var map = [];
        var i;
        if (allPages <= 0) {
            map[1] = 1;
            return map;
        }
        if (allPages <= 7) {
            for (i = 1; i <= allPages; i++) {
                map[i] = i;
            }
            return map;
        }
        map = [curPage - 5, curPage - 4, curPage - 3, curPage - 2, curPage - 1, curPage,
            curPage + 1, curPage + 2, curPage + 3, curPage + 4, curPage + 5];
        for (i = 0; i < map.length; i++) {
            if (map[i] < 0 || map[i] > allPages) {
                map[i] = null;
            }
        }
        if (map.indexOf(allPages) === -1) {
            map[map.length - 1] = allPages;
        }
        if (map.indexOf(1) === -1) {
            map[0] = 1;
        }
        if (allPages > 7 && curPage > 4) {
            map[map.indexOf(Math.min(curPage - 1 > 1 ? curPage - 1 : curPage, curPage - 2 > 1 ? curPage - 2 : curPage,
                curPage - 3 > 1 ? curPage - 3 : curPage, curPage - 4 > 1 ? curPage - 4 : curPage))] = '...';
        }
        for (i = map.length - 1; i > map.indexOf(curPage); i--) {
            if (i === 8 && map[i] === curPage + 3 && map[i] !== allPages) {
                map[i] = null;
            }
        }
        if (allPages > 7 && (4 <= allPages - curPage)) {
            map[map.indexOf(allPages) - 1] = '...';
        }
        return map;
    }

    function massCheckbox(extraClass, value) {
        var input = $('<input class="lu-form-checkbox" type="checkbox">').addClass(extraClass || '');
        if (value !== undefined) {
            input.val(value);
        }
        return $('<div class="lu-form-check"></div>').append($('<label></label>').append(input, '<span class="lu-form-indicator"></span>'));
    }

    /**
     * Give a server-rendered table the WHMCS DataTable behaviour.
     *
     * root: the ".lu-t-c" element holding ".dataTables_wrapper > .lu-d-grid > table".
     * Toolbar buttons are taken from a child "[data-edc-toolbar]" element.
     * options: search (bool), searchable (column indexes), perPage,
     *   pagination (bool), mass ({buttons, onClick(ids, button)}), onDraw(rows).
     * previous: the state() of an earlier instance, kept across a reload.
     */
    function table(root, options, previous) {
        root = $(root).first();
        if (!root.length) {
            return null;
        }
        // Not "edcTable": jQuery's data() would also read the data-edc-table attribute.
        if (root.data('edcTableApi')) {
            return root.data('edcTableApi');
        }
        options = $.extend({search: false, searchable: [], perPage: 10, pagination: true, mass: null, onDraw: null}, options || {});
        var state = $.extend({offset: 0, perPage: options.perPage, search: false, previousSearch: false}, previous || {});
        var selected = [];
        var tableEl = root.find('table').first();
        var grid = root.find('.lu-d-grid').first();
        var rows = [];
        var searchInput = null;

        // search and toolbar
        var toolbarSource = root.children('[data-edc-toolbar]').detach();
        var topBar = null;
        if (options.search || toolbarSource.length) {
            topBar = $('<div class="lu-t-c__top lu-top mob-top-search"></div>');
            if (options.search) {
                searchInput = $('<input class="lu-form-control lu-input-group__form-control lu-table-search" value="">')
                    .attr('placeholder', t('search_placeholder'));
                var clear = $('<button type="button" class="lu-btn lu-btn--link lu-p-r-0x lu-p-l-0x lu-m-r-1x lu-clear-main-search-button" disabled><i class="lu-zmdi lu-i-c-2x lu-zmdi-close"></i></button>');
                topBar.append($('<div class="lu-top__toolbar"></div>').append($('<div class="lu-top__search lu-input-group"></div>')
                    .append('<span class="lu-icon lu-icon-sm lu-input-group__icon"><i class="lu-zmdi lu-zmdi-search"></i></span>', searchInput, clear)));
                if (state.search !== false) {
                    searchInput.val(state.search);
                    clear.prop('disabled', false);
                }
                searchInput.on('keyup', function () {
                    clear.prop('disabled', this.value.length === 0);
                });
                searchInput.on('keydown', function (e) {
                    if (e.which === 13) {
                        e.preventDefault();
                        search(this.value);
                    }
                });
                clear.on('click', function (e) {
                    e.preventDefault();
                    searchInput.val('');
                    clear.prop('disabled', true);
                    search('');
                });
            }
            topBar.append($('<div class="lu-top__toolbar"></div>').append(toolbarSource.children()));
            root.prepend(topBar);
        }

        // mass actions
        var massBar = null;
        var massCount = null;
        var massAll = null;
        if (options.mass) {
            massCount = $('<span class="lu-badge lu-badge--primary lu-value">0</span>');
            var massToolbar = $('<div class="lu-top__toolbar"></div>');
            // One at a time: jQuery before 1.8 cannot append an array of jQuery objects.
            $.each(options.mass.buttons || [], function (i, button) {
                massToolbar.append(button);
            });
            massBar = $('<div class="lu-t-c__mass-actions lu-top"></div>')
                .append($('<div class="lu-top__title"></div>').append(massCount, ' ', document.createTextNode(t('items_selected'))))
                .append(massToolbar);
            if (topBar) {
                topBar.after(massBar);
            } else {
                root.prepend(massBar);
            }
            var firstHeader = tableEl.find('thead th').first();
            firstHeader.contents().wrapAll('<div class="lu-rail"></div>');
            massAll = massCheckbox().find('input');
            firstHeader.children('.lu-rail').prepend(massAll.closest('.lu-form-check'));
            massAll.on('change', function () {
                selected = [];
                if (this.checked) {
                    $.each(visibleRows(), function (i, row) {
                        selected.push(String($(row).attr('data-id')));
                    });
                }
                syncSelection();
            });
            massBar.on('click', '.lu-btn', function (e) {
                e.preventDefault();
                if (options.mass.onClick) {
                    options.mass.onClick(selected.slice(), $(this));
                }
            });
        }

        var noData = $('<div class="lu-no-data"></div>').text(t('nodata')).hide();
        tableEl.after(noData);
        var preloader = $('<div class="lu-preloader-container lu-preloader-container--full-screen lu-preloader-container--overlay"><div class="lu-preloader lu-preloader--sm"></div></div>').hide();
        noData.after(preloader);

        // footer: pages and page size
        var paginate = null;
        var lengths = null;
        if (options.pagination) {
            paginate = $('<div class="dataTables_paginate paging_simple_numbers"></div>');
            lengths = $('<div class="lu-dt-buttons"></div>');
            $.each(PAGE_LENGTHS.concat([INFINITE_LENGTH]), function (i, length) {
                lengths.append($('<a class="dt-button"></a>').attr('data-length', length)
                    .append($('<span></span>').text(length === INFINITE_LENGTH ? '∞' : length)));
            });
            $('<div class="lu-t-c__footer table-footer"></div>').append(paginate, lengths).appendTo(grid.length ? grid : root);
            paginate.on('click', 'a', function (e) {
                e.preventDefault();
                var button = $(this);
                if (button.hasClass('disabled') || button.parent().hasClass('disabled')) {
                    return;
                }
                var page = parseInt(button.attr('data-dt-idx'), 10);
                state.offset = ((page < 1) ? 0 : page - 1) * state.perPage;
                draw();
            });
            lengths.on('click', 'a', function (e) {
                e.preventDefault();
                state.perPage = parseInt($(this).attr('data-length'), 10);
                state.offset = 0;
                draw();
            });
        }

        root.on('change', '.table-mass-action-check', function () {
            var id = String($(this).val());
            selected = $.grep(selected, function (value) {
                return value !== id;
            });
            if (this.checked) {
                selected.push(id);
            }
            syncSelection();
        });

        function scanRows() {
            rows = tableEl.children('tbody').children('tr').toArray();
            if (options.mass) {
                $.each(rows, function (i, row) {
                    var cell = $(row).children('td').first();
                    if (cell.children('.lu-rail').length) {
                        return;
                    }
                    var content = $('<span></span>').append(cell.contents());
                    cell.append($('<div class="lu-rail"></div>')
                        .append(massCheckbox('table-mass-action-check', $(row).attr('data-id')), content));
                });
            }
        }

        function matches(row) {
            var cells = $(row).children('td');
            var needle = String(state.search).toLowerCase();
            for (var i = 0; i < options.searchable.length; i++) {
                if (cells.eq(options.searchable[i]).text().toLowerCase().indexOf(needle) !== -1) {
                    return true;
                }
            }
            return false;
        }

        function filteredRows() {
            return state.search === false ? rows : $.grep(rows, matches);
        }

        function visibleRows() {
            return $.grep(rows, function (row) {
                return row.style.display !== 'none';
            });
        }

        function syncSelection() {
            if (!options.mass) {
                return;
            }
            root.find('.table-mass-action-check').each(function () {
                this.checked = selected.indexOf(String(this.value)) !== -1;
            });
            if (!selected.length) {
                massAll.prop('checked', false);
            }
            massCount.text(selected.length);
            massBar.toggleClass('is-open', selected.length > 0);
        }

        function renderPages(curPage, allPages) {
            paginate.empty();
            paginate.append($('<a class="paginate_button previous" href="javascript:" page="prev" tabindex="0"></a>')
                .attr('data-dt-idx', curPage - 1)
                .toggleClass('disabled', curPage < 2));
            $.each(pagesMap(curPage, allPages), function (i, number) {
                var span = $('<span></span>');
                if (number && number !== '...') {
                    span.append($('<a class="paginate_button" tabindex="0"></a>')
                        .attr('data-dt-idx', number)
                        .toggleClass('current', curPage === number)
                        .text(' ' + number + ' '));
                } else if (number === '...') {
                    span.append('<a class="paginate_button disabled"> ... </a>');
                }
                paginate.append(span);
            });
            paginate.append($('<a class="paginate_button next" href="javascript:" page="next" tabindex="0"></a>')
                .attr('data-dt-idx', curPage + 1)
                .toggleClass('disabled', curPage === allPages || allPages === 0));
            lengths.children('a').each(function () {
                $(this).toggleClass('active', parseInt($(this).attr('data-length'), 10) === state.perPage);
            });
        }

        function draw() {
            var list = filteredRows();
            var perPage = options.pagination ? state.perPage : INFINITE_LENGTH;
            var page = list.slice(state.offset, state.offset + perPage);
            if (page.length === 0 && state.offset > 0) {
                state.offset = 0;
                page = list.slice(0, perPage);
            }
            $(rows).hide();
            $(page).show();
            noData.toggle(page.length === 0);
            selected = [];
            syncSelection();
            if (options.pagination) {
                var total = list.length;
                var curPage = (state.offset / perPage) + 1;
                var tempPages = total > perPage ? parseInt(total / perPage, 10) : 0;
                renderPages(curPage, tempPages + ((perPage * tempPages) < total ? 1 : 0));
            }
            if (options.onDraw) {
                options.onDraw(page);
            }
        }

        function search(value) {
            state.search = value === '' ? false : value;
            if (state.search !== false) {
                if (state.previousSearch !== false && state.previousSearch !== state.search) {
                    state.offset = 0;
                }
                state.previousSearch = state.search;
            } else {
                state.previousSearch = false;
            }
            draw();
        }

        scanRows();
        draw();

        var api = {
            draw: draw,
            refresh: function () {
                scanRows();
                draw();
            },
            loading: function (on) {
                preloader.toggle(!!on);
            },
            state: function () {
                return $.extend({}, state);
            }
        };
        root.data('edcTableApi', api);
        return api;
    }

    // Label / value tables (Service Information): pages, no search.
    function initInfoTables(scope) {
        $(scope || document).find('.lu-t-c[data-edc-table="info"]').each(function () {
            table(this, {search: false, pagination: true});
        });
    }

    /* ------------------------------------------------------------------ */
    /* Period filters - GraphSettingsForm, BandwidthSettingsForm,          */
    /* SensorsScope - saved per service by the module (ScopeSettings),     */
    /* as WHMCS saves them in its module settings.                         */
    /* ------------------------------------------------------------------ */

    var savedScopes = null;

    // The service's saved filters, rendered into the page (data-edc-scopes).
    function scopes() {
        if (savedScopes === null) {
            try {
                savedScopes = JSON.parse($('[data-edc-scopes]').first().attr('data-edc-scopes') || '{}') || {};
            } catch (e) {
                savedScopes = {};
            }
        }
        return savedScopes;
    }

    function loadSettings(store, names) {
        var values = {};
        values[names.mode] = '0';
        values[names.scope] = 'td';
        values[names.start] = '';
        values[names.end] = '';
        return $.extend(values, scopes()[store] || {});
    }

    function periodQuery(values, names) {
        if (values[names.mode] === '1') {
            return '&interval=custom&start=' + encodeURIComponent(values[names.start] || '') +
                '&end=' + encodeURIComponent(values[names.end] || '');
        }
        return '&interval=' + encodeURIComponent(values[names.scope] || 'td');
    }

    /**
     * options: title, store, names {mode, scope, start, end}, customLabel,
     * tooltips {scope, start, end}, onSaved(values). The module checks and
     * saves the filter and answers with the WHMCS provider's message.
     */
    function scopeModal(options) {
        var names = options.names;
        var current = loadSettings(options.store, names);
        var tips = options.tooltips || {};
        var periods = $.map(PERIODS, function (period) {
            return [[period[0], t(period[1])]];
        });
        var mode = field.select({
            name: names.mode,
            label: t('filter_mode'),
            options: [['0', t('predefined_period')], ['1', options.customLabel || t('custom_dates')]],
            value: current[names.mode]
        });
        var scope = $('<div></div>').append(field.select({
            name: names.scope, label: t('period'), options: periods, value: current[names.scope], tooltip: tips.scope
        }));
        var dates = $('<div></div>').append(
            field.datetime({name: names.start, label: t('start_date'), value: current[names.start], tooltip: tips.start}),
            field.datetime({name: names.end, label: t('end_date'), value: current[names.end], tooltip: tips.end})
        );
        function toggle() {
            var custom = mode.find('select').val() === '1';
            scope.toggle(!custom);
            dates.toggle(custom);
        }
        mode.find('select').on('change', toggle);
        toggle();

        return modal({
            type: 'edit',
            title: options.title,
            body: [mode, scope, dates],
            onSubmit: function (api) {
                api.busy(true);
                request('&ajax=1&edcSaveScope=1&store=' + encodeURIComponent(options.store) + '&' + $.param({formdata: api.values()}), function (data) {
                    scopes()[options.store] = data.values || {};
                    api.close();
                    notify('info', data.message);
                    if (options.onSaved) {
                        options.onSaved(scopes()[options.store]);
                    }
                }, function (data) {
                    api.busy(false);
                    notify('error', data.error || '');
                });
            }
        });
    }

    /* ------------------------------------------------------------------ */
    /* Widgets shared by the admin and client pages                        */
    /* ------------------------------------------------------------------ */

    var GRAPH_NAMES = {mode: 'period', scope: 'graphScope', start: 'start_date', end: 'end_date'};

    // A spinner over the graph's place while it loads, as the WHMCS Graph component shows one.
    function graphLoading(element, on) {
        var el = $(element);
        el.toggleClass('edc-graph--loading', !!on);
        el.children('.edc-graph-loader').remove();
        if (on) {
            el.append('<div class="edc-graph-loader lu-preloader-container"><div class="lu-preloader lu-preloader--sm"></div></div>');
        }
    }

    /**
     * An Aggregate Traffic / Ping / Status graph: drawn for the saved period,
     * and redrawn after the "Filter Graph" modal is saved.
     */
    function graphPanel(o) {
        if (!document.getElementById(o.element)) {
            return;
        }
        function load() {
            graphLoading('#' + o.element, true);
            $.ajax({type: 'GET', url: pageUrl() + '&graphs=' + o.graph + periodQuery(loadSettings(o.store, GRAPH_NAMES), GRAPH_NAMES)})
                .done(function (data) {
                    var options = EasyDCIMGraphs.parse(data);
                    var element = document.getElementById(o.element);
                    var scale = parseFloat(element.getAttribute('data-edc-height-scale'));
                    if (options && scale > 0) {
                        // ApexCharts' own "auto" height is width / 1.61; the admin page asks for a share of it.
                        options.chart = options.chart || {};
                        options.chart.height = Math.round(element.clientWidth / 1.61 * scale);
                    }
                    EasyDCIMGraphs.draw(o.element, options);
                })
                .fail(function () {
                    EasyDCIMGraphs.clear(o.element);
                })
                .always(function () {
                    graphLoading('#' + o.element, false);
                });
        }
        $(document).on('click', o.button, function (e) {
            e.preventDefault();
            scopeModal({
                title: t('graph_filter_modal'),
                store: o.store,
                names: GRAPH_NAMES,
                tooltips: {scope: t('graph_scope_description'), start: t('start_date_description'), end: t('end_date_description')},
                onSaved: load
            });
        });
        load();
    }

    var BANDWIDTH_NAMES = {mode: 'period', scope: 'bandwidthScope', start: 'start_date', end: 'end_date'};

    /**
     * The Bandwidth widget: one row for the saved period (the WHMCS Bandwidth
     * table, no search and no pages), changed with "Filter Bandwidth".
     */
    function bandwidthPanel(o) {
        var root = $(o.table);
        if (!root.length) {
            return;
        }
        var list = table(root.find('.lu-t-c'), {search: false, pagination: false});
        var body = root.find('tbody');
        function load() {
            list.loading(true);
            $.ajax({type: 'GET', url: pageUrl() + '&bandwidthPeriod=1' + periodQuery(loadSettings('bandwidth_scope', BANDWIDTH_NAMES), BANDWIDTH_NAMES)})
                .done(function (raw) {
                    body.empty();
                    $.each(parse(raw).rows || [], function (i, row) {
                        body.append($('<tr class="lu-table-row"></tr>')
                            .append($('<td></td>').text(row.bandwidthInterval))
                            .append($('<td></td>').text(row.bandwidthIn))
                            .append($('<td></td>').text(row.bandwidthOut))
                            .append($('<td></td>').text(row.bandwidthTotal)));
                    });
                })
                .fail(function () {
                    body.empty();
                })
                .always(function () {
                    list.loading(false);
                    list.refresh();
                });
        }
        $(document).on('click', o.button, function (e) {
            e.preventDefault();
            scopeModal({
                title: t('bandwidth_filter_modal'),
                store: 'bandwidth_scope',
                names: BANDWIDTH_NAMES,
                tooltips: {scope: t('bandwidth_scope_description'), start: t('start_date_description'), end: t('end_date_description')},
                onSaved: load
            });
        });
        load();
    }

    // The service action tiles and their confirmations (StatusWidget).
    var SERVICE_ACTIONS = {
        boot: {type: 'success', alert: 'info', key: 'start'},
        shutdown: {type: 'danger', alert: 'danger', key: 'stop'},
        reboot: {type: 'warning', alert: 'warning', key: 'reset'},
        bmcColdReset: {type: 'warning', alert: 'warning', key: 'bmc'},
        enableRescueMode: {type: 'danger', alert: 'danger', key: 'rescue'},
        noVNCConsole: {type: 'success', alert: 'info', key: 'novnc'},
        logIntoPanel: {type: 'success', alert: 'info', key: 'login'}
    };

    function serviceAction(action) {
        var definition = SERVICE_ACTIONS[action];
        if (!definition) {
            return;
        }
        modal({
            type: definition.type,
            title: t(definition.key + '_title'),
            submit: t(definition.key + '_submit'),
            body: [alertBox(definition.alert, $('<div></div>').text(t(definition.key + '_alert')).html())],
            onSubmit: function (api) {
                api.busy(true);
                request('&deviceButtonsAction=' + encodeURIComponent(action), function (data) {
                    api.close();
                    notify('info', data.success);
                    if (data.url) {
                        window.open(data.url, '_blank');
                    }
                }, function (data) {
                    api.busy(false);
                    notify('error', data.errors || data.error || '');
                });
            }
        });
    }

    // components/CopyPasswordInline without its icon: "******" until clicked.
    $(document).on('click', '.copy-text-inline-component [data-edc-secret]', function () {
        var el = $(this);
        var shown = el.attr('data-edc-shown') === '1';
        el.text(shown ? '******' : el.attr('data-edc-secret'));
        el.attr('data-edc-shown', shown ? '0' : '1');
    });

    $(document).on('click', '[data-edc-service-action]', function (e) {
        e.preventDefault();
        serviceAction($(this).attr('data-edc-service-action'));
    });

    $(function () {
        initInfoTables();
    });

    return {
        initInfoTables: initInfoTables,
        initFields: initFields,
        graphLoading: graphLoading,
        t: t,
        notify: notify,
        request: request,
        reload: reload,
        field: field,
        alert: alertBox,
        modal: modal,
        submitModal: submitModal,
        table: table,
        pagesMap: pagesMap,
        scopeModal: scopeModal,
        loadSettings: loadSettings,
        periodQuery: periodQuery,
        graphPanel: graphPanel,
        bandwidthPanel: bandwidthPanel,
        serviceAction: serviceAction
    };
})(jQuery);
