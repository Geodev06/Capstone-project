

<?php $__env->startSection('edit_establishment'); ?>
<link href="https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.10.0/mapbox-gl.js"></script>
<!-- <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.0/mapbox-gl-directions.css" type="text/css"> -->


<style>
    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus,
    input[type="number"]:focus {
        border: 1px solid gray;
        outline: 0 none;
        box-shadow: none;
    }

    input[type="file"] {
        display: none;
    }
</style>
<div class="row">
    <div class="col-md-5 col-lg-5">
        <form method="POST" id="add-establishment" action="<?php echo e(route('establishment.update', $establishments[0]->id)); ?>">
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
                <p class="fs-4 fw-bold">Edit <span class="text-capitalize"><?php echo e($establishments[0]->establishment_name); ?></span></p>
                <div class="mb-3 ">
                    <label for="" class="form-label text-muted">Establishment name</label>
                    <div class="input-group">
                        <input type="text" value="<?php echo e($establishments[0]->establishment_name); ?>" name="establishment_name" autocomplete="off" placeholder="Establishment name" class="form-control" />
                    </div>
                </div>

                <div class="mb-3 ">
                    <label for="" class="form-label text-muted">Establishment address</label>
                    <div class="input-group">
                        <input type="text" id="est_add" value="<?php echo e($establishments[0]->establishment_address); ?>" name="establishment_address" autocomplete="off" placeholder="Establishment address" class="form-control" />
                    </div>
                </div>

                <div class="mb-3 ">
                    <label for="" class="form-label text-muted">Schedules</label>
                    <div class="input-group">
                        <input type="text" value="<?php echo e($establishments[0]->schedule); ?>" name="schedule" autocomplete="off" placeholder="Schedules" class="form-control" />
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <div class="mb-3 w-100">
                        <label for="" class="form-label text-muted">Contact no.</label>
                        <div class="input-group">
                            <input type="number" value="<?php echo e($establishments[0]->contact); ?>" name="contact" autocomplete="off" class="form-control" />
                        </div>
                    </div>
                    <div class="mb-3 w-100">
                        <label for="" class="form-label text-muted">Email</label>
                        <div class="input-group">
                            <input type="text" value="<?php echo e($establishments[0]->email); ?>" name="email" autocomplete="off" class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <div class="mb-3 w-100">
                        <label for="" class="form-label text-muted">Open time</label>
                        <div class="input-group">
                            <input type="time" value="<?php echo e($establishments[0]->open); ?>" name="open" autocomplete="off" class="form-control" />
                        </div>
                    </div>
                    <div class="mb-3 w-100">
                        <label for="" class="form-label text-muted">Close time</label>
                        <div class="input-group">
                            <input type="time" value="<?php echo e($establishments[0]->close); ?>" name="close" autocomplete="off" class="form-control" />
                        </div>
                    </div>
                </div>

                <div class="d-flex mb-4 justify-content-end">
                    <span class="badge bg-success" id="lng">Longitude</span>
                    <span class="badge bg-danger" id="lt">Latitude</span>
                    <input type="hidden" value="<?php echo e($establishments[0]->lat); ?>" name="lat" id="lat" />
                    <input type="hidden" value="<?php echo e($establishments[0]->lon); ?>" name="lon" id="lon" />
                </div>
                <input type="submit" class="custom-btn mx-auto w-100" value="Save changes">
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

            const latLng = ["<?php echo e($establishments[0]->long); ?>", "<?php echo e($establishments[0]->lat); ?>"];


            mapboxgl.accessToken = 'pk.eyJ1IjoiYWdlb2Fnbm90ZSIsImEiOiJjbDloNjZqOTAxOGxyM3FteTIyNHRmMzZ2In0.oLZTFCvyiwBCxI__Xs6ZcQ';
            const map = new mapboxgl.Map({
                container: 'map',
                // Choose from Mapbox's core styles, or make your own style with Mapbox Studio
                style: 'mapbox://styles/mapbox/streets-v11',
                center: latLng,
                zoom: 13
            });

            const popup = new mapboxgl.Popup({
                    closeOnClick: false
                })
                .setLngLat(latLng)
                .setHTML('<div class="p-2 ">Current saved Location : <span class="fw-bold"><?php echo e($establishments[0]->establishment_address); ?></span></div>')
                .addTo(map);

            const Newpopup = new mapboxgl.Popup({
                    closeOnClick: false
                })
                .setHTML('<div class="p-2 bg-primary text-white ">New Address</div>')
                .addTo(map);

            const marker = new mapboxgl.Marker({
                    color: 'seagreen'
                })
                .setLngLat(latLng)
                .setPopup(popup)
                .addTo(map);

            const newMarker = new mapboxgl.Marker({
                    color: 'blue'
                })
                .setLngLat([0, 0])
                .setPopup(Newpopup)
                .addTo(map);

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
                $('#lon').val(`${lng}`)

                document.querySelector('#lt').innerHTML = `Lat : ${lat}`
                document.querySelector('#lng').innerHTML = `Long : ${lng}`
                newMarker.setLngLat(event.lngLat).addTo(map);



                const address = "https://api.mapbox.com/geocoding/v5/mapbox.places/" + lng + "," + lat + ".json?access_token=pk.eyJ1IjoiYWdlb2Fnbm90ZSIsImEiOiJjbDloNjZqOTAxOGxyM3FteTIyNHRmMzZ2In0.oLZTFCvyiwBCxI__Xs6ZcQ";
                getAddress(address)
            });

        });

    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.manage_establishments', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\tanawsystem\resources\views/admin/edit_establishment.blade.php ENDPATH**/ ?>