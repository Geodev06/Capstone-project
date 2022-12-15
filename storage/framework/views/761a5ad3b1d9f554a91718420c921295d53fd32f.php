

<?php $__env->startSection('users'); ?>

<script src="<?php echo e(asset('./dataTables/datatables.js')); ?>"></script>
<link rel="stylesheet" href="<?php echo e(asset('./dataTables/datatables.min.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(asset('./dataTables/datatables.css')); ?>" />
<script src="<?php echo e(asset('./dataTables/datatables.min.js')); ?>"></script>

<div class="row p-5">
    <div class="col-sm-12 col-md-12 col-lg-12">
        <p>Manage > Users</p>
        <table id="table-users" class="display nowrap w-100 table-striped">
            <thead>
                <tr style=" height: 10px;">
                    <th>User id</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Reg. date</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script>
    function Alertmsg(header, msg, type) {
        Swal.fire(
            header,
            msg,
            type
        )
    }

    var table = $('#table-users').DataTable({
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
            url: "<?php echo e(route('users.get_json')); ?>",
            type: 'get',
            dataType: 'json',
            beforeSend: function() {}
        }).done(function(data) {
            console.log(data)

            table.clear().draw()

            for (let i = 0; i < data.users.length; i++) {

                var button = '<button class="btn btn-sm btn-warning" disabled="disabled">Remove</button>'
                table.row.add([data.users[i][0], data.users[i][1], data.users[i][2], data.users[i][3], data.users[i][4], data.users[i][5], button]).draw()
            }
        }).fail(function(e) {
            Alertmsg('Load faile', 'Error in fetching data', 'error')
        })
    }

    load_data()
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\sarah\Desktop\tanawsystem\tanawsystem\resources\views/admin/users.blade.php ENDPATH**/ ?>