<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tanaw</title>
    <!-- Favicon-->
    <!-- Bootstrap icons-->

    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="<?php echo e(asset('./assets/bs/css/bootstrap.min.css')); ?>" rel="stylesheet" />
    <script src="<?php echo e(asset('./assets/bs/js/bootstrap.min.js')); ?>"></script>
    <link rel="stylesheet" href="<?php echo e(asset('./assets/bs/boxicons.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('styles.css')); ?>" />
    <script src="<?php echo e(asset('./assets/js/jquery-3.5.1.js')); ?>"></script>

    <script src="<?php echo e(asset('scripts.js')); ?>" defer></script>
    <script src="<?php echo e(asset('./sweetalert/sweetalert.min.js')); ?>" defer></script>

    <!-- AOS -->
    <link rel="stylesheet" href="<?php echo e(asset('./aos/aos.css')); ?>" />
    <script src="<?php echo e(asset('./aos/aos.js')); ?>"></script>

</head>

<body>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg p-4 my-nav">
        <div class="container px-5">
            <a class="my-logo" href="<?php echo e(route('index')); ?>">LOGO | SNS Buttons</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link <?php echo e('/' === request()->path() ? 'active': ''); ?>" aria-current="page" href="<?php echo e(route('index')); ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link " href="#about">Things to do</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about1">About TANAW</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about2">Nearby</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about2">Find us</a></li>

                </ul>
            </div>
        </div>
    </nav>
    <!-- Header-->
    <header class="py-5 my-header">
        <div class="container px-5">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-7">
                    <div class="text-center text-white my-5">
                        <div class="header-container">
                            <h1 class="display-5 fw-bold text-white mb-2">TANAW de Rizal Park</h1>
                            <p class=" mb-4 text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna cum laude aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                                <a class="btn-green px-4 me-sm-3" href="<?php echo e(route('login')); ?>">Book Now</a>
                                <a class="btn-transparent px-4" href="#features">Learn More</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <?php if(count($contents) > 0): ?>
    <section class="feature-section bg-white" id="features">
        <div class="container">
            <div class="row">
                <div class="mt-5 text-center">
                    <h1 class="fw-bold">What TANAW offers.</h1>
                    <p class="fw-light px-3"></p>
                </div>
                <?php $__currentLoopData = $contents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-3 col-lg-3 mx-auto p-5" data-aos="fade-up" data-aos-offset="200" data-aos-delay="(300)+100">
                    <div class="h-100">
                        <img src="<?php echo e(asset($content->image)); ?>" alt="<?php echo e(asset($content->image)); ?>" height="160px" width="100%">
                        <div class="p-3">
                            <h4 class="fw-bold"><?php echo e($content->title); ?></h4>
                            <p><?php echo e($content->content); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </div>
    </section>

    <script>
        AOS.init()
    </script>
    <?php endif; ?>

    <?php if(count($abouts) > 0): ?>
    <section data-aos="fade-up" class="about-section" id="about">
        <div class="container">
            <div class="row">
                <div class="mt-5 text-center">
                    <h1 class="fw-bold">Things to do in TANAW.</h1>
                    <p class="fw-light px-3"></p>
                </div>
                <?php $__currentLoopData = $abouts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $about): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-sm-12 col-md-4 col-lg-4 mx-auto p-5" data-aos="fade-right" data-aos-offset="200" data-aos-delay="300">
                    <div class="h-100 p-4">
                        <img src="<?php echo e(asset($about->image)); ?>" alt="<?php echo e(asset($about->image)); ?>" height="100px" width="100%">
                        <div class="p-3 ">
                            <h4 class="fw-bold text-dark"><?php echo e($about->title); ?></h4>
                            <p class="text-muted"><?php echo e($about->content); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </div>
    </section>
    <script>
        AOS.init()
    </script>
    <?php endif; ?>

    <?php if(count($abouts) > 0): ?>
    <section data-aos="fade-up" class="about-section bg-white" id="about1">
        <div class="container">
            <div class="row">
                <div class="mt-5 text-center">
                    <h1 class="fw-bold">About TANAW.</h1>
                    <p class="fw-light px-3"></p>
                </div>
                <?php $__currentLoopData = $abouts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $about): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-sm-12 col-md-4 col-lg-4 mx-auto p-5" data-aos="fade-right" data-aos-offset="200" data-aos-delay="300">
                    <div class="h-100 p-4">
                        <img src="<?php echo e(asset($about->image)); ?>" alt="<?php echo e(asset($about->image)); ?>" height="100px" width="100%">
                        <div class="p-3 ">
                            <h4 class="fw-bold text-dark"><?php echo e($about->title); ?></h4>
                            <p class="text-muted"><?php echo e($about->content); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </div>
    </section>
    <script>
        AOS.init()
    </script>
    <?php endif; ?>

    <?php if(count($abouts) > 0): ?>
    <section data-aos="fade-up" class="about-section" id="about2">
        <div class="container">
            <div class="row">
                <div class="mt-5 text-center">
                    <h1 class="fw-bold">What's near TANAW?</h1>
                    <p class="fw-light px-3">Other places to go in Rizal.</p>
                    <p class="fw-light px-3"></p>
                </div>
                <?php $__currentLoopData = $abouts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $about): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-sm-12 col-md-4 col-lg-4 mx-auto p-5" data-aos="fade-right" data-aos-offset="200" data-aos-delay="300">
                    <div class="h-100 p-4">
                        <img src="<?php echo e(asset($about->image)); ?>" alt="<?php echo e(asset($about->image)); ?>" height="100px" width="100%">
                        <div class="p-3 ">
                            <h4 class="fw-bold text-dark"><?php echo e($about->title); ?></h4>
                            <p class="text-muted"><?php echo e($about->content); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </div>
    </section>
    <script>
        AOS.init()
    </script>
    <?php endif; ?>

    <?php if(count($abouts) > 0): ?>
    <section data-aos="fade-up" class="about-section  bg-white" id="about3">
        <div class="container">
            <div class="row">
                <div class="mt-5 text-center">
                    <h1 class="fw-bold">Find TANAW.</h1>
                    <p class="fw-light px-3">Feel free to contact us.</p>
                    <p class="fw-light px-3"></p>
                </div>
                <?php $__currentLoopData = $abouts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $about): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-sm-12 col-md-4 col-lg-4 mx-auto p-5" data-aos="fade-right" data-aos-offset="200" data-aos-delay="300">
                    <div class="h-100 p-4">
                        <img src="<?php echo e(asset($about->image)); ?>" alt="<?php echo e(asset($about->image)); ?>" height="100px" width="100%">
                        <div class="p-3 ">
                            <h4 class="fw-bold text-dark"><?php echo e($about->title); ?></h4>
                            <p class="text-muted"><?php echo e($about->content); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
        </div>
    </section>
    <script>
        AOS.init()
    </script>
    <?php endif; ?>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container px-5">
            <p class="m-0 text-center text-white">Copyright &copy; Tanaw 2022</p>
        </div>
    </footer>

</body>

</html><?php /**PATH C:\xampp\htdocs\tanawsystem\resources\views/layouts/app.blade.php ENDPATH**/ ?>