const currentDate = new Date().toISOString().slice(0, 10)
const finalDate = createAftDate()
const dateFrom = $('#weatherDateFrom')
const dateTo = $('#weatherDateTo')

function createAftDate () {
    let date = new Date()
    date.setDate(date.getDate() + 4)
    return date.toISOString().slice(0, 10)
}
$(document).ready(function () {
    dateFrom.attr('min', currentDate).attr('max', finalDate)
    dateTo.attr('min', currentDate).attr('max', finalDate)
})
$('#dateWeather').change(function () {
    if (dateFrom.val() && dateTo.val() && dateFrom.val() > dateTo.val()) {
        let string = dateFrom.val()
        dateFrom.val(dateTo.val())
        dateTo.val(string)
    }
})
$('#getWeather').click(function () {
    $.ajax({
        url: '/api/weather',
        type: 'POST',
        dataType: 'json',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            dateFrom: $('#weatherDateFrom').val(),
            dateTo: $('#weatherDateTo').val(),
            country: $('#weatherCountry').val(),
            city: $('#weatherCity').val(),
        },
        success: function(response){
            if (!response.error) {
                $('#weather').empty().append(response.html)
            } else {
                $('#error').text(response.error)
            }
        }
    })
})
