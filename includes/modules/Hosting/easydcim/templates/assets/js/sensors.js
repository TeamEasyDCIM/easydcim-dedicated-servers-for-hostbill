var sensorChart = null;

$(document).ready(function () {
    $('#sensors').DataTable({
        lengthChange: false,
        ordering: false,
        searching: false,
        info: false
    });
});

function closeSensorGraphModal() {
    if (sensorChart !== null) {
        sensorChart.destroy();
        sensorChart = null;
    }
    $('#sensorGraphModal').remove();
}

function showSensorGraph(sensorId, name, unit) {
    $('#layers').append('<div id="sensorGraphModal" class="lu-modal show lu-modal--lg">\n' +
        '    <div class="lu-modal__dialog">\n' +
        '        <div id="mgModalContainer" class="lu-modal__content">\n' +
        '            <div class="lu-modal__top lu-top">\n' +
        '                <div class="lu-top__title lu-type-6"><span class="lu-text-faded lu-font-weight-normal">' + name + '</span></div>\n' +
        '                <div class="lu-top__toolbar">\n' +
        '                    <button onclick="closeSensorGraphModal()" data-dismiss="lu-modal" aria-label="Close"\n' +
        '                            class="lu-btn lu-btn--xs lu-btn--default lu-btn--icon lu-btn--link lu-btn--plain closeModal">\n' +
        '                        <i class="lu-btn__icon lu-zmdi lu-zmdi-close"></i></button>\n' +
        '                </div>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__body">\n' +
        '                <div class="lu-form-group">\n' +
        '                    <select id="sensorGraphInterval" class="lu-form-control"\n' +
        '                            onchange="loadSensorGraph(\'' + sensorId + '\',\'' + unit + '\')">\n' +
        '                        <option value="td">Today</option>\n' +
        '                        <option value="yd">Yesterday</option>\n' +
        '                        <option value="tw">This Week</option>\n' +
        '                        <option value="lw">Last Week</option>\n' +
        '                        <option value="tm">This Month</option>\n' +
        '                        <option value="lm">Last Month</option>\n' +
        '                    </select>\n' +
        '                </div>\n' +
        '                <canvas id="sensorGraphCanvas" height="120"></canvas>\n' +
        '            </div>\n' +
        '            <div class="lu-modal__actions">\n' +
        '                <button onclick="closeSensorGraphModal()" class="lu-btn lu-btn--default lu-btn--outline lu-btn--plain closeModal">Close</button>\n' +
        '            </div>\n' +
        '        </div>\n' +
        '    </div>\n' +
        '</div>');

    loadSensorGraph(sensorId, unit);
}

function loadSensorGraph(sensorId, unit) {
    var interval = $('#sensorGraphInterval').val() || 'td';

    $.ajax({
        type: 'GET',
        url: window.location.href + '&ajax=1&sensorGraph=1&sensorId=' + encodeURIComponent(sensorId) +
            '&interval=' + encodeURIComponent(interval),
        success: function (data) {
            renderSensorGraph(JSON.parse(data).data, unit);
        },
        error: function (data) {
            var message = 'The sensor graph could not be loaded.';
            try {
                message = JSON.parse(data.responseText).data.error || message;
            } catch (e) {
            }
            $('#sensorGraphCanvas').replaceWith('<div class="alert alert-error">' + message + '</div>');
        }
    });
}

function renderSensorGraph(graphData, unit) {
    var canvas = document.getElementById('sensorGraphCanvas');

    if (!canvas) {
        return;
    }

    if (sensorChart !== null) {
        sensorChart.destroy();
        sensorChart = null;
    }

    var datasets = [];

    $(graphData.datasets).each(function (index, value) {
        datasets.push({
            label: value.dataset_name || ('Series ' + (index + 1)),
            data: value.data,
            borderColor: '#5396F4',
            backgroundColor: 'rgba(83,150,244,0.2)',
            borderWidth: 2,
            pointRadius: 0,
            fill: true,
            tension: 0.3
        });
    });

    sensorChart = new Chart(canvas.getContext('2d'), {
        type: 'line',
        data: {
            labels: graphData.labels,
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {display: datasets.length > 1},
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return context.formattedValue + ' ' + unit;
                        }
                    }
                }
            },
            scales: {
                x: {
                    type: 'time',
                    time: {unit: graphData.unit}
                },
                y: {
                    ticks: {
                        callback: function (value) {
                            return value + ' ' + unit;
                        }
                    }
                }
            }
        }
    });
}
