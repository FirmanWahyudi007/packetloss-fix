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
        var markerColor = 'marker-icon-2x-blue'
        if (packet[i].pl_status === 'CONSECUTIVE') {
            markerColor = 'marker-icon-2x-red'; // Jika pl_status = 'consecutive', warna merah
        } else if (packet[i].pl_status === 'SPIKE') {
            markerColor = 'marker-icon-2x-yellow'; // Jika pl_status = 'spike', warna kuning
        } else if (packet[i].pl_status === 'CLEAR') {
            markerColor = 'marker-icon-2x-green'; // Jika pl_status = 'clear', warna hijau
        }
        var markerIcon = new L.Icon({
            iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/${markerColor}.png`,
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });
        var marker = L.marker([packet[i].latitude, packet[i].longitude], {
                icon: markerIcon
            }).addTo(map)
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
        const stackedAreaOptions = {
            chart: {
                type: 'area',
                renderTo: 'stackedAreaChart', // Specify the chart container ID
                backgroundColor: 'transparent' // Set the background color to transparent
            },
            title: {
                text: 'Stacked Area Chart'
            },
            xAxis: {
                categories: weeks
            },
            yAxis: {
                title: {
                    text: 'Loss Data'
                },
                min: 0
            },
            plotOptions: {
                area: {
                    stacking: 'normal', // Set stacking to 'normal' for a stacked area chart
                    lineWidth: 0, // No border lines between areas
                    marker: {
                        enabled: false // Disable markers on data points
                    }
                }
            },
            series: [{
                name: 'Consecutive',
                data: lossdata.consecutives,
                color: 'red'
            }, {
                name: 'Clear',
                data: lossdata.clears,
                color: 'rgb(0,204,102)'
            }, {
                name: 'Spike',
                data: lossdata.spikes,
                color: 'rgb(255,255,51)'
            }],
            credits: {
                enabled: false
            }
        };

        // Create the Highcharts chart
        new Highcharts.Chart(stackedAreaOptions);
    }
</script>

<!-- Donat -->

<!-- <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script> -->
<!-- <script>
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
</script> -->