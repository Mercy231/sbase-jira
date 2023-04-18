@extends('components/layout')

@section('title')
    Autoria
@endsection

@section('body')
    <div class="filter">
        <div>
            <h3>Тип</h3>
            <select id="car-type">
                <option value="1" selected>Легкові</option>
                <option value="2">Мото</option>
                <option value="6">Вантажівки</option>
            </select>
        </div>
        <div>
            <h3>Марка</h3>
            <select id="brand">
                <option value="0">Будь-яка</option>
                <option value="9">BMW</option>
                <option value="6">Audi</option>
                <option value="24">Ford</option>
                <option value="28">Honda</option>
            </select>
        </div>
        <div id="year">
            <h3>Рік випуску </h3>
            <label for="year-from">Від:</label>
            <select id="year-from">
                <option value="0" selected>Будь-який</option>
                <option value="2010">2010</option>
                <option value="2011">2011</option>
                <option value="2012">2012</option>
                <option value="2013">2013</option>
                <option value="2014">2014</option>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
            </select>
            <br>
            <label for="year-to">До:</label>
            <select id="year-to">
                <option value="0" selected>Будь-який</option>
                <option value="2010">2010</option>
                <option value="2011">2011</option>
                <option value="2012">2012</option>
                <option value="2013">2013</option>
                <option value="2014">2014</option>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
            </select>
        </div>
        <div id="price">
            <h3>Ціна $</h3>
            <label for="price-from">Від:</label>
            <input id="price-from" type="number">
            <br>
            <label for="price-to">До:</label>
            <input id="price-to" type="number">
        </div>
        <button id="submit" type="button">Пошук</button>
    </div>
    <div id="cars">
        @include('components.cars')
    </div>
@endsection
