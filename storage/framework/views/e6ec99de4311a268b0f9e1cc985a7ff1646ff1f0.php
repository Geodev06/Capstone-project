

<?php $__env->startSection('manage_content'); ?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

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
<div class="row p-5">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <p>Manage > Content</p>
        <div class="d-flex justify-content-between">
            <button class="mb-3 custom-btn d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#add-content-modal"><i class="bx bx-plus"></i>Create</button>
            <button class="mb-3 custom-btn d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#add-faq-modal"><i class="bx bx-plus"></i>Create FAQ</button>
        </div>

        <table id="table-content" class="display nowrap w-100 table-striped">
            <thead>
                <tr style=" height: 10px;">
                    <th>Content id</th>
                    <th>Title</th>
                    <th>Date created</th>
                    <th>Type</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<!-- add-content -->
<div class="modal fade" id="add-content-modal" tabindex="-1" aria-labelledby="modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- form -->
                            <form method="POST" id="add-content" action="<?php echo e(route('content.store')); ?>" enctype="multipart/form-data">

                                <div class="alert-container" id="error-display" style="display: none;">
                                    <div class="alert-header">
                                        <i class="bx bx-error fs-5"></i>
                                    </div>
                                    <div class="alert-body">
                                        <ul id="error-list">

                                        </ul>
                                    </div>
                                </div>

                                <?php echo csrf_field(); ?>
                                <div class="p-3">
                                    <p class="fs-4 fw-bold">Add new Content</p>
                                    <div class="mb-3 ">
                                        <label for="title" class="form-label text-muted">Title</label>
                                        <div class="input-group">
                                            <input type="text" value="<?php echo e(old('title')); ?>" name="title" autocomplete="off" placeholder="Content title" id="title" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="mb-3 ">
                                        <label for="content" class="form-label text-muted">Content</label>
                                        <textarea name="content" id="" cols="30" class="form-control" rows="7"><?php echo e(old('content')); ?></textarea>
                                    </div>

                                    <div class="mb-3 w-100 mx-auto">
                                        <label for="evnt" class="form-label text-muted">Type</label>
                                        <div class="input-group">
                                            <select class="form-control" name="type">
                                                <option value="Feature">Features</option>
                                                <option value="Todo">Things todo</option>
                                                <option value="About">About</option>

                                                <option value="Chatbot-context">Chatbot context</option>
                                                <option value="gcash-payment">Gcash Qr</option>
                                                <option value="tanaw-map">Tanaw Map</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 w-100 mx-auto">
                                        <label for="evnt" class="form-label text-muted">Image</label>
                                        <div class="input-group">
                                            <input type="file" class="form-control" name="image">
                                        </div>
                                    </div>

                                    <input type="submit" class="custom-btn mx-auto w-100" value="Save">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End modal -->

<!-- view-content -->
<div class="modal fade" id="view-content-modal" tabindex="-1" aria-labelledby="modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-flex justify-content-between">
                    <p class="fs-4 fw-bold">Edit Content</p>
                    <img src="" alt="" class="text-center" height="50px" width="80px" id="e-img">
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- form -->

                            <form method="POST" id="edit-content" enctype="multipart/form-data">

                                <div class="alert-container" id="e-error-display" style="display: none;">
                                    <div class="alert-header">
                                        <i class="bx bx-error fs-5"></i>
                                    </div>
                                    <div class="alert-body">
                                        <ul id="e-error-list">

                                        </ul>
                                    </div>
                                </div>

                                <?php echo csrf_field(); ?>
                                <input type="hidden" id="e-id" />
                                <div class="p-3">

                                    <div class="mb-3 ">
                                        <label for="title" class="form-label text-muted">Title</label>
                                        <div class="input-group">
                                            <input id="e-title" type="text" value="<?php echo e(old('title')); ?>" name="title" autocomplete="off" placeholder="Content title" id="title" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="mb-3 ">
                                        <label for="content" class="form-label text-muted">Content</label>
                                        <textarea name="content" id="e-content" cols="30" class="form-control" rows="5"><?php echo e(old('content')); ?></textarea>
                                    </div>

                                    <div class="mb-3 w-100 mx-auto">
                                        <label for="evnt" class="form-label text-muted">Type</label>
                                        <div class="input-group">
                                            <select class="form-control" name="type" id="e-type">
                                                <option value="Feature">Features</option>
                                                <option value="Todo">Things todo</option>
                                                <option value="About">About</option>

                                                <option value="Chatbot-context">Chatbot context</option>
                                                <option value="gcash-payment">Gcash Qr</option>
                                                <option value="tanaw-map">Tanaw Map</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 w-100 mx-auto">
                                        <label for="evnt" class="form-label text-muted">Image</label>
                                        <div class="input-group">
                                            <input type="file" class="form-control" name="image">
                                        </div>
                                    </div>

                                    <input type="submit" id="btn-update" class="custom-btn mx-auto w-100" value="Save changes">
                                    <input type="button" id="btn-delete" class="btn btn-danger mt-2 mx-auto w-100" value="Remove">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End modal -->


