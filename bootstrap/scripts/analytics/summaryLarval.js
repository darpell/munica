$(function () {
	 var langkaan = 0;
     var sangustini=0;
     var sangustiniii=0;
     var sampaloci=0;
     for(i=(weekno-4); i<weekno;i++)
     {
     	langkaan += parseInt(cases['LANGKAAN II'][year][i]);
     	sangustini +=parseInt(cases['SAN AGUSTIN I'][year][i]);
     	sangustiniii +=parseInt(cases['SAN AGUSTIN III'][year][i]);
     	sampaloci +=parseInt(cases['SAMPALOC I'][year][i]);
     }
        $('#container').highcharts({
            chart: {
            },
            title: {
                text: 'Larval Surveys Reported Last 4 Weeks'
            },
            xAxis: {
                categories: ['Week '+ (weekno-4), 'Week '+ (weekno-3), 'Week '+ (weekno-2), 'Week '+ (weekno-1), 'Current Week',]
            },
            tooltip: {
                formatter: function() {
                    var s;
                    if (this.point.name) { // the pie chart
                        s = ''+
                            this.point.name +': '+ this.y +' Cases';
                    } else {
                        s = ''+
                            this.x  +': '+ this.y;
                    }
                    return s;
                }
            },
            labels: {
                items: [{
                    html: 'Geographic Distribution For Larval Surveys',
                    style: {
                        left: '40x',
                        top: '-15px',
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
            },
            {
                type: 'pie',
                name: 'Total consumption',
                data: [{
                    name: 'LANGKAAN II',
                    y: langkaan,
                    color: Highcharts.getOptions().colors[4] // Jane's color
                }, {
                    name: 'SAMPALOC I',
                    y: sampaloci,
                    color: Highcharts.getOptions().colors[5] // John's color
                }, {
                    name: 'SAN AGUSTIN III',
                    y: sangustiniii,
                    color: Highcharts.getOptions().colors[2] // Joe's color
                }, {
                    name: 'SAN AGUSTIN I',
                    y: sangustini,
                    color: Highcharts.getOptions().colors[3] // Joe's color
                }],
                center: [100, 30],
                size: 100,
                showInLegend: false,
                dataLabels: {
                    enabled: false
                }
            }
            ]
        });
        
       
        
        $('#container2').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Symptoms'
            },
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.y} Cases</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Symptoms',
                data: [
                    ['Muscle Pain',   cases['symptoms'][0]],
                    ['Joint Pain',    cases['symptoms'][1]],
                    ['Headache',      cases['symptoms'][2]],
                    ['Bleeding',      cases['symptoms'][3]],
                    ['Rashes',        cases['symptoms'][4]]
                ]
            }]
        });
    });
