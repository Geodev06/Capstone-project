<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($data[0]['payment'][0]->payment_id); ?></title>
    <!-- Core theme CSS (includes Bootstrap) -->
    <link href="<?php echo e(asset('./assets/bs/css/bootstrap.min.css')); ?>" rel="stylesheet" />
    <script src="<?php echo e(asset('./assets/bs/js/bootstrap.min.js')); ?>"></script>
    <link rel="stylesheet" href="<?php echo e(asset('./assets/bs/boxicons.min.css')); ?>" />
    <script src="<?php echo e(asset('./assets/js/jquery-3.5.1.js')); ?>"></script>
    <!-- user defined styles -->
    <link rel="stylesheet" href="<?php echo e(asset('./user/style.css')); ?>">
    <script type="text/javascript" src="<?php echo e(asset('./qrcode/qrcode.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('./qrcode/qrcode.js')); ?>"></script>
</head>

<style>
    p {
        font-size: 13px;
    }
</style>

<body>
    <div class="container" style="height: 100vh;">
        <div class="row">
            <div class="col-lg-6 mx-auto my-5">
                <h4>Entrance receipt</h4>
                <p style="">Tanaw de Rizal</p>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold">PAYMENT ID</h6>
                        <p><?php echo e($data[0]['payment'][0]->payment_id); ?></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold">PAYER EMAIL</h6>
                        <p><?php echo e($data[0]['payment'][0]->payer_email); ?></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold">DATE OF PAYMENT</h6>
                        <p><?php echo e($data[0]['payment'][0]->created_at->format('M d Y')); ?></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold">PAYMENT STATUS</h6>
                        <p><?php echo e($data[0]['payment'][0]->payment_status); ?></p>
                    </div>
                </div>
                <hr>
                <span style="font-size: 13px;">Entrance details</span>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <h6 class="fw-bold">PAYER ID</h6>
                        <p><?php echo e($data[0]['payment'][0]->payer_id); ?></p>
                    </div>

                    <div class="col-md-6">
                        <h6 class="fw-bold">AMOUNT</h6>
                        <p id="amount"></p>
                    </div>

                    <div class="col-md-12">
                        <h6 class="fw-bold">ONLY VALID ON</h6>
                        <p><?php echo e($data[0]['details'][0]->target_date); ?></p>
                    </div>

                    <div class="col-md-12">
                        <h6 class="fw-bold">HEAD NO.</h6>
                        <p><?php echo e($data[0]['details'][0]->no_of_person); ?></p>
                    </div>

                </div>
            </div>
            <div class="col-lg-6">

                <div class="card border-0 p-5 mt-5">

                    <h1 class="text-center mb-3 mt-2">Payment Receipt QR</h1>
                    <div class="mx-auto">
                        <div class="mb-3 qr_container mx-auto" id="qrcode">
                        </div>
                    </div>
                    <a class="btn btn-sm btn-dark mx-auto" id="btndl" hidden>Download</a>
                    <p class="text-muted text-center mt-3" style="font-size: 12px;">Scan this code with your devices.</p>

                </div>
            </div>
        </div>
    </div>
</body>
<script>
    var value = "<?php echo e($data[0]['payment'][0]->amount); ?>"
    var amount = document.querySelector('#amount').innerHTML = '\u20b1' + parseFloat(value).toFixed(2)

    function makeCode(data, filename) {

        var qrCode = new QRCode('qrcode', {
            text: data,
            width: 200,
            height: 200,
            colorDark: 'black',
            correctLevel: QRCode.CorrectLevel.H
        })

        qrCode.makeCode(data)

        setTimeout(() => {
            let qelem = document.querySelector('#qrcode img')
            let dl = document.querySelector('#btndl')
            let qr = qelem.getAttribute('src')
            dl.setAttribute('href', qr)
            dl.setAttribute('download', "<?php echo e($data[0]['payment'][0]->payment_id); ?>")
            dl.removeAttribute('hidden')
        }, 500)
    }
    const data = "<?php echo e(route('entrance.receipt',$data[0]['payment'][0]->payment_id)); ?>"


    makeCode(data, 'qr_code.png')
</script>

</html><?php /**PATH C:\Users\sarah\Desktop\tanawsystem\tanawsystem\resources\views/user/entrance_receipt.blade.php ENDPATH**/ ?>