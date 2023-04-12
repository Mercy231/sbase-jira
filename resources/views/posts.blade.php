@extends('components/layout')

@section('title')
    Posts
@endsection

@section('body')
    <div>
        <h1>Posts page</h1>
        <h3><a href="/home">Home</a></h3>
    </div>
    <div id="post-create">
        <h1>Create new post</h1>
        <div>
            <label for="title">Title: </label>
            <input id="post-create-title" name="title" type="text">
        </div>
        <textarea id="post-create-text" name="text"></textarea>
        <button class="post-create-btn" type="submit">Create</button>
        <h5 id="post-create-msg"></h5>
    </div>
    <div id="posts">
        @foreach($posts as $post)
            @include('components.post')
        @endforeach
    </div>
@endsection
