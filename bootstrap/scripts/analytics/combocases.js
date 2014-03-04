$(function () {
if(brgycount != 'null')
{
	var arragegroup = new Array();
	for (var i=0;i<agegroup[0].length;i++)
	{
		arragegroup[i] = [agegroup[0][i],agegroup[1][i],agegroup[2][i],agegroup[3][i]];
	}

        $('#combocases').highcharts({
            chart: {
            },
            title: {
                text: 'Case Demographics'
            },
            xAxis: {
                categories: brgys
            },
            tooltip: {
                formatter: function() {
                    var s;
                    if (this.point.name) { // the pie chart
                        s = ''+
                            this.point.name +': '+ this.y +' cases';
                    } else {
                        s = ''+
                            this.x  +': '+ this.y;
                    }
                    return s;
                }
            },
            labels: {
                items: [{
                    html: 'Geographic Distribution',
                    style: {
                        left: '80px',
                        top: '8px',
                        color: 'black'
                    }
                },{
                    html: 'Gender Distribution',
                    style: {
                        left: '550px',
                        top: '8px',
                        color: 'black'
                    }
                }]
            },
            series: [{
                type: 'column',
                name: '<0',
                data: arragegroup[0],

            }, {
                type: 'column',
                name: '1-10',
                data: arragegroup[1],

            }, {
                type: 'column',
                name: '11-20',
                data: arragegroup[2],

            }, {
                type: 'column',
                name: '21-30',
                data: arragegroup[3],

            }, {
                type: 'column',
                name: '31-40',
                data: arragegroup[4],

            }, {
                type: 'column',
                name: '>40',
                data: arragegroup[5],

            },  {
                type: 'pie',
                name: 'Barangay Distribution',
                data: [{
                    name: brgys[0],
                    y: brgycount[0],
                    color: Highcharts.getOptions().colors[0] // Jane's color
                }, {
                    name: brgys[1],
                    y: brgycount[1],
                    color: Highcharts.getOptions().colors[1] // John's color
                }, {
                    name: brgys[2],
                    y: brgycount[2],
                    color: Highcharts.getOptions().colors[2] // Joe's color
                }
                , {
                    name: brgys[3],
                    y: brgycount[3],
                    color: Highcharts.getOptions().colors[3] // Joe's color
                }],
                center: [12, 7],
                size: 100,
                showInLegend: false,
                dataLabels: {
                    enabled: false
                }
            },  {
                type: 'pie',
                name: 'Gender Distribution',
                data: [{
                    name: 'Male',
                    y: gender['m'],
                    color: Highcharts.getOptions().colors[0] // Jane's color
                }, {
                    name: 'Female',
                    y: gender['f'],
                    color: Highcharts.getOptions().colors[1] // John's color
                }],
                center: [700, 7],
                size: 100,
                showInLegend: false,
                dataLabels: {
                    enabled: false
                }
            }]
        });
}

    });
    
