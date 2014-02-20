$(function () {
        $('#container').highcharts({
            chart: {
            },
            title: {
                text: 'Cases Occrued Last 4 Weeks'
            },
            xAxis: {
                categories: ['Week '+ (weekno-4), 'Week '+ (weekno-3), 'Week '+ (weekno-2), 'Week '+ (weekno-1), 'Current Week',]
            },
            tooltip: {
                formatter: function() {
                    var s;
                    if (this.point.name) { // the pie chart
                        s = ''+
                            this.point.name +': '+ this.y +' fruits';
                    } else {
                        s = ''+
                            this.x  +': '+ this.y;
                    }
                    return s;
                }
            },
            labels: {
                items: [{
                    html: '',
                    style: {
                        left: '40px',
                        top: '8px',
                        color: 'black'
                    }
                }]
            },
            series: [{
                type: 'column',
                name: year-1,
                data: [parseInt(cases[year-1][weekno-4]),
                       parseInt(cases[year-1][weekno-3]),
                       parseInt(cases[year-1][weekno-2]),
                       parseInt(cases[year-1][weekno-1]),
                       parseInt(cases[year-1][weekno])
                       ]
            }, {
                type: 'column',
                name: year,
                data: [parseInt(cases[year][weekno-4]),
                       parseInt(cases[year][weekno-3]),
                       parseInt(cases[year][weekno-2]),
                       parseInt(cases[year][weekno-1]),
                       parseInt(cases[year][weekno])
                       ]
            }, {
                type: 'spline',
                name: 'Average',
                data: [parseInt(ave[weekno-4]),
						 parseInt(ave[weekno-3]),
						 parseInt(ave[weekno-2]),
						 parseInt(ave[weekno-1]),
						 parseInt(ave[weekno])
						 ],
                marker: {
                	lineWidth: 2,
                	lineColor: Highcharts.getOptions().colors[3],
                	fillColor: 'white'
                }
            }]
        });
    });