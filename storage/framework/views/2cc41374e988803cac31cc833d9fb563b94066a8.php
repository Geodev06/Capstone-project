

<?php $__env->startSection('room_info'); ?>
<div class="row">
    <div class="col-md-5">
        <form method="POST" id="add-room" action="<?php echo e(route('rooms.store')); ?>">
            <div class="container">
                <div class="row p-2">
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
                    <h4>Room no. <?php echo e($rooms[0]->room_no); ?> information</h4>
                    <?php echo csrf_field(); ?>
                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label text-muted">Room no.</label>
                        <div class="input-group">
                            <input type="number" value="<?php echo e($rooms[0]->room_no); ?>" name="room_no" autocomplete="off" placeholder="Room no" class="form-control" />
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="" class="form-label text-muted">No. of Occupants</label>
                        <div class="input-group">
                            <div class="d-flex align-items-center">
                                <div>

                                    <input type="number" value="<?php echo e($rooms[0]->min); ?>" name="min" autocomplete="off" placeholder="Min." class="form-control" />

                                </div>
                                <span> - </span>
                                <div>

                                    <input type="number" value="<?php echo e($rooms[0]->max); ?>" name="max" autocomplete="off" placeholder="Max." class="form-control" />

                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="custom-btn d-flex justify-content-center align-items-center"><i class="bx bx-save"></i>Save</button>
                </div>
            </div>
        </form>
    </div>

    <div class="col-md-7">
        <?php if($rooms[0]->status == 'free'): ?>
        <span class="badge bg-success">This room is free to use.</span>
        <?php else: ?>
        <div class="row">
            <h4>Current Booking information</h4>
            <table id="table-booking" class="display nowrap w-100 table-striped">
                <thead>
                    <tr style=" height: 10px;">
                        <th>Booking id</th>
                        <th>Checker name</th>
                        <th>Address</th>
                        <th>Email</th>
                        <th>Phone no.</th>
                        <th>Check in date</th>
                        <th>More</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <script>
            $(document).ready(function() {
                function Alertmsg(header, msg, type) {
                    Swal.fire(
                        header,
                        msg,
                        type
                    )
                }

                var table = $('#table-booking').DataTable({
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

                    var route = "<?php echo e(route('booking.get_json', $rooms[0]->room_no)); ?>";

                    return $.ajax({
                        url: route,
                        type: 'get',
                        dataType: 'json',
                        beforeSend: function() {}
                    }).done(function(data) {
                        console.log(data)

                        table.clear().draw()

                        for (let i = 0; i < data.booking.length; i++) {

                            var button = '<button data-id="' + data.booking[i].id + '" data-tdate="' + data.booking[i].target_date + '" data-out="' + data.booking[i].check_out_date + '" data-plan="' + data.booking[i].plan + '" class="btn btn-sm btn-dark btn-more" >More</button>'
                            table.row.add([data.booking[i].id, data.booking[i].checker_name, data.booking[i].address, data.booking[i].email, data.booking[i].mobile, data.booking[i].target_date, button]).draw()
                        }
                    }).fail(function(e) {
                        Alertmsg('Load failed', 'Error in fetching data', 'error')
                    })
                }

                load_data()

                $('#table-booking tbody').on('click', 'tr td .btn-more', function() {
                    $('#out_date').text($(this)[0].dataset.out)
                    $('#tdate').text($(this)[0].dataset.tdate)
                    $('#cplan').text($(this)[0].dataset.plan)
                    $('#booking-modal').modal('toggle')
                    $('#btn-end-booking').attr('data-id', $(this)[0].dataset.id)
                })

                $('#btn-end-booking').on('click', function() {
                    console.log($(this)[0].dataset.id)
                    Swal.fire({
                        type: 'question',
                        title: 'Are you sure?',
                        text: ' Do you want to end this booking now?',
                        showCancelButton: true,
                        confirmButtonText: 'Confirm'
                    }).then((result) => {
                        if (result.value) {
                            var route = "<?php echo e(route('booking.end', ':id')); ?>"

                            window.location.replace(route.replace(':id', $(this)[0].dataset.id))
                        }
                    })
                })

            })
        </script>

        <!-- booking-content -->
        <div class="modal fade" id="booking-modal" tabindex="-1" aria-labelledby="modal-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="p-2">
                                        <h3>Booking details</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-muted">Check in date</h6>
                                            <span class="fw-bold" id="tdate">Date</span>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="text-muted">Check out date</h6>
                                            <span class="fw-bold" id="out_date">Date</span>
                                        </div>

                                        <div class="col-md-6">
                                            <h6 class="text-muted">Check in plan</h6>
                                            <span class="fw-bold" id="cplan">Date</span>
                                        </div>
                                        <div class="col-md-6"></div>
                                        <div class="col-md-12 mt-3">
                                            <button id="btn-end-booking" class="btn btn-danger btn-sm">End Booking</button>
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
        <?php endif; ?>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.manage_room', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\tanawsystem\resources\views/admin/room_info.blade.php ENDPATH**/ ?>