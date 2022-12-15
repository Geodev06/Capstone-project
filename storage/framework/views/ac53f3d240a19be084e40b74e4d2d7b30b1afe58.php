<?php if(count($message) > 0): ?>
<?php $__currentLoopData = $message; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if($msg->sender_type === 'user'): ?>
<div class="col-lg-12">
    <div class="user-message mb-2">
        <div class="text-white mb-2">
            <span class="fw-bold d-flex"><?php echo e($msg->sender_name); ?> <i class="bx bx-check-double"></i></span>
            <span class="text-white float-end mx-2" style="font-size: 12px;"><?php echo e($msg->created_at->format('M d, Y h:m:A')); ?></span>
        </div>
        <p class="message-text text-white"><?php echo e($msg->message); ?></p>
    </div>
</div>
<?php endif; ?>

<?php if($msg->sender_type === 'admin'): ?>
<div class="col-lg-12">
    <div class="my-message mb-2 float-end">
        <div class="text-white mb-2">
            <span class="fw-bold d-flex">Me <i class="bx bx-check-double"></i></span>
            <span class="text-white float-end mx-2" style="font-size: 12px;"><?php echo e($msg->created_at->format('M d, Y h:m:A')); ?></span>
        </div>
        <p class="message-text text-white"><?php echo e($msg->message); ?></p>
    </div>
</div>
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\tanawsystem\resources\views/admin/message_content.blade.php ENDPATH**/ ?>