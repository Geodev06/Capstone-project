<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Tanaw Login</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- or -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="{{ asset('styles.css') }}" />
    <script src="{{ asset('./assets/js/jquery-3.5.1.js')}}"></script>

    <script src="{{ asset('scripts.js')}}" defer></script>
    <style>
        #index {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row p-5">
            <div class="col-sm-12 col-md-6 col-lg-4 mx-auto">
                <div class="d-flex flex-column">
                    <h1 class="fw-bold text-center" id="index">Tanaw ui</h1>
                    <h3 class="text-center mt-4">Sign in</h3>
                    <p class="text-center text-muted">Please login to continue.</p>


                    <form class="p-4" method="POST" action="{{ route('login') }}" autocomplete="off">
                        @csrf
                        @if($errors->any())
                        <div class="alert-container mb-3">
                            <div class="alert-header">
                            </div>
                            <div class="alert-body">
                                <ul>
                                    @foreach($errors->all() as $errors)
                                    <li>{{ $errors }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                        @if(Session::has('error'))
                        <div class="alert-container mb-3">
                            <div class="alert-header">
                            </div>
                            <div class="alert-body">
                                <p>{{Session::get('error')}}</p>
                            </div>
                        </div>
                        @endif



                        <div class="input-container mb-3">
                            <i class="bx bx-user"></i>
                            <input type="email" name="email" placeholder="Email address" value="{{ old('email') }}" />
                        </div>

                        <div class="input-container mb-3">
                            <i class="bx bx-lock"></i>
                            <input type="password" name="password" placeholder="Password" />
                        </div>

                        <div class="d-flex justify-content-between align-items-center p-2 ">
                            <div class="form-check">
                                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                                <label for="remember" class="form-check-label">Remember Me</label>
                            </div>
                            <a href="{{ route('password.request') }}" style="font-size: 12px;">Forgot password</a>
                        </div>

                        <div class="mb-3">
                            <!-- {!! NoCaptcha::renderJs() !!}
                            {!! NoCaptcha::display() !!} -->
                        </div>

                        <input type="submit" class="custom-btn mx-auto w-100" value="Login">
                        <hr>
                        <p>Does not have an account? <a href="{{ route('register') }}">Sign up</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        $('#index').on('click', function(e) {
            e.preventDefault()
            window.location.replace("{{ route('index') }}")
        })
    })
</script>

</html>