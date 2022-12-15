@foreach($notifications as $notif)
@if($notif->status === 'unread')
<div class="d-flex p-3 justify-content-between mb-3 bg-light">
    <div class="d-flex">
        <p>{{$notif->content}}</p>
        <p>{{ $notif->created_at->diffForHumans()}}</p>
    </div>
    <div class="d-flex align-items-center h-100">
        <button class="btn btn-sm btn-outline-primary m-2 btn-mark-notif" data-id="{{$notif->id}}"><i class="bx bx-check"></i></button>
        <button class="btn btn-sm btn-outline-danger m-2 btn-delete-notif" data-id="{{$notif->id}}"><i class="bx bx-trash"></i></button>
    </div>
</div>
@else
<div class="d-flex p-3 justify-content-between mb-3" style="border: 1px solid gray;">
    <div class="d-flex">
        <p>{{$notif->content}}</p>
        <p>{{ $notif->created_at->diffForHumans()}}</p>
    </div>
    <div class="d-flex align-items-center h-100">
        <button class="btn btn-sm btn-outline-primary m-2 btn-mark-notif" data-id="{{$notif->id}}"><i class="bx bx-check"></i></button>
        <button class="btn btn-sm btn-outline-danger m-2 btn-delete-notif" data-id="{{$notif->id}}"><i class="bx bx-trash"></i></button>
    </div>
</div>
@endif
@endforeach

@if(count($notifications) <= 0) <p>No notifications
    </p>
    @endif