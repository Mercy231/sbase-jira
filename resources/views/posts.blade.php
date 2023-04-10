@extends('components/layout')

@section('title')
    Posts
@endsection

@section('body')
    <h1>Posts page</h1>
    <h3><a href="/home">Home</a></h3>
    <a href="/post-create">New post</a>
    <div>
        @foreach($posts as $post)
            <div id="{{ $post->id }}" class="post">
                <div>
                    <h3>{{ $post->user->email }}</h3>
                </div>
                <div>
                    <h1>{{ $post->title }}</h1>
                </div>
                <div>
                    <p>{{ $post->text }}</p>
                </div>
                @if($post->user_id == Auth::user()->id)
                    <div>
                        <a href="/post-edit/{{ $post->id }}">EDIT</a>
                    </div>
                    <br>
                    <div>
                        <a href="/post-delete/{{ $post->id }}">DELETE</a>
                    </div>
                @endif
                <hr>
                <div>
                    <a href="/comment-create/{{ $post->id }}">Create comment</a>
                </div>
                <div class="comments">
                    @foreach($post->comment as $comment)
                        <div id="{{ $comment->id }}" class="comment">
                            <div>
                                <h4>{{ $comment->user->email }}</h4>
                            </div>
                            <div>
                                <p>{{ $comment->text }}</p>
                            </div>
                            @if($comment->user_id == Auth::user()->id)
                                <div class="comment-footer">
                                    <div>
                                        <a href="/comment-edit/{{ $comment->id }}">EDIT</a>
                                    </div>
                                    <br>
                                    <div>
                                        <a href="/comment-delete/{{ $comment->id }}">DELETE</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection
