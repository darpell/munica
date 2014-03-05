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
     var total = langkaan + sangustini + sangustiniii + sampaloci;

        $('#container').highcharts({
            chart: {
            },
            title: {
                text: 'Cases Reported Last 4 Weeks'
            },
            xAxis: {
                categories: ['Week '+ (weekno-4), 'Week '+ (weekno-3), 'Week '+ (weekno-2), 'Week '+ (weekno-1), 'Week '+ (weekno),]
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
            },plotOptions: {
                column: {
                    stacking: 'normal',
                   
                }
            },
            labels: {
                items: [{
                    html: 'Gender Distribution For Current Cases',
                    style: {
                        left: '40x',
                        top: '-15px',
                        color: 'black'
                    }
                }]
            },
            series: [/*{
                type: 'column',
                name: year-1,
                data: [parseInt(cases[year-1][weekno-4]),
                       parseInt(cases[year-1][weekno-3]),
                       parseInt(cases[year-1][weekno-2]),
                       parseInt(cases[year-1][weekno-1]),
                       parseInt(cases[year-1][weekno])
                       ]
            },*/ {
                type: 'column',
                name: '0-9',
                data: [parseInt(agegroup[weekno-4][0]),
                       parseInt(agegroup[weekno-3][0]),
                       parseInt(agegroup[weekno-2][0]),
                       parseInt(agegroup[weekno-1][0]),
                       parseInt(agegroup[weekno][0])
                       ]
            }, {
	            type: 'column',
	            name: '10-19',
	            data: [parseInt(agegroup[weekno-4][1]),
                       parseInt(agegroup[weekno-3][1]),
                       parseInt(agegroup[weekno-2][1]),
                       parseInt(agegroup[weekno-1][1]),
                       parseInt(agegroup[weekno][1])
                       ]
        	}, {
	            type: 'column',
	            name: '20-29',
	            data: [parseInt(agegroup[weekno-4][2]),
                       parseInt(agegroup[weekno-3][2]),
                       parseInt(agegroup[weekno-2][2]),
                       parseInt(agegroup[weekno-1][2]),
                       parseInt(agegroup[weekno][2])
                       ]
        	}, {
	            type: 'column',
	            name: '30-39',
	            data: [parseInt(agegroup[weekno-4][3]),
                       parseInt(agegroup[weekno-3][3]),
                       parseInt(agegroup[weekno-2][3]),
                       parseInt(agegroup[weekno-1][3]),
                       parseInt(agegroup[weekno][3])
                       ]
        	}, {
	            type: 'column',
	            name: '40 and Above',
	            data: [parseInt(agegroup[weekno-4][4]),
                       parseInt(agegroup[weekno-3][4]),
                       parseInt(agegroup[weekno-2][4]),
                       parseInt(agegroup[weekno-1][4]),
                       parseInt(agegroup[weekno][4])
                       ]
        	}, {
                type: 'spline',
                name: 'Average Number Of Cases',
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
                name: 'Gender Distribution',
                data: [{
                    name: 'Male',
                    y: parseInt(gender['M']),
                    color: Highcharts.getOptions().colors[4] // Jane's color
                }, {
                    name: 'Female',
                    y: parseInt(gender['F']),
                    color: Highcharts.getOptions().colors[5] // John's color
                }],
                center: [0,10],
                size: 80,
                showInLegend: false,
                dataLabels: {
                    enabled: false
                }
            }
            ]
        });
        
        var tempbrands= [];
        var tempseries= [];
        var drilldown=[[],[],[],[]];
        
        tempbrands.push({ 
            name: 'LANGKAAN II', 
            y: langkaan,
            drilldown:'LANGKAAN II'
        });
        tempbrands.push({ 
            name: 'SAN AGUSTIN I', 
            y: sangustini,
            drilldown:'SAN AGUSTIN I'
        });
        tempbrands.push({ 
            name: 'SAN AGUSTIN III', 
            y: sangustiniii,
            drilldown:'SAN AGUSTIN III'
        });
        tempbrands.push({ 
            name: 'SAMPALOC I', 
            y: sampaloci,
            drilldown:'SAMPALOC I'
        });
       
        $.each(household, function (key) {
        	
        	for(var i = 0; i< barangay.length; i++)
        	{
        	if(barangay[i] == household[key]['barangay'])
        	drilldown[i].push([key,parseInt(household[key]['ctr'])]);
        	}
        });


     
        for(var i = 0; i< barangay.length; i++)
    	{
        	tempseries.push({
                name: barangay[i],
                id: barangay[i],
                data: drilldown[i]
            });
    	}
     
        
        // Create the chart
        $('#container3').highcharts({
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Cases per barangay'
            },
            subtitle: {
                text: 'Click the slices to view number people infected in each household'
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.name} : {point.y}'
                    }
                }
            },

            tooltip: {
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> of total<br/>'
            }, 

            series: [{
                name: 'Barangay',
                colorByPoint: true,
                data: tempbrands
            }],
            drilldown: {
                series: tempseries
            }
        });
        $('#container4').highcharts({
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Cases per barangay'
            },
            subtitle: {
                text: 'Click the slices to view number people infected in each household'
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        format: '{point.name} : {point.y}'
                    }
                }
            },

            tooltip: {
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> of total<br/>'
            }, 

            series: [{
                name: 'Barangay',
                colorByPoint: true,
                data: tempbrands
            }],
            drilldown: {
                series: tempseries
            }
        });
       
        
        
     
    });
