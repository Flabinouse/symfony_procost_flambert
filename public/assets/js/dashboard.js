////////////////////////// Ratio Chart //////////////////////////

var ratioFullData = {
    datasets: [{
        data: ratioData,
        backgroundColor: [
            '#1F9D55',
            '#fff',
        ],
        borderColor: [
            '#ddd',
            '#ddd'
        ]
    }]
};

var ratioChart = new Chart(document.getElementById("ratio-chart").getContext("2d"), {
    type: 'doughnut',
    data: ratioFullData,
    options: {
        tooltips: {
            enabled: false
        }
    }
});

////////////////////////// Delivered Chart //////////////////////////

var deliveredFullData = {
    datasets: [{
        data: deliveredData,
        backgroundColor: [
            '#1F9D55',
            '#fff',
        ],
        borderColor: [
            '#ddd',
            '#ddd'
        ]
    }]
};

var deliveredChart = new Chart(document.getElementById("delivered-chart").getContext("2d"), {
    type: 'doughnut',
    data: deliveredFullData,
    options: {
        tooltips: {
            enabled: false
        }
    }
});