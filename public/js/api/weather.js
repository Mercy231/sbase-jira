const fullCurrentDate = new Date()
const day = ('0' + fullCurrentDate.getDate()).slice(-2)
const month = ('0' + (fullCurrentDate.getMonth() + 1)).slice(-2)
const year = fullCurrentDate.getFullYear()
const currentDate = `${year}-${month}-${day}`

const fullFinalDate = new Date()
fullFinalDate.setDate(fullFinalDate.getDate() + 4)
const finalDay = ('0' + fullFinalDate.getDate()).slice(-2)
const finalMonth = ('0' + (fullFinalDate.getMonth() + 1)).slice(-2)
const finalYear = fullFinalDate.getFullYear()
const finalDate = `${finalYear}-${finalMonth}-${finalDay}`

const dateFrom = $('#weatherDateFrom')
const dateTo = $('#weatherDateTo')

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
