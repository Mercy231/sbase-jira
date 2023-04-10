@extends('components/layout')

@section('title')
    Edit comment
@endsection

@section('body')
    <h1>Edit comment</h1>
    <form method="post" action="/comment-edit/{{ $comment->id }}">
        @csrf
        <textarea name="text">{{ $comment->text }}</textarea>
        <button>Update</button>
    </form>
    @if($errors)
        {{ $errors->first() }}
    @endif
@endsection
