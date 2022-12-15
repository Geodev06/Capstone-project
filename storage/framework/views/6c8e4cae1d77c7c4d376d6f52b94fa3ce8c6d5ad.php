<?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if($notif->status === 'unread'): ?>
<div class="d-flex p-3 justify-content-between mb-3 bg-light">
    <div class="d-flex">
        <p><?php echo e($notif->content); ?></p>
        <p><?php echo e($notif->created_at->diffForHumans()); ?></p>
    </div>
    <div class="d-flex align-items-center h-100">
        <button class="btn btn-sm btn-outline-primary m-2 btn-mark-notif" data-id="<?php echo e($notif->id); ?>"><i class="bx bx-check"></i></button>
        <button class="btn btn-sm btn-outline-danger m-2 btn-delete-notif" data-id="<?php echo e($notif->id); ?>"><i class="bx bx-trash"></i></button>
    </div>
</div>
<?php else: ?>
<div class="d-flex p-3 justify-content-between mb-3" style="border: 1px solid gray;">
    <div class="d-flex">
        <p><?php echo e($notif->content); ?></p>
        <p><?php echo e($notif->created_at->diffForHumans()); ?></p>
    </div>
    <div class="d-flex align-items-center h-100">
        <button class="btn btn-sm btn-outline-primary m-2 btn-mark-notif" data-id="<?php echo e($notif->id); ?>"><i class="bx bx-check"></i></button>
        <button class="btn btn-sm btn-outline-danger m-2 btn-delete-notif" data-id="<?php echo e($notif->id); ?>"><i class="bx bx-trash"></i></button>
    </div>
</div>
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php if(count($notifications) <= 0): ?> <p>No notifications
    </p>
    <?php endif; ?><?php /**PATH C:\Users\sarah\Desktop\tanawsystem\tanawsystem\resources\views/user/notification.blade.php ENDPATH**/ ?>