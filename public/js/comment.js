let comment = true

$(".comment-create-btn").click(createComment)
$(".comment-edit-btn").click(updateComment)
$(".comment-delete-btn").click(destroyComment)

function createComment () {
    let id = $(this).parent().parent().parent().attr('id')
    $.ajax({
        url: '/comment/create',
        type: 'POST',
        dataType: 'json',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            text: $(`#${id} .comment-text`).val(),
            id: id,
        },
        success: function(response){
            if (response.success) {
                $(`#${id} .comment-create-msg`).text('Created successfully')
                $(`#${id} .comment-text`).val('')
                $(`#${id} #comments`).prepend(response.html)
                $(`#${id} #comments:last-child`).find('.comment-edit-btn').bind('click', updateComment)
                $(`#${id} #comments:last-child`).find('.comment-delete-btn').bind('click', destroyComment)
            } else {
                $(`#${id} .comment-create-msg`).text(response.error)
            }
        }
    })
}
function updateComment () {
    let id = $(this).parent().parent().parent().parent().parent().attr('id')
    let commId = $(this).parent().parent().attr('id')
    let text = $(`#${id} #${commId} .text`)
    let msg = $(`#${id} #${commId} .comment-msg`)
    let btn = $(`#${id} #${commId} .comment-edit-btn`)
    switch(comment) {
    case true:
        btn.text('Save').toggle()
        $(".comment-edit-btn").toggle()
        $(".comment-delete-btn").toggle()
        text.replaceWith(`<textarea class="text">${text.text()}</textarea>`)
        comment = !comment
        break
    case false:
        $.ajax({
            url: `/comment/${commId}`,
            type: 'PATCH',
            dataType: 'json',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                text: text.val(),
            },
            success: function(response){
                if (response.success) {
                    text.replaceWith(`<p class="text">${text.val()}</p>`)
                    msg.text('')
                    btn.text('Edit').toggle()
                    $(".comment-edit-btn").toggle()
                    $(".comment-delete-btn").toggle()
                    comment = !comment
                } else {
                    msg.text(response.error)

                }
            }
        });
        break
    }
}
function destroyComment () {
    let id = $(this).parent().parent().parent().parent().parent().attr('id')
    let commId = $(this).parent().parent().attr('id')
    $.ajax({
        url: `/comment/${commId}`,
        type: 'DELETE',
        dataType: 'json',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response){
            if (response.success) {
                $(`#${id} #${commId}`).remove()
            }
        }
    });
}
