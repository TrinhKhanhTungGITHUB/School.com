<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1,  shrink-to-fit=no">
    <title>School | Log in </title>
    @php
        $getHeaderSetting = App\Models\SettingModel::getSingle();
    @endphp
    <link href="{{ $getHeaderSetting->getFavicon() }}" rel="icon" type="image/jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('public/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ url('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('public/dist/css/adminlte.min.css') }}">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ url('public/dist/fonts/icomoon/style.css') }}">

    <link rel="stylesheet" href="{{ url('public/dist/css/owl.carousel.min.css') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ url('public/dist/css/bootstrap.min.css') }}">

    <!-- Style -->
    <link rel="stylesheet" href="{{ url('public/dist/css/style.css') }}">
</head>

<body class="hold-transition login-page">

{{-- <body> --}}
    <div class="d-lg-flex half">
        <img class="bg order-1 order-md-2" src="{{ url('public/dist/images/bg_1.jpg') }}" alt="">
        <div class="contents order-2 order-md-1">

            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-8">
                        <div class="text-center">
                            <a href="{{ url('') }}" class="h1"><b>School </b>Login</a>
                        </div>
                        <p class="login-box-msg">Sign in to start your session</p>

                        <form action=" {{ url('login')}}" method="post">
                            {{ csrf_field() }}
                            <label for="">Email</label>
                                <div class="input-group mb-4">
                                    <input type="email" class="form-control" required name="email"
                                        placeholder="your-email@gmail.com" value="{{ old('email') }}">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-envelope"></span>
                                        </div>
                                    </div>
                                </div>

                            <label >Password</label>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" name="password" placeholder="Password"
                                    value="{{ old('password') }}">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                @if ($errors->has('email'))
                                    <p class="text-danger">{{ $errors->first('email') }}</p>
                                @endif
                                @if ($errors->has('password'))
                                    <p class="text-danger">{{ $errors->first('password') }}</p>
                                @endif
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex mb-5 align-items-center">
                                        <label class="control control--checkbox mb-0"><span class="caption">Remember
                                                me</span>
                                            <input type="checkbox" checked="checked" name="remember" />
                                            <div class="control__indicator"></div>
                                        </label>
                                        <span class="ml-auto"><a href="{{url('forgot-password')}}" class="forgot-pass">Forgot
                                                Password</a></span>
                                    </div>

                                </div>
                            </div>
                            <button type="submit" class="btn btn-block btn-primary">Login</button>

                        </form>
                    </div>
                </div>
            </div>



        </div>


    </div>

    {{-- <!-- jQuery -->
    <script src="{{ url('public/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('public/dist/js/adminlte.min.js') }}"></script> --}}
    <script src="{{ url('public/dist/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ url('public/dist/js/popper.min.js') }}"></script>
    <script src="{{ url('public/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('public/dist/js/main.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    {!! Toastr::message() !!}
</body>

</html>
