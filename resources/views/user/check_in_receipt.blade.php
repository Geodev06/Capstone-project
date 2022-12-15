@if(count($payment) > 0)
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $payment[0]->payment_id}}</title>

    <!-- assets -->
    <link href="{{ asset('./assets/bs/css/bootstrap.min.css')}}" rel="stylesheet" />
    <script src="{{ asset('./assets/bs/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('./qrcode/qrcode.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('./qrcode/qrcode.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('./assets/bs/boxicons.min.css') }}" />
    <script src="{{ asset('./assets/js/jquery-3.5.1.js')}}"></script>
    <script src="{{ asset('./sweetalert/sweetalert.min.js')}}" defer></script>
    <style>
        p {
            font-size: 12px;
            font-weight: 600;
            margin: 0px;
        }

        span {
            font-size: 12px;
            font-weight: normal;
        }

        .info-container p {
            padding: 2px;
        }

        a {
            font-size: 12px;
            text-decoration: none;
        }
    </style>
</head>

<body class="bg-light">
    @if(Session::has('success'))
    <script>
        $(document).ready(function() {
            Swal.fire(
                'Success',
                "{{ Session::get('success')}}",
                'success'
            )
        })
    </script>
    @endif
    <div class="container-fluid">
        <div class="row p-5">

            <div class="col-md-12 col-lg-5 mt-5">
                <a href="{{route('user.dashboard')}}" class="float-end w-auto ">To dashboard</a>
                <h1 class="fw-bold">Payment Success!</h1>
                <h2 class="fw-bold">Tanaw UI</h2>
                <div class="my-card p-3">
                    <p>Receipt Id : <span id="rid"></span></p>
                    <p>Payment Id : <span>{{$payment[0]->payment_id}}</span></p>
                    <p>Payer Id : <span>{{$payment[0]->payer_id}}</span></p>
                    <p>Paypal Email : <span>{{$payment[0]->payer_email}}</span></p>
                    <hr>
                    <div class="info-container">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <p class="fw-bold text-muted" style="font-size: 10px;">NAME</p>
                                <span class="fw-bold ">{{$details[0]->checker_name}}</span>
                            </div>
                            <div class="col-md-6 mb-3 d-flex justify-content-between">
                                <div>
                                    <p class="fw-bold text-muted" style="font-size: 10px;">ADDRESS</p>
                                    <span class="fw-bold">{{$details[0]->address}}</span>
                                </div>
                                <div>
                                    <p class="fw-bold text-muted" style="font-size: 10px;">PHONE</p>
                                    <span class="fw-bold">{{$details[0]->mobile}}</span>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div>
                                    <p class="fw-bold text-muted" style="font-size: 10px;">EMAIL</p>
                                    <span class="fw-bold">{{$details[0]->email}}</span>

                                </div>

                            </div>

                            <div class="col-md-8 mb-3 text-end">
                                <p class="fw-bold text-muted" style="font-size: 10px;">PAYMENT STATUS</p>
                                <span class="fw-bold text-success text-uppercase">{{$payment[0]->payment_status}}</span>
                            </div>
                            <div class="col-md-6">
                                <p class="fw-bold text-muted" style="font-size: 10px;">CHECK IN DATE</p>
                                <span class="fw-bold ">{{$details[0]->target_date}}</span>
                            </div>
                            <div class="col-md-6">
                                <p class="fw-bold text-muted" style="font-size: 10px;">ONLY VALID UNTIL</p>
                                <span class="fw-bold ">{{$details[0]->target_date}}</span>
                            </div>
                            <div class="col-md-12 mt-3">
                                <p class="fw-bold text-muted" style="font-size: 10px;">CHECK IN PLAN</p>
                                <span class="fw-bold fs-4 text-muted">{{$details[0]->plan}}</span>
                            </div>
                            <div class="col-md-8">
                                <p class="fw-bold text-muted" style="font-size: 10px;">FEES</p>
                                <ul style="list-style-type: none; font-size:10px">
                                    <li>Discount: &#8369 0.00</li>
                                    <li>Extra fees: &#8369 0.00</li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <p class="fw-bold text-muted" style="font-size: 10px;">TOTAL AMOUNT</p>
                                <span class="fw-bold fs-4" id="amount"></span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <p>Payment date: {{ $details[0]->created_at->format(' jS, \of F, Y  g:i  A')}}</p>
                    <p class="text-center mt-3 fw-light">Thank you for choosing us.</p>
                </div>
            </div>

            <div class="col-md-12 col-lg-7 mt-5">

                <div class="card p-5">

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
    var rid = "{{ $payment[0]->id }}"
    document.querySelector('#rid').innerHTML = rid.padStart(8, '0')

    var amount = "{{ $payment[0]->amount }}"
    document.querySelector('#amount').innerHTML = '\u20B1' + parseFloat(amount).toFixed(2)

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
            dl.setAttribute('download', "{{ $payment[0]->payment_id }}")
            dl.removeAttribute('hidden')
        }, 500)
    }
    const data = "{{ route('check_in.receipt',$payment[0]->payment_id)}}"


    makeCode(data, 'qr_code.png')
</script>

</html>
@else
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404</title>
</head>

<body>
    <h1>404 NOT FOUND!</h1>
</body>

</html>
@endif