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
            <canvas id="pieChart"></canvas>
        </div>
        <div>
            <canvas id="barChart"></canvas>
        </div>
    </div>
@endsection
