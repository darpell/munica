$(function () {
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