Highcharts.chart('graf1', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Prikaz stanja pozicija na kataforezi'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y} ({point.percentage:.1f}) %'
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: podaci
    }]
});

graf2funkcija();
