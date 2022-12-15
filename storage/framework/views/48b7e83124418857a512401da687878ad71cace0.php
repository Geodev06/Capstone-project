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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
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
                    <h3 class="text-center mt-4">Forgot password</h3>
                    <p class="text-center text-muted">Please type your email to continue.</p>


                    <form class="p-4" method="POST" action="<?php echo e(route('password.email')); ?>" autocomplete="off">
                        <?php echo csrf_field(); ?>
                        <?php if($errors->any()): ?>
                        <div class="alert-container mb-3">
                            <div class="alert-header">
                                <i class="bx bx-error fs-5"></i>
                            </div>
                            <div class="alert-body">
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <?php endif; ?>


                        <div class="input-container mb-3">
                            <i class="bx bx-user"></i>
                            <input type="email" name="email" placeholder="Email address" value="<?php echo e(old('email')); ?>" />
                        </div>

                        <input type="submit" class="custom-btn mx-auto w-100" value="Send Password Reset Link">
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

</html><?php /**PATH C:\Users\sarah\Desktop\tanawsystem\tanaw-deploy\tanawsystem\resources\views/auth/passwords/email.blade.php ENDPATH**/ ?>