<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancellation request</title>


    <link href="{{ asset('./assets/bs/css/bootstrap.min.css')}}" rel="stylesheet" />
    <script src="{{ asset('./assets/bs/js/bootstrap.min.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('./assets/bs/boxicons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles.css') }}" />
    <script src="{{ asset('./assets/js/jquery-3.5.1.js')}}"></script>

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 p-5">
                <h1>Tanaw web app</h1>
                <h5>Hi, {{ $mailData['to']}}</h5>
                <p>We've already processed your refund request. please check your account. if you have question feel free to contact the administrator.</p>
            </div>
        </div>
    </div>
</body>

</html>