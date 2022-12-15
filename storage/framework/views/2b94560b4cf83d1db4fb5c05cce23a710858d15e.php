


<?php $__env->startSection('entrance'); ?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

<?php if(Session::has('success')): ?> <script>
    $(document).ready(function() {
        Swal.fire(
            'Success',
            "<?php echo e(Session::get('success')); ?>",
            'success'
        )
    })
</script>
<?php endif; ?>
<div class="row p-5" style="height: 100vh; background-color: #f2f2f2;">
    <?php if($errors->any()): ?>
    <div class="alert-container mb-3">
        <div class="alert-header">
        </div>
        <div class="alert-body">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $errors): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($errors); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
    <?php endif; ?>
    <div class="col-md-12">
        <h1 class="fw-bold py-2">Pay entrance for 120.00</h1>
        <form action="<?php echo e(route('user.entrance.pay')); ?>" method="POST">
            <div class="d-flex justify-content-between align-items-center">
                <?php echo csrf_field(); ?>
                <div>
                    <input type="hidden" id="amount" name="amount" value="120.00" />
                    <label for="" class="form-label text-muted">Target date</label>
                    <div class="input-group">
                        <input id="date" type="date" value="<?php echo e(old('date')); ?>" name="date" autocomplete="off" class="form-control" />
                    </div>
                    <div class="input-group mt-2">
                        <input type="number" id="no_of_person" value="<?php echo e(old('no_of_person')); ?>" placeholder="No. of person" name="no_of_person" autocomplete="off" class="form-control" />
                    </div>
                </div>
                <div>
                    <button class="btn btn-sm btn-danger" type="submit">Pay with paypal</button>
                    <?php if(count($gcash_content) > 0 ): ?>
                    <button class="btn btn-sm btn-primary" id="btn-gcash" type="button">Pay with gcash</button>
                    <?php endif; ?>
                </div>
            </div>
        </form>
        <div class="mb-3 mt-3">
            <h6 class="text-muted">Your entrance</h6 class="text-muted">
        </div>
        <table id="table-entrance" class="display nowrap w-100 table-striped">
            <thead>
                <tr style=" height: 10px;">
                    <th>Payment id</th>
                    <th>Payer email</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<?php if(count($gcash_content) > 0 ): ?>
<!-- gcash-modal -->
<div class="modal fade" id="gcash-modal" tabindex="-1" aria-labelledby="modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 p-5">
                            <h4>Pay with gcash</h4>
                            <h6>Amount to pay: <span id="to-pay" class="fw-bold"></span></h6>
                            <h6>Target date : <span id="t-date"></span></h6>
                            <p>After paying to the reference no. please be patient to wait until the admin approve your payment.</p>
                            <p id="text-error" class="mt-4 text-danger"></p>
                        </div>
                        <div class="col-sm-6">
                            <img src="<?php echo e(asset($gcash_content[0]->image)); ?>" alt="gcash." height="400px" width="100%">
                            <button type="button" class="btn btn-primary mt-4" id="btn-proceed">Proceed</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<!-- Entrance payment -->
<div class="modal fade" id="info-modal" tabindex="-1" aria-labelledby="modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="p-2">
                                <h3>Payment details</h3>
                            </div>
                            <div class="row">
                                <div class="col-md-12 bg-light p-2 mb-2">
                                    <h6 class="text-muted">Payment id</h6>
                                    <span id="p-id" class="fw-bold"></span>
                                </div>
                                <div class="col-md-12 bg-light p-2 mb-2">
                                    <h6 class="text-muted">Paymer Email</h6>
                                    <span id="p-email" class="fw-bold"></span>
                                </div>
                                <div class="col-md-6 bg-light p-2 mb-2">
                                    <h6 class="text-muted">Amount</h6>
                                    <span id="p-amount" class="fw-bold"></span>
                                </div>
                                <div class="col-md-6 bg-light p-2 mb-2">
                                    <h6 class="text-muted">Status</h6>
                                    <span id="p-status" class="fw-bold text-success text-uppercase"></span>
                                </div>

                                <div class="col-md-12 bg-light p-2 mb-2">
                                    <h6 class="text-muted">Date of payment</h6>
                                    <span id="p-date" class="fw-bold"></span>
                                </div>

                                <div class="col-md-12 bg-light p-2 mb-2">
                                    <h6 class="text-muted">Only valid on</h6>
                                    <span id="p-tdate" class="fw-bold"></span>
                                </div>

                                <div class="col-md-12 bg-light p-2 mb-2">
                                    <h6 class="fw-bold">Validity</h6>
                                    <span id="p-validity" class="fw-bold text-primary"></span>
                                </div>

                                <div class="col-md-12">
                                    <button id="btn-receipt" class="btn btn-sm btn-primary">View receipt</button>
                                    <button id="btn-refund" class="btn btn-sm btn-danger">Call for refund</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End modal -->
