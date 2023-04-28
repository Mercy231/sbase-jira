@extends('components.layout')

@section('title')
    Weather
@endsection

@section('body')
    <div>
        <div>
            <label>
                Country:
                <input id="weatherCountry" type="text">
            </label>
            <label>
                City:
                <input id="weatherCity" type="text">
            </label>
        </div>
        <div id="dateWeather">
            <label>From:
                <input id="weatherDateFrom" type="date">
            </label>
            <label>To:
                <input id="weatherDateTo" type="date">
            </label>
            <button id="getWeather">Get weather</button>
        </div>
        <div>
            <h5 id="error"></h5>
        </div>
        <div id="weather">
        </div>
    </div>
@endsection
