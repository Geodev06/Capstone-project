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
    <link href="<?php echo e(asset('./assets/bs/css/bootstrap.min.css')); ?>" rel="stylesheet" />

    <script src="<?php echo e(asset('./assets/bs/js/bootstrap.min.js')); ?>"></script>
    <link rel="stylesheet" href="<?php echo e(asset('./assets/bs/boxicons.min.css')); ?>" />
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
                            <a class="dropdown-item d-flex align-items-center <?php echo e('u/admin/manage-establishments'=== request()->path() ? 'active' :''); ?>" href="<?php echo e(route('admin.manage_content')); ?>"><i class='bx bx-book-content'></i> Contents</a>
                        </div>
                    </div>

                    <div class="dropdown">
                        <a class="btn text-white dropdown-toggle" href="#" role="button" id="dm" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo e($userdata->name); ?>

                        </a>
                        <div class="dropdown-menu p-2" aria-labelledby="dm">
                            <div class="dropdown-header">Account</div>
                            <a class="dropdown-item d-flex align-items-center <?php echo e('u/admin/setting'=== request()->path() ? 'active' :''); ?>" href="<?php echo e(route('admin.setting')); ?>"><i class="bx bx-cog"></i> Setting</a>
                            <a class="dropdown-item d-flex align-items-center "><i class="bx bx-bell"></i> Notifications</a>
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
                                <h4>0</h4>
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
                                        <td><span class="badge" style="background-color: seagreen;"><?php echo e($payment->payment_status); ?></span></td>
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
                                        <td><span class="badge" style="background-color: seagreen;"><?php echo e($payment->payment_status); ?></span></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-12 mb-2">
                    <div class="my-card border rounded p-2">
                        <h1 class="fs-6 mb-2">Revenue</h1>
                        <div class="d-flex">
                            <span class="btn-overview overview-active" id="btn-weekly">Weekly</span>
                            <span class="btn-overview" id="btn-monthly">Monthly</span>
                            <span class="btn-overview" id="btn-annually">Annually</span>
                        </div>
                        <div id="overview-div">
                            <canvas id="overviewChart" height="60%" width="100%"></canvas>
                        </div>
                    </div>
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
        </div>
    </section>



</body>

<script>
    $(document).ready(function() {

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
                    fill: false
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
</script>

</html><?php /**PATH C:\xampp\htdocs\tanawsystem\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>