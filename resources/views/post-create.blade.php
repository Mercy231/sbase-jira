@extends('components/layout')

@section('title')
    Create post
@endsection

@section('body')
    <h1>Create new post</h1>
    <form method="post" action="/post-create">
        @csrf
        <div>
            <label for="title">Title: </label>
            <input name="title" type="text">
        </div>
        <textarea name="text"></textarea>
        <button>Create</button>
    </form>
    @if($errors)
        {{ $errors->first() }}
    @endif
@endsection
