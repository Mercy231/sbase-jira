@foreach($data as $item)
<div>
    <h5>{{ $item["dt_txt"] }}</h5>
    <div>
        <h2>{{ $item["weather"][0]["description"] }}</h2>
    </div>
    <br><hr><br>
</div>
@endforeach
