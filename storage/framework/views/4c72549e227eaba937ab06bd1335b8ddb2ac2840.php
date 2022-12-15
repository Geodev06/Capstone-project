

<?php $__env->startSection('create_establishment'); ?>


<link href="https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.js"></script>
<!-- <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.css" type="text/css"> -->

<!-- Load the `mapbox-gl-geocoder` plugin.
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css"> -->


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
<div class="row">
    <div class="col-md-5 col-lg-5">
        <form method="POST" id="add-establishment" action="<?php echo e(route('establishment.store')); ?>">
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
            <?php echo csrf_field(); ?>
            <div class="p-3">
                <p class="fs-4 fw-bold">Add new Establishment</p>
                <div class="mb-3 ">
                    <label for="" class="form-label text-muted">Establishment name</label>
                    <div class="input-group">
                        <input type="text" value="<?php echo e(old('establishment_name')); ?>" name="establishment_name" autocomplete="off" placeholder="Establishment name" class="form-control" />
                    </div>
                </div>

                <div class="mb-3 ">
                    <label for="" class="form-label text-muted">Establishment address</label>
                    <div class="input-group">
                        <input type="text" value="<?php echo e(old('establishment_address')); ?>" name="establishment_address" autocomplete="off" id="est_add" placeholder="Establishment address" class="form-control" />
                    </div>
                </div>

                <div class="mb-3 ">
                    <label for="" class="form-label text-muted">Schedules</label>
                    <div class="input-group">
                        <input type="text" value="<?php echo e(old('schedule')); ?>" name="schedule" autocomplete="off" placeholder="Schedules" class="form-control" />
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <div class="mb-3 w-100">
                        <label for="" class="form-label text-muted">Contact no.</label>
                        <div class="input-group">
                            <input type="number" value="<?php echo e(old('contact')); ?>" name="contact" autocomplete="off" class="form-control" />
                        </div>
                    </div>
                    <div class="mb-3 w-100">
                        <label for="" class="form-label text-muted">Email</label>
                        <div class="input-group">
                            <input type="text" value="<?php echo e(old('email')); ?>" name="email" autocomplete="off" class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <div class="mb-3 w-100">
                        <label for="" class="form-label text-muted">Open time</label>
                        <div class="input-group">
                            <input type="time" value="<?php echo e(old('open')); ?>" name="open" autocomplete="off" class="form-control" />
                        </div>
                    </div>
                    <div class="mb-3 w-100">
                        <label for="" class="form-label text-muted">Close time</label>
                        <div class="input-group">
                            <input type="time" value="<?php echo e(old('close')); ?>" name="close" autocomplete="off" class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="d-flex mb-4 justify-content-end">
                    <span class="badge bg-success" id="lng">Longitude</span>
                    <span class="badge bg-danger" id="latt">Latitude</span>

                    <input type="hidden" value="<?php echo e(old('lat')); ?>" name="lat" id="lat" />
                    <input type="hidden" value="<?php echo e(old('lon')); ?>" name="lon" id="loni" />
                </div>
                <input type="submit" class="custom-btn mx-auto w-100" value="Save">
            </div>
        </form>
    </div>

    <div class="col-md-7 col-lg-7">
        <div class="map-container">
            <div id="map" style="height: 500px; width:100%"></div>
        </div>
    </div>
</div>


<script>
    if (navigator.geolocation) {


        navigator.geolocation.getCurrentPosition(function(location) {

            mapboxgl.accessToken = 'pk.eyJ1IjoiYWdlb2Fnbm90ZSIsImEiOiJjbDloNjZqOTAxOGxyM3FteTIyNHRmMzZ2In0.oLZTFCvyiwBCxI__Xs6ZcQ';
            const map = new mapboxgl.Map({
                container: 'map',
                // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [location.coords.longitude, location.coords.latitude],
                zoom: 13
            });

            map.addControl(new mapboxgl.GeolocateControl({
                positionOptions: {
                    enableHighAccuracy: true
                },
                trackUserLocation: true,
                showUserHeading: true
            }))

            let lng;
            let lat;

            const marker = new mapboxgl.Marker({
                color: '#314ccd'
            });

            function getAddress(address) {

                $.ajax({
                    url: address,
                    type: 'get',
                    processData: false,
                    dataType: 'json',
                }).done(function(data) {
                    $('#est_add').val(data.features[0].place_name)
                }).fail(function(e) {
                    $('#est_add').text('Error loading address. please try again.')
                })

            }


            map.on('click', (event) => {
                // When the map is clicked, set the lng and lat constants
                // equal to the lng and lat properties in the returned lngLat object.
                lng = event.lngLat.lng;
                lat = event.lngLat.lat;

                $('#lat').val(`${lat}`)
                $('#loni').val(`${lng}`)

                document.querySelector('#latt').innerHTML = `Lat : ${lat}`
                document.querySelector('#lng').innerHTML = `Long : ${lng}`
                // console.log(`${lng}, ${lat}`);
                marker.setLngLat(event.lngLat).addTo(map);

                const address = "https://api.mapbox.com/geocoding/v5/mapbox.places/" + lng + "," + lat + ".json?access_token=pk.eyJ1IjoiYWdlb2Fnbm90ZSIsImEiOiJjbDloNjZqOTAxOGxyM3FteTIyNHRmMzZ2In0.oLZTFCvyiwBCxI__Xs6ZcQ";
                getAddress(address)
            });

        });

    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.manage_establishments', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\tanawsystem\resources\views/admin/create_establishment.blade.php ENDPATH**/ ?>