$(function () {

	var seriesdata = new Array();
	var catagoriesdata = new Array();
	var piedata = new Array();
	$.each(outbreak, function(index, value) {
	  seriesdata.push(value);
	  catagoriesdata.push(index);
	});
	var ctr = 0;
	$.each(outbreakmonth, function(index, value) {
		if(value>0)
			{
				piedata.push( {
	            name: index,
	            y: value,
	            color: Highcharts.getOptions().colors[ctr] // Joe's color
				});
				ctr++;
			}
		});
        $('#totaloutbreak').highcharts({
            chart: {
            },
            title: {
                text: 'Total Outbreaks occured per year'
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
            },
            series: [{
                type: 'column',
                name: 'Number of outbreaks',
                data: seriesdata
            },{
                type: 'pie',
                name: 'Total consumption',
                data: piedata,
                center: [650, 3],
                size: 100,
                showInLegend: false,
                dataLabels: {
                    enabled: false
                }
            }]
        });
    });
    