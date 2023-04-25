$('#getStats').click(function () {
    $.ajax({
        url: '/admin/get/stats',
        type: 'POST',
        dataType: 'json',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            dateFrom: $('#dateFrom').val(),
            dateTo: $('#dateTo').val(),
        },
        success: function(response){
            stats(response.pieChart, response.barChart)
        }
    })
})

function stats (pieChartData, barChartData) {
    const pieChart = new Chart ($('#pieChart'), {
        type: 'pie',
        data: {
            labels: ['Posts', 'Comments'],
            datasets: [{
                label: 'Posts and comments stats',
                data: pieChartData,
                backgroundColor: [
                    'rgb(50, 170, 255)',
                    'rgb(255, 100, 150)',
                ],
            }],
        },
    })
    const barChart = new Chart ($('#barChart'), {
        type: 'bar',
        data: {
            labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            datasets: [{
                label: 'Registered users by last week',
                data: barChartData,
            }],
        },
    })
}




