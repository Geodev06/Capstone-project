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

@else
<p class="text-center">No images provided.</p>
@endif