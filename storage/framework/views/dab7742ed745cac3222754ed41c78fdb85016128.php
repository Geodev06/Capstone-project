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
    <!-- Bootstrap icons-->

    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="<?php echo e(asset('./assets/bs/css/bootstrap.min.css')); ?>" rel="stylesheet" />

    <script src="<?php echo e(asset('./assets/bs/js/bootstrap.min.js')); ?>"></script>
    <link rel="stylesheet" href="<?php echo e(asset('./assets/bs/boxicons.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('styles.css')); ?>" />
    <script src="<?php echo e(asset('./assets/js/jquery-3.5.1.js')); ?>"></script>

    <script src="<?php echo e(asset('scripts.js')); ?>" defer></script>
    <style>
        * {
            font-family: 'Roboto';

        }


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
                    <h3 class="text-center mt-4">Sign up</h3>
                    <p class="text-center text-muted">Please complete the form requirements.</p>
                    <form class="p-4" method="POST" action="<?php echo e(route('register')); ?>" autocomplete="off">
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

                        <div class="input-container mb-3">
                            <i class="bx bx-user"></i>
                            <input type="text" name="name" placeholder="Name" value="<?php echo e(old('name')); ?>" />
                        </div>

                        <div class="input-container mb-3">
                            <i class="bx bx-pin"></i>
                            <input type="text" name="address" placeholder="Address" value="<?php echo e(old('address')); ?>" />
                        </div>

                        <div class="d-flex justify-content-between">
                            <div class="input-container mb-3">
                                <i class="bx bx-phone"></i>
                                <input type="number" name="phone" placeholder="Phone no." value="<?php echo e(old('phone')); ?>" />
                            </div>

                            <div class="input-container mb-3">
                                <i class="bx bx-envelope"></i>
                                <input type="email" name="email" placeholder="Email address" value="<?php echo e(old('email')); ?>" />
                            </div>
                        </div>
                        <hr>
                        <div class="input-container mb-3">
                            <i class="bx bx-lock"></i>
                            <input type="password" name="password" placeholder="Password" value="<?php echo e(old('password')); ?>" />
                        </div>

                        <div class="input-container mb-3">
                            <i class="bx bx-lock"></i>
                            <input type="password" name="password_confirmation" placeholder="Confirm Password" value="<?php echo e(old('password')); ?>" />
                        </div>

                        <input type="submit" class="custom-btn mx-auto w-100" value="Sign up">
                        <hr>
                        <p>I already have an account? <a href="<?php echo e(route('login')); ?>">Sign in</a>
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

</html><?php /**PATH C:\xampp\htdocs\tanawsystem\resources\views/auth/register.blade.php ENDPATH**/ ?>