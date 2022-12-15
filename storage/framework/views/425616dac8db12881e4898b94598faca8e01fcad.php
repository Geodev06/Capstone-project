

<?php $__env->startSection('booking'); ?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>

<div class="row p-5" style="background-color: #f2f2f2; height:100vh">
    <div class="col-md-12">
        <table id="table-booking" class="display nowrap w-100 table-striped">
            <thead>
                <tr style=" height: 10px;">
                    <th>Payment_id</th>
                    <th>Check in plan</th>
                    <th>Room no.</th>
                    <th>Target date.</th>
                    <th>Valid until</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<script>
    $(function() {

        function Alertmsg(header, msg, type) {
            Swal.fire(
                header,
                msg,
                type
            )
        }

        var table = $('#table-booking').DataTable({
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
                url: "<?php echo e(route('user.booking.get')); ?>",
                type: 'get',
                dataType: 'json',
                beforeSend: function() {}
            }).done(function(data) {
                console.log(data)

                table.clear().draw()

                for (let i = 0; i < data.content.length; i++) {

                    var button = '<button data-pay_id="' + data.content[i].payment_id + '" class="btn btn-sm btn-dark btn-more btn-view-content" >More</button>'
                    table.row.add([data.content[i].payment_id, data.content[i].plan, data.content[i].room_no, data.content[i].target_date, data.content[i].validity, button]).draw()
                }
            }).fail(function(e) {
                Alertmsg('Load faile', 'Error in fetching data', 'error')
            })
        }

        load_data()

        $('#table-booking tbody').on('click', 'tr td .btn-more', function() {

            $('#info-modal').modal('toggle')

            var route = "<?php echo e(route('user.booking_detail.get',':id')); ?>"

            $('#btn-receipt').attr('data-id', $(this)[0].dataset.pay_id)
            $.ajax({
                url: route.replace(':id', $(this)[0].dataset.pay_id),
                type: 'get',
                dataType: 'json',
                beforeSend: function() {}
            }).done(function(data) {
                $('#p_id').text(data.content[0].payment_id)
                $('#t_date').text(data.content[0].target_date)
                $('#c_date').text(data.content[0].check_out_date)
                $('#plan').text(data.content[0].plan)
                $('#room_no').text(data.content[0].room_no)
                $('#p-status').text(data.content[0].status)
                var p_date = new Date(data.content[0].created_at).toLocaleDateString()
                $('#p-date').text(p_date)


                $('#btn-revoke').attr('data-id', data.content[0].payment_id)
                $('#btn-revoke').attr('data-status', data.content[0].status)


            }).fail(function(e) {
                Alertmsg('Load faile', 'Error in fetching data', 'error')
            })


        })

        $('#btn-receipt').on('click', function() {
            var uri_ = "<?php echo e(route('check_in.receipt',':id')); ?>"
            window.open(uri_.replace(':id', $(this)[0].dataset.id))
        })

        $('#btn-revoke').click(function() {
            if ($(this)[0].dataset.status == 'reserved') {
                Swal.fire({
                    type: 'question',
                    title: 'Are you sure?',
                    text: ' Do you want to cancel this booking reservation? this process will take time until the administrator approve. we will send you further notification about the refund.',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm'
                }).then((result) => {
                    if (result.value) {
                        var route = "<?php echo e(route('booking.cancel',':id')); ?>"
                        return $.ajax({
                            url: route.replace(':id', $(this)[0].dataset.id),
                            type: 'get',
                            dataType: 'json',
                            beforeSend: function() {}
                        }).done(function(data) {


                            Alertmsg('Success', 'Your request has been sent', 'success')
                        }).fail(function(e) {
                            Alertmsg('Load failed', 'Error in fetching data', 'error')
                        })
                    }
                })
            } else {

                Alertmsg('Cannot be done', 'This booking has been used or invalid validity', 'error')
            }
        })
    })
</script>
<!-- Booking payment -->
<div class="modal fade" id="info-modal" tabindex="-1" aria-labelledby="modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="p-2">
                                <h3>Booking details</h3>
                            </div>
                            <div class="row">
                                <div class="col-md-12 bg-light p-2 mb-2">
                                    <h6 class="text-muted">Payment id</h6 class="text-muted">
                                    <span id="p_id" class="fw-bold">Loading...</span>
                                </div>
                                <div class="col-md-12 bg-light p-2 mb-2">
                                    <h6 class="text-muted">Target date</h6 class="text-muted">
                                    <span id="t_date" class="fw-bold">Loading...</span>
                                </div>
                                <div class="col-md-12 bg-light p-2 mb-2">
                                    <h6 class="text-muted">Check out date</h6 class="text-muted">
                                    <span id="c_date" class="fw-bold">Loading...</span>
                                </div>
                                <div class="col-md-6 bg-light p-2 mb-2">
                                    <h6 class="text-muted">Plan</h6 class="text-muted">
                                    <span id="plan" class="fw-bold">Loading...</span>
                                </div>
                                <div class="col-md-6 bg-light p-2 mb-2">
                                    <h6 class="text-muted">Room no.</h6 class="text-muted">
                                    <span id="room_no" class="fw-bold text-danger text-uppercase">Loading...</span>
                                </div>

                                <div class="col-md-12 bg-light p-2 mb-2">
                                    <h6 class="text-muted">Date of payment</h6 class="text-muted">
                                    <span id="p-date" class="fw-bold">Loading...</span>
                                </div>

                                <div class="col-md-12 bg-light p-2 mb-2">
                                    <h6 class="text-muted">Booking status</h6 class="text-muted">
                                    <span id="p-status" class="fw-bold text-primary">Loading...</span>
                                </div>

                                <div class="col-md-12">
                                    <button id="btn-receipt" class="btn btn-sm btn-primary">View receipt</button>
                                    <button id="btn-revoke" class="btn btn-sm btn-danger">Cancel my booking</button>
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
<?php echo $__env->make('user.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\sarah\Desktop\tanawsystem\tanaw-deploy\tanawsystem\resources\views/user/user_booking.blade.php ENDPATH**/ ?>