@extends('components/layout')

@section('title')
    Register
@endsection

@section('body')
    <h1>Register</h1>
    <a href="/login">Login</a>
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
            <label for="password_confirmation">Confirm password:</label>
            <input name="password_confirmation" type="password">
        </div>
        <div>
            <button type="submit">Register</button>
        </div>
    </form>
    {{ $error }}
    @endsection
