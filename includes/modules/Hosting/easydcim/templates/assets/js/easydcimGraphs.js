/**
 * Draws the ApexCharts options the server builds (App\Helpers\GraphOptions,
 * a port of the WHMCS module's Graph component options), after the same
 * clean-up the WHMCS component does before handing them to ApexCharts:
 * strings holding "function (...)" become functions, and "formatters.<name>"
 * becomes the named formatter below.
 */
var EasyDCIMGraphs = (function () {
    var charts = {};

    // The formatters of the WHMCS Graph component.
    var formatters = {
        showOnlyIntegers: function (val) {
            return Number.isInteger(val) ? val : "";
        },
        showWithoutZeros: function (val) {
            if (typeof val !== 'number' && typeof val !== 'string') return '';
            var num = Number(val);
            if (isNaN(num)) return '';
            return num;
        }
    };

    // Port of the WHMCS component's fixDataStructure().
    function fixDataStructure(options) {
        for (var key in options) {
            if (!options.hasOwnProperty(key)) {
                continue;
            }

            var value = options[key];

            if (typeof value === 'object' && value !== null) {
                fixDataStructure(value);
                continue;
            }

            if (typeof value === 'string' && value.indexOf('function') === 0) {
                try {
                    options[key] = new Function('return ' + value)();
                } catch (e) {
                }
                continue;
            }

            if (typeof value === 'string' && value.indexOf('formatter') === 0) {
                var name = value.split('.')[1];

                if (formatters[name] && typeof formatters[name] === 'function') {
                    options[key] = formatters[name];
                }
            }
        }

        return options;
    }

    function clear(id) {
        if (charts[id]) {
            charts[id].destroy();
            delete charts[id];
        }
    }

    // One chart per element: a reload replaces it rather than stacking a second one.
    function draw(id, options) {
        var element = document.getElementById(id);

        clear(id);

        if (!element || !options || typeof ApexCharts === 'undefined') {
            return null;
        }

        charts[id] = new ApexCharts(element, fixDataStructure(options));
        charts[id].render();

        return charts[id];
    }

    // The graph endpoints answer {"data": {"options": {...}}}.
    function parse(response) {
        if (!response) {
            return null;
        }

        try {
            // jQuery hands over an object instead when the answer is sent as JSON.
            return (typeof response === 'string' ? JSON.parse(response) : response).data.options || null;
        } catch (e) {
            return null;
        }
    }

    return {
        draw: draw,
        clear: clear,
        parse: parse,
        fixDataStructure: fixDataStructure
    };
})();
