$(function () {
    var chart;
    $(document).ready(function () {
    	
    	// Build the chart
        $('#container').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Pie Chart of Cases'
            },
            tooltip: {
        	    pointFormat: '{series.name}: <b>{point.y}</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    animation: false,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.y ;
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Browser share',
                data: [
                    ['Threatening',  parseInt(case_data['threatening_count'])],
                    {
                        name: 'Suspected',
                        y:  parseInt(case_data['suspected_count']),
                        sliced: true,
                        selected: true
                    },
                    ['Serious',    parseInt(case_data['serious_count'])],
                    ['Hospitalized',     parseInt(case_data['hospitalized_count'])],
                ]
            }]
        });
    });
    
});