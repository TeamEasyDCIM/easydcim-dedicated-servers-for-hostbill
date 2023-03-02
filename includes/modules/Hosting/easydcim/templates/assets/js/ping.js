$(document).ready(function () {
    let myPingChart;
    let url = window.location.href;
    $.ajax({
        type: "GET",
        url: url + '&graphs=Ping&interval=td',
        success: function (data) {
            let graphData
            if (data != '')
            {
                graphData = JSON.parse(data).data;
            }else {
                graphData = {
                    labels: [],
                    datasets: []
                };
            }
            const labels = graphData.labels;
            let dataSet = [];
            if (graphData.datasets.length !== 0)
            {
                dataSet = graphData.datasets[0].data;
            }
            const dataForGraph = {
                labels: labels,
                datasets: [
                    {
                        backgroundColor: '#F00F00',
                        borderColor: '#F00F00',
                        spanGaps: false,
                        borderWidth: 1.3,
                        label: 'Ping (ms)',
                        fill: true,
                        data:dataSet,
                    }]
            };

            const config = {
                type: 'line',
                data: dataForGraph,
                plugins:[{
                    afterInit: function(chart,options){
                        var canvasHeight = ctx.height();
                        let datasets = chart.data.datasets;

                        $.each(datasets, function(key, value) {
                            var mainColor = value.backgroundColor;

                            if($.isArray(mainColor)) {
                                var gradients = [];

                                $.each(mainColor, function( index, value ) {
                                    gradients.push(getGradientFill(ctx, value, canvasHeight));
                                });

                                chart.data.datasets[key].backgroundColor = gradients;
                                chart.data.datasets[key].hoverBackgroundColor = gradients;
                            } else {
                                chart.data.datasets[key].backgroundColor = getGradientFill(ctx, mainColor, canvasHeight);
                                chart.data.datasets[key].hoverBackgroundColor = getGradientFill(ctx, mainColor, canvasHeight);
                            }

                        });
                    }
                }],
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                    },
                    elements:{
                        line:{
                            tension: 0.4,
                        },
                        point:{
                            radius: false,
                        },
                    },
                    scales:{
                        y:{
                            ticks: {
                                // Include a dollar sign in the ticks
                                callback: function(value, index, ticks) {
                                    return value +'ms';
                                }
                            },
                            display: true,
                            beginAtZero: true,
                            stacked: false,
                            grid: {
                                color: 'rgb(238,238,241,0.64)',
                                zeroLineColor: 'transparent',
                                drawBorder: 1,
                                tickMarkLength: 0,
                            },
                            title: {
                                display: true,
                                text: 'Ping',
                            },
                        },
                        x:{
                            type: 'time',
                            time: {
                                unit: graphData.unit,
                                displayFormats: {
                                    hour:'hh:mm',
                                }
                            },
                        },
                    }
                },
            }
            let ctx = $('#pingGraph');
            myPingChart = new Chart(
                ctx,
                config
            );
        },
        error: function (data) {
        },
    });

    $('#reloadpingGraph').on('click',function (e) {
        e.preventDefault();
        hidePingModal();
        let option = $('#scope2 option:selected').val();
        let url = window.location.href;
        $.ajax({
            type: "GET",
            url: url + '&graphs=Ping&interval='+option,
            success: function (data) {
                let graphData
                if (data != '')
                {
                    graphData = JSON.parse(data).data;
                }else {
                    graphData = {
                        labels: [],
                        datasets: []
                    };
                }
                let dataSet = [];
                if (graphData.datasets.length !== 0)
                {
                    dataSet = graphData.datasets[0].data;
                }
                myPingChart.data.labels = graphData.labels
                myPingChart.data.datasets[0].data = dataSet;
                myPingChart.options.scales.x.time.unit = graphData.unit;
                myPingChart.update();
            },
            error: function (data) {
            },
        });
    });
});

function hexToRGB(hex, alpha) {
    var r = parseInt(hex.slice(1, 3), 16),
        g = parseInt(hex.slice(3, 5), 16),
        b = parseInt(hex.slice(5, 7), 16);

    if (alpha) {
        return "rgba(" + r + ", " + g + ", " + b + ", " + alpha + ")";
    } else {
        return "rgb(" + r + ", " + g + ", " + b + ")";
    }
}

function getGradientFill(c, color, height)
{
    var ctx = c[0].getContext("2d");

    var gradientFill = ctx.createLinearGradient(0,0,0,height);

    gradientFill.addColorStop(0, hexToRGB(color, 0.4));
    gradientFill.addColorStop(1, hexToRGB(color, 0.05));

    return gradientFill
}

function showPingModal() {
    $('#confirmationModal2').addClass( "show" );
}

function hidePingModal() {
    $('#confirmationModal2').removeClass( "show" );
}
