@extends('components/layout')

@section('title')
    Posts
@endsection

@section('body')
    <div>
        <h1>{{ __('messages.title') }}</h1>
        <h3><a href="/home">{{ __('messages.home_link') }}</a></h3>
    </div>
    <div id="post-create">
        <h1>{{ __("messages.create_post_title") }}</h1>
        <div>
            <label for="title">{{ __('messages.title') }}: </label>
            <input id="post-create-title" name="title" type="text">
            <input id="post-create-title-ru" name="title" type="text" hidden>
            <select id="post-create-lang">
                <option value="ru" @if(session()->get('locale') == 'ru') selected @endif>{{ __('messages.russian') }}</option>
                <option value="en" @if(session()->get('locale') == 'en') selected @endif>{{ __('messages.english') }}</option>
            </select>
        </div>
        <textarea id="post-create-text" name="text"></textarea>
        <textarea id="post-create-text-ru" name="text" hidden></textarea>
        <button class="post-create-btn" type="submit">{{ __('messages.create') }}</button>
        <h5 id="post-create-msg"></h5>
    </div>
    <div id="posts">
        @foreach($posts as $post)
            @include('components.post')
        @endforeach
    </div>
@endsection
