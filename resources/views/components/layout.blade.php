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
    <link rel="stylesheet" href="./public/css/style.css">
</head>
<body>
    <div class="header">
        <select name="lang" id="lang">
            <option value="ru" @if(session()->get('locale') == 'ru') selected @endif>{{ __('messages.russian') }}</option>
            <option value="en" @if(session()->get('locale') == 'en') selected @endif>{{ __('messages.english') }}</option>
        </select>
    </div>
    @yield('body')
    <script src="./public/js/post.js"></script>
    <script src="./public/js/comment.js"></script>
    <script src="./public/js/autoria.js"></script>
    <script src="./public/js/register.js"></script>
    <script src="./public/js/lang.js"></script>
</body>
</html>
