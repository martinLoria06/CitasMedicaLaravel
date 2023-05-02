const chart = Highcharts.chart("container", {
    chart: {
        type: "column",
    },
    title: {
        text: "Desempeño medico",
    },

    xAxis: {
        categories: [],
        crosshair: true,
    },
    yAxis: {
        min: 0,
        title: {
            text: "citas atendidas",
        },
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat:
            '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
        footerFormat: "</table>",
        shared: true,
        useHTML: true,
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0,
        },
    },
    series: [],
});

function fetchData() {
    // Fetch API
    fetch("/reportes/doctors/column/data")
        .then(function (response) {
            return response.json();
        })
        .then(function (myJson) {
            // console.log(myJson);
            chart.xAxis[0].setCategories(myJson.categories);
            chart.addSeries(myJson.series[0]); //Citas atendidas
            chart.addSeries(myJson.series[1]); //Citas canceladas
        });
}

$(function () {
    fetchData();
})
