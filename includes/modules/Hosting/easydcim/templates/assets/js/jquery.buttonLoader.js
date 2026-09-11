/**
 * Busy state for the product page buttons that call the module. The button
 * keeps its label and its size: the content is hidden in place and a spinner
 * is laid over it (.edc-btn-loading in mg_styles.css). The plugin this
 * replaces rewrote the button's markup, which changed its width and on "stop"
 * put back a fixed "Create Configurable Options" whatever the button said.
 */
(function ($) {
    $.fn.buttonLoader = function (action) {
        var self = $(this);
        if (action === 'start') {
            if (self.hasClass('edc-btn-loading')) {
                return false;
            }
            self.addClass('edc-btn-loading').attr('aria-busy', 'true')
                .append('<span class="edc-btn-spinner" aria-hidden="true"></span>');
        }
        if (action === 'stop') {
            self.removeClass('edc-btn-loading').removeAttr('aria-busy')
                .children('.edc-btn-spinner').remove();
        }
        return self;
    };
})(jQuery);
