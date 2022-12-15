@extends('user.dashboard')

@section('room_info')
<style>
    .room-detail-card {
        padding: 10px;
    }

    ul {
        list-style: none;
    }

    .btn-check-in {
        outline: none;
        border: none;
        height: auto;
        padding: 8px;
        background-color: rgba(0, 0, 0, 0.80);
        color: springgreen;
        text-align: center;
        border-radius: 8px;
        cursor: pointer;
    }

    .btn-check-in:hover {
        transition: all .3s;
        color: springgreen;
        background-color: rgba(0, 0, 0, 1);
    }

    img {
        max-height: 400px;
    }
</style>
<div class="row p-5">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="fw-bold">Room details</h1>
        <a class="btn-back" href="{{ route('user.dashboard') }}">Go back</a>
    </div>
    <div class="col-md-12 col-lg-4">
        <div class="room-detail-card d-flex flex-column">
            <h6>Room no. {{ $rooms[0]->room_no}}</h6>
            <ul>
                <li><i class="bx bx-check"></i> Now Available</li>
                <li><i class="bx bx-check"></i> {{ $rooms[0]->min.'-'.$rooms[0]->max }} persons.</li>
            </ul>
            <h6>Prices</h6>
            <ul>

                @if(count($prices) > 0)
                @foreach($prices as $prc)
                <li><i class="bx bx-check"></i> &#8369 {{ $prc->price }} for {{ $prc->hour }} Hours</li>
                @endforeach
                @endif
            </ul>
            <button class="btn-check-in" id="btn-check-in"> Check in</button>

            <script>
                $(function() {
                    $('#btn-check-in').on('click', function() {
                        window.location.replace("{{ route('user.checkinform',$rooms[0]->room_no) }}")
                    })
                })
            </script>
        </div>
    </div>
    <div class="col-md-12 col-lg-8 mt-4">
        @if(count($images)> 0)

        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">

            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 0"></button>
                @for($i = 1; $i < count($images); $i++) <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$i}}" aria-label="Slide {{$i}}"></button>
                    @endfor
            </div>
            <div class="carousel-inner">

                <div class="carousel-item active h-100">
                    <img src="{{ asset($images[0]->image)}}" class="d-block w-100" alt="img0">
                </div>
                @for($i = 1; $i < count($images); $i++) <div class="carousel-item h-100">
                    <img src="{{ asset($images[$i]->image)}}" class="d-block w-100" alt="img{{$i}}">
            </div>
            @endfor
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <p style="font-size: 12px;">Room images</p>
    @else
    <p class="text-center">No images provided.</p>
    @endif
</div>
</div>
@endsection