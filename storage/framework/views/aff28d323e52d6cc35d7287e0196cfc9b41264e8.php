<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>TANAW Dashboard</title>
    <!-- Favicon-->



    <?php if('user/nearby' === request()->path()): ?>
    <link href="https://api.tiles.mapbox.com/mapbox-gl-js/v2.9.2/mapbox-gl.css" rel="stylesheet" />
    <script src="https://api.tiles.mapbox.com/mapbox-gl-js/v2.9.2/mapbox-gl.js"></script>
    <!-- <script src="https://js.sentry-cdn.com/9c5feb5b248b49f79a585804c259febc.min.js" crossorigin="anonymous"></script> -->
    <?php endif; ?>

    <!-- Core theme CSS (includes Bootstrap) -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <script src="<?php echo e(asset('./assets/js/jquery-3.5.1.js')); ?>"></script>

    <script src="<?php echo e(asset('scripts.js')); ?>" defer></script>
    <script src="<?php echo e(asset('./sweetalert/sweetalert.min.js')); ?>" defer></script>

    <!-- user defined styles -->
    <link rel="stylesheet" href="<?php echo e(asset('./user/style.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        .active-link {
            background-color: rgb(28, 28, 28);
            color: springgreen;
            outline-style: solid;
            outline-color: springgreen;
            outline-width: 2px;
        }

        .list-group-item:hover {
            transition: all .2s;
            background-color: rgb(38, 38, 38);
            color: springgreen;
        }

        .dropdown-item:hover {
            background-color: rgb(38, 38, 38);
            color: springgreen;
        }

        a {
            color: rgb(28, 28, 28);
            text-decoration: none;
        }

        a:hover {
            color: springgreen;
            text-decoration: none;
        }

        .my-border {
            outline: 1px solid transparent;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .my-gradient {
            background: linear-gradient(to top left, #232526 95%, orange 5%);
            color: white;
        }

        .avatar-link {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .avatar {
            background-color: rgba(0, 0, 0, .80);
            color: springgreen;
            border-radius: 100%;
            height: 40px;
            width: 40px;
        }

        .weather-card {
            background-color: rgba(0, 0, 0, .80);

            padding: 10px;
            border-radius: 2px;
            border-radius: 4px;
        }

        .weather {
            font-size: 14px;
            font-weight: bold;
            color: springgreen;
        }

        .image {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .imgClass {
            height: auto;
            width: auto;
        }

        .minValues {
            font-size: 12px;
            color: dodgerblue;
        }

        .maxValues {
            font-size: 12px;
            color: red;
        }

        #status_d1,
        #status_d2,
        #status_d3,
        #status_d4,
        #status_d5 {
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <div class="border-end bg-white shadow-lg" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-light p-5"><a class="text-dark" href="<?php echo e(route('user.dashboard')); ?>" style="text-decoration: none;"><span class="fw-bold">TANAW APP</span></a></div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action p-3 <?php echo e('user/dashboard' === request()->path()? 'active-link' :''); ?>" href="<?php echo e(route('user.dashboard')); ?>"> <i class="bx bxs-dashboard"></i> Dashboard</a>
                <a class="list-group-item list-group-item-action p-3 <?php echo e('user/nearby' === request()->path()? 'active-link' :''); ?>" href="<?php echo e(route('user.nearby')); ?>"><i class=" bx bx-map"></i> Nearby TANAW</a>
                <a class="list-group-item list-group-item-action p-3 <?php echo e('user/tanaw-map' === request()->path()? 'active-link' :''); ?>" href="<?php echo e(route('tanaw.map')); ?>"><i class=" bx bx-map-alt"></i> TANAW Map</a>


                <a class="list-group-item list-group-item-action p-3 <?php echo e('user/entrance' === request()->path()? 'active-link' :''); ?>" href="<?php echo e(route('user.entrance')); ?>"><i class=" bx bx-user-check"></i> Entrance Registration</a>
                <a class="list-group-item list-group-item-action p-3 <?php echo e('user/bookings' === request()->path()? 'active-link' :''); ?>" href="<?php echo e(route('user.bookings')); ?>"><i class=" bx bx-bookmarks"></i> My Bookings</a>
                <a class="list-group-item list-group-item-action p-3 <?php echo e('user/my-payments' === request()->path()? 'active-link' :''); ?>" href="<?php echo e(route('user.payments')); ?>"><i class=" bx bx-credit-card"></i> Recent payments</a>
                <a class="list-group-item list-group-item-action p-3 <?php echo e('user/messages' === request()->path()? 'active-link' :''); ?>" href="<?php echo e(route('user.messages')); ?>"><i class=" bx bx-chat"></i> Send Message <?php if($unread_count > 0): ?> <span class="badge bg-danger"><?php echo e($unread_count); ?></span> <?php endif; ?></a>
            </div>
        </div>

        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Top navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <span id="sidebarToggle" style="cursor: pointer;"> <i class="bx bx-menu fs-4"></i></span>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="avatar p-3 py-2 text-center m-2"><?php echo e($userdata->name[0]); ?></span><?php echo e($userdata->name); ?></a>
                                <div class="dropdown-menu dropdown-menu-end p-2" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" id="btn-notifications"><i class="bx bx-bell"></i> Notifications <?php if($notifications > 0): ?> <span class="badge bg-danger"><?php echo e($notifications); ?></span> <?php endif; ?></a>
                                    <a class="dropdown-item <?php echo e('user/setting' === request()->path()? 'active-link' :''); ?>" href="<?php echo e(route('user.setting')); ?>"> <i class="bx bx-cog"></i> Account setting</a>
                                    <div class="dropdown-divider"></div>
                                    <form action="<?php echo e(route('logout')); ?>" id="form-logout" method="post">
                                        <?php echo csrf_field(); ?>
                                        <button type="button" class="dropdown-item d-flex align-items-center" id="btn-logout"><i class="bx bx-log-out"></i> Sign out</button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

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
            <script>
                function load_notification() {

                    $.ajax({
                        url: "<?php echo e(route('user.notification')); ?>",
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
                    var route_ = "<?php echo e(route('user.notification.update',':id')); ?>"
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
                    var route_delete = "<?php echo e(route('user.notification.delete',':id')); ?>"
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

                $('#notification-container').on('click', '.btn-delete-notif', function() {
                    delete_notification($(this)[0].dataset.id)
                })

                $('#notification-container').on('click', '.btn-mark-notif', function() {
                    update_notification($(this)[0].dataset.id)
                })

                $('#btn-notifications').click(function() {
                    $('#notification-modal').modal('show')
                    load_notification()
                })
            </script>

            <?php if(!empty($eligible) && $eligible === true): ?>

            <link rel="stylesheet" href="<?php echo e(asset('user/rating.css')); ?>" />

            <!-- Rating modal -->
            <div class="modal fade" id="rating-modal" tabindex="-1" aria-labelledby="modal-label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="p-2">
                                            <h3 class="text-center">How was your experienced with us?</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="star_container">
                                                    <div class="star-widget">
                                                        <input type="radio" class="rating" name="rate" id="rate-5" value="excellent">
                                                        <label for="rate-5" class="fas fa-star"></label>

                                                        <input type="radio" class="rating" name="rate" id="rate-4" value="great">
                                                        <label for="rate-4" class="fas fa-star"></label>

                                                        <input type="radio" class="rating" name="rate" id="rate-3" value="good">
                                                        <label for="rate-3" class="fas fa-star"></label>

                                                        <input type="radio" class="rating" name="rate" id="rate-2" value="poor">
                                                        <label for="rate-2" class="fas fa-star"></label>
                                                        <input type="radio" class="rating" name="rate" id="rate-1" value="terrible">
                                                        <label for="rate-1" class="fas fa-star"></label>
                                                        <form action="#">
                                                            <header class="text-center"></header>
                                                            <input type="hidden" id="feedback">

                                                            <div class="text-center">

                                                                <button type="button" id="btn-send-rating" class="btn btn-sm btn-primary mx-auto">Submit</button>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>
                                                <input type="text" name="comment" id="comment" placeholder="Comment/suggestion" class="mt-3 form-control">
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
                $(document).ready(function() {
                    $('#rating-modal').modal('show')
                })

                const btn = document.querySelector("button");
                const post = document.querySelector(".post");
                const widget = document.querySelector(".star-widget");
                const editBtn = document.querySelector(".edit");

                var feedback = document.querySelector('#feedback');
                btn.onclick = () => {
                    widget.style.display = "none";
                    post.style.display = "block";
                    // editBtn.onclick = () => {
                    //     widget.style.display = "block";
                    //     post.style.display = "none";
                    // }
                    return false;
                }


                $('.star-widget').on('change', '.rating', function() {
                    $('#feedback').val($(this).val())
                })


                $('#btn-send-rating').on('click', function(e) {
                    e.preventDefault()
                    $.ajax({
                        url: "<?php echo e(route('rating.store')); ?>",
                        type: 'post',
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>',
                            feedback: $('#feedback').val(),
                            comment: $('#comment').val()
                        },
                        dataType: 'json',
                        beforeSend: function() {

                        }
                    }).done(function(data) {
                        if (data.status == 200) {
                            $('#rating-modal').modal('hide')
                            Swal.fire(
                                'Success',
                                data.msg,
                                'success'
                            )
                        }
                    }).fail(function(e) {
                        Swal.fire(
                            'Error',
                            'error in sending feedback',
                            'error'
                        )
                    })
                })
            </script>
            <?php endif; ?>



            <!-- Page content-->
            <div class="container-fluid">

                <?php if('user/setting' === request()->path()): ?>
                <?php echo $__env->yieldContent('setting'); ?>
                <?php endif; ?>


                <?php if('user/messages' === request()->path()): ?>
                <?php echo $__env->yieldContent('messages'); ?>
                <?php endif; ?>

                <?php if('user/bookings' === request()->path()): ?>
                <?php echo $__env->yieldContent('booking'); ?>
                <?php endif; ?>

                <?php if('user/nearby' === request()->path()): ?>
                <?php echo $__env->yieldContent('nearby'); ?>
                <?php endif; ?>

                <?php if('user/my-payments' === request()->path()): ?>
                <?php echo $__env->yieldContent('payments'); ?>
                <?php endif; ?>

                <?php if('user/entrance' === request()->path()): ?>
                <?php echo $__env->yieldContent('entrance'); ?>
                <?php endif; ?>

                <?php if('user/tanaw-map' === request()->path()): ?>
                <?php echo $__env->yieldContent('tanaw'); ?>
                <?php endif; ?>

                <?php if(count($rooms) > 0): ?>

                <?php if('user/view-room/'.$rooms[0]->room_no === request()->path()): ?>
                <?php echo $__env->yieldContent('room_info'); ?>
                <?php endif; ?>

                <?php if('user/check-in-form/'.$rooms[0]->room_no === request()->path()): ?>
                <?php echo $__env->yieldContent('check_in_form'); ?>
                <?php endif; ?>


                <?php endif; ?>

                <?php if('user/dashboard' === request()->path()): ?>

                <div class="row p-5" style="background-color: #f2f2f2;">

                    <div class="col-lg-12 mb-3">

                        <div class="card shadow-sm p-4">
                            <div class="d-flex flex-column">
                                <h1 class="text-dark"><?php echo e(now()->format(' jS \of F, Y.  g:i  A')); ?></h5>
                                    <p style="font-size:12px;" class="text-muted">Weather forecast for TANAW, Rizal Laguna.</p>

                            </div>
                            <div class="row">
                                <div class="col-lg-2 col-md-2 mb-2">
                                    <div class="weather-card h-100">
                                        <p class="weather" id="day1">Weather 1</p>
                                        <p id="day01" class="text-warning" style="font-size: 12px;">Loading...</p>
                                        <div class="image"><img src="dots.png" class="imgClass" id="img1"></div>
                                        <p id="status_d1" class="text-white text-center">Loading..</p>
                                        <div class="d-flex justify-content-between">
                                            <p class="minValues" id="day1Min">Loading...</p>
                                            <p class="maxValues" id="day1Max">Loading...</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-2 mb-2">
                                    <div class="weather-card h-100">
                                        <p class="weather" id="day2">Weather 2</p>
                                        <p id="day02" class="text-warning" style="font-size: 12px;">Loading...</p>
                                        <div class="image"><img src="dots.png" class="imgClass" id="img2"></div>
                                        <p id="status_d2" class="text-white text-center">Loading..</p>
                                        <div class="d-flex justify-content-between">
                                            <p class="minValues" id="day2Min">Loading...</p>
                                            <p class="maxValues" id="day2Max">Loading...</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-2 mb-2">
                                    <div class="weather-card h-100">
                                        <p class="weather" id="day3">Weather 3</p>
                                        <p id="day03" class="text-warning" style="font-size: 12px;">Loading...</p>
                                        <div class="image"><img src="dots.png" class="imgClass" id="img3"></div>
                                        <p id="status_d3" class="text-white text-center">Loading..</p>
                                        <div class="d-flex justify-content-between">
                                            <p class="minValues" id="day3Min">Loading...</p>
                                            <p class="maxValues" id="day3Max">Loading...</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-2 mb-2">
                                    <div class="weather-card h-100">
                                        <p class="weather" id="day4">Weather 4</p>
                                        <p id="day04" class="text-warning" style="font-size: 12px;">Loading...</p>
                                        <div class="image"><img src="dots.png" class="imgClass" id="img4"></div>
                                        <p id="status_d4" class="text-white text-center">Loading..</p>
                                        <div class="d-flex justify-content-between">
                                            <p class="minValues" id="day4Min">Loading...</p>
                                            <p class="maxValues" id="day4Max">Loading...</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-2 col-md-2 mb-2">
                                    <div class="weather-card h-100">
                                        <p class="weather" id="day5">Weather 5</p>
                                        <p id="day05" class="text-warning" style="font-size: 12px;">Loading...</p>
                                        <div class="image"><img src="dots.png" class="imgClass" id="img5"></div>
                                        <p id="status_d5" class="text-white text-center">Loading..</p>
                                        <div class="d-flex justify-content-between">
                                            <p class="minValues" id="day5Min">Loading...</p>
                                            <p class="maxValues" id="day5Max">Loading...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-3 mb-3 ">
                        <div class="my-gradient h-100 my-border p-4 d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-column">
                                <h5>REGISTRATIONS</h5>
                                <p style="font-size: 12px;color:springgreen;">Total no. of registrations made. <span class="text-white"><?php echo e($dashboard_data['registration']); ?></span></p>

                            </div>
                            <i class="bx bx-credit-card fs-1 text-white"></i>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-3 mb-3">
                        <div class="my-gradient h-100 my-border p-4 d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-column">
                                <h5>MY BOOKINGS</h5>
                                <p style="font-size: 12px; color:springgreen;">Total no. of bookings made. <span class="text-white"><?php echo e($dashboard_data['bookings']); ?></span></p>
                            </div>
                            <i class="bx bx-bookmarks fs-1 text-white"></i>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-3 mb-3">
                        <div class="my-gradient h-100 my-border p-4 d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-column">
                                <h5>NEARBY</h5>
                                <p style="font-size: 12px;color:springgreen;">Other things to do in Rizal. <span class="text-white"><?php echo e($dashboard_data['nearby']); ?></span></p>
                            </div>
                            <i class="bx bx-map fs-1 text-white"></i>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-3 mb-3">
                        <div class="my-gradient h-100 my-border p-4 d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-column">
                                <h5>NOTIFICATIONS</h5>
                                <p style="font-size: 12px;color:springgreen;">My notifications. <span class="text-white"><?php echo e($dashboard_data['notifications']); ?></span></p>
                            </div>
                            <i class="bx bx-bell fs-1 text-white"></i>
                        </div>
                    </div>
                    <?php if(count($rooms) > 0): ?>
                    <div class="col-lg-12 mt-2">
                        <h2 class="fw-bold">Available rooms in TANAW.</h4>
                            <!-- <span class="badge bg-dark mb-2">4-5 person</span>
                            <span class="badge bg-dark mb-2">6-10 person</span>
                            <span class="badge bg-dark mb-2">10+ person</span> -->
                            <div class="room-container row p-4">
                                <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-6 col-lg-4 mb-4 mt-2">
                                    <div class="room-card h-100 p-5 d-flex flex-column">
                                        <h5 class="text-white">Room no. <?php echo e($room->room_no); ?></h5>
                                        <span class="text-info" style="font-size: 12px;"><i class="bx bx-check text-success"></i> Available</span>
                                        <span class="text-warning" style="font-size: 12px;"><i class="bx bx-check text-success"></i> <?php echo e($room->min .'-'. $room->max); ?> person.</span>
                                        <a class="btn-book-now mt-4" data-id="<?php echo e($room->room_no); ?>"> Book now</a>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                    </div>
                    <script>
                        $(document).ready(function() {

                            $('.room-card').on('click', '.btn-book-now', function() {
                                var route = "<?php echo e(route('user.roominfo',':id')); ?>"
                                window.location.replace(route.replace(':id', $(this)[0].dataset.id))
                            })
                        })
                    </script>
                    <?php else: ?>
                    <p>There is no available rooms right now.</p>
                    <?php endif; ?>
                </div>

                <script>
                    function Getweather(location) {


                        //'https://api.openweathermap.org/data/2.5/forecast?q=' + location + '&appid=c9f2891045f75f44aa5f6722671a3f19'
                        const apikey = 'c9f2891045f75f44aa5f6722671a3f19'
                        fetch('https://api.openweathermap.org/data/2.5/forecast?q=' + location + '&appid=c9f2891045f75f44aa5f6722671a3f19')
                            .then(response => response.json())
                            .then(data => {
                                console.log(data)
                                //Getting the min and max values for each day
                                for (i = 0; i < 5; i++) {
                                    document.getElementById("day1" + "Min").innerHTML = "Min: " + Number(data.list[0].main.temp_min - 273.15).toFixed(1) + "°";
                                    document.getElementById("day2" + "Min").innerHTML = "Min: " + Number(data.list[3].main.temp_min - 273.15).toFixed(1) + "°";
                                    document.getElementById("day3" + "Min").innerHTML = "Min: " + Number(data.list[11].main.temp_min - 273.15).toFixed(1) + "°";
                                    document.getElementById("day4" + "Min").innerHTML = "Min: " + Number(data.list[19].main.temp_min - 273.15).toFixed(1) + "°";
                                    document.getElementById("day5" + "Min").innerHTML = "Min: " + Number(data.list[28].main.temp_min - 273.15).toFixed(1) + "°";
                                    //Number(1.3450001).toFixed(2); // 1.35
                                }

                                for (i = 0; i < 5; i++) {
                                    document.getElementById("day1" + "Max").innerHTML = "Max: " + Number(data.list[2].main.temp_max - 273.15).toFixed(2) + "°";
                                    document.getElementById("day2" + "Max").innerHTML = "Max: " + Number(data.list[4].main.temp_max - 273.15).toFixed(2) + "°";
                                    document.getElementById("day3" + "Max").innerHTML = "Max: " + Number(data.list[11].main.temp_max - 273.15).toFixed(2) + "°";
                                    document.getElementById("day4" + "Max").innerHTML = "Max: " + Number(data.list[20].main.temp_max - 273.15).toFixed(2) + "°";
                                    document.getElementById("day5" + "Max").innerHTML = "Max: " + Number(data.list[28].main.temp_max - 273.15).toFixed(2) + "°";
                                }
                                //------------------------------------------------------------

                                //Getting Weather Icons
                                for (i = 0; i < 5; i++) {
                                    document.getElementById("img1").src = "http://openweathermap.org/img/wn/" +
                                        data.list[2].weather[0].icon +
                                        ".png";

                                    document.getElementById("img2").src = "http://openweathermap.org/img/wn/" +
                                        data.list[3].weather[0].icon +
                                        ".png";

                                    document.getElementById("img3").src = "http://openweathermap.org/img/wn/" +
                                        data.list[11].weather[0].icon +
                                        ".png";

                                    document.getElementById("img4").src = "http://openweathermap.org/img/wn/" +
                                        data.list[19].weather[0].icon +
                                        ".png";

                                    document.getElementById("img5").src = "http://openweathermap.org/img/wn/" +
                                        data.list[28].weather[0].icon +
                                        ".png";
                                    document.querySelector('#status_d1').innerHTML = data.list[2].weather[0].description
                                    document.querySelector('#status_d2').innerHTML = data.list[3].weather[0].description
                                    document.querySelector('#status_d3').innerHTML = data.list[11].weather[0].description
                                    document.querySelector('#status_d4').innerHTML = data.list[19].weather[0].description
                                    document.querySelector('#status_d5').innerHTML = data.list[28].weather[0].description
                                }
                                //------------------------------------------------------------



                            })

                            .catch(err => alert("Something Went Wrong: Try Checking Your Internet Coneciton"))
                    }



                    //Getting and displaying the text for the upcoming five days of the week
                    var d = new Date();
                    var weekday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", ];

                    var day_1 = new Date()
                    var day_2 = new Date()
                    var day_3 = new Date()
                    var day_4 = new Date()
                    var day_5 = new Date()

                    day_1.setDate(day_1.getDate())
                    day_2.setDate(day_2.getDate() + 1)
                    day_3.setDate(day_3.getDate() + 2)
                    day_4.setDate(day_4.getDate() + 3)
                    day_5.setDate(day_5.getDate() + 4)

                    document.querySelector('#day01').innerHTML = day_1.toDateString()
                    document.querySelector('#day02').innerHTML = day_2.toDateString()
                    document.querySelector('#day03').innerHTML = day_3.toDateString()
                    document.querySelector('#day04').innerHTML = day_4.toDateString()
                    document.querySelector('#day05').innerHTML = day_5.toDateString()


                    //Function to get the correct integer for the index of the days array
                    function CheckDay(day) {
                        if (day + d.getDay() > 6) {
                            return day + d.getDay() - 7;
                        } else {
                            return day + d.getDay();
                        }
                    }
                    for (i = 0; i < 5; i++) {
                        document.getElementById("day" + (i + 1)).innerHTML = weekday[CheckDay(i)];
                    }
                    //------------------------------------------------------------
                    Getweather('Nagcarlan,Laguna')
                </script>
                <?php endif; ?>

            </div>
        </div>
    </div>
    <!-- Bootstrap core JS-->
</body>

<script>
    $(document).ready(function() {
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
</script>

</html><?php /**PATH C:\Users\sarah\Desktop\tanawsystem\tanaw-deploy\tanawsystem\resources\views/user/dashboard.blade.php ENDPATH**/ ?>