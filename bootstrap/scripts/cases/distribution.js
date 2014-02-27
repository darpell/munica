$(function () {
        $('#graph').highcharts({
            chart: {
            },
            title: {
                text: 'Case Demographics'
            },
            xAxis: {
                categories: ['0-20', '21-50', '41-60', '61-80', '81 and above']
            },
            
            yAxis: {
                min: 0,
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
            
            tooltip: {
                formatter: function() {
                    var s;
                    if (this.point.name) { // the pie chart
                        s = ''+
                            this.point.name +': '+ this.y;
                    } else {
                        s = this.y;
                    }
                    return s;
                }
            },
            labels: {
                items: [{
                    html: 'Gender Distribution',
                    style: {
                        left: '40px',
                        top: '-40px',
                        color: 'black'
                    }
                }]
            },
            
            legend: {
                align: 'right',
                x: -70,
                verticalAlign: 'top',
                y: 20,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColorSolid) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            
            plotOptions: {
                column: {
                	stacking : 'normal',
                    dataLabels: {
                        enabled: true,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                        style: {
                            textShadow: '0 0 3px black, 0 0 3px black'
                        }
                    },
                    enableMouseTracking: false
                }
            },
            
            series: [{
                type: 'column',
                name: 'Male',
                data: male
            }, {
                type: 'column',
                name: 'Female',
                data: female
            }, {
                type: 'pie',
                name: 'Total consumption',
                data: [{
                    name: 'Male',
                    y: distribution[0],
                    color: Highcharts.getOptions().colors[0] // Jane's color
                }, {
                    name: 'Female',
                    y: distribution[1],
                    color: Highcharts.getOptions().colors[1] // John's color
                }],
                center: [70, 10],
                size: 100,
                showInLegend: false,
                dataLabels: {
                    enabled: false
                }
            }]
        });
    });