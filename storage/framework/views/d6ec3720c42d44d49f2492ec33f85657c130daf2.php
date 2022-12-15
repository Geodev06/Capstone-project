

<?php $__env->startSection('room_info'); ?>
<style>
    .room-detail-card {
        padding: 10px;
    }

    ul {
        list-style: none;
    }

    .btn-check-in {
        outline: none;
        border: none;
        height: auto;
        padding: 8px;
        background-color: rgba(0, 0, 0, 0.80);
        color: springgreen;
        text-align: center;
        border-radius: 8px;
        cursor: pointer;
    }

    .btn-check-in:hover {
        transition: all .3s;
        color: springgreen;
        background-color: rgba(0, 0, 0, 1);
    }

    img {
        max-height: 400px;
    }
</style>
<div class="row p-5">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="fw-bold">Room details</h1>
        <a class="btn-back" href="<?php echo e(route('user.dashboard')); ?>">Go back</a>
    </div>
    <div class="col-md-12 col-lg-4">
        <div class="room-detail-card d-flex flex-column">
            <h6>Room no. <?php echo e($rooms[0]->room_no); ?></h6>
            <ul>
                <li><i class="bx bx-check"></i> Now Available</li>
                <li><i class="bx bx-check"></i> <?php echo e($rooms[0]->min.'-'.$rooms[0]->max); ?> persons.</li>
            </ul>
            <h6>Prices</h6>
            <ul>

                <?php if(count($prices) > 0): ?>
                <?php $__currentLoopData = $prices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><i class="bx bx-check"></i> &#8369 <?php echo e($prc->price); ?> for <?php echo e($prc->hour); ?> Hours</li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </ul>
            <button class="btn-check-in" id="btn-check-in"> Check in</button>

            <script>
                $(function() {
                    $('#btn-check-in').on('click', function() {
                        window.location.replace("<?php echo e(route('user.checkinform',$rooms[0]->room_no)); ?>")
                    })
                })
            </script>
        </div>
    </div>
    <div class="col-md-12 col-lg-8 mt-4">
        <?php if(count($images)> 0): ?>

        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">

            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 0"></button>
                <?php for($i = 1; $i < count($images); $i++): ?> <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo e($i); ?>" aria-label="Slide <?php echo e($i); ?>"></button>
                    <?php endfor; ?>
            </div>
            <div class="carousel-inner">

                <div class="carousel-item active h-100">
                    <img src="<?php echo e(asset($images[0]->image)); ?>" class="d-block w-100" alt="img0">
                </div>
                <?php for($i = 1; $i < count($images); $i++): ?> <div class="carousel-item h-100">
                    <img src="<?php echo e(asset($images[$i]->image)); ?>" class="d-block w-100" alt="img<?php echo e($i); ?>">
            </div>
            <?php endfor; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <p style="font-size: 12px;">Room images</p>
    <?php else: ?>
    <p class="text-center">No images provided.</p>
    <?php endif; ?>
</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\sarah\Desktop\tanawsystem\tanawsystem\resources\views/user/view_room.blade.php ENDPATH**/ ?>