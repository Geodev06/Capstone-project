<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Tanaw de Rizal Park" />
    <meta name="author" content="" />
    <title>Tanaw</title>
    <!-- Favicon-->
    <!-- Bootstrap icons-->

    <link href="https://api.tiles.mapbox.com/mapbox-gl-js/v2.9.2/mapbox-gl.css" rel="stylesheet" />
    <script src="https://api.tiles.mapbox.com/mapbox-gl-js/v2.9.2/mapbox-gl.js"></script>


    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <link rel="stylesheet" href="<?php echo e(asset('styles.css')); ?>" />
    <script src="<?php echo e(asset('./assets/js/jquery-3.5.1.js')); ?>"></script>

    <script src="<?php echo e(asset('scripts.js')); ?>" defer></script>
    <script src="<?php echo e(asset('./sweetalert/sweetalert.min.js')); ?>" defer></script>

    <!-- AOS -->
    <link rel="stylesheet" href="<?php echo e(asset('./aos/aos.css')); ?>" />
    <script src="<?php echo e(asset('./aos/aos.js')); ?>"></script>

    <style>
        .marquee-wrapper {
            background: transparent;
            text-align: center;
        }

        .marquee-wrapper .container {
            overflow: hidden;
        }

        .marquee-inner span {
            float: left;
            width: 50%;
        }

        .marquee-wrapper .marquee-block {
            --total-marquee-items: 5;
            height: 200px;
            width: calc(250px * (var(--total-marquee-items)));
            overflow: hidden;
            box-sizing: border-box;
            position: relative;
            margin: 20px auto;
            background: transparent;
            padding: 30px 0;
        }

        .marquee-inner {
            display: block;
            width: 200%;
            position: absolute;
            height: auto;
        }

        .marquee-inner p {
            font-weight: 800;
            font-size: 14px;
            color: rgb(45, 45, 45);

        }

        .marquee-inner.to-left {
            animation: marqueeLeft 25s linear infinite;
        }

        .marquee-inner.to-right {
            animation: marqueeRight 25s linear infinite;
        }

        .marquee-item {
            width: 230px;
            height: 200px;
            display: inline-block;
            margin: 0 10px;
            float: left;
            transition: all .2s ease-out;
            background: gainsboro;
        }

        @keyframes  marqueeLeft {
            0% {
                left: 0;
            }

            100% {
                left: -100%;
            }
        }

        @keyframes  marqueeRight {
            0% {
                left: -100%;
            }

            100% {
                left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg p-4 my-nav sticky-top">
        <div class="container px-5">
            <p class="my-logo">LOGO | <i class="bx bxl-facebook"></i> <i class="bx bxl-instagram"></i> <i class="bx bxl-gmail"></i></p>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link <?php echo e('/' === request()->path() ? 'active': ''); ?>" aria-current="page" href="<?php echo e(route('index')); ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link " href="#todo">Things to do</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About TANAW</a></li>
                    <li class="nav-item"><a class="nav-link" href="#nearby">Nearby</a></li>
                    <li class="nav-item"><a class="nav-link" href="#findus">Find us</a></li>

                </ul>
            </div>
        </div>
    </nav>
    <!-- Header-->
    <header class="py-5 my-header">
        <div class="container px-5">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-7">
                    <div class="text-center text-white my-5">
                        <div class="header-container">
                            <h1 class="display-5 fw-bold text-white mb-2">TANAW de Rizal Park</h1>
                            <p class=" mb-4 text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna cum laude aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                                <a class="btn-green px-4 me-sm-3" href="<?php echo e(route('login')); ?>">Book Now</a>
                                <a class="btn-transparent px-4" href="#features">Learn More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- FEATURES -->
    <?php if(count($contents) > 0): ?>
    <section class="feature-section bg-white" id="features">
        <div class="container">
            <div class="row">
                <div class="mt-5 text-center">
                    <h1 class="fw-bold">What TANAW offers.</h1>
                    <p class="fw-light px-3"></p>
                </div>
                <?php $__currentLoopData = $contents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-3 col-lg-3 mx-auto p-5" data-aos="fade-up" data-aos-offset="200" data-aos-delay="(300)+100">
                    <div class="h-100">
                        <img src="<?php echo e(asset($content->image)); ?>" alt="<?php echo e(asset($content->image)); ?>" height="160px" width="100%">
                        <div class="p-3">
                            <h4 class="fw-bold"><?php echo e($content->title); ?></h4>
                            <p><?php echo e($content->content); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </div>
    </section>
    <script>
        AOS.init()
    </script>
    <?php endif; ?>
    <!-- END FEATURES -->


    <!-- TODO -->
    <?php if(count($todos) > 0): ?>
    <section data-aos="fade-up" class="todo-section" id="todo">
        <div class="container">
            <div class="row">
                <div class="mt-5 text-center p-5">
                    <h1 class="fw-bold">Things to do in TANAW.</h1>
                    <p class="fw-light px-3"></p>
                </div>
                <?php $__currentLoopData = $todos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $todo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-sm-12 col-md-4 col-lg-4 mx-auto p-5" data-aos="fade-right" data-aos-offset="200" data-aos-delay="300">
                    <div class="h-100 p-4">
                        <img src="<?php echo e(asset($todo->image)); ?>" alt="<?php echo e(asset($todo->image)); ?>" height="100px" width="100%">
                        <div class="p-3 ">
                            <h4 class="fw-bold text-dark"><?php echo e($todo->title); ?></h4>
                            <p class="text-muted"><?php echo e($todo->content); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </div>
    </section>
    <script>
        AOS.init()
    </script>
    <?php endif; ?>
    <!-- END TODO -->


    <!-- ABOUT -->
    <?php if(count($abouts) > 0): ?>
    <section data-aos="fade-up" class="about-section-x" id="about">
        <div class="container">
            <div class="row">
                <div class="mt-5 text-center">
                    <h1 class="fw-bold p-5">About TANAW.</h1>
                    <p class="fw-light px-3"></p>
                </div>
                <?php $__currentLoopData = $abouts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $about): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-sm-12 col-md-4 col-lg-4 mx-auto p-5" data-aos="fade-right" data-aos-offset="200" data-aos-delay="300">
                    <div class="h-100 p-4 about-card">
                        <img src="<?php echo e(asset($about->image)); ?>" alt="<?php echo e(asset($about->image)); ?>" height="100px" width="100%">
                        <div class="p-3 ">
                            <h4 class="fw-bold text-dark"><?php echo e($about->title); ?></h4>
                            <p class="text-muted"><?php echo e($about->content); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
    <script>
        AOS.init()
    </script>
    <?php endif; ?>
    <!-- END ABOUT -->

    <!-- ABOUT -->
    <?php if(count($establishment) > 0): ?>
    <section class="nearby-section" id="nearby">
        <div class="container">
            <div class="row">
                <div class="mt-5 text-center">
                    <h1 class="fw-bold">What's Nearby TANAW.</h1>
                    <p class="fw-light px-3"></p>
                </div>
                <div class="col-lg-4 col-md-5" data-aos="fade-right" data-aos-offset="200" data-aos-delay="300">
                    <h6>Establishments list's</h6>
                    <input type="text" name="search" id="search" class="txt-search" placeholder="search">
                    <div class="list-container" id="establishment_list">
                        <!-- content goes heere -->

                    </div>
                </div>

                <div class=" col-lg-8 col-md-7">
                    <div id="map" style="height: 480px; width:100%;"></div>
                    <div id=" instructions"></div>
                </div>
            </div>
        </div>

        <!-- Establishment modal -->
        <div class="modal fade" id="est_modal" tabindex="-1" aria-labelledby="modal-label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="p-2">
                                        <h3>Establishment details</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="col-md-12">
                                                <span class="fw-bold text-secondary">Establishment name:</span>
                                                <p id="est_name">Loading...</p>
                                            </div>

                                            <div class="col-md-12">
                                                <span class="fw-bold text-secondary">Establishment address:</span>
                                                <p id="est_address">Loading...</p>
                                            </div>

                                            <div class="col-md-12">
                                                <span class="fw-bold text-secondary">Contact:</span>
                                                <p id="est_contact">Loading...</p>
                                            </div>

                                            <div class="col-md-12">
                                                <span class="fw-bold text-secondary">Email:</span>
                                                <p id="est_email">Loading...</p>
                                            </div>

                                            <div class="col-md-12">
                                                <span class="fw-bold text-secondary">Schedules:</span>
                                                <p id="est_sched">Loading...</p>
                                            </div>

                                            <div class="col-md-12 d-flex justify-content-between">
                                                <div>
                                                    <span class="fw-bold text-secondary">Open</span>
                                                    <p id="est_open">Loading...</p>
                                                </div>

                                                <div>
                                                    <span class="fw-bold text-secondary">Close</span>
                                                    <p id="est_close">Loading...</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <!-- images -->
                                            <div id="img_container"></div>
                                        </div>
                                    </div>
                                    <div class="text-center mt-4">
                                        <button class="btn btn-primary btn-sm" id="btn_close_modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End modal -->
    </section>
    <script>
        AOS.init()

        function load_establishments(value) {
            var route = "<?php echo e(route('establishment.guest',':value')); ?>";
            $.ajax({
                url: route.replace(':value', value),
                type: 'post',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    search: value
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#establishment_list').html('<p>fecthing data...</p>')
                }
            }).done(function(data) {
                $('#establishment_list').html(data.data)
            }).fail(function(e) {
                alert('Error in fetching some data.')
            })
        }
        load_establishments()

        $('#search').on('keyup', function() {
            load_establishments($(this).val())
        })
        // load images
        function load_images(id) {
            var route = "<?php echo e(route('establishment.get.json.images',':id')); ?>";
            $.ajax({
                url: route.replace(':id', id),
                type: 'get',
                dataType: 'json',
                beforeSend: function() {
                    $('#img_container').html('<p>fecthing data...</p>')
                }
            }).done(function(data) {
                console.log(data)
                $('#img_container').html(data.image)
            }).fail(function(e) {
                alert('Error in fetching some data.')
            })
        }

        //click on the list
        $('#establishment_list').on('click', '.btn-est', function() {

            $('#est_modal').modal('show')

            var route = "<?php echo e(route('establishment.get.json',':id')); ?>";
            $.ajax({
                url: route.replace(':id', $(this)[0].dataset.id),
                type: 'get',
                dataType: 'json',
                beforeSend: function() {

                }
            }).done(function(data) {
                console.log(data)
                $('#est_name').text(data.data[0].establishment_name)
                $('#est_address').text(data.data[0].establishment_address)
                $('#est_contact').text(data.data[0].contact)
                $('#est_email').text(data.data[0].email)
                $('#est_sched').text(data.data[0].schedule)
                $('#est_open').text(data.data[0].open)
                $('#est_close').text(data.data[0].close)

                load_images(data.data[0].id)

            }).fail(function(e) {
                alert('Error in fetching some data.')
            })
        })

        $('#btn_close_modal').on('click', function() {
            $('#est_modal').modal('hide')
        })
        //map scripts
        $(document).ready(function() {


            if (navigator.geolocation) {

                navigator.geolocation.getCurrentPosition(function(location) {



                    mapboxgl.accessToken = 'pk.eyJ1IjoiYWdlb2Fnbm90ZSIsImEiOiJjbDloNjZqOTAxOGxyM3FteTIyNHRmMzZ2In0.oLZTFCvyiwBCxI__Xs6ZcQ';
                    const map = new mapboxgl.Map({
                        container: 'map', // container id
                        style: 'mapbox://styles/mapbox/streets-v11', // stylesheet location
                        center: [location.coords.longitude, location.coords.latitude], // starting position
                        zoom: 15 // starting zoom
                    });


                    map.addControl(new mapboxgl.NavigationControl());

                    map.addControl(new mapboxgl.GeolocateControl({
                        positionOptions: {
                            enableHighAccuracy: true
                        },
                        trackUserLocation: true,
                        showUserHeading: true
                    }))



                    const start = [location.coords.longitude, location.coords.latitude];
                    const end = [$(this).attr('lon'), $(this).attr('lat')];

                    // create a function to make a directions request
                    async function getRoute(start, end) {
                        // make directions request using cycling profile
                        const query = await fetch(
                            `https://api.mapbox.com/directions/v5/mapbox/driving/${start[0]},${start[1]};${end[0]},${end[1]}?steps=true&geometries=geojson&access_token=${mapboxgl.accessToken}`, {
                                method: 'GET'
                            }
                        );
                        const json = await query.json();
                        const data = json.routes[0];
                        const route = data.geometry.coordinates;
                        const geojson = {
                            'type': 'Feature',
                            'properties': {},
                            'geometry': {
                                'type': 'LineString',
                                'coordinates': route
                            }
                        };
                        // if the route already exists on the map, we'll reset it using setData

                        // if the route already exists on the map, we'll reset it using setData
                        if (map.getSource('route')) {
                            map.getSource('route').setData(geojson);
                        }
                        // otherwise, we'll make a new request
                        else {
                            map.addLayer({
                                'id': 'route',
                                'type': 'line',
                                'source': {
                                    'type': 'geojson',
                                    'data': geojson
                                },
                                'layout': {
                                    'line-join': 'round',
                                    'line-cap': 'round'
                                },
                                'paint': {
                                    'line-color': 'dodgerblue',
                                    'line-width': 5,
                                    'line-opacity': 0.75
                                }
                            });
                        }

                        // get the sidebar and add the instructions
                        const instructions = document.getElementById('instructions');

                        const steps = data.legs[0].steps;

                        let tripInstructions = '';
                        for (const step of steps) {
                            tripInstructions += `<li>${step.maneuver.instruction}</li>`;
                        }
                        instructions.innerHTML = `<p><strong>Trip duration: ${Math.floor(
          data.duration / 60
        )} mins </strong></p><ol>${tripInstructions}</ol>`;
                    }


                    const Popup = new mapboxgl.Popup({
                            closeOnClick: false
                        })
                        .setHTML('<div class="p-3 text-dark d-flex flex-column"><span>You are here!</span></div>')
                        .addTo(map);



                    const current = new mapboxgl.Marker({
                        color: 'blue'
                    });

                    current.setLngLat(start).setPopup(Popup).addTo(map);

                    $.ajax({
                        url: "<?php echo e(route('get_est')); ?>",
                        type: 'get',
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        beforeSend: function() {},
                        success: function(data) {

                            if (data.status == 200) {
                                console.log(data.data)
                                data.data.map(function(val, i) {

                                    var Estpopup = new mapboxgl.Popup({
                                            closeOnClick: false
                                        })
                                        .setHTML('<div class="p-3 text-dark">' + val.establishment_name + '<div> <ul><li>' + val.establishment_address + '</li><li>' + val.email + '</li></ul></div><button data-lon="' + val.long + '" data-lat="' + val.lat + '" class="btn-destination btn btn-sm btn-primary">Show route</button></div>')
                                        .addTo(map);
                                    const destination = new mapboxgl.Marker({
                                        color: 'seagreen'
                                    });
                                    destination.setLngLat([val.long, val.lat]).setPopup(Estpopup).addTo(map);
                                })
                            }
                        },
                        error: function(e) {
                            Alertmsg('Failed', 'Something went wrong!', 'error')
                        }
                    });

                    $('#establishment_list').on('mouseover', '.btn-est', function() {
                        map.flyTo({
                            center: [$(this)[0].dataset.lon, $(this)[0].dataset.lat]
                        })
                    })

                    $('#map').on('click', '.btn-destination', function(e) {
                        var coords = [$(this)[0].dataset.lon, $(this)[0].dataset.lat]

                        getRoute(start, coords)
                        const end = {
                            'type': 'FeatureCollection',
                            'features': [{
                                'type': 'Feature',
                                'properties': {},
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': coords
                                }
                            }]
                        }
                        if (map.getLayer('end')) {
                            map.getSource('end').setData(end);
                        } else {
                            map.addLayer({
                                'id': 'end',
                                'type': 'circle',
                                'source': {
                                    'type': 'geojson',
                                    'data': {
                                        'type': 'FeatureCollection',
                                        'features': [{
                                            'type': 'Feature',
                                            'properties': {},
                                            'geometry': {
                                                'type': 'Point',
                                                'coordinates': coords
                                            }
                                        }]
                                    }
                                },
                                'paint': {
                                    'circle-radius': 10,
                                    'circle-color': 'seagreen'
                                }
                            });
                        }
                    })


                    map.on('load', () => {
                        // make an initial directions request that
                        // starts and ends at the same location
                        // getRoute(start, end);

                        // Add destination to the map
                        map.addLayer({
                            'id': 'point',
                            'type': 'circle',
                            'source': {
                                'type': 'geojson',
                                'data': {
                                    'type': 'FeatureCollection',
                                    'features': [{
                                        'type': 'Feature',
                                        'properties': {},
                                        'geometry': {
                                            'type': 'Point',
                                            'coordinates': start
                                        }
                                    }]
                                }
                            },
                            'paint': {
                                'circle-radius': 10,
                                'circle-color': 'blue'
                            }
                        });

                        map.addLayer({
                            'id': 'end',
                            'type': 'circle',
                            'source': {
                                'type': 'geojson',
                                'data': {
                                    'type': 'FeatureCollection',
                                    'features': [{
                                        'type': 'Feature',
                                        'properties': {},
                                        'geometry': {
                                            'type': 'Point',
                                            'coordinates': end
                                        }
                                    }]
                                }
                            },
                            'paint': {
                                'circle-radius': 10,
                                'circle-color': 'seagreen'
                            }
                        });
                    });


                })
            }
        })
    </script>
    <?php endif; ?>
    <!-- END NEARBY -->

    <!-- feedback -->
    <?php if($rating_count >= 5): ?>
    <div class="" id="feedback">
        <div class="p-5 bg-light">

            <div class="marquee-wrapper">
                <div class="container">
                    <div class="text-center">
                        <h5>Our ratings</h5>
                    </div>
                    <div class="marquee-block">
                        <div class="marquee-inner to-right">

                            <span id="marquee-container">


                            </span>

                            <span id="marquee-container-2">


                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function load_ratings() {

                $.ajax({
                    url: "<?php echo e(route('layout.ratings')); ?>",
                    type: 'get',
                    dataType: 'json',
                    beforeSend: function() {}
                }).done(function(data) {
                    if (data.status == 200) {
                        $('#marquee-container').html(data.content)
                        $('#marquee-container-2').html(data.content)
                        console.log(data.content)
                    }
                }).fail(function(e) {

                })
            }

            load_ratings()
        </script>
    </div>

    <?php endif; ?>

    <?php if(count($admin) > 0): ?>
    <section class="findus-section bg-white" id="findus">
        <div class="container">
            <div class="row">
                <div class="mt-5 text-center">
                    <h1 class="fw-bold">Find us.</h1>
                    <p class="fw-light px-3"></p>
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-7 col-md-8">
                            <div id="map_find_us" style="height: 300px; width:100%"></div>
                        </div>
                        <div class="col-lg-5 col-md-4 p-5" data-aos="fade-left" data-aos-offset="200" data-aos-delay="300">
                            <h5 class="mb-3">Contact information</h5>
                            <div class="d-flex p-2 align-items-baseline">
                                <i class="bx bx-phone m-2"></i>
                                <h6 class="fw-light m-2"><?php echo e($admin[0]->phone); ?></h6>
                            </div>
                            <div class="d-flex p-2 align-items-baseline">
                                <i class="bx bx-envelope m-2"></i>
                                <h6 class="fw-light m-2"><?php echo e($admin[0]->email); ?></h6>
                            </div>
                            <div class="d-flex p-2 align-items-baseline justify-content-between">
                                <div class="d-flex">
                                    <i class="bx bxl-facebook-square m-2 text-primary"></i>
                                    <p class="fw-light m-2">fb page here.</p>
                                </div>

                                <div class="d-flex">
                                    <i class="bx bxl-instagram m-2"></i>
                                    <p class="fw-light m-2">09123456789</p>
                                </div>

                                <div class="d-flex">
                                    <i class="bx bxl-discord m-2" style="color: indigo;"></i>
                                    <p class="fw-light m-2">09123456789</p>
                                </div>
                            </div>
                            <hr>
                            <p>Full address here.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        AOS.init()

        mapboxgl.accessToken = 'pk.eyJ1IjoiYWdlb2Fnbm90ZSIsImEiOiJjbDloNjZqOTAxOGxyM3FteTIyNHRmMzZ2In0.oLZTFCvyiwBCxI__Xs6ZcQ';
        const map_tanaw = new mapboxgl.Map({
            container: 'map_find_us', // container id
            style: 'mapbox://styles/mapbox/streets-v11', // stylesheet location
            center: [
                121.40946514930226, 14.074911540765413
            ], // starting position tanaw de rizal
            zoom: 15 // starting zoom
        });


        const tanaw = new mapboxgl.Popup({
                closeOnClick: false
            })
            .setHTML('<div class="p-3 text-dark d-flex flex-column"><h6 class="fw-bold">Tanaw de Rizal Park</h6><span>We are here.</span></div>')
            .addTo(map_tanaw)

        const tanaw_llocation = new mapboxgl.Marker({
            color: 'crimson'
        });

        tanaw_llocation.setLngLat([121.40946514930226, 14.074911540765413]).setPopup(tanaw).addTo(map_tanaw);
    </script>
    <?php endif; ?>

    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container px-5">
            <p class="m-0 text-center text-white">Copyright &copy; Tanaw 2022</p>
        </div>
    </footer>
</body>

</html><?php /**PATH C:\Users\sarah\Desktop\tanawsystem\tanaw-deploy\tanawsystem\resources\views/layouts/app.blade.php ENDPATH**/ ?>