$("#country-dd").change(function () {
    let countryId = this.value
    $('#state-dd option').remove()
    $('#city-dd option').remove()
    $.ajax({
        url: "/register/getStates",
        type: 'POST',
        dataType: 'json',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            country_id: countryId,
        },
        success:function(response){
            $('#state-dd').html('<option value="0">Select State</option>');
            $.each(response.states, function(index, item) {
                $('#state-dd').append(`<option value="${item.id}">${item.name}</option>`)
            })
            $('#city-dd').html('<option value="0">Select City</option>')
        }
    })
})
$("#state-dd").change(function () {
    let stateId = this.value
    $('#city-dd').html('')
    $.ajax({
        url: "/register/getCities",
        type: 'POST',
        dataType: 'json',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            state_id: stateId,
        },
        success:function(response){
            $('#city-dd').html('<option value="">Select State</option>');
            $.each(response.cities, function(index, item) {
                $('#city-dd').append(`<option value="${item.id}">${item.name}</option>`)
            })
        }
    })
})
