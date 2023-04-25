@extends('components.layout')

@section('title')
    Admin STATS
@endsection

@section('body')
    <div>
        <button id="getStats">Get stats</button>
    </div>
    <div class="stats">
        <div>
            <div>
                <label>From: </label>
                <input id="dateFrom" type="date" required>
                <label>To: </label>
                <input id="dateTo" type="date" required>
            </div>
            <canvas id="pieChart"></canvas>
        </div>
        <div>
            <canvas id="barChart"></canvas>
        </div>
    </div>
@endsection
