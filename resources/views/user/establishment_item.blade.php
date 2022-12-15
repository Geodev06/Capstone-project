@foreach($est as $item)
<div class="establishment-item d-flex justify-content-between align-items-center">
    <div>
        <h6>{{ $item->establishment_name}}</h6>
        <p style="font-size:14px">{{ $item->establishment_address}}</p>
        <button class="btn btn-sm btn-primary btn-est" data-id="{{$item->id}}" data-lat="{{ $item->lat}}" data-lon="{{ $item->long}}">More info</button>
    </div>
</div>
@endforeach