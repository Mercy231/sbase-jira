$('#lang').change(function () {
    $.ajax({
        url: `/changeLang`,
        type: 'POST',
        dataType: 'json',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            lang: $('#lang').val(),
        },
        success: function(response){
            console.log(`Language selected: ${response.lang}`)
            if (response.success) location.reload()
        }
    })
})
