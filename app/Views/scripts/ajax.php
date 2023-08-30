<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script> <!-- Include the Accessibility module -->
<script>
    $(document).ready(function() {
        $.ajax({
            type: "Get",
            url: `http://localhost:8080/Home/getDatabyWeek`,
            success: function(response) {
                // Handle the response from the server (if needed)
                console.log(response);
                const clearData = response.pl_clear;
                const spikeData = response.pl_spike;
                const consecutiveData = response.pl_consecutive;

                // Call the function to update the charts with the initial data
                updateCharts(clearData, spikeData, consecutiveData);
            },
            error: function() {
                console.error("An error occurred while making the AJAX request.");
            }
        });

        $("select[name='week']").change(function() {
            const selectedValue = $(this).val();
            console.log(selectedValue);

            // Make the AJAX request
            $.ajax({
                type: "GET",
                url: `http://localhost:8080/Home/getDatabyWeek/${selectedValue}`,
                success: function(response) {
                    // Handle the response from the server (if needed)
                    console.log(response);
                    const clearData = response.pl_clear;
                    const spikeData = response.pl_spike;
                    const consecutiveData = response.pl_consecutive;

                    // Call the function to update the charts with new data
                    updateCharts(clearData, spikeData, consecutiveData);
                },
                error: function() {
                    console.error("An error occurred while making the AJAX request.");
                }
            });
        });
    });

    function updateCharts(clearData, spikeData, consecutiveData) {


        // Create the donut chart using Highcharts
        Highcharts.chart('donatChart', {
            chart: {
                type: 'pie'
            },
            accessibility: {
                enabled: false // Disable accessibility module
            },
            title: {
                text: 'Pie Chart'
            },
            plotOptions: {
                pie: {
                    colors: ['green', 'yellow', 'red'] // Set colors for CLEAR, SPIKE, and CONSECUTIVE
                }
            },
            series: [{
                data: [{
                        name: 'CLEAR',
                        y: clearData
                    },
                    {
                        name: 'SPIKE',
                        y: spikeData
                    },
                    {
                        name: 'CONSECUTIVE',
                        y: consecutiveData
                    }
                ],
                type: 'pie'
            }]
        });


        Highcharts.chart('columnChart', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Column'
            },
            xAxis: {
                categories: ['CLEAR', 'SPIKE', 'CONSECUTIVE']
            },
            yAxis: {
                title: {
                    text: 'Y Axis Label'
                },
                min: 0
            },
            plotOptions: {
                column: {
                    borderWidth: 0,
                    grouping: false,
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: [{
                name: 'Data',
                data: [{
                    name: 'CLEAR',
                    y: clearData,
                    color: 'rgb(0, 204, 102)' // Green color for CLEAR
                }, {
                    name: 'SPIKE',
                    y: spikeData,
                    color: 'rgb(255, 255, 51)' // Yellow color for SPIKE
                }, {
                    name: 'CONSECUTIVE',
                    y: consecutiveData,
                    color: 'red' // Red color for CONSECUTIVE
                }]
            }],
            credits: {
                enabled: false
            }
        });





    }
</script>