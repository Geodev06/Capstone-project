@extends('admin.dashboard')

@section('message')
<style>
    .avatar-container {
        height: 40px;
        width: 40px;
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: dodgerblue;
        color: white;
    }

    .message-container {
        min-height: 70vh;
        height: 70vh;
        overflow-y: scroll;
        width: 100%;
    }

    .message-field {
        width: 100%;
        height: 40px;
        padding: 12px 12px;
        border: 0;
        outline: none;
        background-color: aliceblue;
    }

    .button-container {
        background-color: dodgerblue;
        width: 60px;
        color: white;
        height: 40px;
        cursor: pointer;
    }

    .button-container:hover {
        transition: .3s all;
        background-color: highlight;
    }

    .user-message {
        max-width: 400px;
        background-color: dodgerblue;
        padding: 10px;
        border-radius: 8px;
    }

    .my-message {
        min-width: 300px;
        max-width: 400px;
        background-color: seagreen;
        padding: 10px;
        border-radius: 8px;
    }

    .user-card {
        background-color: white;
    }

    .user-card:hover {
        background-color: gainsboro;
    }

    .has_unread {
        background-color: gainsboro;
    }
</style>
<div class="row">
    <div class="col-md-5 col-lg-3 shadow-sm" style="height: 80vh; overflow-y:scroll">
        <h6 class="p-3 fw-bold">Messages <p class="fw-light">You have {{$unread_msg}} unread messages</p>
        </h6>

        <hr>
        <div class="d-flex justify-content-between mb-2">
            <!-- <button class="btn btn-link btn-sm">See all</button> -->
            <div class="d-flex align-items-center">
                <i class="bx bx-search"></i>
                <input type="text" placeholder="search" id="filter">
            </div>
        </div>
        <div class="row" id="msg_section2">
            @for($i = 0; $i< count($user_data); $i++) <div class="col-lg-12 mb-2 user-div user_chat" style="cursor: pointer;" data-name="{{strtolower($user_data[$i]['user']->sender_name)}}" data-message_id="{{$user_data[$i]['user']->message_id}}">
                <div class="user-card p-3 d-flex align-items-center {{ $user_data[$i]['user']->has_unread? 'has_unread':'' }} ">
                    <div class="avatar-container m-3">
                        <span class="m-3 avatar">A</span>
                    </div>
                    <div class="d-flex flex-column">
                        <span class="fw-bold" style="font-size: 14px;"> {{$user_data[$i]['user']->sender_email}}</span>
                        <span class="fw-light text-muted" style="font-size: 12px;"> {{$user_data[$i]['user']->sender_name}}</span>
                    </div>
                    @if($user_data[$i]['unread'] > 0)
                    <div>
                        <span class="badge bg-danger m-2">{{$user_data[$i]['unread']}}</span>
                    </div>
                    @endif
                </div>
        </div>
        @endfor
    </div>
</div>
<div class="col-md-7 col-lg-9">

    <!-- <div style="display: none;" class="d-flex justify-content-center align-items-center h-100" id="default-container">
            <p>Please select a user to view their message.</p>
        </div> -->

    <div>
        <p class="my-auto" id="loader">Please select a receipient.</p>
        <div class="message-container row p-3 mt-2" id="message-container">

            <!-- message goes here -->


        </div>

        <div class="d-flex align-items-center">
            <input type="text" autocomplete="off" name="message" id="message" class="message-field" placeholder="Send message here" />
            <div class="button-container d-flex justify-content-center align-items-center" id="btn-send">
                <i class="bx bx-send"></i>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    function loadMessage(msg_id) {


        var route = "{{ route('admin.messages.get',':id') }}";
        $.ajax({
            url: route.replace(':id', msg_id),
            type: 'get',
            dataType: 'json',
            beforeSend: function() {
                $('#loader').css('display', 'block')
                $('#loader').text('Loading...')
            }
        }).done(function(data) {

            $('#message-container').html(data.content)
            $('#message-container').scrollTop($('#message-container')[0].scrollHeight)
            $('#loader').css('display', 'none')
            $('#loader').text('')
        }).fail(function(e) {
            Swal.fire(
                'Loading error',
                'Error in loading message. please try again.',
                'error'
            )
        })
    }

    function filter(value) {
        var regex = new RegExp('\\b\\w*' + value + '\\w*\\b')
        $('.user_chat').hide().filter(function() {
            return regex.test($(this).data('name'))
        }).show()
    }

    $(document).ready(function() {


        $('#msg_section').on('click', '.user-div', function(e) {
            loadMessage($(this)[0].dataset.message_id)
            $('#btn-send').attr('data-id', $(this)[0].dataset.message_id)
        })

        $('#msg_section2').on('click', '.user-div', function(e) {
            loadMessage($(this)[0].dataset.message_id)
            $('#btn-send').attr('data-id', $(this)[0].dataset.message_id)
        })


        $('#filter').keyup(function() {
            var value = $(this).val();
            filter(value.toLowerCase())
        })
        $('#btn-send').on('click', function(e) {
            e.preventDefault()

            if ($(this)[0].dataset.id === undefined) {
                Swal.fire(
                    'Notice',
                    "No selected recepient.",
                    'info'
                )
            } else {

                if ($('#message').val() === '') {

                    Swal.fire(
                        'Notice',
                        "Cannot send an empty message.",
                        'info'
                    )
                }
                var route = "{{ route('admin.message.store',':id') }}"

                var msg_id = $(this)[0].dataset.id

                $.ajax({
                    url: route.replace(':id', $(this)[0].dataset.id),
                    type: 'post',
                    data: {
                        _token: '{{ csrf_token() }}',
                        message: $('#message').val()
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $('#message').attr('disabled')
                    },
                    success: function(data) {
                        $('#message').removeAttr('disabled')

                        if (data.status === 200) {
                            $('#message').val('')
                            Swal.fire(
                                'Success',
                                data.msg,
                                'success'
                            )

                            loadMessage(msg_id)
                        }
                    },
                    error: function(e) {

                    }
                });
            }

        })
    })
</script>
@endsection