<!-- add-content -->
<div class="modal fade" id="add-faq-modal" tabindex="-1" aria-labelledby="modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- form -->
                            <div class="d-flex justify-content-between align-items-center">
                                <h1>Add FAQ</h1>
                                <button class="btn btn-sm btn-danger" id="view-saves">view saveds</button>
                            </div>
                            <form method="POST" id="add-faq">

                                <div class="alert-container" id="faq-error-display" style="display: none;">
                                    <div class="alert-header">
                                        <i class="bx bx-error fs-5"></i>
                                    </div>
                                    <div class="alert-body">
                                        <ul id="faq-error-list">

                                        </ul>
                                    </div>
                                </div>

                                <?php echo csrf_field(); ?>
                                <div class="mb-3 ">
                                    <label for="question" class="form-label text-muted">Question</label>
                                    <div class="input-group">
                                        <input id="question" type="text" value="" name="question" autocomplete="off" placeholder="Sample question" class="form-control" />
                                    </div>
                                </div>

                                <div class="mb-3 ">
                                    <label for="answer" class="form-label text-muted">Answer</label>
                                    <div class="input-group">
                                        <input id="answer" type="text" value="" name="answer" autocomplete="off" placeholder="Answer" class="form-control" />
                                    </div>
                                </div>

                                <div class="mb-3 ">
                                    <button class="btn btn-sm btn-primary" id="btn-add-faq">Save</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End modal -->