<script>
    $(function() {

        function Alertmsg(header, msg, type) {
            Swal.fire(
                header,
                msg,
                type
            )
        }

        var table = $('#table-entrance').DataTable({
            responsive: true,
            'lengthMenu': [
                [10, 20, 35, 50, 60, -1],
                [10, 20, 35, 50, 60, 'All'],
            ],
            'order': [
                [0, 'desc']
            ]
        })


        function load_data() {

            return $.ajax({
                url: "<?php echo e(route('user.entrance.get')); ?>",
                type: 'get',
                dataType: 'json',
                beforeSend: function() {}
            }).done(function(data) {

                table.clear().draw()

                for (let i = 0; i < data.entrance.length; i++) {
                    var button = '<button data-date="' + data.entrance[i].date + '" data-status="' + data.entrance[i].payment_status + '" data-user_id="<?php echo e($userdata->id); ?>" data-amount="' + data.entrance[i].amount + '" data-payment_id="' + data.entrance[i].payment_id + '" data-payer_email="' + data.entrance[i].payer_email + '" class="btn btn-sm btn-dark btn-more">More</button>'
                    table.row.add([data.entrance[i].payment_id, data.entrance[i].payer_email, '\u20b1' + parseFloat(data.entrance[i].amount).toFixed(2), data.entrance[i].payment_status, button]).draw()
                }
            }).fail(function(e) {
                Alertmsg('Load failed', 'Error in fetching data', 'error')
            })
        }

        load_data()

        $('#table-entrance tbody').on('click', 'tr td .btn-more', function() {

            var route = "<?php echo e(route('user.entrance.getdetails',':payment_id')); ?>";


            $.ajax({
                url: route.replace(':payment_id', $(this)[0].dataset.payment_id),
                type: 'get',
                dataType: 'json',
                beforeSend: function() {
                    $('#p-tdate').text('Loading...')
                }
            }).done(function(data) {
                console.log(data)
                $('#p-tdate').text(data.details[0].target_date)
                $('#p-validity').text(data.details[0].status)
                $('#btn-refund').attr('data-status', data.details[0].status)
            }).fail(function(e) {
                Alertmsg('Load failed', 'Error in fetching data', 'error')
            })

            $('#btn-receipt').attr('data-id', $(this)[0].dataset.payment_id)
            $('#btn-refund').attr('data-id', $(this)[0].dataset.payment_id)


            $('#p-id').text($(this)[0].dataset.payment_id)
            $('#p-email').text($(this)[0].dataset.payer_email)
            $('#p-status').text($(this)[0].dataset.status)
            $('#p-date').text($(this)[0].dataset.date)
            $('#p-amount').text('\u20b1' + parseFloat($(this)[0].dataset.amount).toFixed(2))
            $('#info-modal').modal('toggle')
        })

        $('#btn-receipt').on('click', function() {
            var link = "<?php echo e(route('entrance.receipt',':id')); ?>"
            window.open(link.replace(':id', $(this)[0].dataset.id))
        })

        $('#btn-refund').click(function() {

            if ($(this)[0].dataset.status == 'to-approve') {
                Swal.fire({
                    type: 'question',
                    title: 'Are you sure?',
                    text: ' Do you want to cancel this entrance reservation? this process will take time until the administrator approve. we will send you further notification about the refund.',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm'
                }).then((result) => {
                    if (result.value) {
                        var route = "<?php echo e(route('request.refund',':id')); ?>"
                        return $.ajax({
                            url: route.replace(':id', $(this)[0].dataset.id),
                            type: 'get',
                            dataType: 'json',
                            beforeSend: function() {}
                        }).done(function(data) {

                            load_data()
                            Alertmsg('Success', 'Your request has been sent', 'success')
                        }).fail(function(e) {
                            Alertmsg('Load failed', 'Error in fetching data', 'error')
                        })
                    }
                })
            } else {

                Alertmsg('Cannot be done', 'This entrance ticket has been used or invalid validity', 'error')
            }
        })

        $('#btn-gcash').on('click', function() {
            $('#to-pay').text($('#plan_field').val())
            $('#t-date').text($('#date').val())
            $('#text-error').text('')
            $('#gcash-modal').modal('show')
        })

        $('#btn-proceed').on('click', function() {
            if ($('#date').val() != '') {

                if ($('#no_of_person').val() != '') {

                    var amount_ = parseFloat($('#amount').val()) * parseFloat($('#no_of_person').val())
                    var target_date_ = $('#date').val()
                    var data = {
                        _token: "<?php echo e(csrf_token()); ?>",
                        type: 'entrance',
                        amount: amount_,
                        target_date: target_date_,
                        room_no: "0",
                        plan: '',
                        hour: '',
                        no_of_person: $('#no_of_person').val()

                    }
                    $.ajax({
                        url: "<?php echo e(route('pay.gcash')); ?>",
                        type: 'post',
                        data: data,
                        dataType: 'json',
                        beforeSend: function() {}
                    }).done(function(data) {
                        if (data.status == 200) {
                            Swal.fire(
                                'Ok',
                                'Payment success',
                                'success'
                            )
                            window.location.replace("<?php echo e(route('user.entrance')); ?>")
                        }
                    }).fail(function(e) {

                    })
                } else {
                    $('#text-error').text('Please enter the no of person.')
                }
            } else {
                $('#text-error').text('please choose a target date for your booking')
            }

        })

    })
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\sarah\Desktop\tanawsystem\tanaw-deploy\tanawsystem\resources\views/user/entrance.blade.php ENDPATH**/ ?>