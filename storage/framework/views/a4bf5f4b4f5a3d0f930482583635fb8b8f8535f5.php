<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tanaw Login</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- or -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <link rel="stylesheet" href="<?php echo e(asset('styles.css')); ?>" />
    <script src="<?php echo e(asset('./assets/js/jquery-3.5.1.js')); ?>"></script>

    <script src="<?php echo e(asset('scripts.js')); ?>" defer></script>
    <style>
        #index {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row p-5">
            <div class="col-sm-12 col-md-6 col-lg-4 mx-auto">
                <div class="d-flex flex-column">
                    <h1 class="fw-bold text-center" id="index">Tanaw ui</h1>
                    <h3 class="text-center mt-4">Sign in</h3>
                    <p class="text-center text-muted">(admin only)Please login to continue.</p>


                    <form class="p-4" method="POST" action="<?php echo e(route('admin.authenticate')); ?>" autocomplete="off">
                        <?php echo csrf_field(); ?>
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
                        <?php if(Session::has('error')): ?>
                        <div class="alert-container mb-3">
                            <div class="alert-header">
                            </div>
                            <div class="alert-body">
                                <p><?php echo e(Session::get('error')); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>



                        <div class="input-container mb-3">
                            <i class="bx bx-user"></i>
                            <input type="email" name="email" placeholder="Email address" value="<?php echo e(old('email')); ?>" />
                        </div>

                        <div class="input-container mb-3">
                            <i class="bx bx-lock"></i>
                            <input type="password" name="password" placeholder="Password" />
                        </div>

                        <div class="d-flex justify-content-between align-items-center p-2 ">
                            <div class="form-check">
                                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                                <label for="remember" class="form-check-label">Remember Me</label>
                            </div>
                            <a href="<?php echo e(route('password.request')); ?>" style="font-size: 12px;">Forgot password</a>
                        </div>

                        <div class="mb-3">
                            <!-- <?php echo NoCaptcha::renderJs(); ?>

                            <?php echo NoCaptcha::display(); ?> -->
                        </div>

                        <input type="submit" class="custom-btn mx-auto w-100" value="Login">
                        <hr>

                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        $('#index').on('click', function(e) {
            e.preventDefault()
            window.location.replace("<?php echo e(route('index')); ?>")
        })
    })
</script>

</html><?php /**PATH C:\Users\sarah\Desktop\tanawsystem\tanaw-deploy\tanawsystem\resources\views/admin/admin_login.blade.php ENDPATH**/ ?>