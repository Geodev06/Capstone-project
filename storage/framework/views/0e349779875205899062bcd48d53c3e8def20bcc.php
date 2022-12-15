<?php $__currentLoopData = $est; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="establishment-item d-flex justify-content-between align-items-center">
    <div>
        <h6><?php echo e($item->establishment_name); ?></h6>
        <p style="font-size:14px"><?php echo e($item->establishment_address); ?></p>
        <button class="btn btn-sm btn-primary btn-est" data-id="<?php echo e($item->id); ?>" data-lat="<?php echo e($item->lat); ?>" data-lon="<?php echo e($item->long); ?>">More info</button>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH C:\Users\sarah\Desktop\tanawsystem\tanaw-deploy\tanawsystem\resources\views/user/establishment_item.blade.php ENDPATH**/ ?>