<!-- add-content -->
<div class="modal fade" id="saves-modal" tabindex="-1" aria-labelledby="modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- form -->
                            <h1>FAQs</h1>

                            <table id="table-faq" class="display nowrap w-100 table-striped">
                                <thead>
                                    <tr style=" height: 10px;">
                                        <th>Id</th>
                                        <th>Question</th>
                                        <th>Answer</th>
                                        <th>Operation</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <script>
                            $(document).ready(function() {


                                function Alertmsg(header, msg, type) {
                                    Swal.fire(
                                        header,
                                        msg,
                                        type
                                    )
                                }

                                var table_faq = $('#table-faq').DataTable({
                                    responsive: true,
                                    'lengthMenu': [
                                        [10, 20, 35, 50, 60, -1],
                                        [10, 20, 35, 50, 60, 'All'],
                                    ],
                                    'order': [
                                        [0, 'desc']
                                    ]
                                })

                                function load_faq() {

                                    $.ajax({
                                        url: "<?php echo e(route('saves.faq.get')); ?>",
                                        type: 'get',
                                        dataType: 'json',
                                        beforeSend: function() {}
                                    }).done(function(data) {
                                        console.log(data.content.length)

                                        table_faq.clear().draw()
                                        for (let i = 0; i < data.content.length; i++) {
                                            var button_saves = '<button data-id="' + data.content[i].id + '" class="btn btn-sm btn-danger btn-delete-faq">Delete</button>'
                                            table_faq.row.add([data.content[i].id, data.content[i].question, data.content[i].answer, button_saves]).draw()
                                        }

                                    }).fail(function(e) {
                                        Alertmsg('Load failed', 'Error in fetching data', 'error')
                                    })
                                }

                                load_faq()


                                $('#table-faq tbody').on('click', 'tr td .btn-delete-faq', function() {
                                    Swal.fire({
                                        type: 'question',
                                        title: 'Are you sure?',
                                        text: ' Do you want to delete this FAQ',
                                        showCancelButton: true,
                                        confirmButtonText: 'Confirm'
                                    }).then((result) => {
                                        if (result.value) {
                                            var route = "<?php echo e(route('faq.destroy',':id')); ?>"
                                            return $.ajax({
                                                url: route.replace(':id', $(this)[0].dataset.id),
                                                type: 'get',
                                                dataType: 'json',
                                                beforeSend: function() {}
                                            }).done(function(data) {

                                                $('#saves-modal').modal('hide')
                                                load_faq()
                                                Alertmsg('Success', 'Deleted Successfully', 'success')
                                            }).fail(function(e) {
                                                Alertmsg('Load failed', 'Error in fetching data', 'error')
                                            })
                                        }
                                    })
                                })

                                $('#btn-add-faq').click(function(e) {
                                    e.preventDefault()
                                    $.ajax({
                                        url: "<?php echo e(route('faq.store')); ?>",
                                        type: 'post',
                                        data: {
                                            _token: '<?php echo e(csrf_token()); ?>',
                                            question: $('#question').val(),
                                            answer: $('#answer').val()
                                        },
                                        dataType: 'json',
                                        beforeSend: function() {
                                            $('#add-faq :input').prop("disabled", true);

                                            $('#faq-error-display').css('display', 'none');
                                            document.querySelector('#faq-error-list').innerHTML = ''
                                        }
                                    }).done(function(data) {
                                        $('#add-faq :input').prop("disabled", false);
                                        if (data.status == 200) {
                                            load_faq()
                                            Alertmsg('Success', data.msg, 'success')
                                            $('#question').val('')
                                            $('#answer').val('')
                                        }

                                        if (data.status === 400) {
                                            $('#faq-error-display').css('display', 'flex');
                                            $.each(data.error, function(prefix, val) {

                                                var li = document.createElement('li')
                                                li.innerText = val[0]
                                                document.querySelector('#faq-error-list').appendChild(li)
                                            })
                                        }
                                    }).fail(function(e) {
                                        Alertmsg('Request failed', 'Error in fetching data', 'error')
                                    })
                                })
                            })
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- End modal -->
<script>
    $(document).ready(function() {

        function Alertmsg(header, msg, type) {
            Swal.fire(
                header,
                msg,
                type
            )
        }


        $('#view-saves').click(function() {

            $('#saves-modal').modal('show')

        })



        var table = $('#table-content').DataTable({
            responsive: true,
            'lengthMenu': [
                [10, 20, 35, 50, 60, -1],
                [10, 20, 35, 50, 60, 'All'],
            ],
            'order': [
                [0, 'desc']
            ]
        })

        function load_data() {

            return $.ajax({
                url: "<?php echo e(route('content.get_json')); ?>",
                type: 'get',
                dataType: 'json',
                beforeSend: function() {}
            }).done(function(data) {
                console.log(data)

                table.clear().draw()

                for (let i = 0; i < data.content.length; i++) {

                    var button = '<button data-id="' + data.content[i][0] + '" data-title="' + data.content[i][1] + '" data-content="' + data.content[i][2] + '" data-type="' + data.content[i][4] + '" data-img="' + data.content[i][5] + '" class="btn btn-sm btn-dark btn-view-content" data-bs-toggle="modal" data-bs-target="#view-content-modal">View content</button>'
                    table.row.add([data.content[i][0], data.content[i][1], data.content[i][3], data.content[i][4], button]).draw()
                }
            }).fail(function(e) {
                Alertmsg('Load faile', 'Error in fetching data', 'error')
            })
        }

        load_data()

        $('#table-content tbody').on('click', 'tr td .btn-view-content', function() {
            var path = $(this)[0].dataset.img
            var img_uri = "<?php echo e(asset(':path')); ?>"
            $('#e-img').attr('src', img_uri.replace(':path', path))
            $('#e-id').val($(this)[0].dataset.id)
            $('#e-title').val($(this)[0].dataset.title)
            $('#e-content').val($(this)[0].dataset.content)
            $('#e-type').val($(this)[0].dataset.type)


            $('#btn-delete').attr('data-id', $(this)[0].dataset.id)
            $('#edit-content').attr('data-id', $(this)[0].dataset.id)
        })

        $('#btn-delete').on('click', function(e) {
            e.preventDefault()

            var uri = "<?php echo e(route('content.destroy',':id')); ?>"

            $.ajax({
                url: uri.replace(':id', $(this)[0].dataset.id),
                type: 'get',
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {},
                success: function(data) {
                    $('#add-content :input').prop("disabled", false);
                    if (data.status == 200) {

                        $('#view-content-modal').modal('toggle')
                        Alertmsg('Success', data.msg, 'success')
                        load_data()
                    }
                },
                error: function(e) {
                    Alertmsg('Failed', 'Something went wrong!', 'error')
                }
            });
        })

        $('#add-content').on('submit', function(e) {
            e.preventDefault()
            $.ajax({
                url: "<?php echo e(route('content.store')); ?>",
                type: 'post',
                data: new FormData(this),
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#add-content :input').prop("disabled", true);

                    $('#error-display').css('display', 'none');
                    document.querySelector('#error-list').innerHTML = ''

                },
                success: function(data) {
                    $('#add-content :input').prop("disabled", false);
                    if (data.status == 200) {
                        $('#add-content')[0].reset();
                        $('#add-content-modal').modal('toggle')

                        Alertmsg('Success', data.msg, 'success')
                        load_data()
                    }
                    if (data.status == 400) {
                        $('#error-display').css('display', 'flex');
                        $.each(data.error, function(prefix, val) {
                            // $('.error_' + prefix).text(val[0]);
                            var li = document.createElement('li')
                            li.innerText = val[0]
                            document.querySelector('#error-list').appendChild(li)
                        })
                    }
                },
                error: function(e) {
                    Alertmsg('Failed', 'Something went wrong!', 'error')
                }
            });
        });

        //edit

        $('#edit-content').on('submit', function(e) {
            e.preventDefault()
            var uri = "<?php echo e(route('content.update',':id')); ?>"
            $.ajax({
                url: uri.replace(':id', $(this)[0].dataset.id),
                type: 'post',
                data: new FormData(this),
                dataType: 'json',
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('#edit-content :input').prop("disabled", true);

                    $('#e-error-display').css('display', 'none');
                    document.querySelector('#error-list').innerHTML = ''

                },
                success: function(data) {
                    $('#edit-content :input').prop("disabled", false);
                    if (data.status == 200) {
                        $('#edit-content')[0].reset();
                        $('#view-content-modal').modal('toggle')

                        Alertmsg('Success', data.msg, 'success')
                        load_data()
                    }
                    if (data.status == 400) {
                        $('#e-error-display').css('display', 'flex');
                        $.each(data.error, function(prefix, val) {
                            // $('.error_' + prefix).text(val[0]);
                            var li = document.createElement('li')
                            li.innerText = val[0]
                            document.querySelector('#e-error-list').appendChild(li)
                        })
                    }
                },
                error: function(e) {
                    Alertmsg('Failed', 'Something went wrong!', 'error')
                }
            });
        });
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\sarah\Desktop\tanawsystem\tanaw-deploy\tanawsystem\resources\views/admin/manage_content.blade.php ENDPATH**/ ?>