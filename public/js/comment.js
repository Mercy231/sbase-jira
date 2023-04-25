$(".comment-create-btn").click(createComment)
$(".comment-edit-btn").click(showUpdateComment)
$(".comment-delete-btn").click(destroyComment)
$('.comment-reply-btn').click(createReply)

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
            reply: false,
        },
        success: function(response){
            if (response.success) {
                $(`#${id} .comment-create-msg`).text('Created successfully')
                $(`#${id} .comment-text`).val('')
                $(`#${id} #comments`).prepend(response.html)
                $(`#${id} #comments .comment-edit-btn`).first().bind('click', showUpdateComment)
                $(`#${id} #comments .comment-delete-btn`).first().bind('click', destroyComment)
                $(`#${id} #comments .comment-reply-btn`).first().bind('click', createReply)
            } else {
                $(`#${id} .comment-create-msg`).text(response.error)
            }
        }
    })
}
function showUpdateComment () {
    let id = $(this).parent().parent().parent().parent().parent().parent().attr('id')
    let commId = $(this).parent().parent().parent().attr('id')
    let text = $(`#${id} #${commId} .text:first`)
    let btn = $(`#${id} #${commId} .comment-edit-btn`)
    btn.text('Save').toggle()
    $(".comment-edit-btn").toggle()
    $(".comment-delete-btn").toggle()
    text.replaceWith(`<textarea class="text">${text.text()}</textarea>`)
    btn.unbind('click')
    btn.bind('click', updateComment)
}
function updateComment () {
    let id = $(this).parent().parent().parent().parent().parent().parent().attr('id')
    let commId = $(this).parent().parent().parent().attr('id')
    let text = $(`#${id} #${commId} .text:first`)
    let msg = $(`#${id} #${commId} .comment-msg`)
    let btn = $(`#${id} #${commId} .comment-edit-btn`)
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
                btn.unbind('click')
                btn.bind('click', showUpdateComment)
            } else {
                msg.text(response.error)
            }
        }
    });
}
function destroyComment () {
    let id = $(this).parent().parent().parent().parent().parent().parent().attr('id')
    let commId = $(this).parent().parent().parent().attr('id')
    console.log(id, commId)
    if (confirm("Delete comment?")) {
        $.ajax({
            url: `/comment/${commId}`,
            type: 'DELETE',
            dataType: 'json',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                if (response.success) {
                    $(`#${id} #${commId}`).remove()
                }
            }
        });
    }
}

function createReply() {
    let id = $(this).parent().parent().attr('id')
    console.log(id)
    $.ajax({
        url: '/reply/create',
        type: 'POST',
        dataType: 'json',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            text: $(`#${id} .comment-text`).val(),
            id: id,
            reply: true,
        },
        success: function(response){
            console.log('resr')
            if (response.success) {
                $(`#${id} .comment-create-msg`).text('Created successfully')
                $(`#${id} .comment-text`).val('')
                $(`#${id} #comments`).prepend(response.html)
                $(`#${id} #comments .comment-edit-btn`).first().bind('click', showUpdateComment)
                $(`#${id} #comments .comment-delete-btn`).first().bind('click', destroyComment)
                $(`#${id} #comments .comment-reply-btn`).first().bind('click', createReply)
            } else {
                $(`#${id} .comment-create-msg`).text(response.error)
            }
        }
    })
}
