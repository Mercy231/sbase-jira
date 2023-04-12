let bool = true

$(".post-create-btn").click(createPost)
$(".post-edit-btn").click(updatePost)
$(".post-delete-btn").click(destroyPost)

function createPost () {
    $.ajax({
        url: '/post/create',
        type: 'POST',
        dataType: 'json',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            title: $("#post-create-title").val(),
            text: $("#post-create-text").val(),
        },
        success: function(response){
            if (response.success) {
                $("#post-create-msg").text('Created successfully')
                $("#post-create-title").val('')
                $("#post-create-text").val('')
                $("#posts").prepend(response.html).find('.post-edit-btn').bind('click', updatePost)
                $("#posts").find('.post-delete-btn').bind('click', destroyPost)
            } else {
                $("#post-create-msg").text(response.error)
            }
        }
    });
}
function updatePost () {
    let id = $(this).parent().parent().attr('id')
    let title = $(`#${id} .title`)
    let text = $(`#${id} .text`)
    let msg = $(`#${id} .post-msg`)
    let btn = $(`#${id} .post-edit-btn`)
    switch (bool) {
        case true:
            btn.text('Save').toggle()
            $(".post-edit-btn").toggle()
            $(".post-delete-btn").toggle()
            title.replaceWith(`<input type='text' class="title" value="${title.text()}">`)
            text.replaceWith(`<textarea class="text">${text.text()}</textarea>`)
            bool = !bool
            break
        case false:
            $.ajax({
                url: `/post/${id}`,
                type: 'PATCH',
                dataType: 'json',
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    title: title.val(),
                    text: text.val(),
                },
                success: function(response){
                    if (response.success) {
                        title.replaceWith(`<h2 class="title">${title.val()}</h2>`)
                        text.replaceWith(`<p class="text">${text.val()}</p>`)
                        msg.text('')
                        btn.text('Edit').toggle()
                        $(".post-edit-btn").toggle()
                        $(".post-delete-btn").toggle()
                        bool = !bool
                    } else {
                        msg.text(response.error)
                    }
                }
            });
            break
    }
}
function destroyPost () {
    let id = $(this).parent().parent().attr('id')
    if (confirm("Delete post?")) {
        $.ajax({
            url: `/post/${id}`,
            type: 'DELETE',
            dataType: 'json',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response){
                if (response.success) {
                    $(`#${id}`).remove()
                }
            }
        });
    }
}
