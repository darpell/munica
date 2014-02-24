$(function () {
	if(fatality != 'null')
{
        $('#fatalityrate').highcharts({
            chart: {
                type: 'column',
                margin: [ 50, 50, 100, 80]
            },
            title: {
                text: 'Fatality Rate'
            },
            xAxis: {
                categories: ['below 1','1-10','11-20','21-30','31-40','>40'],
                labels: {
                    rotation: -45,
                    align: 'right',
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Case Fatality Ratio'
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Case Fatality: <b>{point.y:.2f} Percent</b>',
            },
            series: [{
                name: 'Rate',
                data: fatality,
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#FFFFFF',
                    align: 'right',
                    x: 4,
                    y: 10,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif',
                        textShadow: '0 0 3px black'
                    }
                }
            }]
        });
}
    });
    
