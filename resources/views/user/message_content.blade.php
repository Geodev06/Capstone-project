@foreach($message as $msg)
@if($msg->sender_type === 'admin')
<div class="col-lg-12">
    <div class="admin-message mb-2">
        <div class="">
            <span class="admin">administrator</span>
            <span class="text-white float-end mx-2" style="font-size: 12px;">{{$msg->created_at->diffForHumans()}}</span>
        </div>
        <p class="message-text">{{$msg->message}}</p>
    </div>
</div>
@endif

@if($msg->sender_type === 'user')
<div class="col-lg-12 ">

    <div class="float-end">
        <span style="font-size: 10px; margin:0">{{$msg->created_at->diffForHumans()}}</span>
        <div class="user-message">
            <div class="">
                <span class="admin">Me</span>
                <span class="text-white float-end mx-2 d-flex flex-column" style="font-size: 12px;"> <span style="font-size: 9px;">{{$msg->created_at->format('M d, Y h:i:A')}}</span> </span>
            </div>
            <p class="message-text">{{$msg->message}}</p>
        </div>

    </div>
</div>

@endif
@endforeach