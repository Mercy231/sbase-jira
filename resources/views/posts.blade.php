@extends('components/layout')

@section('title')
    Posts
@endsection

@section('body')
    <h1>Posts page</h1>
    <h3><a href="/home">Home</a></h3>
    <div id="post-create">
        <h1>Create new post</h1>
        <div>
            <label for="title">Title: </label>
            <input id="title" name="title" type="text">
        </div>
        <textarea id="text" name="text"></textarea>
        <button id="btn-create" type="submit">NEW POST</button>
        <h5 id="msg"></h5>
    </div>
    <div id="posts">
        @foreach($posts as $post)
{{--            <div id="{{ $post->id }}" class="post">--}}
{{--                <div>--}}
{{--                    <h3>{{ $post->user->email }}</h3>--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    <h1>{{ $post->title }}</h1>--}}
{{--                </div>--}}
{{--                <div>--}}
{{--                    <p>{{ $post->text }}</p>--}}
{{--                </div>--}}
{{--                @if($post->user_id == Auth::user()->id)--}}
{{--                    <div>--}}
{{--                        <button id="edit-{{ $post->id }}">EDIT</button>--}}
{{--                    </div>--}}
{{--                    <br>--}}
{{--                    <div>--}}
{{--                        <button id="delete-{{ $post->id }}">DELETE</button>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--                <hr>--}}
{{--                <div>--}}
{{--                    <a href="/comment-create/{{ $post->id }}">Create comment</a>--}}
{{--                </div>--}}
{{--                <div class="comments">--}}
{{--                    @foreach($post->comment as $comment)--}}
{{--                        <div id="{{ $comment->id }}" class="comment">--}}
{{--                            <div>--}}
{{--                                <h4>{{ $comment->user->email }}</h4>--}}
{{--                            </div>--}}
{{--                            <div>--}}
{{--                                <p>{{ $comment->text }}</p>--}}
{{--                            </div>--}}
{{--                            @if($comment->user_id == Auth::user()->id)--}}
{{--                                <div class="comment-footer">--}}
{{--                                    <div>--}}
{{--                                        <a href="/comment-edit/{{ $comment->id }}">EDIT</a>--}}
{{--                                    </div>--}}
{{--                                    <br>--}}
{{--                                    <div>--}}
{{--                                        <a href="/comment-delete/{{ $comment->id }}">DELETE</a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            </div>--}}
            @include('components.post')
        @endforeach
    </div>
    <script>
        $("#post-create #btn-create ").click(function (e) {
            e.preventDefault()
            $.ajax({
                url: '/post/create',
                type: 'POST',
                dataType: 'json',
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    title: $("#post-create #title").val(),
                    text: $("#post-create #text").val(),
                },
                success: function(response){
                    if (!response.success) {
                        $("#post-create #msg").text(response.error)
                    } else {
                        $("#post-create #msg").text('Created successfully')
                        $("#post-create #title").val('')
                        $("#post-create #text").val('')
                        $("#posts").prepend(response.html)
                    }
                }
            });
        });
    </script>
@endsection
