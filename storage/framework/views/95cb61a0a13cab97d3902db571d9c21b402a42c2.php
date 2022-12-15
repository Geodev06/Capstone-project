<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email verification</title>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="<?php echo e(asset('./assets/bs/css/bootstrap.min.css')); ?>" rel="stylesheet" />
    <script src="<?php echo e(asset('./assets/bs/js/bootstrap.min.js')); ?>"></script>
    <link rel="stylesheet" href="<?php echo e(asset('./assets/bs/boxicons.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('styles.css')); ?>" />
    <script src="<?php echo e(asset('./assets/js/jquery-3.5.1.js')); ?>"></script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 p-5">
                <div class="card">
                    <div class="card-header"><?php echo e(__('Verify Your Email Address')); ?></div>

                    <div class="card-body">
                        <?php if(session('resent')): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo e(__('A fresh verification link has been sent to your email address.')); ?>

                        </div>
                        <?php endif; ?>

                        <?php echo e(__('Before proceeding, please check your email for a verification link.')); ?>

                        <?php echo e(__('If you did not receive the email')); ?>,
                        <form class="d-inline" method="POST" action="<?php echo e(route('verification.resend')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline"><?php echo e(__('click here to request another')); ?></button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html><?php /**PATH C:\Users\sarah\Desktop\tanawsystem\tanawsystem\resources\views/auth/verify.blade.php ENDPATH**/ ?>