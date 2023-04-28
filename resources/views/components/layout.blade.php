<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>
    <link rel="stylesheet" href="{{ asset('/public/css/style.css') }}">
</head>
<body>
    <div class="header">
        <select name="lang" id="lang">
            <option value="ru" @if(session()->get('locale') == 'ru') selected @endif>{{ __('messages.russian') }}</option>
            <option value="en" @if(session()->get('locale') == 'en') selected @endif>{{ __('messages.english') }}</option>
        </select>
    </div>
    @yield('body')
    <script src="{{ asset('/public/js/post.js') }}"></script>
    <script src="{{ asset('/public/js/comment.js') }}"></script>
    <script src="{{ asset('/public/js/autoria.js') }}"></script>
    <script src="{{ asset('/public/js/register.js') }}"></script>
    <script src="{{ asset('/public/js/lang.js') }}"></script>
    <script src="{{ asset('/public/js/admin/stats.js') }}"></script>
    <script src="{{ asset('/public/js/api/weather.js') }}"></script>
</body>
</html>
