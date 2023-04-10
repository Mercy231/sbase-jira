@extends('components/layout')

@section('title')
    Create comment
@endsection

@section('body')
    <h1>Create new comment</h1>
    <form method="post" action="/comment-create/{{ $id }}">
        @csrf
        <textarea name="text"></textarea>
        <button>Create</button>
    </form>
    @if($errors)
        {{ $errors->first() }}
    @endif
@endsection
