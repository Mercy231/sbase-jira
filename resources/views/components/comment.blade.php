<div id="{{ $comment->id }}" class="comment">
    <div>
        <h4>{{ $comment->user->email }}</h4>
    </div>
    <div>
        <p id="text">{{ $comment->text }}</p>
    </div>
    <p id="error"></p>
    @if($comment->user_id == Auth::user()->id)
        <div class="comment-footer">
            <div>
                <button id="btn-comment-edit">Edit</button>
            </div>
            <br>
            <div>
                <button id="btn-comment-delete">Delete</button>
            </div>
        </div>
    @endif
</div>

<script>
    let comment{{$comment->id}} = true
    $("#{{ $comment->id }} #btn-comment-edit").click(function () {
        switch(comment{{$comment->id}}) {
            case true:
                $("#{{ $comment->id }} #btn-comment-edit").text('Save')
                $("#{{ $comment->id }} #btn-comment-edit").prop('id', 'btn-comment-save')
                $("#{{ $comment->id }} #text")
                    .replaceWith(`<textarea id="text">${$("#{{ $comment->id }} #text").text()}</textarea>`)
                comment{{$comment->id}} = false
                break
            case false:
                $.ajax({
                    url: '/comment/{{ $comment->id }}',
                    type: 'PATCH',
                    dataType: 'json',
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        text: $("#{{ $comment->id }} #text").val(),
                    },
                    success: function(response){
                        if (response.success) {
                            $("#{{ $comment->id }} #text")
                                .replaceWith(`<p id="text">${$("#{{$comment->id}} #text").val()}</p>`)
                            $("#{{ $comment->id }} #btn-comment-save").text('Edit')
                            $("#{{ $comment->id }} #btn-comment-save").prop('id', 'btn-comment-edit')
                            $("#{{ $comment->id }} #error").text('')
                            comment{{ $comment->id }} = true
                        } else {
                            $("#{{ $comment->id }} #error").text(response.error)
                        }
                    }
                });
                break
        }
    })

    $("#{{ $comment->id }} #btn-comment-delete").click(function () {
        $.ajax({
            url: '/comment/{{ $comment->id }}',
            type: 'DELETE',
            dataType: 'json',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response){
                if (response.success) {
                    $("#{{ $comment->id }}").remove()
                }
            }
        });
    })
</script>
