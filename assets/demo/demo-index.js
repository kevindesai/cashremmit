jQuery(document).ready(function() {

    $(function() {

    //Switchery
        Switchery(document.querySelector('.js-switch-success'), {color: Utility.getBrandColor('success')});

    // EasyPieChart

    try {
        $('.easypiechart#progress').easyPieChart({
            barColor: "#cddc39",
            trackColor: 'rgba(255, 255, 255, 0.32)',
            scaleColor: false,
            scaleLength: 8,
            lineCap: 'square',
            lineWidth: 2,
            size: 96,
            onStep: function(from, to, percent) {
                $(this.el).find('.percent-non').text(Math.round(percent));
            }
        });
    } catch(e) {}


    // Sparklines
        
        var sparker = function() {
            $('#profit-sparline-inside').sparkline([5,7,6,9,5,6,6], { type: 'bar', barColor: '#eceff1', height: '100px',width: '100%', barWidth: 6, barSpacing: 6, spotRadius: 4});
        }
        var sparkResize;
     
        $(window).resize(function(e) {
            clearTimeout(sparkResize);
            sparkResize = setTimeout(sparker, 500);
        });
        sparker();
    });


    //Multiple

    var d1 = [[1, 0.5], [2, 1], [3, 0.25], [4, 1], [5, 2], [6, 3], [7, 2], [8, 4], [9, 3.5], [10, 2], [11, 4], [12, 3]];

    var d2 = [[1, 2], [2, 3.5], [3, 2], [4, 4.5], [5, 3.5], [6, 6.5], [7, 5.5], [8, 6.5], [9, 6.0], [10, 7.5], [11, 7.0], [12, 8.0]];


    $.plot($("#multiple"), [

        {
            data: d1, label: "Page Views",
            bars: { show: true, fill: 0.33, lineWidth: 0, barWidth: 0.2, order: 1, align: 'center' },
            shadowSize: 0
        },
        {
            data: d2, label: "Visitors",
            points: { show: true, fill: 0.2 },
            shadowSize: 0,

                splines: {
                    show: true,
                    fill: 0.1,
                    tension: 0.33, // float between 0 and 1, defaults to 0.5
                    lineWidth: 2.5 // number, defaults to 2
            },
        },

    ], {
        grid: {
            labelMargin: 10,
            hoverable: true,
            clickable: true,
            borderWidth: 1,
            borderColor: '#f5f5f5',
        },
        yaxis: { tickColor: '#f5f5f5', font: {color: '#bdbdbd'}},
        xaxis: { tickColor: '#f5f5f5', font: {color: '#bdbdbd'},ticks: [[1,'JAN'],[2,'FEB'],[3,'MAR'],[4,'APR'],[5,'MAY'],[6,'JUN'],[7,'JUL'],[8,'AUG'],[9,'SEP'],[10,'OCT'],[11,'NOV'],[12,'DEC']], autoscaleMargin: 0.02, tickDecimals: 0},
        colors: [Utility.getBrandColor('midnightblue'), Utility.getBrandColor('info')],
        tooltip: true,
        tooltipOpts: {
            content: "Vistors: %y"
        }
    });

    // Chart
        function randValue() {
            return (Math.floor(Math.random() * (2)));
        }

        var fans = [[1, 2], [2, 4], [3, 3], [4, 5], [5, 3], [6, 6], [7, 4], [8, 7], [9, 6], [10, 8]];
        var followers = [[1, 1], [2, 2], [3, 1], [4, 4], [5, 3], [6, 6], [7, 4], [8, 5], [9, 3], [10, 4]];

        var plot = $.plot($("#chart"),
            [{ data: fans, label: 'Revenues'},
             {}], {
                series: {

                 shadowSize: 0,
                    lines: { 
                        show: false,
                        lineWidth: 0
                    },
                    points: { show: false },
                    splines: {
                        show: true,
                        fill: 0.2,
                        tension: 0.3, // float between 0 and 1, defaults to 0.5
                        lineWidth: 2.5 // number, defaults to 2
                    },
                },
                grid: {
                    labelMargin: 8,
                    hoverable: true,
                    clickable: true,
                    borderWidth: 0,
                    borderColor: '#fafafa'
                },
                legend: {
                    backgroundColor: '#fff',
                    margin: 8
                },
                yaxis: { 
                    min: 0, 
                    max: 10, 
                    tickColor: '#fafafa', 
                    font: {color: '#bdbdbd', size: 10},
                    // tickFormatter: function (val, axis) {
                    //     if (val>999) {return (val/1000) + "K";} else {return val;}
                    // }
                },
                xaxis: { 
                    tickColor: '#fafafa', 
                    tickDecimals: 0, 
                    font: {color: '#bdbdbd', size: 10},
                    //ticks: []
                },
                colors: ['#80cbc4', '#b2dfdb'],
                tooltip: true,
                tooltipOpts: {
                    content: "Revenues: %y"
                }
            });

    // Revenue/Small

        var d1 = [
            [1, 2],
            [2, 4],
            [3, 1.25],
            [4, 3.5],
            [5, 4.5],
            [6, 2],
            [7, 2.75],
            [8, 3.25],
            [9, 1.25],
            [10, 2.25]
        ];

        var ds = new Array();

        ds.push({
        data:d1,
        bars: {
            show: true,
            barWidth: 0.9,
            order: 1
        }
        });

        var variance = $.plot($("#ordered"), ds, {
            series: {
                bars: {
                    show: true,
                    fill: 0.5,
                    align: "center",
                    lineWidth: 0
                }
            },
            grid: {
                labelMargin: 4,
                hoverable: true,
                clickable: true,
                tickColor: "transparent",
                borderWidth: 0
            },
            colors: ["#aaaaaa"],
            xaxis: {
                ticks: [1,2,3,4,5,6,7,8,9,10],
                autoscaleMargin: 0.02,
                tickColor: "transparent",
                tickDecimals: 0,
                font: {
                    color: 'transparent',
                    size: 10
                },
                tickFormatter: function (val, axis) {
                    //return "$" + val + "K";
                    return "";
                }
            },
            yaxis: {
                ticks: [0, 2, 4, 6],
                tickColor: "transparent",
                font: {
                    color: 'transparent',
                    size: 10
                },
                tickFormatter: function (val, axis) {
                    //return "$" + val + "K";
                    return val;
                }
            },
            legend : {
                backgroundColor: '#fff',
                margin: 8
            },
            tooltip: true,
            tooltipOpts: {
                content: "Revenues: %y"
            }
        });


        $('#daterangepicker-d').daterangepicker({
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
            'Last 7 Days': [moment().subtract('days', 6), moment()],
            'Last 30 Days': [moment().subtract('days', 29), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
        },
        opens: 'left',
        startDate: moment().subtract('days', 29),
        endDate: moment()
        },
        function(start, end) {
            $('#daterangepicker-d span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        });

});