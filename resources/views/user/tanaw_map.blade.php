@extends('user.dashboard')

@section('tanaw')

<div class="row p-5">
    <div class="col-lg-12">
        <h1>TANAW Map</h1>
        @if(count($map_data) > 0)
        <img src="{{asset($map_data[0]->image)}}" alt="tanaw.jpeg" width="100%" height="400px">
        <p class="p-2">{{$map_data[0]->content}}</p>
        @else
        <p>No map provided right now.</p>
        @endif
    </div>
</div>
@endsection