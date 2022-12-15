

<?php $__env->startSection('room_form'); ?>
<form method="POST" id="add-room" action="<?php echo e(route('rooms.store')); ?>" class="col-md-6 mx-auto">
    <div class="container">
        <div class="row p-5">
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
            <h4>Add Room</h4>
            <?php echo csrf_field(); ?>
            <div class="col-md-6 mb-3">
                <label for="" class="form-label text-muted">Room no.</label>
                <div class="input-group">
                    <input type="number" value="<?php echo e(old('room_no')); ?>" name="room_no" autocomplete="off" placeholder="Room no" class="form-control" />
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="" class="form-label text-muted">No. of Occupants</label>
                <div class="input-group">
                    <div class="d-flex align-items-center">
                        <div>

                            <input type="number" value="<?php echo e(old('min')); ?>" name="min" autocomplete="off" placeholder="Min." class="form-control" />

                        </div>
                        <span> - </span>
                        <div>

                            <input type="number" value="<?php echo e(old('max')); ?>" name="max" autocomplete="off" placeholder="Max." class="form-control" />
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="custom-btn d-flex justify-content-center align-items-center"><i class="bx bx-save"></i>Save</button>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.manage_room', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\sarah\Desktop\tanawsystem\tanawsystem\resources\views/admin/room_form.blade.php ENDPATH**/ ?>