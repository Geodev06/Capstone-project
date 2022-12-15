<?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="card mb-3">
    <div class="card-body">
        <h5 class="fw-bold"><span class="h3 fw-bold">Q:</span> <?php echo e($faq->question); ?></h5>
        <span class="badge bg-primary"><?php echo e($faq->answer); ?></span>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH C:\Users\sarah\Desktop\tanawsystem\tanaw-deploy\tanawsystem\resources\views/user/faqs.blade.php ENDPATH**/ ?>