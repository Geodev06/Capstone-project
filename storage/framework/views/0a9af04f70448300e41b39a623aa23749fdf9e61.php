

<?php $__env->startSection('nearby'); ?>


<div class="row">
    <?php if(count($establishments) > 0): ?>
    <div class="col-md-12 col-lg-12">
        <div id="map" style="height: 700px; width:100%" style="display: none;"></div>
        <div id="instructions"></div>
    </div>
    <?php else: ?>
    <p>No establishment found!</p>
    <?php endif; ?>
</div>
<script>
    function Alertmsg(header, msg, type) {
        Swal.fire(
            header,
            msg,
            type
        )
    }
    $(document).ready(function() {


        if (navigator.geolocation) {

            navigator.geolocation.getCurrentPosition(function(location) {



                mapboxgl.accessToken = 'pk.eyJ1IjoiYWdlb2Fnbm90ZSIsImEiOiJjbDloNjZqOTAxOGxyM3FteTIyNHRmMzZ2In0.oLZTFCvyiwBCxI__Xs6ZcQ';
                const map = new mapboxgl.Map({
                    container: 'map', // container id
                    style: 'mapbox://styles/mapbox/streets-v11', // stylesheet location
                    center: [location.coords.longitude, location.coords.latitude], // starting position
                    zoom: 13 // starting zoom
                });


                map.addControl(new mapboxgl.NavigationControl());

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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\tanawsystem\resources\views/user/nearby.blade.php ENDPATH**/ ?>