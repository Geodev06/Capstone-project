

<?php $__env->startSection('check_in_form'); ?>

<style>
    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus,
    input[type="number"]:focus {
        border: 1px solid gray;
        outline: 0 none;
        box-shadow: none;
    }

    label {
        font-size: 12px;
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
    }

    ul {
        list-style: none;
    }

    ul li {
        font-size: 12px;
    }
</style>
<div class="row p-5">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="fw-bold">Check in form.</h1>
        <a class="btn-back" data-id="<?php echo e($rooms[0]->room_no); ?>">Go back</a>
    </div>
    <p class="text-muted" style="font-size: 12px;">Please fill up the information below to complete your check in.</p>
    <!-- USE FORM -->
    <form action="<?php echo e(route('payment')); ?>" method="POST" class="mt-2">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="user_id" value="<?php echo e($userdata->id); ?>" />
        <div class="row">
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
                <div class="mb-3">
                    <ul class="p-2">
                        <span class="fw-bold">User details</span>
                        <li><i class="bx bx-user"></i> Name: <?php echo e($userdata->name); ?></li>
                        <li><i class="bx bx-map"></i>Address: <?php echo e($userdata->address); ?></li>
                        <li><i class="bx bx-envelope"></i>Email: <?php echo e($userdata->email); ?></li>
                        <li><i class="bx bx-phone"></i>Phone: <?php echo e($userdata->phone); ?></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 ">
                <div class="mb-3 ">
                    <label for="" class="form-label text-muted">Check in plan</label>
                    <div class="input-group">
                        <select class="form-control" name="amount" id="plan">
                            <?php if(count($prices) > 0): ?>

                            <?php $__currentLoopData = $prices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($prc->price); ?>" data-amount="<?php echo e($prc->price); ?>" data-hours="<?php echo e($prc->hour); ?>"><?php echo e($prc->hour); ?> hours - &#8369 <?php echo e($prc->price); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="plan" id="plan_field" />
                <input type="hidden" name="hour" id="hour_field" />
                <input type="hidden" name="amount" id="amount_plan" />
                <input type="hidden" name="room_no" value="<?php echo e($rooms[0]->room_no); ?>" />
            </div>

            <div class="col-md-4 col-lg-4 ">
                <div class="mb-3 ">
                    <label for="" class="form-label text-muted">Target date</label>
                    <div class="input-group">
                        <input type="date" value="<?php echo e(old('date')); ?>" name="date" autocomplete="off" id="date" class="form-control" />
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-lg-8 ">
                <p class="text-muted" style="font-size:12px">I have read and agree to and will abide by all of terms and conditions that are setout in the accomodation centre Terms and Conditions.</p>
                <button type="submit" class="btn-check-in" id="btn-check-in">Pay with Paypal </button>
                <?php if(count($gcash_content) > 0): ?>
                <button type="button" class="btn btn-sm btn-primary" id="btn-gcash">Pay with Gcash </button>
                <?php endif; ?>

                <script>
                    $(function() {

                        $('#btn-gcash').on('click', function() {
                            $('#to-pay').text($('#plan_field').val())
                            $('#t-date').text($('#date').val())
                            $('#text-error').text('')
                            $('#gcash-modal').modal('show')
                        })

                        $('#btn-proceed').on('click', function() {
                            if ($('#date').val() == '') {
                                $('#text-error').text('please choose a target date for your booking')
                            } else {
                                var amount_ = $('#amount_plan').val()
                                var target_date_ = $('#date').val()
                                var plan_ = $('#plan_field').val()
                                var hour_ = $('#hour_field').val()

                                var data = {
                                    _token: "<?php echo e(csrf_token()); ?>",
                                    type: 'booking',
                                    amount: amount_,
                                    target_date: target_date_,
                                    room_no: "<?php echo e($rooms[0]->room_no); ?>",
                                    plan: plan_,
                                    hour: hour_
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
                                        window.location.replace("<?php echo e(route('user.bookings')); ?>")
                                    }
                                }).fail(function(e) {

                                })

                            }
                        })
                    })
                </script>
            </div>

        </div>
    </form>

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
                                <h6>Selected plan: <span id="to-pay" class="fw-bold"></span></h6>
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
    <script>
        $(document).ready(function() {
            $('.btn-back').on('click', function() {
                var route = "<?php echo e(route('user.roominfo',':id')); ?>"
                window.location.replace(route.replace(':id', $(this)[0].dataset.id))
            })


            $('#plan_field').val($('#plan option:selected').text())
            $('#hour_field').val($('#plan option:selected')[0].dataset.hours)
            $('#amount_plan').val($('#plan option:selected')[0].dataset.amount)

            $('#plan').on('change', function() {
                $('#plan_field').val($('#plan option:selected').text())
                $('#hour_field').val($('#plan option:selected')[0].dataset.hours)

                $('#amount_plan').val($('#plan option:selected')[0].dataset.amount)
            })
        })
    </script>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\sarah\Desktop\tanawsystem\tanawsystem\resources\views/user/check_in_form.blade.php ENDPATH**/ ?>