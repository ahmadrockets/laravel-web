<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>{{ config('app.name') }} | Forgot Password</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('stisla/modules/bootstrap/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('stisla/modules/fontawesome/css/all.min.css')}}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{asset('stisla/modules/izitoast/css/iziToast.min.css')}}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('stisla/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('stisla/css/components.css')}}">
  <!-- Start GA -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-94034622-3');
  </script>
  <!-- /END GA -->
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <a href="{{route('root')}}">
                <img src="{{asset('stisla/img/stisla-fill.svg')}}" alt="logo" width="100" class="shadow-light rounded-circle">
              </a>
            </div>

            <div class="card card-primary">
              <div class="card-header">
                <h4>Reset Password</h4>
              </div>

              <div class="card-body">
                <form method="POST" action="{{route('auth.doResetPassword')}}">
                  @csrf
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" value="{{$resetPassData->email}}" disabled class="form-control" name="email" tabindex="1">
                    <input id="token" type="hidden" value="{{$token}}" class="form-control" name="token" tabindex="1" required>
                  </div>

                  <div class="form-group">
                    <label for="password">New Password</label>
                    <input id="password" type="password" class="form-control" name="password" tabindex="1" required autofocus>
                  </div>

                  <div class="form-group">
                    <label for="password_confirmation">Confirm New Password</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" tabindex="1" required>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Reset Password
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="simple-footer">
              Copyright &copy; {{ config('app.name') }} | {{date('Y')}}
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="{{asset('stisla/modules/jquery.min.js')}}"></script>
  <script src="{{asset('stisla/modules/popper.js')}}"></script>
  <script src="{{asset('stisla/modules/tooltip.js')}}"></script>
  <script src="{{asset('stisla/modules/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('stisla/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
  <script src="{{asset('stisla/modules/moment.min.js')}}"></script>
  <script src="{{asset('stisla/js/stisla.js')}}"></script>

  <!-- JS Libraies -->
  <script src="{{asset('stisla/modules/izitoast/js/iziToast.min.js')}}"></script>
  <!-- Page Specific JS File -->
  <script src="{{asset('stisla/js/page/modules-toastr.js')}}"></script>

  <!-- Template JS File -->
  <script src="{{asset('stisla/js/scripts.js')}}"></script>
  <script src="{{asset('stisla/js/custom.js')}}"></script>

  @if (session('success'))
  <script>
    iziToast.success({
      title: 'Success',
      message: '{{session("success")}}',
      position: 'topRight'
    });
  </script>
  @endif
  @foreach ($errors->all() as $error)
  <script>
    iziToast.warning({
      title: 'Failed',
      message: '{{ $error }}',
      position: 'topRight'
    });
  </script>
  @endforeach
</body>

</html>