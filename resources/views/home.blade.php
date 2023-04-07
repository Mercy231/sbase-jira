@extends('components/layout')

@section('title')
    Home with layout
@endsection

@section('body')
    @if(Auth::user())
        <h1>Welcome, {{ Auth::user()->email }}! <a href="/logout">Log out</a></h1>
        @if(Auth::user()->email_verified_at)
            <p>Your email verified!</p>
        @else
            <p>Your email is not verified!</p>
            <a href="/email/verification-notification">Verification mail resend</a>
        @endif
    @else
        <h1><a href="/login">Login</a> | <a href="/register">Register</a></h1>
    @endif
@endsection
