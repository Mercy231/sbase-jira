@foreach($data as $item)
    <div class="car-item">
        <div class="image">
            <a href="{{ $item['link'] }}">
                <img src="{{ $item['image'] }}" height="200px">
            </a>
        </div>
        <div class="info">
            <h3>{{ $item['name'] }}</h3>
            <div>
                <h2>$ {{ $item['priceUSD'] }}</h2>
                <h2>{{ $item['priceUAH'] }} грн</h2>
            </div>
            <h5>Mileage: {{ $item['mileage'] }}</h5>
            <h5>Location: {{ $item['location'] }}</h5>
            <h5>Fuel type: {{ $item['fuelType'] }}</h5>
            <h5>Transmission type: {{ $item['transmissionType'] }}</h5>
            <h5>Color: {{ $item['color'] }}</h5>
        </div>
    </div>
@endforeach
