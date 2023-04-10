@extends('components/layout')

@section('title')
    Edit post
@endsection

@section('body')
    <h1>Edit post</h1>
    <form method="post" action="/post-edit/{{ $post->id }}">
        @csrf
        <div>
            <label for="title">Title: </label>
            <input name="title" type="text" value="{{ $post->title }}">
        </div>
        <textarea name="text">{{ $post->text }}</textarea>
        <button>Update</button>
    </form>
    @if($errors)
        {{ $errors->first() }}
    @endif
@endsection
