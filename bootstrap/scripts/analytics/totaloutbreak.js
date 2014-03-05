$(function () {

	var seriesdata = new Array();
	var catagoriesdata = new Array();
	var piedata = new Array();
	for(var i = yearstart; i<=yearend;i++)
	{  
	catagoriesdata.push(i);
	}
	var ctr = 0;
	$.each(outbreak, function(index, value) {
		var temp = new Array();
		var sum = 0;
		$.each(value, function(x, y) {
			temp.push(y);
			sum += y;
			})
		seriesdata.push(
		{
                type: 'column',
                name: index,
                data: temp,
                dataLabels: {
                    enabled: true,
                    rotation: 0,
                    color: '#FFFFFF',
                    align: 'center',
                    x: 0,
                    y: 0,
                    style: {
                        fontSize: '15px',
                        fontFamily: 'Verdana, sans-serif',
                        textShadow: '0 0 3px black'
                    }
                }
		})
		
		piedata.push( {
            name: index,
            y: sum,
            color: Highcharts.getOptions().colors[ctr] // Joe's color
			});
		ctr++;
	});
	

	seriesdata.push({
        type: 'pie',
        name: 'Total consumption',
        data: piedata,
        center: [650, 3],
        size: 100,
        showInLegend: false,
        dataLabels: {
            enabled: false
        }
    });
        $('#totaloutbreak').highcharts({
            chart: {
            },
            title: {
                text: 'Total Outbreaks occured for years ' + yearstart + ' to '+ yearend
            },
            xAxis: {
                categories: catagoriesdata
            },
            tooltip: {
                formatter: function() {
                    var s;
                    if (this.point.name) { // the pie chart
                        s = ''+
                            this.point.name +': '+ this.y +' Outbreaks';
                    } else {
                        s = ''+
                            this.x  +': '+ this.y + ' Outbreaks';
                    }
                    return s;
                }
            }, labels: {
                items: [{
                    html: 'Overall Geographic Distribution Of Outbreaks',
                    style: {
                        left: '350px',
                        top: '8px',
                        color: 'black'
                    }
                }]
            }, plotOptions: {
                column: {
                    stacking: 'normal'
                }
            },
            series: seriesdata
        });
    });
    