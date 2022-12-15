

<?php $__env->startSection('manage_establishments'); ?>

<div class="row p-5">
    <div class="col-lg-12">

        <?php if('u/admin/manage-establishments' === request()->path()): ?>
        <p>Manage > Establishments</p>
        <button id="btn-create-establishment" class="mb-3 custom-btn d-flex align-items-center"><i class="bx bx-plus"></i>Create</button>
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
        <script>
            document.querySelector('#btn-create-establishment').addEventListener('click', function() {
                location.href = "<?php echo e(route('admin.create_establishment')); ?>";
            })
        </script>

        <div class="container-fluid">
            <div class="row">

                <?php $__currentLoopData = $establishments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $est): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 col-lg-3 mb-3">
                    <div class="card  establishment-card p-3 h-100">

                        <div class="d-flex flex-column mt-3 h-100">
                            <div class="d-flex justify-content-between">
                                <h5 class="text-uppercase "><?php echo e($est->establishment_name); ?></h5>
                                <span class="float-end btn-delete" data-id="<?php echo e($est->id); ?>" data-name="<?php echo e($est->establishment_name); ?>"><i class="bx bx-x bg-danger text-white" style="cursor:pointer;border-radius: 50px;"></i></span>
                            </div>

                            <div class="d-flex justify-content-between">
                                <p class="fw-light text-info"><?php echo e($est->establishment_address); ?></p>
                                <span class="float-end btn-upload-image" data-id="<?php echo e($est->id); ?>" data-name="<?php echo e($est->establishment_name); ?>"><i class="bx bx-image-add text-dark" style="cursor:pointer;border-radius: 50px;"></i></span>

                            </div>
                        </div>

                        <a href="<?php echo e(route('establishment.edit', $est->id)); ?>" class="btn custom-btn d-flex justify-content-center align-items-baseline">
                            <i class="bx bx-edit"></i> Details</a>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <?php endif; ?>
        <!-- create view-->
        <?php if('u/admin/manage-establishments/create' === request()->path()): ?>
        <p class="d-flex justify-content-between">Manage > Establishments > Create <a href="<?php echo e(route('admin.manage_establishments')); ?>">Go back</a></p>
        <div class="container-fluid">
            <?php echo $__env->yieldContent('create_establishment'); ?>
        </div>
        <?php endif; ?>
        <!-- update view -->

        <?php if(count($establishments) > 0): ?>
        <?php if('u/admin/manage-establishments/edit/'.$establishments[0]->id === request()->path()): ?>
        <p class="d-flex justify-content-between">Manage > Establishments > Edit <a href="<?php echo e(route('admin.manage_establishments')); ?>">Go back</a></p>
        <?php echo $__env->yieldContent('edit_establishment'); ?>
        <?php endif; ?>
        <?php endif; ?>
        <!-- upload_images -->
        <?php if(count($establishments) > 0): ?>
        <?php if('u/admin/manage-establishments/upload-image/'.$establishments[0]->id === request()->path()): ?>
        <p class="d-flex justify-content-between">Manage > Establishments > Image > Upload <a href="<?php echo e(route('admin.manage_establishments')); ?>">Go back</a></p>
        <?php echo $__env->yieldContent('establishment_upload_images'); ?>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('.card').on('click', '.btn-delete', function() {

            var est_id = $(this)[0].dataset.id
            var est_name = $(this)[0].dataset.name
            Swal.fire({
                type: 'warning',
                title: 'Are you sure?',
                text: 'Do you want to remove ' + est_name + '\nYou cannot undo this after.',
                showCancelButton: true,
                confirmButtonText: 'Confirm'
            }).then((result) => {
                if (result.value) {
                    var url = "<?php echo e(route('establishment.destroy',':id')); ?>"
                    window.location.replace(url.replace(':id', est_id))
                }
            })
        })

        $('.card').on('click', '.btn-upload-image', function() {

            var est_id = $(this)[0].dataset.id
            var uri = "<?php echo e(route('establishment.upload_image',':id')); ?>"
            window.location.replace(uri.replace(':id', est_id))
        })
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\sarah\Desktop\tanawsystem\tanawsystem\resources\views/admin/manage_establishments.blade.php ENDPATH**/ ?>