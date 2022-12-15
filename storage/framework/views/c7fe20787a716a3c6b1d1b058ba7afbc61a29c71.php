

<?php $__env->startSection('manage_rooms'); ?>
<script src="<?php echo e(asset('./dataTables/datatables.js')); ?>"></script>
<link rel="stylesheet" href="<?php echo e(asset('./dataTables/datatables.min.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(asset('./dataTables/datatables.css')); ?>" />
<script src="<?php echo e(asset('./dataTables/datatables.min.js')); ?>"></script>
<style>
    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus,
    input[type="number"]:focus {
        border: 1px solid gray;
        outline: 0 none;
        box-shadow: none;
    }
</style>

<div class="row p-5">
    <div class="col-lg-12">
        <?php if('u/admin/manage-rooms' === request()->path()): ?>
        <p>Manage > Room</p>
        <div class="d-flex justify-content-between">
            <button id="btn-create-room" class="mb-3 custom-btn d-flex align-items-center"><i class="bx bx-plus"></i>Add Room</button>
            <div class="d-flex">
                <button id="btn-create-price" data-bs-toggle="modal" data-bs-target="#add-price-modal" class="mb-3 custom-btn d-flex align-items-center"><i class="bx bx-plus"></i>Add Booking Prices</button>
            </div>
        </div>
        <!-- add-content -->
        <div class="modal fade" id="add-price-modal" tabindex="-1" aria-labelledby="modal-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- form -->
                                    <form method="POST" id="add-price" action="<?php echo e(route('price.store')); ?>">

                                        <div class="alert-container" id="error-display" style="display: none;">
                                            <div class="alert-header">
                                                <i class="bx bx-error fs-5"></i>
                                            </div>
                                            <div class="alert-body">
                                                <ul id="error-list">

                                                </ul>
                                            </div>
                                        </div>
                                        <?php echo csrf_field(); ?>
                                        <div class="p-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="fs-4 fw-bold">Add new price plan</p>
                                                <a href="" id="price-btn" data-bs-toggle="modal" data-bs-target="#view-price-modal" style="font-size: 12px; text-decoration:none">View Saves</a>
                                            </div>
                                            <div class="mb-3 ">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="title" class="form-label text-muted">Hour</label>
                                                        <div class="input-group">
                                                            <input type="number" value="<?php echo e(old('hour')); ?>" name="hour" autocomplete="off" placeholder="Hours" class="form-control" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="title" class="form-label text-muted">Price</label>
                                                        <div class="input-group">
                                                            <input type="number" value="<?php echo e(old('price')); ?>" name="price" autocomplete="off" placeholder="Price" class="form-control" />
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <input type="submit" class="custom-btn mx-auto w-100" value="Save">
                                        </div>

                                    </form>
                                    <script>
                                        $(document).ready(function() {

                                            function Alertmsg(header, msg, type) {
                                                Swal.fire(
                                                    header,
                                                    msg,
                                                    type
                                                )
                                            }

                                            $('#add-price').on('submit', function(e) {
                                                e.preventDefault()
                                                $.ajax({
                                                    url: "<?php echo e(route('price.store')); ?>",
                                                    type: 'post',
                                                    data: new FormData(this),
                                                    dataType: 'json',
                                                    processData: false,
                                                    contentType: false,
                                                    beforeSend: function() {
                                                        $('#add-price :input').prop("disabled", true);

                                                        $('#error-display').css('display', 'none');
                                                        document.querySelector('#error-list').innerHTML = ''

                                                    },
                                                    success: function(data) {
                                                        $('#add-price :input').prop("disabled", false);
                                                        if (data.status == 200) {
                                                            $('#add-price')[0].reset();
                                                            $('#add-price-modal').modal('toggle')

                                                            Alertmsg('Success', data.msg, 'success')

                                                        }
                                                        if (data.status == 400) {
                                                            $('#error-display').css('display', 'flex');
                                                            $.each(data.error, function(prefix, val) {

                                                                var li = document.createElement('li')
                                                                li.innerText = val[0]
                                                                document.querySelector('#error-list').appendChild(li)
                                                            })
                                                        }
                                                    },
                                                    error: function(e) {
                                                        Alertmsg('Failed', 'Something went wrong!', 'error')
                                                    }
                                                });
                                            })
                                        })
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End modal -->

        <!-- add-content -->
        <div class="modal fade" id="view-price-modal" tabindex="-1" aria-labelledby="modal-label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- form -->
                                    <h1 class="fs-4 fw-bold mb-3">Registered prices</h1>
                                    <table id="table-prices" class="display nowrap w-100 table-striped">
                                        <thead>
                                            <tr style=" height: 10px;">
                                                <th>Id</th>
                                                <th>Hour</th>
                                                <th>Price</th>
                                                <th>Date created</th>
                                                <th>Operation</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <script>
                                    $(function() {

                                        function Alertmsg(header, msg, type) {
                                            Swal.fire(
                                                header,
                                                msg,
                                                type
                                            )
                                        }

                                        var table = $('#table-prices').DataTable({
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
                                                url: "<?php echo e(route('prices.get')); ?>",
                                                type: 'get',
                                                dataType: 'json',
                                                beforeSend: function() {}
                                            }).done(function(data) {

                                                table.clear().draw()

                                                for (let i = 0; i < data.content.length; i++) {
                                                    var button = '<button data-id="' + data.content[i][0] + '" data-id"' + data.content[i][0] + '" class="btn btn-sm btn-danger btn-delete-price">Delete</button>'
                                                    table.row.add([data.content[i][0], data.content[i][1] + "Hours", "\u20B1" + data.content[i][2], data.content[i][3], button]).draw()
                                                }
                                            }).fail(function(e) {
                                                Alertmsg('Load faile', 'Error in fetching data', 'error')
                                            })
                                        }

                                        load_data()
                                        $('#price-btn').on('click', function() {
                                            load_data()
                                        })

                                        $('#table-prices tbody').on('click', 'tr td .btn-delete-price', function() {
                                            Swal.fire({
                                                type: 'question',
                                                title: 'Are you sure?',
                                                text: ' Do you want to delete this price',
                                                showCancelButton: true,
                                                confirmButtonText: 'Confirm'
                                            }).then((result) => {
                                                if (result.value) {
                                                    var route = "<?php echo e(route('price.destroy',':id')); ?>"
                                                    return $.ajax({
                                                        url: route.replace(':id', $(this)[0].dataset.id),
                                                        type: 'get',
                                                        dataType: 'json',
                                                        beforeSend: function() {}
                                                    }).done(function(data) {

                                                        load_data()
                                                        Alertmsg('Success', 'Deleted Successfully', 'success')
                                                    }).fail(function(e) {
                                                        Alertmsg('Load failed', 'Error in fetching data', 'error')
                                                    })
                                                }
                                            })
                                        })
                                    })
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End modal -->
        <?php if(Session::has('success')): ?>
        <script>
            $(document).ready(function() {
                Swal.fire(
                    'Success',
                    "<?php echo e(Session::get('success')); ?>",
                    'success'
                )
            })
        </script>
        <?php endif; ?>


        <div class="container-fluid">
            <div class="row">

                <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 col-lg-3 mb-3">
                    <div class="card room-card p-3 h-100">
                        <div class="d-flex flex-column mt-3 h-100">
                            <div class="d-flex justify-content-between">
                                <h5 class="text-uppercase ">ROOM NO. <?php echo e($room->room_no); ?></h5>
                                <span class="float-end btn-delete" data-id="<?php echo e($room->id); ?>" data-room_no="<?php echo e($room->room_no); ?>"><i class="bx bx-x bg-danger text-white" style="cursor:pointer;border-radius: 50px;"></i></span>
                            </div>

                            <div class="d-flex justify-content-between">
                                <p class="fw-light text-dark">No. of occupancy <?php echo e($room->min .'-'.$room->max); ?> person</p>
                                <span class="float-end btn-upload" data-id="<?php echo e($room->room_no); ?>"><i class="bx bx-image-add text-info" style="cursor:pointer;border-radius: 50px;"></i></span>
                            </div>
                        </div>
                        <?php if($room->status == 'free'): ?>
                        <span class="text-success mb-3">Free <i class="bx bx-cloud-upload text-white" style="cursor:pointer;border-radius: 50px;"></i></span>
                        <?php elseif($room->status == 'reserved'): ?>
                        <span class="text-warning mb-3">Reserved</span>
                        <?php elseif($room->status == 'occupied'): ?>
                        <span class="text-danger mb-3">No Available</span>
                        <?php endif; ?>
                        <a href="<?php echo e(route('rooms.info',$room->id)); ?>" class="btn custom-btn d-flex justify-content-center align-items-baseline">
                            <i class="bx bx-edit"></i> Information</a>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <script>
            document.querySelector('#btn-create-room').addEventListener('click', function() {
                location.href = "<?php echo e(route('rooms.create')); ?>";
            })

            $(document).ready(function() {
                $('.card').on('click', '.btn-delete', function() {
                    var room_id = $(this)[0].dataset.id
                    var room_no = $(this)[0].dataset.room_no
                    Swal.fire({
                        type: 'warning',
                        title: 'Are you sure?',
                        text: 'Do you want to remove Room no. ' + room_no + '\nYou cannot undo this after.',
                        showCancelButton: true,
                        confirmButtonText: 'Confirm'
                    }).then((result) => {
                        if (result.value) {
                            var url = "<?php echo e(route('rooms.destroy',':id')); ?>"
                            window.location.replace(url.replace(':id', room_id))
                        }
                    })
                })

                $('.card').on('click', '.btn-upload', function() {
                    var route = "<?php echo e(route('rooms.images',':id')); ?>";
                    window.location.replace(route.replace(':id', $(this)[0].dataset.id))
                })
            })
        </script>
        <?php endif; ?>

        <!-- create view-->
        <?php if('u/admin/manage-rooms/create' === request()->path()): ?>
        <p class="d-flex justify-content-between">Manage > Room > Create <a href="<?php echo e(route('rooms.manage')); ?>">Go back</a></p>
        <div class="container-fluid">
            <?php echo $__env->yieldContent('room_form'); ?>
        </div>
        <?php endif; ?>

        <?php if(count($rooms) > 0): ?>
        <?php if('u/admin/manage-rooms/room-info/'.$rooms[0]->id === request()->path()): ?>
        <p class="d-flex justify-content-between">Manage > Room > information <a href="<?php echo e(route('rooms.manage')); ?>">Go back</a></p>
        <div class="container-fluid">
            <?php echo $__env->yieldContent('room_info'); ?>
        </div>
        <?php endif; ?>
        <?php endif; ?>

        <?php if(count($rooms) > 0): ?>
        <?php if('u/admin/manage-rooms/room-images/'.$rooms[0]->room_no === request()->path()): ?>
        <p class="d-flex justify-content-between">Manage > Room > images <a href="<?php echo e(route('rooms.manage')); ?>">Go back</a></p>
        <div class="container-fluid">
            <?php echo $__env->yieldContent('room_images'); ?>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\tanawsystem\resources\views/admin/manage_room.blade.php ENDPATH**/ ?>