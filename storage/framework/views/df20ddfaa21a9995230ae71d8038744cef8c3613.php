<?php $__currentLoopData = $est; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="establishment-item p-3 bg-white mb-2 card">
    <h6><?php echo e($item->establishment_name); ?></h6>
    <div class="d-flex justify-content-between align-items-center">
        <p style="margin: 0;"><?php echo e($item->establishment_address); ?></p>
        <button class="btn btn-sm btn-primary btn-est" data-id="<?php echo e($item->id); ?>" data-lat="<?php echo e($item->lat); ?>" data-lon="<?php echo e($item->long); ?>">Info</button>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH C:\Users\sarah\Desktop\tanawsystem\tanawsystem\resources\views/layouts/establishment_item.blade.php ENDPATH**/ ?>