

<?php $__env->startSection('messages'); ?>


<!-- Load TensorFlow.js. This is required to use the qna model. -->
<script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"> </script>
<!-- Load the qna model. -->
<script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/qna"> </script>
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

    #faqs_container {
        max-height: 400px;
        overflow-y: scroll;
        padding: 8px;
    }
</style>
<div class="row p-5" style="background-color: #f2f2f2;">
    <h2>Send us a message</h2>
    <p>Feel free to send us a message if you have questions. regarding to our services.</p>
    <div class="col-lg-7 mb-3">
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
    <div class="col-lg-5">
        <div class="d-flex justify-content-between mb-2 align-items-center">
            <h4 class="fw-bold">FAQs as of <span style="font-size: 12px;"><?php echo e(now()->format('M d, Y')); ?></span></h4>
            <button class="btn btn-primary btn-sm" id="btn-chatbot">Try our Chatbot</button>
        </div>
        <div class="d-flex flex-column" id="faqs_container">

        </div>
    </div>
</div>

<!-- chatbot-modal -->
<div class="modal fade" id="chatbot-modal" tabindex="-1" aria-labelledby="modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 p-5">
                            <h3 class="fw-bold">Lets answer your question in no time.</h3>
                            <input type="hidden" id="context">
                            <div class="alert alert-success" id="alert-answer" style="display:none;">
                                <strong>Answer : </strong>
                                <span id="answer"></span>
                            </div>
                            <p style="font-size: 12px;">Laguage question and answering is powered by BERT</p>
                            <div id="answer=container"></div>
                            <input type="text" id="txt_question" class="form-control mb-3" placeholder="question">
                            <button class="btn btn-sm btn-primary" id="btn-getanswer">get answer</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function loadChatbot_context() {
        $.ajax({
            url: "<?php echo e(route('chatbot.getcontext')); ?>",
            type: 'get',
            dataType: 'json',
            beforeSend: function() {}
        }).done(function(data) {
            $('#context').val(data.content.content)

        }).fail(function(e) {
            Swal.fire(
                'Loading error',
                'Error in iniatializing the chatbot. please try again.',
                'error'
            )
        })
    }

    loadChatbot_context()

    // Load the model.
    const getAnswer = async () => {

        model = await qna.load()

        var passage = $('#context').val()

        var question = $('#txt_question').val()
        $('#alert-answer').css('display', 'none')
        $('#answer').text('Loading...')

        model.findAnswers(question, passage).then(answer => {
            $('#alert-answer').css('display', 'block')
            $('#answer').text(answer[0].text)
        })
    }


    $('#btn-getanswer').click(function() {
        getAnswer()
    })

    function loadFaqs() {

        $.ajax({
            url: "<?php echo e(route('getfaqs')); ?>",
            type: 'get',
            dataType: 'json',
            beforeSend: function() {}
        }).done(function(data) {

            $('#faqs_container').html(data.content)

        }).fail(function(e) {
            Swal.fire(
                'Loading error',
                'Error in loading data. please try again.',
                'error'
            )
        })
    }

    loadFaqs()

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

        $('#btn-chatbot').click(function() {
            $('#chatbot-modal').modal('show')
        })

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
<?php echo $__env->make('user.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\sarah\Desktop\tanawsystem\tanaw-deploy\tanawsystem\resources\views/user/messages.blade.php ENDPATH**/ ?>