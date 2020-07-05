<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Signin Template for Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link href="https://getbootstrap.com/docs/4.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/4.0/examples/sign-in/signin.css" rel="stylesheet">

    <link rel="stylesheet" href="/custom.css">

  </head>

  <body class="text-center">
    <form class="form-signin" method="POST" action="{{ route('login') }}">
        @csrf
      <img class="mb-4" src="https://ummgl.ac.id/wp-content/uploads/2017/10/logo-ummagelang-1.png" alt="" width="300" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <div class="form-group row">
            {{-- <label for="username" class="col-md-4 col-form-label text-md-left">{{ __('User ID') }}</label> --}}

            <div class="col-md-12">
                <input id="email" type="email" class="form-control bunder @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="email" required>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>


        <div class="form-group row">
            {{-- <label for="password" class="col-md-4 col-form-label text-md-left">{{ __('Password') }}</label> --}}

            <div class="col-md-12">
                <input id="password" type="password" class="form-control bunder @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

      @if (session('error'))
      <div class="alert alert-danger alert-block">
          <button type="button" class="close" data-dismiss="">x</button>
          <strong>{{session('error')}}</strong>
      </div>
      @endif

        <div class="form-group row mb-0">
            <div class="col-md-12">
            <button type="submit" class="btn btn-primary bunder">
                {{ __('Login') }}
            </button>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-12">
            @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            @endif
            </div>
        </div>


      {{-- <a href="#">Forgot password</a>
      <button class="btn btn-lg btn-primary btn-block bunder mt-2" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted">&copy; 2020</p> --}}
    </form>
  </body>
</html>
