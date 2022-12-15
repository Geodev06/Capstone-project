@if(count($message) > 0)
@foreach($message as $msg)
@if($msg->sender_type === 'user')
<div class="col-lg-12">
    <div class="user-message mb-2">
        <div class="text-white mb-2">
            <span class="fw-bold d-flex">{{ $msg->sender_name}} <i class="bx bx-check-double"></i></span>
            <span class="text-white float-end mx-2" style="font-size: 12px;">{{ $msg->created_at->format('M d, Y h:m:A')}}</span>
        </div>
        <p class="message-text text-white">{{$msg->message}}</p>
    </div>
</div>
@endif

@if($msg->sender_type === 'admin')
<div class="col-lg-12">
    <div class="my-message mb-2 float-end">
        <div class="text-white mb-2">
            <span class="fw-bold d-flex">Me <i class="bx bx-check-double"></i></span>
            <span class="text-white float-end mx-2" style="font-size: 12px;">{{ $msg->created_at->format('M d, Y h:m:A')}}</span>
        </div>
        <p class="message-text text-white">{{$msg->message}}</p>
    </div>
</div>
@endif
@endforeach
@endif