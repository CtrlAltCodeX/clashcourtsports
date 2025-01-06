<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="title" content="Clash Court Sports - Login">
  <meta name="description" content="Clash Court Sports">
  <link rel="icon" type="image/ico" href="{{ asset('assets/images/favicon.ico') }}">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <title>Clash Court Sports</title>
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
</head>

<body>
  <div class="body_main">
    <!-- Header Section -->
    @include('layouts.header')

    <!-- Alert Section -->
    @if(session('alert'))
    <div class="alert alert-warning">
      {{ session('alert') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-warning">
      {{ session('error') }}
    </div>
    @endif

    <!-- Banner Section -->
    <div class="login_banner_section bg_img_login">
      <div class="login_section">
        <div class="container sports_container">
          <form action="{{ route('userPost.auth.login') }}" method="POST">
            @csrf
            <div class="login_box">
              <!-- Email Input -->
              <div class="login_group mb_30">
                <p class="label_from">Email Address <span>*</span></p>
                <input type="email" name="email" class="form-control info_form_control" placeholder="Enter your email" required>
                @error('email')
                <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
              </div>

              <!-- Password Input -->
              <div class="login_group mb_30">
                <p class="label_from">Password <span>*</span></p>
                <input type="password" name="password" class="form-control info_form_control" placeholder="Enter your password" required>
                @error('password')
                <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
              </div>

              <!-- General Error Display -->
              @if ($errors->has('email'))
              <div class="text-danger mt-2">{{ $errors->first('email') }}</div>
              @endif

              <!-- Forgot Password -->
              <div class="login_group">
                <a href="{{ route('password.request') }}" class="lost_link">Lost Your Password?</a>
              </div>

              <!-- Remember Me -->
              <div class="login_group">
                <div class="form-check remember_check">
                  <input type="checkbox" name="remember" class="form-check-input" id="remember">
                  <label class="form-check-label" for="remember">Remember Me</label>
                </div>
              </div>

              <!-- Submit Button -->
              <div class="login_group">
                <button type="submit" class="btn join_now_btn">Log In</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Login Section -->

    <!-- Footer Section -->
    @include('layouts.footer')
  </div>

  <!-- Scripts -->
  <script src="{{ asset('assets/js/jquery.js') }}"></script>
  <script src="{{ asset('assets/js/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>

</html>