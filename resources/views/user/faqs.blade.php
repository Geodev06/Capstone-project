@foreach($faqs as $faq)
<div class="card mb-3">
    <div class="card-body">
        <h5 class="fw-bold"><span class="h3 fw-bold">Q:</span> {{$faq->question}}</h5>
        <span class="badge bg-primary">{{$faq->answer}}</span>
    </div>
</div>
@endforeach