@extends('components/layout')

@section('title')
    Home with layout
@endsection

@section('body')
    @if(Auth::user())
        <h1>Welcome, {{ Auth::user()->email }}! <a href="/logout">Log out</a></h1>
    @else
        <h1><a href="/login">Login</a> | <a href="/register">Register</a></h1>
    @endif
@endsection
