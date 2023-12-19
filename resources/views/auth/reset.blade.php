<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>School | Reset Password </title>
  @php
  $getHeaderSetting = App\Models\SettingModel::getSingle();
@endphp
  <link href="{{ $getHeaderSetting->getFavicon() }}" rel="icon" type="image/jpg">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('public/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{url('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('public/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="{{url('')}}" class="h1"><b>School </b></a><h4>Reset Password</h4>
    </div>
    <div class="card-body">

      @include('_message')

      <form action="" method="post">
         {{ csrf_field() }}
        <div class="input-group mb-3">
          <input type="password" class="form-control" required name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          @if ($errors->has('password'))
          <p class="text-danger">{{ $errors->first('password') }}</p>
        @endif
        </div>

        <div class="input-group mb-3">
            <input type="password" class="form-control" required name="confirm_password" placeholder="Confrim Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            @if ($errors->has('confirm_password'))
            <p class="text-danger">{{ $errors->first('confirm_password') }}</p>
            @endif
          </div>

        <div class="row">

          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Reset</button>
          </div>

        </div>
      </form>

      <!-- /.social-auth-links -->

      <p class="mb-1">
        <br/>
        <a href=" {{ url('forgot-password') }}">Login</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ url('public/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ url('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ url('public/dist/js/adminlte.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
{!! Toastr::message() !!}
</body>
</html>
