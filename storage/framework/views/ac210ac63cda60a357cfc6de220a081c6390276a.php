

<?php $__env->startSection('payments'); ?>
<script src="<?php echo e(asset('./dataTables/datatables.js')); ?>"></script>
<link rel="stylesheet" href="<?php echo e(asset('./dataTables/datatables.min.css')); ?>" />
<link rel="stylesheet" href="<?php echo e(asset('./dataTables/datatables.css')); ?>" />
<script src="<?php echo e(asset('./dataTables/datatables.min.js')); ?>"></script>
<div class="row p-5">
    <p>User > Payments</p>
    <div class="col-md-12">
        <table id="table-content" class="display nowrap w-100 table-striped">
            <thead>
                <tr style=" height: 10px;">
                    <th>Payment Id</th>
                    <th>Payer Id</th>
                    <th>Paymer Email</th>
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
                url: "<?php echo e(route('payments.get_json')); ?>",
                type: 'get',
                dataType: 'json',
                beforeSend: function() {}
            }).done(function(data) {
                console.log(data)

                table.clear().draw()

                for (let i = 0; i < data.payments.length; i++) {

                    var button = '<button data-userid="" data-date="' + data.payments[i][5] + '" data-status="' + data.payments[i][4] + '" data-payment_id="' + data.payments[i][0] + '" data-payer_id="' + data.payments[i][1] + '" data-payer_email="' + data.payments[i][2] + '" data-amount="' + data.payments[i][3] + '" class="btn btn-sm btn-dark btn-more">More</button>'
                    var payment_status = '<span class="bagde badge-success">' + data.payments[i][4] + '</span>'
                    table.row.add([data.payments[i][0], data.payments[i][1], data.payments[i][2], "\u20B1" + parseFloat(data.payments[i][3]).toFixed(2), payment_status, data.payments[i][5], button]).draw()
                }
            }).fail(function(e) {
                Alertmsg('Load failed', 'Error in fetching data', 'error')
            })
        }

        load_data()

        $('#table-content tbody').on('click', 'tr td .btn-more', function() {

            $('#payment-id').text($(this)[0].dataset.payment_id)
            $('#payer-id').text($(this)[0].dataset.payer_id)
            $('#p-email').text($(this)[0].dataset.payer_email)
            $('#amount').text("\u20B1" + $(this)[0].dataset.amount)
            $('#status').text($(this)[0].dataset.status)
            $('#date').text($(this)[0].dataset.date)
            $('#info-modal').modal('toggle')

            $('#btn-open-link').attr('data-id', $(this)[0].dataset.payment_id)
        })

        $('#btn-open-link').on('click', function() {
            var route = "<?php echo e(route('check_in.receipt',':id')); ?>"
            window.open(route.replace(':id', $(this)[0].dataset.id))
        })
    })
</script>
<!-- add-content -->

<style>
    span {
        font-size: 12px;
    }
</style>

<div class="modal fade" id="info-modal" tabindex="-1" aria-labelledby="modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="p-2">
                                <h3>Payment details</h3>
                            </div>
                            <div class="row p-5">
                                <div class="col-md-4 mb-3">
                                    <h6 class="text-muted">Payment Id</h6>

                                    <span class="fw-bold" id="payment-id">id</span>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <h6 class="text-muted">Payer id</h6>
                                    <span class="fw-bold" id="payer-id">email</span>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <h6 class="text-muted">Payer email</h6>
                                    <span class="fw-bold" id="p-email">Date</span>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <h6 class="text-muted">Amount</h6>
                                    <span class="fw-bold" id="amount">amount</span>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <h6 class="text-muted">Status</h6>
                                    <span class="fw-bold" id="status">status</span>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted">Date of payment</h6>
                                    <span class="fw-bold" id="date">date</span>
                                </div>
                                <div class="col-md-12">
                                    <button id="btn-open-link" class="btn btn-sm btn-danger">View receipt</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End modal -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\tanawsystem\resources\views/admin/user_payments.blade.php ENDPATH**/ ?>