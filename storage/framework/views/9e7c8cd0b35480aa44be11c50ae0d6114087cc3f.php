

<?php $__env->startSection('tanaw'); ?>

<div class="row p-5">
    <div class="col-lg-12">
        <h1>TANAW Map</h1>
        <?php if(count($map_data) > 0): ?>
        <img src="<?php echo e(asset($map_data[0]->image)); ?>" alt="tanaw.jpeg" width="100%" height="400px">
        <p class="p-2"><?php echo e($map_data[0]->content); ?></p>
        <?php else: ?>
        <p>No map provided right now.</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\sarah\Desktop\tanawsystem\tanaw-deploy\tanawsystem\resources\views/user/tanaw_map.blade.php ENDPATH**/ ?>