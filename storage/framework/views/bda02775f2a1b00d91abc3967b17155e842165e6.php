<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tanaw</title>
    <!-- Favicon-->

    <!-- Bootstrap icons-->

    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <link rel="stylesheet" href="<?php echo e(asset('styles.css')); ?>" />
    <script src="<?php echo e(asset('./assets/js/jquery-3.5.1.js')); ?>"></script>

    <script src="<?php echo e(asset('scripts.js')); ?>" defer></script>
    <!-- sweetalert -->
    <script src="<?php echo e(asset('./sweetalert/sweetalert.min.js')); ?>" defer></script>

    <!-- chartjs -->
    <script src="<?php echo e(asset('chartjs/package/dist/chart.js')); ?>"></script>
    <script src="<?php echo e(asset('chartjs/datalabels.min.js')); ?>"></script>

</head>

<body>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-4">
        <div class="container px-5">
            <a class="navbar-brand" href="<?php echo e(route('index')); ?>">TANAW SYSTEM</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link <?php echo e('u/admin'=== request()->path() ? 'active' :''); ?>" aria-current="page" href="<?php echo e(route('admin.dashboard')); ?>" style="color: #fff;">Home</a></li>


                    <div class="dropdown">
                        <a class="btn text-white dropdown-toggle" href="#" role="button" id="dm0" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Manage
                        </a>
                        <div class="dropdown-menu p-2" aria-labelledby="dm0">
                            <div class="dropdown-header fw-bold">Management</div>
                            <a class="dropdown-item d-flex align-items-center <?php echo e('u/admin/manage-users'=== request()->path() ? 'active' :''); ?>" href="<?php echo e(route('manage.users')); ?>"><i class="bx bx-user"></i> Users</a>
                            <a class="dropdown-item d-flex align-items-center <?php echo e('u/admin/payments'=== request()->path() ? 'active' :''); ?>" href="<?php echo e(route('user_payments')); ?>"><i class="bx bx-money"></i> Payments</a>
                            <a class="dropdown-item d-flex align-items-center <?php echo e('u/admin/manage-rooms'=== request()->path() ? 'active' :''); ?>" href="<?php echo e(route('rooms.manage')); ?>"><i class="bx bx-door-open"></i> Rooms</a>
                            <a class="dropdown-item d-flex align-items-center <?php echo e('u/admin/manage-establishments'=== request()->path() ? 'active' :''); ?>" href="<?php echo e(route('admin.manage_establishments')); ?>"><i class="bx bx-building"></i> Establishments</a>
                            <a class="dropdown-item d-flex align-items-center <?php echo e('u/admin/manage-content'=== request()->path() ? 'active' :''); ?>" href="<?php echo e(route('admin.manage_content')); ?>"><i class='bx bx-book-content'></i> Contents</a>
                        </div>
                    </div>

                    <div class="dropdown">
                        <a class="btn text-white dropdown-toggle" href="#" role="button" id="dm" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo e($userdata->name); ?>

                        </a>
                        <div class="dropdown-menu p-2" aria-labelledby="dm">
                            <div class="dropdown-header">Account</div>
                            <a class="dropdown-item d-flex align-items-center <?php echo e('u/admin/setting'=== request()->path() ? 'active' :''); ?>" href="<?php echo e(route('admin.setting')); ?>"><i class="bx bx-cog"></i> Setting</a>
                            <a class="dropdown-item d-flex align-items-center " id="btn-notification"><i class="bx bx-bell"></i> Notifications <?php if('u/admin'=== request()->path()): ?> <?php if($dashboard[8] > 0): ?> <span class="badge bg-danger"><?php echo e($dashboard[8]); ?></span> <?php endif; ?> <?php endif; ?></a>
                            <a class="dropdown-item d-flex align-items-center <?php echo e('u/admin/user-message'=== request()->path() ? 'active' :''); ?>" href="<?php echo e(route('admin.message')); ?>"><i class="bx bx-envelope"></i> Message <?php if($unread_msg > 0): ?> <span class="badge bg-danger"><?php echo e($unread_msg); ?></span> <?php endif; ?></a>


                            <form method="POST" id="form-logout" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="button" id="btn-logout" class="dropdown-item d-flex align-items-center"><i class=" bx bx-log-out"></i> Sign out</button>
                            </form>
                        </div>
                    </div>

                </ul>
            </div>
        </div>
    </nav>


    <section>
        <div class="container-fluid main-container ">

            <?php if('u/admin/manage-content' === request()->path()): ?>

            <?php echo $__env->yieldContent('manage_content'); ?>

            <?php endif; ?>

            <?php if('u/admin/user-message' === request()->path()): ?>

            <?php echo $__env->yieldContent('message'); ?>

            <?php endif; ?>

            <?php if('u/admin/manage-users'): ?>

            <?php echo $__env->yieldContent('users'); ?>

            <?php endif; ?>

            <?php if('u/admin/manage-establishments'): ?>

            <?php echo $__env->yieldContent('manage_establishments'); ?>

            <?php endif; ?>

            <?php if('u/admin/manage-rooms'): ?>

            <?php echo $__env->yieldContent('manage_rooms'); ?>

            <?php endif; ?>

            <?php if('u/admin/setting'): ?>
            <?php echo $__env->yieldContent('setting'); ?>
            <?php endif; ?>

            <?php if('u/admin/payments'): ?>
            <?php echo $__env->yieldContent('payments'); ?>
            <?php endif; ?>

            <?php if('u/admin' === request()->path()): ?>
            <div class="row p-5">

                <div class="col-sm-12 col-md-3 col-lg-3 mb-2">
                    <div class="h-100 my-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-column">
                                <h4><?php echo e($dashboard[0]); ?></h4>
                                <p>Registered users.</p>
                            </div>
                            <div class="d-flex justify-content-center align-items-center ">
                                <div class="icon-container">
                                    <i class="bx bx-user fs-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-3 col-lg-3 mb-2">
                    <div class="h-100 my-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-column">
                                <h4><?php echo e($dashboard[2]); ?></h4>
                                <p>Nearby establishments registered.</p>
                            </div>
                            <div class="d-flex justify-content-center align-items-center ">
                                <div class="icon-container">
                                    <i class="bx bx-building fs-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-3 col-lg-3 mb-2">
                    <div class="h-100 my-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-column">
                                <h4>&#8369;<?php echo e($dashboard[3]); ?></h4>
                                <p>Income for the day.</p>
                            </div>
                            <div class="d-flex justify-content-center align-items-center ">
                                <div class="icon-container">
                                    <i class="bx bx-money fs-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-3 col-lg-3 mb-2">
                    <div class="h-100 my-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-column">
                                <h4><?php echo e($dashboard[1]); ?></h4>
                                <p>Contents created.</p>
                            </div>
                            <div class="d-flex justify-content-center align-items-center ">
                                <div class="icon-container">
                                    <i class="bx bxs-hand fs-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-3 col-lg-3 mb-2" style="cursor: pointer;" id="room">
                    <div class="h-100 my-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-column">
                                <h4><?php echo e($dashboard[4]); ?></h4>
                                <p>Total no. of rooms.</p>
                            </div>
                            <div class="d-flex justify-content-center align-items-center ">
                                <div class="icon-container">
                                    <i class="bx bx-door-open fs-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-3 col-lg-3 mb-2">
                    <div class="h-100 my-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-column">
                                <h4><?php echo e($dashboard[5]); ?></h4>
                                <p>Room reservations.</p>
                            </div>
                            <div class="d-flex justify-content-center align-items-center ">
                                <div class="icon-container">
                                    <i class="bx bx-bookmarks fs-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-3 col-lg-3 mb-2">
                    <div class="h-100 my-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-column">
                                <h4><?php echo e($dashboard[6]); ?></h4>
                                <p>Visitors today.</p>
                            </div>
                            <div class="d-flex justify-content-center align-items-center ">
                                <div class="icon-container">
                                    <i class="bx bx-wink-smile fs-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-3 col-lg-3 mb-2">
                    <div class="h-100 my-card p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-column">
                                <h4><?php echo e($dashboard[9]); ?></h4>
                                <p>Paid entrance.</p>
                            </div>
                            <div class="d-flex justify-content-center align-items-center ">
                                <div class="icon-container">
                                    <i class="bx bx-user-x fs-3"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- table -->
                <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                    <div class="my-card h-100 p-2">
                        <h1 class="fs-6 mb-2">Recent Booking Payments</h1>
                        <div>
                            <table class="table table-striped" style="font-size: 11px" id="table-recent">
                                <thead class="text-white bg-primary">
                                    <th>Transaction id</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $recent_payment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr style="cursor:pointer" data-id="<?php echo e($payment->id); ?>">
                                        <td class="text-white"><?php echo e($payment->payment_id); ?></td>
                                        <td class="text-success">&#8369 <?php echo e($payment->amount); ?></td>
                                        <td class="text-info"><?php echo e($payment->created_at->format(' jS, \of F, Y  g:i  A')); ?></td>
                                        <td>
                                            <?php if($payment->payment_status === 'to-approve'): ?>
                                            <span class="badge bg-warning"><?php echo e($payment->payment_status); ?></span>
                                            <?php endif; ?>

                                            <?php if($payment->payment_status === 'paid'): ?>
                                            <span class="badge bg-success"><?php echo e($payment->payment_status); ?></span>
                                            <?php endif; ?>

                                            <?php if($payment->payment_status === 'on-cancel-request'): ?>
                                            <span class="badge" style="background-color: dodgerblue;"><?php echo e($payment->payment_status); ?></span>
                                            <?php endif; ?>

                                            <?php if($payment->payment_status === 'cancelled'): ?>
                                            <span class="badge" style="background-color: crimson;"><?php echo e($payment->payment_status); ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                    <div class="my-card h-100 p-2">
                        <h1 class="fs-6 mb-2">Recent Entrance Payments</h1>
                        <div>
                            <table class="table table-striped" style="font-size: 11px" id="table-recent">
                                <thead class="text-white bg-primary">
                                    <th>Transaction id</th>
                                    <th>User id</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $entrance_payment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr style="cursor:pointer" data-id="<?php echo e($payment->id); ?>">
                                        <td class="text-white"><?php echo e($payment->payment_id); ?></td>
                                        <td class="text-white"><?php echo e($payment->user_id); ?></td>
                                        <td class="text-success">&#8369 <?php echo e($payment->amount); ?></td>
                                        <td class="text-info"><?php echo e($payment->created_at->format(' jS, \of F, Y  g:i  A')); ?></td>
                                        <td>
                                            <?php if($payment->payment_status === 'paid'): ?>
                                            <span class="badge" style="background-color: seagreen;"><?php echo e($payment->payment_status); ?></span>
                                            <?php endif; ?>

                                            <?php if($payment->payment_status === 'to-approve'): ?>
                                            <span class="badge bg-warning"><?php echo e($payment->payment_status); ?></span>
                                            <?php endif; ?>

                                            <?php if($payment->payment_status === 'on-cancel-request'): ?>
                                            <span class="badge" style="background-color: dodgerblue;"><?php echo e($payment->payment_status); ?></span>
                                            <?php endif; ?>

                                            <?php if($payment->payment_status === 'cancelled'): ?>
                                            <span class="badge" style="background-color: crimson;"><?php echo e($payment->payment_status); ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-sm-8 col-md-8 col-lg-8 mb-2">
                    <div class="my-card border rounded p-2">
                        <h1 class="fs-6 mb-2">Revenue</h1>
                        <div class="d-flex">
                            <span class="btn-overview overview-active" id="btn-weekly">Weekly</span>
                            <span class="btn-overview" id="btn-monthly">Monthly</span>
                            <span class="btn-overview" id="btn-annually">Annually</span>
                        </div>
                        <div id="overview-div">
                            <canvas id="overviewChart" height="40%" width="100%"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4 col-md-4 col-lg-4 mb-2">
                    <div class="my-card border rounded p-2">
                        <h1 class="fs-6 mb-2">Ratings</h1>

                        <div id="rating-div">
                            <canvas id="ratingchart" height="92%" width="100%"></canvas>
                        </div>
                    </div>
                </div>


                <div class="col-sm-6 col-md-6 col-lg-6 mb-2">
                    <div class="my-card border rounded p-2">
                        <h1 class="fs-6 mb-2">Visitors</h1>
                        <div class="d-flex">
                            <span class="btn-overview overview-active" id="btn-weekly-v">Per week</span>
                            <span class="btn-overview" id="btn-monthly-v">Per month</span>
                            <span class="btn-overview" id="btn-annually-v">All time</span>
                        </div>
                        <div id="overview-div-v">
                            <canvas id="overviewChart_visitor" height="50%" width="100%"></canvas>
                        </div>
                    </div>
                </div>


                <div class="col-sm-6 col-md-6 col-lg-6 mb-2">
                    <div class="my-card border rounded p-2">
                        <h1 class="fs-6 mb-2">Entrance payments</h1>
                        <div class="d-flex">
                            <span class="btn-overview overview-active" id="btn-weekly-e">Per week</span>
                            <span class="btn-overview" id="btn-monthly-e">Per month</span>
                            <span class="btn-overview" id="btn-annually-e">All time</span>
                        </div>
                        <div id="overview-div-e">
                            <canvas id="overviewChart_entrance" height="50%" width="100%"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <button class="btn btn-primary" id="btn-print">Print report</button>
                </div>

            </div>

            <!-- room-content -->
            <div class="modal fade" id="room-modal" tabindex="-1" aria-labelledby="modal-label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark">
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 p-5">
                                        <p class="text-white">Rooms status for today, <span class="fw-bold"><?php echo e(now()->format('M d, Y')); ?>.</span></p>
                                        <div class="d-flex flex-column">
                                            <div class="d-flex justify-content-between text-success">
                                                <h2>Free</h2>
                                                <h2><?php echo e($dashboard[7][0]); ?></h2>
                                            </div>

                                            <div class="d-flex justify-content-between text-warning">
                                                <h2>Reserved</h2>
                                                <h2><?php echo e($dashboard[7][1]); ?></h2>
                                            </div>

                                            <div class="d-flex justify-content-between text-primary">
                                                <h2>In-use</h2>
                                                <h2><?php echo e($dashboard[7][2]); ?></h2>
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

            <!-- notification-modal -->
            <div class="modal fade" id="notification-modal" tabindex="-1" aria-labelledby="modal-label" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12 p-5">
                                        <h4 class="">Notifications as of, <span class="fw-bold"><?php echo e(now()->format('M d, Y')); ?>.</span></h4>
                                        <div id="notification-container"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End modal -->
        </div>
    </section>



