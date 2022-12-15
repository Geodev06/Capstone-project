

<?php $__env->startSection('messages'); ?>
<style>
    .message-container {

        height: 400px;
        overflow-y: scroll;
    }

    .admin-message {

        height: auto;
        width: 400px;
        background-color: dodgerblue;
        border-radius: 10px;
    }

    .message-text {
        font-size: 12px;
        padding: 8px;
        color: white;
    }

    .admin {
        font-weight: bold;
        padding-left: 10px;
        color: white;
    }

    .user-message {
        height: auto;
        max-width: 400px;
        background-color: seagreen;
        border-radius: 10px;
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
</style>
<div class="row p-5">
    <h2>Send us a message</h2>
    <p>Feel free to send us a message if you have questions. regarding to our services.</p>
    <div class="col-lg-7">
        <div class="message-container row p-3" id="msg-container">
            <!-- message goes here -->
        </div>
        <div class="d-flex align-items-center">
            <input type="text" name="message" id="message" class="message-field" placeholder="Send message here" />
            <div class="button-container d-flex justify-content-center align-items-center" id="btn-send">
                <i class="bx bx-send"></i>
            </div>
        </div>
    </div>
</div>
<script>
    function loadMessage() {

        $.ajax({
            url: "<?php echo e(route('user.messages.get')); ?>",
            type: 'get',
            dataType: 'json',
            beforeSend: function() {}
        }).done(function(data) {

            $('#msg-container').html(data.content)
            $('#msg-container').scrollTop($('#msg-container')[0].scrollHeight)
        }).fail(function(e) {
            Swal.fire(
                'Loading error',
                'Error in loading message. please try again.',
                'error'
            )
        })
    }
    loadMessage()
    $(document).ready(function() {

        $('#btn-send').on('click', function(e) {
            e.preventDefault()
            if ($('#message').val() === '') {

                Swal.fire(
                    'Notice',
                    "Cannot send an empty message.",
                    'info'
                )
            }
            $.ajax({
                url: "<?php echo e(route('user.message.store')); ?>",
                type: 'post',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
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
                        loadMessage()
                    }
                },
                error: function(e) {
                    Swal.fire(
                        'Message failed',
                        'message not sent, something went wrong please try again.',
                        'error'
                    )
                }
            });
        })
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\tanawsystem\resources\views/user/messages.blade.php ENDPATH**/ ?>