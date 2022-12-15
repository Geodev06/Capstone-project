

<?php $__env->startSection('payments'); ?>
<script src="<?php echo e(asset('./dataTables/datatables.js')); ?>"></script>
<link rel="stylesheet" href="<?php echo e(asset('./dataTables/datatables.min.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(asset('./dataTables/datatables.css')); ?>" />
<script src="<?php echo e(asset('./dataTables/datatables.min.js')); ?>"></script>
<div class="row p-5" style="background-color: #f2f2f2;">
    <p>My Payments</p>
    <div class="col-md-12">
        <table id="table-content" class="display nowrap w-100 table-striped">
            <thead>
                <tr style=" height: 10px;">
                    <th>Payment Id</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Created at</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
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
                url: "<?php echo e(route('user.payments.json',$userdata->id)); ?>",
                type: 'get',
                dataType: 'json',
                beforeSend: function() {}
            }).done(function(data) {

                table.clear().draw()

                for (let i = 0; i < data.payments.length; i++) {

                    var button = '<button class="btn btn-sm btn-dark btn-view-content" data-bs-toggle="modal" data-bs-target="#view-content-modal">More</button>'
                    var payment_status = '<span class="bagde badge-success">' + data.payments[i][2] + '</span>'
                    table.row.add([data.payments[i][0], "\u20B1" + parseFloat(data.payments[i][1]).toFixed(2), payment_status, data.payments[i][3], button]).draw()
                }
            }).fail(function(e) {
                Alertmsg('Load failed', 'Error in fetching data', 'error')
            })
        }

        load_data()
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\sarah\Desktop\tanawsystem\tanawsystem\resources\views/user/payments.blade.php ENDPATH**/ ?>