

<?php $__env->startSection('setting'); ?>

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
<div class="row p-5 my-white">
    <!-- user basic info -->
    <div class="col-md-4 col-lg-4 mb-3">
        <h3 class="fw-light">Profile information</h1>
            <p>Update your name and address information</p>
    </div>

    <div class="col-md-8 col-lg-8 mb-3">
        <div class="card p-4 shadow-sm">
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

            <?php if(Session::has('success')): ?>

            <script>
                $(document).ready(function() {
                    Swal.fire(
                        'Success',
                        "<?php echo e(Session::get('success')); ?>",
                        'success'
                    )
                })
            </script>
            <?php endif; ?>

            <?php if(Session::has('error')): ?>

            <script>
                $(document).ready(function() {
                    Swal.fire(
                        'Password change failed',
                        "<?php echo e(Session::get('error')); ?>",
                        'error'
                    )
                })
            </script>
            <?php endif; ?>
            <div class="col-lg-8 col-md-8">
                <form method="POST" action="<?php echo e(route('user.update_info')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="p-3">
                        <input type="hidden" name="id" value="<?php echo e($userdata->id); ?>" />
                        <div class="mb-3 ">
                            <label for="name" class="form-label text-muted">Name</label>
                            <div class="input-group">
                                <input id="name" type="text" value="<?php echo e($userdata->name); ?>" name="name" autocomplete="off" placeholder="Name" class="form-control" />
                            </div>
                        </div>

                        <div class="mb-3 ">
                            <label for="address" class="form-label text-muted">Address</label>
                            <div class="input-group">
                                <input id="address" type="text" value="<?php echo e($userdata->address); ?>" name="address" autocomplete="off" placeholder="Address" class="form-control" />
                            </div>
                        </div>

                        <div class="mb-3 ">
                            <label for="address" class="form-label text-muted">Email</label>
                            <div class="input-group">
                                <input id="email" type="text" value="<?php echo e($userdata->email); ?>" name="email" autocomplete="off" placeholder="Address" disabled class="form-control" />
                            </div>
                        </div>

                        <div class="mb-3 ">
                            <label for="address" class="form-label text-muted">Phone</label>
                            <div class="input-group">
                                <input id="email" type="number" value="<?php echo e($userdata->phone); ?>" name="phone" autocomplete="off" placeholder="Phone no." class="form-control" />
                            </div>
                        </div>

                        <input type="submit" class="btn btn-dark float-start w-auto" value="Save">
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- user password info -->
    <div class="col-md-4 col-lg-4 mb-3">
        <h3 class="fw-light">Update password</h3>
        <p>Ensure your account is using a long, random password to stay secure.</p>
    </div>

    <div class="col-md-8 col-lg-8 mb-3">
        <div class="card p-4 shadow-sm">
            <div class="col-lg-8 col-md-8">
                <form method="POST" action="<?php echo e(route('user.update_pass')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="p-3">
                        <input type="hidden" name="id" value="<?php echo e($userdata->id); ?>" />
                        <div class="mb-3 ">
                            <label for="name" class="form-label text-muted">Current Password</label>
                            <div class="input-group">
                                <input id="password_old" type="password" name="old_pass" autocomplete="off" placeholder="Content name" id="name" class="form-control" />
                            </div>
                        </div>

                        <div class="mb-3 ">
                            <label for="address" class="form-label text-muted">New Password</label>
                            <div class="input-group">
                                <input id="password_n" type="password" name="password" autocomplete="off" placeholder="Content name" id="name" class="form-control" />
                            </div>
                        </div>

                        <div class="mb-3 ">
                            <label for="address" class="form-label text-muted">Confirm Password</label>
                            <div class="input-group">
                                <input id="password_c" type="password" name="password_confirmation" autocomplete="off" placeholder="Content name" id="name" class="form-control" />
                            </div>
                        </div>
                        <input type="submit" class="btn btn-dark float-start w-auto" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!--delete account info -->
    <div class="col-md-4 col-lg-4">
        <h3 class="fw-light">Delete Account</h3>
        <p>Permanently. delete your account</p>
    </div>

    <div class="col-md-8 col-lg-8">
        <div class="card p-4 shadow-sm">
            <div class="col-lg-8 col-md-8">
                <form method="POST" action="<?php echo e(route('user.delete', $userdata->id)); ?>" class="p-3">
                    <?php echo csrf_field(); ?>
                    <p>Once your account is deleted. all of it's resources and data will be permanently deleted.Before deleting your account please download any data or information that your wish to retain.</p>
                    <input type="submit" class="btn  btn-danger float-start w-auto" value="Delete account">
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($userdata->role == 1 ? 'admin.dashboard' : 'user.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\sarah\Desktop\tanawsystem\tanawsystem\resources\views/user_settings.blade.php ENDPATH**/ ?>