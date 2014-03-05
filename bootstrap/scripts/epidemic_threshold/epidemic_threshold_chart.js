/*$(function () {
    $('#container').highcharts({
        data: {
            table: document.getElementById('datatable')
        },
        chart: {
            type: 'spline'
        },
        title: {
            text: 'Epidemic Threshold'
        },
        yAxis: {
            allowDecimals: false,
            title: {
                text: 'Cases'
            }
        },
        tooltip: {
            formatter: function() {
                return '<b>'+ this.point.name.toUpperCase() + ' ' + this.series.name +'</b><br/>' + this.point.y + ' Cases';
            }
        }
    });
});
*/
$(function () {
	
        $('#container').highcharts({
            chart: {
            },
            title: {
                text: ''
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May','Jun','Jul','Aug','Sept','Oct','Nov','Dec']
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
            series: [{
                type: 'column',
                name: 'Cases',
                data: currentcases
            }, {
                type: 'spline',
                name: '3rd Quartile',
                data: quartile3,
                marker: {
                	lineWidth: 2,
                	lineColor: Highcharts.getOptions().colors[1],
                	fillColor: 'white'
                }
            }/*, {
                type: 'spline',
                name: '1st Quartile',
                data: quartile1,
                marker: {
                	lineWidth: 2,
                	lineColor: Highcharts.getOptions().colors[2],
                	fillColor: 'white'
                }
            }, {
                type: 'spline',
                name: 'Median',
                data: median,
                marker: {
                	lineWidth: 2,
                	lineColor: Highcharts.getOptions().colors[3],
                	fillColor: 'white'
                }
            }*/]
        });
    });
