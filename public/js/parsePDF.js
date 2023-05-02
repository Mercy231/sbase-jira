const fileInput = $('#fileInputPdf')
$('#btnSubmitPdf').click(function () {
    const file = fileInput[0].files
    let formData = new FormData()
    if (file.length > 0) {
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'))
        $.each(fileInput[0].files, function(i, file) {
            formData.append('file-'+i, file);
        });
        $.ajax({
            url: '/parsePDF',
            type: 'POST',
            contentType: false,
            processData: false,
            dataType: 'json',
            data: formData,
            success: function(response) {
                $('#parsedInfo').empty().append(response.html)
            }
        })
    }
})
