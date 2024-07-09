$(document).ready(function () {
    let myChart;
    let url = window.location.href;
    $.ajax({
        type: "GET",
        url: url + '&graphs=AggregateTraffic&interval=td',
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
            let dataSet1 = [];
            let dataSet2 = [];
            let dataSet3 = [];
            if (graphData.datasets.length !== 0)
            {
                dataSet1 = graphData.datasets[0].data;
                dataSet2 = graphData.datasets[1].data;
                dataSet3 = graphData.datasets[2].data;
            }
            const dataForGraph = {
                labels: labels,
                datasets: [
                    {
                        backgroundColor: '#62C45E',
                        borderColor: '#62C45E',
                        spanGaps: true,
                        borderWidth: 1.3,
                        label: 'Traffic IN (Gb/s)',
                        fill: true,
                        data: dataSet1,
                    },
                    {
                        backgroundColor: '#2BA7FF',
                        borderColor: '#2BA7FF',
                        spanGaps: true,
                        borderWidth: 1.3,
                        label: 'Traffic OUT (Gb/s)',
                        fill: true,
                        data: dataSet2,
                    },
                    {
                        backgroundColor: '#0C6174',
                        borderColor: '#0C6174',
                        spanGaps: true,
                        borderWidth: 1.3,
                        label: 'Traffic IN & OUT (Gb/s)',
                        fill: true,
                        data:dataSet3,
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
                                    return value +' Gb/s';
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
                                text: 'Traffic',
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
            let ctx = $('#aggregateTraffic');
            myChart = new Chart(
                ctx,
                config
            );
        },
        error: function (data) {
        },
    });

    $('#reloadAggregateTraffic').on('click',function (e) {
        e.preventDefault();
        hideTrafficModal();
        let option = $('#scope3 option:selected').val();
        let url = window.location.href;
        $.ajax({
            type: "GET",
            url: url + '&graphs=AggregateTraffic&interval='+option,
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
                let dataSet1 = [];
                let dataSet2 = [];
                let dataSet3 = [];
                if (graphData.datasets.length !== 0)
                {
                    dataSet1 = graphData.datasets[0].data;
                    dataSet2 = graphData.datasets[1].data;
                    dataSet3 = graphData.datasets[2].data;
                }
                myChart.data.labels = graphData.labels
                myChart.data.datasets[0].data = dataSet1;
                myChart.data.datasets[1].data = dataSet2;
                myChart.data.datasets[2].data = dataSet3;
                myChart.options.scales.x.time.unit = graphData.unit;
                myChart.update();
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


function showTrafficModal() {
    $('#confirmationModal1').addClass( "show" );
}

function hideTrafficModal() {
    $('#confirmationModal1').removeClass( "show" );
}