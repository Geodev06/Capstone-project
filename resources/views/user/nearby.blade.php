@extends('user.dashboard')

@section('nearby')

<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.css" type="text/css">

<style>
    #establishment_container {
        height: 420px;
        overflow-y: scroll;
        background-color: aliceblue
    }

    #establishment_container::-webkit-scrollbar {
        width: 4px;
    }

    #establishment_container::-webkit-scrollbar-thumb {
        background-color: dodgerblue;
    }

    .establishment-item {
        margin: 3px;
        padding: 15px;
        background-color: white;
    }

    .search-container {
        display: flex;
        align-items: center;
        justify-content: end;
    }

    #search {
        padding: 8px 4px;
        border: none;
        outline: none;
        font-size: 14px;
    }
</style>
<div class="row p-5" style="background-color: #f2f2f2;">
    <h1>What's Nearby tanaw?</h1>
    <div class="col-lg-5 col-md-5">
        <p>Establishments lists</p>
        <div class="search-container mb-3">
            <i class="bx bx-search"></i>
            <input type="text" name="" id="search" class="" placeholder="search">
        </div>
        <div id="establishment_container" class="d-flex flex-column">
            <!-- item goes here -->
        </div>
    </div>
    <div class="col-lg-7 col-md-7">
        <div class="d-flex">
            <span class="badge bg-success m-2">Nearby establishment</span>
            <span class="badge bg-primary m-2">Current location</span>
            <span class="badge bg-danger m-2">Tanaw de Rizal Park</span>
        </div>
        <div id="map" style="width: 600px; height:520px"></div>
        <!-- <div id="instructions"></div> -->
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
                                            <span class="fw-bold text-success">Open</span>
                                            <p id="est_open">Loading...</p>
                                        </div>

                                        <div>
                                            <span class="fw-bold text-danger">Close</span>
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
                                <button class="btn btn-danger btn-sm" id="btn_locate">Locate</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End modal -->
    <script>
        function Alertmsg(header, msg, type) {
            Swal.fire(
                header,
                msg,
                type
            )
        }



        function load_establishments(value) {
            var route = "{{ route('getnearby',':value') }}";
            $.ajax({
                url: route.replace(':value', value),
                type: 'post',
                data: {
                    _token: '{{ csrf_token()}}',
                    search: value
                },
                dataType: 'json',
                beforeSend: function() {
                    $('#establishment_container').html('<p>fecthing data...</p>')
                }
            }).done(function(data) {
                $('#establishment_container').html(data.view)
            }).fail(function(e) {
                alert('Error in fetching some data.')
            })
        }

        $('#search').on('keyup', function() {
            load_establishments($(this).val())
        })

        load_establishments()

        function load_images(id) {
            var route = "{{ route('establishment.get.json.images',':id') }}";
            $.ajax({
                url: route.replace(':id', id),
                type: 'get',
                dataType: 'json',
                beforeSend: function() {
                    $('#img_container').html('<p>fecthing data...</p>')
                    $('#btn_locate').attr('disabled', 'disabled')
                }
            }).done(function(data) {
                $('#btn_locate').removeAttr('disabled')
                $('#img_container').html(data.image)
            }).fail(function(e) {
                alert('Error in fetching some data.')
            })
        }

        $('#establishment_container').on('click', '.btn-est', function() {

            $('#est_modal').modal('show')

            var route = "{{ route('establishment.get.json',':id') }}";
            $.ajax({
                url: route.replace(':id', $(this)[0].dataset.id),
                type: 'get',
                dataType: 'json',
                beforeSend: function() {

                    $('#btn_locate').attr('disabled', 'disabled')
                }
            }).done(function(data) {
                $('#btn_locate').removeAttr('disabled')

                $('#est_name').text(data.data[0].establishment_name)
                $('#est_address').text(data.data[0].establishment_address)
                $('#est_contact').text(data.data[0].contact)
                $('#est_email').text(data.data[0].email)
                $('#est_sched').text(data.data[0].schedule)
                $('#est_open').text(data.data[0].open)
                $('#est_close').text(data.data[0].close)

                $('#btn_locate').attr('data-lng', data.data[0].long)
                $('#btn_locate').attr('data-lat', data.data[0].lat)

                load_images(data.data[0].id)

            }).fail(function(e) {
                alert('Error in fetching some data.')
            })
        })

        $('#btn_close_modal').on('click', () => $('#est_modal').modal('hide'))


        $(document).ready(function() {


            if (navigator.geolocation) {

                navigator.geolocation.getCurrentPosition(function(location) {



                    mapboxgl.accessToken = 'pk.eyJ1IjoiYWdlb2Fnbm90ZSIsImEiOiJjbDloNjZqOTAxOGxyM3FteTIyNHRmMzZ2In0.oLZTFCvyiwBCxI__Xs6ZcQ';
                    const map = new mapboxgl.Map({
                        container: 'map', // container id
                        style: 'mapbox://styles/mapbox/streets-v11', // stylesheet location
                        center: [121.40946514930226, 14.074911540765413], // starting position tanaw
                        zoom: 13 // starting zoom
                    });

                    $('#btn_locate').on('click', function() {

                        // console.log($(this)[0].dataset.lng)
                        map.flyTo({
                            center: [$(this)[0].dataset.lng, $(this)[0].dataset.lat]
                        })
                        $('#est_modal').modal('hide')
                    })

                    map.addControl(new mapboxgl.NavigationControl());

                    map.addControl(new mapboxgl.GeolocateControl({
                        positionOptions: {
                            enableHighAccuracy: true
                        },
                        trackUserLocation: true,
                        showUserHeading: true
                    }))

                    map.addControl(
                        new MapboxDirections({
                            accessToken: mapboxgl.accessToken
                        }),
                        'top-left'
                    )
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
                        url: "{{ route('get_est')}}",
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

                    const Tanaw = new mapboxgl.Marker({
                        color: 'crimson'
                    });

                    var Tanawpopup = new mapboxgl.Popup({
                            closeOnClick: false
                        })
                        .setHTML('<div class="p-3 text-dark"><h6 class="fw-bold">Tanaw de Rizal Park</h6><p>Contact info here.</p></div>')
                        .addTo(map);

                    Tanaw.setLngLat([121.40946514930226, 14.074911540765413]).setPopup(Tanawpopup).addTo(map).togglePopup();

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
    <style>
        #instructions {
            position: relative;
            margin: 20px;
            width: auto;
            top: 0;
            bottom: 20%;
            padding: 20px;
            background-color: rgb(36, 36, 36);
            color: rgb(10, 246, 128);
            overflow-y: scroll;
            font-family: sans-serif;
            font-size: 12px;
        }
    </style>
    @endsection