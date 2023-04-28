@extends('components/layout')

@section('title')
    Login
@endsection

@section('body')
    <h1>Login</h1>
    <a href="/register">Register</a>
    <a href="/home">Home</a>
    <form method="post" action="">
        @csrf
        <div>
            <label for="email">Email:</label>
            <input name="email" type="email">
        </div>
        <div>
            <label for="password">Password:</label>
            <input name="password" type="password">
        </div>
        <div>
            <button type="submit">Login</button>
        </div>
    </form>
    {{ $error }}
    <hr>
    <div>
        <a href="{{ url('/auth/twitter/redirect') }}">Login with twitter</a>
    </div>
@endsection
