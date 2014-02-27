$(function () {
    $('#symptoms').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Symptoms'
        },
        tooltip: {
    	    pointFormat: '{series.name}: <b> {point.y} </b> ({point.percentage:.1f}%)'
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
            name: 'Symptom Count',
            data: [
                ['Muscle Pain', symp_mp],
                ['Joint Pain', symp_jp],
                {
                    name: 'Headache',
                    y: symp_h,
                    sliced: true,
                    selected: true
                },
                ['Bleeding', symp_b],
                ['Rashes', symp_r]
            ]
        }]
    });
});