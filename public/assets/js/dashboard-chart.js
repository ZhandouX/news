// dashboard-chart.js
$(function () {
    "use strict";

    // Gunakan newsPerMonth yang sudah diinisialisasi di blade
    var bulanLabels = newsPerMonth.map(item => item.monthName);
    var jumlahData = newsPerMonth.map(item => item.count);
    var progressData = newsPerMonth.map(item => item.progress);

    // ================== DATASET ==================

    // BAR & LINE Chart (Jumlah berita per bulan)
    var data = {
        labels: bulanLabels,
        datasets: [
            {
                label: "Jumlah Berita",
                data: jumlahData,
                backgroundColor: "rgba(54, 162, 235, 0.2)",
                borderColor: "rgba(54, 162, 235, 1)",
                borderWidth: 2,
                fill: false,
            },
        ],
    };

    // MULTILINE Chart (contoh statis, biar dashboard tidak kosong)
    var multiLineData = {
        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
        datasets: [
            {
                label: "Dataset 1",
                data: [12, 19, 3, 5, 2, 3],
                borderColor: ["#587ce4"],
                borderWidth: 2,
                fill: false,
            },
            {
                label: "Dataset 2",
                data: [5, 23, 7, 12, 42, 23],
                borderColor: ["#ede190"],
                borderWidth: 2,
                fill: false,
            },
            {
                label: "Dataset 3",
                data: [15, 10, 21, 32, 12, 33],
                borderColor: ["#f44252"],
                borderWidth: 2,
                fill: false,
            },
        ],
    };

    // AREA Chart (Jumlah berita per bulan, ada fill)
    var areaData = {
        labels: bulanLabels,
        datasets: [
            {
                label: "Jumlah Berita per Bulan",
                data: jumlahData,
                backgroundColor: "rgba(255, 99, 132, 0.2)",
                borderColor: "rgba(255,99,132,1)",
                borderWidth: 2,
                fill: true,
            },
        ],
    };

    // DOUGHNUT / PIE Chart (contoh statis)
    var doughnutPieData = {
        datasets: [
            {
                data: [30, 40, 30],
                backgroundColor: [
                    "rgba(255, 99, 132, 0.5)",
                    "rgba(54, 162, 235, 0.5)",
                    "rgba(255, 206, 86, 0.5)",
                    "rgba(75, 192, 192, 0.5)",
                    "rgba(153, 102, 255, 0.5)",
                    "rgba(255, 159, 64, 0.5)",
                ],
                borderColor: [
                    "rgba(255,99,132,1)",
                    "rgba(54, 162, 235, 1)",
                    "rgba(255, 206, 86, 1)",
                    "rgba(75, 192, 192, 1)",
                    "rgba(153, 102, 255, 1)",
                    "rgba(255, 159, 64, 1)",
                ],
            },
        ],
        labels: ["Pink", "Blue", "Yellow"],
    };

    // MULTI-AREA Chart (contoh statis)
    var multiAreaData = {
        labels: [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec",
        ],
        datasets: [
            {
                label: "Facebook",
                data: [8, 11, 13, 15, 12, 13, 16, 15, 13, 19, 11, 14],
                borderColor: ["rgba(255, 99, 132, 0.5)"],
                backgroundColor: ["rgba(255, 99, 132, 0.5)"],
                borderWidth: 1,
                fill: true,
            },
            {
                label: "Twitter",
                data: [7, 17, 12, 16, 14, 18, 16, 12, 15, 11, 13, 9],
                borderColor: ["rgba(54, 162, 235, 0.5)"],
                backgroundColor: ["rgba(54, 162, 235, 0.5)"],
                borderWidth: 1,
                fill: true,
            },
            {
                label: "Linkedin",
                data: [6, 14, 16, 20, 12, 18, 15, 12, 17, 19, 15, 11],
                borderColor: ["rgba(255, 206, 86, 0.5)"],
                backgroundColor: ["rgba(255, 206, 86, 0.5)"],
                borderWidth: 1,
                fill: true,
            },
        ],
    };

    // SCATTER Chart (contoh statis)
    var scatterChartData = {
        datasets: [
            {
                label: "First Dataset",
                data: [
                    { x: -10, y: 0 },
                    { x: 0, y: 3 },
                    { x: -25, y: 5 },
                    { x: 40, y: 5 },
                ],
                backgroundColor: ["rgba(255, 99, 132, 0.2)"],
                borderColor: ["rgba(255,99,132,1)"],
                borderWidth: 1,
            },
            {
                label: "Second Dataset",
                data: [
                    { x: 10, y: 5 },
                    { x: 20, y: -30 },
                    { x: -25, y: 15 },
                    { x: -10, y: 5 },
                ],
                backgroundColor: ["rgba(54, 162, 235, 0.2)"],
                borderColor: ["rgba(54, 162, 235, 1)"],
                borderWidth: 1,
            },
        ],
    };

    // ================== OPTIONS ==================

    var options = {
        scales: {
            y: {
                ticks: { beginAtZero: true },
            },
        },
        legend: { display: false },
        elements: {
            line: { tension: 0.5 },
            point: { radius: 0 },
        },
    };

    var areaOptions = {
        elements: { line: { tension: 0.5 } },
        plugins: { filler: { propagate: true } },
    };

    var multiAreaOptions = {
        plugins: { filler: { propagate: true } },
        elements: {
            line: { tension: 0.5 },
            point: { radius: 0 },
        },
        scales: {
            x: { gridLines: { display: false } },
            y: { gridLines: { display: false } },
        },
    };

    var doughnutPieOptions = {
        responsive: true,
        animation: { animateScale: true, animateRotate: true },
    };

    var scatterChartOptions = {
        scales: { x: { type: "linear", position: "bottom" } },
    };

    // ================== RENDER ==================

    if ($("#barChart").length) {
        var barChartCanvas = $("#barChart").get(0).getContext("2d");
        new Chart(barChartCanvas, { type: "bar", data: data, options: options });
    }

    if ($("#lineChart").length) {
        var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
        new Chart(lineChartCanvas, { type: "line", data: data, options: options });
    }

    if ($("#linechart-multi").length) {
        var multiLineCanvas = $("#linechart-multi").get(0).getContext("2d");
        new Chart(multiLineCanvas, {
            type: "line",
            data: multiLineData,
            options: options,
        });
    }

    if ($("#areachart-multi").length) {
        var multiAreaCanvas = $("#areachart-multi").get(0).getContext("2d");
        new Chart(multiAreaCanvas, {
            type: "line",
            data: multiAreaData,
            options: multiAreaOptions,
        });
    }

    if ($("#doughnutChart").length) {
        var doughnutChartCanvas = $("#doughnutChart").get(0).getContext("2d");
        new Chart(doughnutChartCanvas, {
            type: "doughnut",
            data: doughnutPieData,
            options: doughnutPieOptions,
        });
    }

    if ($("#pieChart").length) {
        var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
        new Chart(pieChartCanvas, {
            type: "pie",
            data: doughnutPieData,
            options: doughnutPieOptions,
        });
    }

    if ($("#areaChart").length) {
        var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
        new Chart(areaChartCanvas, {
            type: "line",
            data: areaData,
            options: areaOptions,
        });
    }

    if ($("#scatterChart").length) {
        var scatterChartCanvas = $("#scatterChart").get(0).getContext("2d");
        new Chart(scatterChartCanvas, {
            type: "scatter",
            data: scatterChartData,
            options: scatterChartOptions,
        });
    }

    if ($("#browserTrafficChart").length) {
        var doughnutChartCanvas = $("#browserTrafficChart").get(0).getContext("2d");
        new Chart(doughnutChartCanvas, {
            type: "doughnut",
            data: doughnutPieData,
            options: doughnutPieOptions,
        });
    }
});