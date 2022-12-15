

<?php $__env->startSection('room_images'); ?>

<style>
    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus,
    input[type="number"]:focus {
        border: 1px solid gray;
        outline: 0 none;
        box-shadow: none;
    }

    input[type="file"] {
        display: none;
    }
</style>
<div class="row">
    <div class="col-md-5 col-lg-5  mb-3">
        <form method="POST" id="room-upload" action="<?php echo e(route('room_images.upload',$rooms[0]->room_no)); ?>" enctype="multipart/form-data" class="mt-5 w-50 mx-auto ">
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
                        'Failed to upload',
                        "<?php echo e(Session::get('error')); ?>",
                        'error'
                    )
                })
            </script>
            <?php endif; ?>

            <?php echo csrf_field(); ?>
            <div class="justify-content-center">
                <label for="file-input" class="my-file">
                    <i class="bx bx-cloud-upload fs-1 "></i>
                    Upload images here.
                </label>
                <input type="hidden" value="<?php echo e($rooms[0]->room_no); ?>" name="room_no" />
                <input multiple accept="image/png, image/jpeg, image/gif, image/jpg" id="file-input" name="image[]" type="file" />
            </div>
        </form>
        <div class="d-flex justify-content-center mt-3 flex-column text-center">
            <h4>Upload 4 images for Room no.<?php echo e($rooms[0]->room_no); ?></h4>
            <p>You can upload multiple images at the same time. accepted format(.png, .jpeg, .jpg, .gif,).</p>
            <?php if(count($images) > 0): ?>
            <button id="btn-delete-images" class="mt-4 mb-4 btn btn-sm btn-danger mx-auto">Delete all images</button>
            <script>
                $(document).ready(function() {

                    $('#btn-delete-images').on('click', function() {
                        Swal.fire({
                            type: 'question',
                            title: 'Are you sure?',
                            text: 'Do you want to delete images for Room no' + "<?php echo e($rooms[0]->room_no); ?>",
                            showCancelButton: true,
                            confirmButtonText: 'Confirm'
                        }).then((result) => {
                            if (result.value) {
                                window.location.replace("<?php echo e(route('rooms.delete_all',$rooms[0]->room_no)); ?>")
                            }
                        })
                    })
                })
            </script>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-md-7 col-lg-7">
        <div class="row">
            <?php if(count($images) > 0): ?>
            <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-sm-6 mb-4 ">
                <div class="img-container">
                    <img class="image-del" data-id="<?php echo e($image->id); ?>" src="<?php echo e(asset($image->image)); ?>" height="200px" width="100%" />
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <script>
                $(document).ready(function() {

                    $('.img-container').on('click', 'img', function() {
                        var img_id = $(this)[0].dataset.id
                        console.log(img_id)
                        Swal.fire({
                            type: 'question',
                            title: 'Are you sure?',
                            text: 'Do you want to delete this image?',
                            showCancelButton: true,
                            confirmButtonText: 'Confirm'
                        }).then((result) => {
                            if (result.value) {
                                var url = "<?php echo e(route('rooms.image_delete',':id')); ?>"
                                window.location.replace(url.replace(':id', img_id))
                            }
                        })
                    })
                })
            </script>
            <?php else: ?>
            <p class="text-center">No images.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#file-input').on('change', function() {
            $('#room-upload').submit()
        })
    })
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.manage_room', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\tanawsystem\resources\views/admin/room_images.blade.php ENDPATH**/ ?>