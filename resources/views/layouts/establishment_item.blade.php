@foreach($est as $item)
<div class="establishment-item p-3 bg-white mb-2 card">
    <h6>{{$item->establishment_name}}</h6>
    <div class="d-flex justify-content-between align-items-center">
        <p style="margin: 0;">{{$item->establishment_address}}</p>
        <button class="btn btn-sm btn-primary btn-est" data-id="{{$item->id}}" data-lat="{{ $item->lat}}" data-lon="{{ $item->long}}">Info</button>
    </div>
</div>
@endforeach