<div id="{{ $post->id }}" class="post">
    <div class="header">
        <h3>{{ $post->user->email }}</h3>
        <h2 id="title">{{ $post->title }}</h2>
    </div>
    <div class="middle">
        <p id="text">{{ $post->text }}</p>
    </div>
    <div class="footer">
        @if($post->user_id == Auth::user()->id)
            <button id="btn-edit">Edit</button>
            <button id="btn-delete">Delete</button>
        @endif
        <p id="error"></p>
        <hr>
            <div id="comment-create">
                <h4>Create new comment</h4>
                <textarea id="comment-text" name="text"></textarea>
                <button id="btn-create" type="submit">Create</button>
                <h5 id="msg"></h5>
            </div>
        <div id="comments">
            @foreach($post->comment as $comment)
                @include('components.comment')
            @endforeach
        </div>
    </div>
</div>

<script>
    let bool{{$post->id}} = true
    $("#{{ $post->id }} #btn-edit").click(function () {
        switch(bool{{$post->id}}) {
            case true:
                $("#{{ $post->id }} #btn-edit").text('Save')
                $("#{{ $post->id }} #btn-edit").prop('id', 'btn-save')
                $("#{{$post->id}} #title")
                    .replaceWith(`<input id="title" type='text' value="${$("#{{$post->id}} #title").text()}">`)
                $("#{{ $post->id }} #text")
                    .replaceWith(`<textarea id="text">${$("#{{ $post->id }} #text").text()}</textarea>`)
                bool{{$post->id}} = false
                break
            case false:
                $.ajax({
                    url: '/post/{{ $post->id }}',
                    type: 'PATCH',
                    dataType: 'json',
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        title: $("#{{$post->id}} #title").val(),
                        text: $("#{{$post->id}} #text").val(),
                    },
                    success: function(response){
                        if (response.success) {
                            $("#{{$post->id}} #title")
                                .replaceWith(`<h2 id="title">${$("#{{$post->id}} #title").val()}</h2>`)
                            $("#{{ $post->id }} #text")
                                .replaceWith(`<p id="text">${$("#{{$post->id}} #text").val()}</p>`)
                            $("#{{ $post->id }} #btn-save").text('Edit')
                            $("#{{ $post->id }} #btn-save").prop('id', 'btn-edit')
                            $("#{{ $post->id }} #error").text('')
                            bool{{$post->id}} = true
                        } else {
                            $("#{{ $post->id }} #error").text(response.error)
                        }
                    }
                });
                break
        }
    })

    $("#{{ $post->id }} #btn-delete").click(function () {
        $.ajax({
            url: '/post/{{ $post->id }}',
            type: 'DELETE',
            dataType: 'json',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response){
                if (response.success) {
                    $("#{{ $post->id }}").remove()
                }
            }
        });
    })

    $("#{{ $post->id }} #comment-create #btn-create ").click(function () {
        $.ajax({
            url: '/comment/create',
            type: 'POST',
            dataType: 'json',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                text: $("#{{ $post->id }} #comment-create #comment-text").val(),
                id: {{ $post->id }},
            },
            success: function(response){
                if (!response.success) {
                    $(" #{{ $post->id }} #comment-create #msg").text(response.error)
                } else {
                    $("#{{ $post->id }} #comment-create  #msg").text('Created successfully')
                    $("#{{ $post->id }} #comment-create #comment-text").val('')
                    $("#{{ $post->id }} #comments").prepend(response.html)
                }
            }
        });
    });
</script>
