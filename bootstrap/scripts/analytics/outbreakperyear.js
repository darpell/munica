$(function () {

	var seriesdata = new Array();
	var catagoriesdata = new Array();
	$.each(months, function(index, value) {
		  catagoriesdata.push(value);
		});
	var temp = new Array();
	$.each(barangay[brgy], function(index, value) {
		
		temp.push(value);
		
		});

	seriesdata.push(
			{
                type: 'column',
                name: brgy,
                data: temp,
                dataLabels: {
                    enabled: true,
                    rotation: 0,
                    color: '#FFFFFF',
                    align: 'right',
                    x: 0,
                    y: 34,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif',
                        textShadow: '0 0 3px black'
                    }
                }
			});
			
	var splinedata = new Array();
	
	for(var i = 1 ; i <= 12; i++)
	{
	if(threshold[brgy][yearsel][i][3]<=monthsum[brgy][i-1])
	{
		splinedata.push({
            y: threshold[brgy][yearsel][i][3],
            marker: {
                symbol: 'diamond'
            }});
	}
	else 
	splinedata.push(threshold[brgy][yearsel][i][3]);
	}
	
	seriesdata.push(
	{
        type: 'spline',
        name: 'Epidemic Threshold',
        data: splinedata,
        marker: {
        	lineWidth: 2,
        	lineColor: Highcharts.getOptions().colors[3],
        	fillColor: 'white'
        }
    })
    
        $('#totaloutbreak').highcharts({
        	chart: {
                type: 'column'
            },
            title: {
                text: 'Reported Dengue Cases and Epidemic Threshold For ' + brgy
            },
            xAxis: {
                categories: catagoriesdata
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                },
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
                            this.point.name +': '+ this.y +' cases';
                    } else {
                        s = ''+
                            this.x  +': '+ this.y + ' cases';
                    }
                    return s;
                }
            },
            labels: {
                items: [{
                    html: 'Note: Spline Marker changes into a diamond when the number of cases exceeds the threshold',
                    style: {
                        left: '80px',
                        top: '8px',
                        color: 'black'
                    }
                }]
            },
            
            series: seriesdata
        });
    });