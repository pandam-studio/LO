<!DOCTYPE html>
<html>
  <head>
    <title>Login Admin</title>
    <meta charset="utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta content="template language" name="keywords">
    <meta content="PamerlAN soziDev" name="author">
    <meta content="AdMin dashboard html template" name="description">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="favicon.png" rel="shortcut icon">
    <link href="apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
    <link href="admin/bower_components/select2/dist/css/select2.min.css" rel="stylesheet">
    <link href="admin/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="admin/bower_components/dropzone/dist/dropzone.css" rel="stylesheet">
    <link href="admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="admin/bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="admin/bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" rel="stylesheet">
    <link href="admin/bower_components/slick-carousel/slick/slick.css" rel="stylesheet">
    <link href="admin/css/main.css?version=4.4.0" rel="stylesheet">
  </head>
  <body class="auth-wrapper">
    <div class="all-wrapper menu-side with-pattern">
      <div class="auth-box-w">
        <div class="logo-w">
          <img width="270px" alt="" src="https://ummgl.ac.id/wp-content/uploads/2017/10/logo-ummagelang-1.png">
        </div>
        <h4 class="auth-header">
          Login Form
        </h4>
        <form action="{{ route('login') }}" method="POST">
            @csrf
          <div class="form-group">
            <label for="">NIK</label>
            <input class="form-control @error('email') is-invalid @enderror"
            placeholder="Enter your NIK" type="text" autocomplete="email"
            name="nik" value="{{ old('nik') }}">
            <div class="pre-icon os-icon os-icon-user-male-circle"></div>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="form-group">
            <label for="">Password</label>
            <input class="form-control @error('password') is-invalid @enderror"
            placeholder="Enter your password" type="password" autocomplete="current-password"
            name="password" required>
            <div class="pre-icon os-icon os-icon-fingerprint"></div>
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="buttons-w">
            <button class="btn btn-primary" type="submit"> {{ __('Login') }}</button>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
