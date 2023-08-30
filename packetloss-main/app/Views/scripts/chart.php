<!-- map -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([-7.837222, 113.0275], 8);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    var packet = <?php echo json_encode($packetloss); ?>;
    var koordinate = [];



    for (let i = 0; i < packet.length; i++) {
        var marker = L.marker([packet[i].latitude, packet[i].longitude]).addTo(map)
            .bindPopup('<b>' + packet[i].site_id + '</b>')
            .openPopup();

    }
</script>

<!--areaChart -->
<script>
    function generateRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    fetch('<?= base_url('api/weeks') ?>')
        .then(res => res.json())
        .then(response => getLossData(response.map(week => `Minggu ${week}`)));

    function getLossData(weeks) {
        fetch('<?= base_url('api/lossdata') ?>')
            .then(res => res.json())
            .then(response => drawChart(weeks, response));
    }

    function drawChart(weeks, lossdata) {
        const lineCtx = document.getElementById('lineChart').getContext('2d');

        const lineData = {
            labels: weeks,
            datasets: [{
                label: 'Consecutive',
                data: lossdata.consecutives,
                borderColor: 'rgb(255, 255, 255)',
                backgroundColor: 'red',
                borderWidth: 2,
                fill: true,
            }, {
                label: 'Clear',
                data: lossdata.clears,
                borderColor: 'rgba(255, 255, 255)',
                backgroundColor: 'rgb(0,204,102)',
                borderWidth: 2,
                fill: true,
            }, {
                label: 'Spike',
                data: lossdata.spikes,
                borderColor: 'rgb(255, 255, 255)',
                backgroundColor: 'rgb(255,255,51)',
                borderWidth: 2,
                fill: true,
            }],
        }

        new Chart(lineCtx, {
            type: 'line',
            data: lineData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    },
                },
                responsive: true,
            }
        });
    }
</script>

<!-- Donat -->
<script>
    const ctx = document.getElementById('donatChart');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['CLEAR', 'SPIKE', 'CONSECUTIVE'],

            datasets: [{
                data: [
                    <?= $pl_clear; ?>, <?= $pl_spike; ?>, <?= $pl_consecutive; ?>
                ],
                backgroundColor: ['rgb(0,204,102)', 'rgb(255,255,51)', 'red'],
                borderWidth: 1
            }]
        },
        options: {
            cutoutPercentage: 10,
            responsize: true,
            maintainAspectRatio: false
        }

    });
</script>

<script>
    const bar = document.getElementById('barChart');
    new Chart(bar, {
        type: 'bar',
        data: {
            labels: ['CLEAR', 'SPIKE', 'CONSECUTIVE'],
            datasets: [{
                data: [
                    <?= $pl_clear; ?>, <?= $pl_spike; ?>, <?= $pl_consecutive; ?>
                ],
                backgroundColor: ['rgb(0,204,102)', 'rgb(255,255,51)', 'red'],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true // Memulai skala y dari 0
                }
            },
            responsize: true,
            maintainAspectRatio: false
        }

    });
</script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    Highcharts.chart('areaChart', {
        chart: {
            type: 'area'
        },
        title: {
            text: 'Greenhouse gases from Norwegian economic activity',
            align: 'left'
        },
        subtitle: {
            text: 'Source: ' +
                '<a href="https://www.ssb.no/en/statbank/table/09288/"' +
                'target="_blank">SSB</a>',
            align: 'left'
        },
        yAxis: {
            title: {
                useHTML: true,
                text: 'Million tonnes CO<sub>2</sub>-equivalents'
            }
        },
        tooltip: {
            shared: true,
            headerFormat: '<span style="font-size:12px"><b>{point.key}</b></span><br>'
        },
        plotOptions: {
            series: {
                pointStart: 2012
            },
            area: {
                stacking: 'normal',
                lineColor: '#666666',
                lineWidth: 1,
                marker: {
                    lineWidth: 1,
                    lineColor: '#666666'
                }
            }
        },
        series: [{
            name: 'Ocean transport',
            data: [13234, 12729, 11533, 17798, 10398, 12811, 15483, 16196, 16214]
        }, {
            name: 'Households',
            data: [6685, 6535, 6389, 6384, 6251, 5725, 5631, 5047, 5039]

        }, {
            name: 'Agriculture and hunting',
            data: [4752, 4820, 4877, 4925, 5006, 4976, 4946, 4911, 4913]
        }, {
            name: 'Air transport',
            data: [3164, 3541, 3898, 4115, 3388, 3569, 3887, 4593, 1550]

        }, {
            name: 'Construction',
            data: [2019, 2189, 2150, 2217, 2175, 2257, 2344, 2176, 2186]
        }]
    });
</script>