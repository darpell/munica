$(function () {

		if (cyearstart <= lyearstart)
		{
			var name1 = 'Cases'
			var name2 = 'larval Breeding Gorunds'
			var name1data = cases;
			var name2data = caseandlarval;
		}
		else
		{
			var name2 = 'Cases'
			var name1 = 'larval Breeding Gorunds'
			var name1data = larval;
			var name2data = caseandlarval;
		}
		
	        $('#areaCasesAndLarval').highcharts({
	            chart: {
	                zoomType: 'x',
	                spacingRight: 20
	            },
	            title: {
	                text: 'Cases and Larval breeding grounds from ' + clyearstart + ' to present day'
	            },
	            subtitle: {
	                text: document.ontouchstart === undefined ?
	                    'Click and drag in the plot area to zoom in' :
	                    'Pinch the chart to zoom in'
	            },
	            xAxis: {
	                type: 'datetime',
	                maxZoom: 14 * 24 * 3600000, // fourteen days
	                title: {
	                    text: null
	                }
	            },
	            yAxis: {
	                title: {
	                    text: ''
	                }
	            },
	            tooltip: {
	                shared: true
	            },
	            legend: {
	                enabled: false
	            },
	            plotOptions: {
	                area: {
	                    fillColor: {
	                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
	                        stops: [
	                            [0, Highcharts.getOptions().colors[0]],
	                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
	                        ]
	                    },
	                    lineWidth: 1,
	                    marker: {
	                        enabled: false
	                    },
	                    shadow: false,
	                    states: {
	                        hover: {
	                            lineWidth: 1
	                        }
	                    },
	                    threshold: null
	                }
	            },
	           
	            series: [{
	                type: 'area',
	                name: name1,
	                pointInterval: 30 * 24 * 3600 * 1000,
	                pointStart: Date.UTC(clyearstart, clmonthstart-1, 01),
	                data: name1data
	            },
	            {
	                type: 'area',
	                name: name2,
	                pointInterval: 30 * 24 * 3600 * 1000,
	                pointStart: Date.UTC(clyearstart, clmonthstart-1, 01),
	                data: name2data
	            }]
	        });
	    });
	    