</body>

<script>
    function load_notification() {

        $.ajax({
            url: "<?php echo e(route('notification')); ?>",
            type: 'get',
            dataType: 'json',
            beforeSend: function() {}
        }).done(function(data) {
            if (data.status == 200) {
                $('#notification-container').html(data.data)
            }
        }).fail(function(e) {

        })
    }

    function update_notification(id) {
        var route_ = "<?php echo e(route('notification.update',':id')); ?>"
        $.ajax({
            url: route_.replace(':id', id),
            type: 'post',
            data: {
                _token: '<?php echo e(csrf_token()); ?>'
            },
            dataType: 'json',
            beforeSend: function() {}
        }).done(function(data) {
            if (data.status == 200) {
                load_notification()
            }
        }).fail(function(e) {

        })
    }

    function delete_notification(id) {
        var route_delete = "<?php echo e(route('notification.delete',':id')); ?>"
        $.ajax({
            url: route_delete.replace(':id', id),
            type: 'post',
            data: {
                _token: '<?php echo e(csrf_token()); ?>'
            },
            dataType: 'json',
            beforeSend: function() {}
        }).done(function(data) {
            if (data.status == 200) {
                load_notification()
            }
        }).fail(function(e) {

        })
    }

    $(document).ready(function() {

        $('#notification-container').on('click', '.btn-delete-notif', function() {
            delete_notification($(this)[0].dataset.id)
        })

        $('#notification-container').on('click', '.btn-mark-notif', function() {
            update_notification($(this)[0].dataset.id)
        })

        $('#btn-notification').click(function() {
            load_notification()
            $('#notification-modal').modal('show')
        })
        $('#room').on('click', function() {
            $('#room-modal').modal('toggle')
        })

        $('#btn-logout').on('click', function() {
            Swal.fire({
                type: 'question',
                title: 'Are you sure?',
                text: ' Do you want to sign out now?',
                showCancelButton: true,
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.value) {
                    $('#form-logout').submit()
                }
            })
        })
    })


    function load_overview_chart(chart_data) {

        var revenue_labels = [];
        var revenue_points = []

        for (let i = 0; i < chart_data.length; i++) {
            revenue_labels.push(chart_data[i].date)
            revenue_points.push(chart_data[i].total)

        }
        var ctx_o = document.getElementById('overviewChart')
        var chart_o = new Chart(ctx_o, {
            type: 'line',
            data: {
                labels: revenue_labels,
                datasets: [{
                    label: ['Revenue'],
                    data: revenue_points,
                    backgroundColor: [
                        'springgreen',
                    ],
                    borderColor: [
                        'springgreen'

                    ],
                    borderWidth: 1,
                    fill: true
                }]
            },

            plugins: [ChartDataLabels],
            options: {
                bezierCurve: true,
                elements: {
                    line: {
                        tension: 0.5
                    }
                },

                scales: {
                    y: {
                        ticks: {
                            color: 'white'
                        },
                        display: true,
                        title: {
                            display: true,
                            text: 'Revenue amount'
                        },
                        grid: {
                            color: 'gray'
                        }
                    },
                    x: {
                        ticks: {
                            color: 'white'
                        }
                    }

                },
                responsive: true,
                plugins: {
                    datalabels: {
                        display: true,
                        formatter: (value, ctx) => {
                            return "\u20B1 " + parseFloat(ctx.chart.data.datasets[0].data[ctx.dataIndex]).toFixed(2)
                        },
                        backgroundColor: 'crimson',
                        color: 'white',
                        borderRadius: 3,
                        font: {
                            size: 8
                        }
                    }
                }
            }
        })
    }

    function overview_data(category) {

        var temp_uri = "<?php echo e(route('overview.get', ':category')); ?>";
        $.ajax({
            url: temp_uri.replace(':category', category),
            type: 'get',
            dataType: 'json',
            beforeSend: function() {}
        }).done(function(data) {
            if (data.status == 200) {
                load_overview_chart(data.data)
            }
        }).fail(function(e) {

        })
    }

    overview_data(7)

    $('#btn-weekly').on('click', function(e) {
        e.preventDefault()
        $('#btn-weekly').addClass('overview-active')
        $('#btn-annually').removeClass('overview-active')
        $('#btn-monthly').removeClass('overview-active')
        $('#overviewChart').remove();
        $('#overview-div').html('<canvas id="overviewChart" height="50%" width="100%"></canvas>')
        overview_data(7)
    })

    $('#btn-monthly').on('click', function(e) {
        e.preventDefault()
        $('#btn-weekly').removeClass('overview-active')
        $('#btn-annually').removeClass('overview-active')
        $('#btn-monthly').addClass('overview-active')
        $('#overviewChart').remove();
        $('#overview-div').html('<canvas id="overviewChart" height="50%" width="100%"></canvas>')
        overview_data(30)
    })

    $('#btn-annually').on('click', function(e) {
        e.preventDefault()
        $('#btn-weekly').removeClass('overview-active')
        $('#btn-annually').addClass('overview-active')
        $('#btn-monthly').removeClass('overview-active')
        $('#overviewChart').remove();
        $('#overview-div').html('<canvas id="overviewChart" height="50%" width="100%"></canvas>')
        overview_data(365)
    })



    //ratings
    function load_Ratings(excellent, great, good, poor, terrible) {


        var ctx_r = document.getElementById('ratingchart')
        var chart_r = new Chart(ctx_r, {
            type: 'bar',
            data: {
                labels: ['excellent', 'great', 'good', 'poor', 'terrible'],
                datasets: [{
                    label: ['Rating'],
                    data: [excellent, great, good, poor, terrible],
                    backgroundColor: [
                        'orange',
                        'dodgerblue',
                        'springgreen',
                        'crimson',
                        'red',
                    ],
                    borderColor: [
                        'orange',
                        'dodgerblue',
                        'springgreen',
                        'crimson',
                        'red',

                    ],
                    borderWidth: 1,
                    fill: true,
                }]
            },

            plugins: [ChartDataLabels],
            options: {
                scales: {
                    y: {
                        ticks: {
                            color: 'white'
                        },
                        display: true,
                        title: {
                            display: true,
                            text: 'Ratings'
                        },
                        grid: {
                            color: 'gray'
                        }
                    },
                    x: {
                        ticks: {
                            color: 'white'
                        }
                    }

                },
                responsive: true,
                plugins: {
                    datalabels: {
                        display: true,
                        backgroundColor: 'crimson',
                        color: 'white',
                        borderRadius: 3,
                        font: {
                            size: 8
                        }
                    }
                }
            }
        })
    }

    function load_Ratings_Data() {

        var temp_uri = "<?php echo e(route('ratings.get')); ?>";
        $.ajax({
            url: temp_uri,
            type: 'get',
            dataType: 'json',
            beforeSend: function() {}
        }).done(function(data) {
            if (data.status == 200) {
                console.log(data)
                load_Ratings(data.data.excellent, data.data.great, data.data.good, data.data.poor, data.data.terrible)
            }
        }).fail(function(e) {

        })
    }

    load_Ratings_Data()

    /**
     * visitor chart
     */

    function load_overview_chart_visitor(chart_data) {

        var revenue_labels_v = [];
        var revenue_points_v = []

        for (let i = 0; i < chart_data.length; i++) {
            revenue_labels_v.push(chart_data[i].date)
            revenue_points_v.push(chart_data[i].total)

        }
        var ctx_v = document.getElementById('overviewChart_visitor')
        var chart_v = new Chart(ctx_v, {
            type: 'line',
            data: {
                labels: revenue_labels_v,
                datasets: [{
                    label: ['No. of visitor'],
                    data: revenue_points_v,
                    backgroundColor: [
                        'crimson',
                    ],
                    borderColor: [
                        'crimson'

                    ],
                    borderWidth: 1,
                    fill: true
                }]
            },

            plugins: [ChartDataLabels],
            options: {
                scales: {
                    y: {
                        ticks: {
                            color: 'white'
                        },
                        display: true,
                        title: {
                            display: true,
                            text: 'Revenue amount'
                        },
                        grid: {
                            color: 'gray'
                        }
                    },
                    x: {
                        ticks: {
                            color: 'white'
                        }
                    }

                },
                responsive: true,
                plugins: {
                    datalabels: {
                        display: true,
                        backgroundColor: 'crimson',
                        color: 'white',
                        borderRadius: 3,
                        font: {
                            size: 8
                        }
                    }
                }
            }
        })
    }

    function overview_data_visitor(category) {

        var temp_uri = "<?php echo e(route('overview.visitor', ':category')); ?>";
        $.ajax({
            url: temp_uri.replace(':category', category),
            type: 'get',
            dataType: 'json',
            beforeSend: function() {}
        }).done(function(data) {
            if (data.status == 200) {
                load_overview_chart_visitor(data.data)
                console.log(data)
            }
        }).fail(function(e) {

        })
    }

    overview_data_visitor(7)

    $('#btn-weekly-v').on('click', function(e) {
        e.preventDefault()
        $('#btn-weekly-v').addClass('overview-active')
        $('#btn-annually-v').removeClass('overview-active')
        $('#btn-monthly-v').removeClass('overview-active')
        $('#overviewChart_visitor').remove();
        $('#overview-div-v').html('<canvas id="overviewChart_visitor" height="50%" width="100%"></canvas>')
        overview_data_visitor(7)
    })

    $('#btn-monthly-v').on('click', function(e) {
        e.preventDefault()
        $('#btn-weekly-v').removeClass('overview-active')
        $('#btn-annually-v').removeClass('overview-active')
        $('#btn-monthly-v').addClass('overview-active')
        $('#overviewChart_visitor').remove();
        $('#overview-div-v').html('<canvas id="overviewChart_visitor" height="50%" width="100%"></canvas>')
        overview_data_visitor(30)
    })

    $('#btn-annually-v').on('click', function(e) {
        e.preventDefault()
        $('#btn-weekly-v').removeClass('overview-active')
        $('#btn-annually-v').addClass('overview-active')
        $('#btn-monthly-v').removeClass('overview-active')
        $('#overviewChart_visitor').remove();
        $('#overview-div-v').html('<canvas id="overviewChart_visitor" height="50%" width="100%"></canvas>')
        overview_data_visitor(365)
    })

    /**
     * @ entrance payments
     */

    function load_overview_chart_entrance(chart_data) {

        var revenue_labels_e = [];
        var revenue_points_e = []

        for (let i = 0; i < chart_data.length; i++) {
            revenue_labels_e.push(chart_data[i].date)
            revenue_points_e.push(chart_data[i].total)

        }
        var ctx_e = document.getElementById('overviewChart_entrance')
        var chart_e = new Chart(ctx_e, {
            type: 'line',
            data: {
                labels: revenue_labels_e,
                datasets: [{
                    label: ['Entrance amount'],
                    data: revenue_points_e,
                    backgroundColor: [
                        'orange',
                    ],
                    borderColor: [
                        'orange'

                    ],
                    borderWidth: 1,
                    fill: true,
                }]
            },

            plugins: [ChartDataLabels],
            options: {
                scales: {
                    y: {
                        ticks: {
                            color: 'white'
                        },
                        display: true,
                        title: {
                            display: true,
                            text: 'Entrances amount'
                        },
                        grid: {
                            color: 'gray'
                        }
                    },
                    x: {
                        ticks: {
                            color: 'white'
                        }
                    }

                },
                responsive: true,
                plugins: {
                    datalabels: {
                        display: true,
                        backgroundColor: 'crimson',
                        color: 'white',
                        borderRadius: 3,
                        font: {
                            size: 8
                        }
                    }
                }
            }
        })
    }

    function overview_data_entrance(category) {

        var temp_uri = "<?php echo e(route('overview.entrance', ':category')); ?>";
        $.ajax({
            url: temp_uri.replace(':category', category),
            type: 'get',
            dataType: 'json',
            beforeSend: function() {}
        }).done(function(data) {
            if (data.status == 200) {
                load_overview_chart_entrance(data.data)
                console.log(data)
            }
        }).fail(function(e) {

        })
    }

    overview_data_entrance(7)

    $('#btn-weekly-e').on('click', function(e) {
        e.preventDefault()
        $('#btn-weekly-e').addClass('overview-active')
        $('#btn-annually-e').removeClass('overview-active')
        $('#btn-monthly-e').removeClass('overview-active')
        $('#overviewChart_entrance').remove();
        $('#overview-div-e').html('<canvas id="overviewChart_entrance" height="50%" width="100%"></canvas>')
        overview_data_entrance(7)
    })

    $('#btn-monthly-e').on('click', function(e) {
        e.preventDefault()
        $('#btn-weekly-e').removeClass('overview-active')
        $('#btn-annually-e').removeClass('overview-active')
        $('#btn-monthly-e').addClass('overview-active')
        $('#overviewChart_entrance').remove();
        $('#overview-div-e').html('<canvas id="overviewChart_entrance" height="50%" width="100%"></canvas>')
        overview_data_entrance(30)
    })

    $('#btn-annually-e').on('click', function(e) {
        e.preventDefault()
        $('#btn-weekly-e').removeClass('overview-active')
        $('#btn-annually-e').addClass('overview-active')
        $('#btn-monthly-e').removeClass('overview-active')
        $('#overviewChart_entrance').remove();
        $('#overview-div-e').html('<canvas id="overviewChart_entrance" height="50%" width="100%"></canvas>')
        overview_data_entrance(365)
    })

    $('#btn-print').click(function() {
        window.open("<?php echo e(route('report.print')); ?>")
    })
</script>

</html><?php /**PATH C:\Users\sarah\Desktop\tanawsystem\tanaw-deploy\tanawsystem\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>