<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="title" content="Clash Court Sports- Join Now">
  <meta name="description" content="Clash Court Sports">
  <meta name="keywords" content="Clash Court Sports">
  <link rel="icon" type="image/ico" href="{{ asset('assets/images/favicon.ico') }}">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" />
</head>

<body>
  <div class="body_main">
    @include('layouts.header')
    @if(session('alert'))
    <div class="alert alert-warning">
        {{ session('alert') }}
    </div>
 
@endif

    <div class="join_now_bannner">
      <div class="container sports_container">
        <div class="event_content">
          <h1 class="event_headng">The Event is coming soon</h1>
          <p class="event_sub_heading">Get ready for something exciting! Our team is hard at work crafting an exceptional experience for you.</p>
          <a  href="{{ route('user.auth.login') }}" class="btn event_btn" target="_blank">Join Now</a>
        </div>
      </div>
    </div>
    <div class="login_section">
      <div class="container sports_container">
        <div class="timer_box">
          <ul class="timer_list">
          <li>
      <div class="timer_box_inner">
        <p class="minutes_text" id="hours">-- <span>Hours</span></p>
      </div>
    </li>
    <li>
      <div class="timer_box_inner">
        <p class="minutes_text" id="minutes">-- <span>Minutes</span></p>
      </div>
    </li>
    <li>
      <div class="timer_box_inner">
        <p class="minutes_text" id="seconds">-- <span>Seconds</span></p>
      </div>
    </li>
          </ul>
        </div>
      
  <form action="{{ route('stripe.checkout.joinNow', $official->id) }}" method="POST">
  @csrf
  <div class="login_section">
    <div class="container sports_container">
      <div class="login_box">
        <ul class="join_now_list">
          <!-- First Name -->
          <li>
            <div class="login_group mb_30">
              <p class="label_from">First Name <span>*</span></p>
              <input type="text" name="first_name" class="form-control info_form_control" value="{{ old('first_name') }}">
              @error('first_name')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </li>
          <!-- Last Name -->
          <li>
            <div class="login_group mb_30">
              <p class="label_from">Last Name <span>*</span></p>
              <input type="text" name="last_name" class="form-control info_form_control" value="{{ old('last_name') }}">
              @error('last_name')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </li>
          <!-- Phone Number -->
          <li>
            <div class="login_group mb_30">
              <p class="label_from">Phone Number <span>*</span></p>
              <input type="text" name="phone_number" class="form-control info_form_control" value="{{ old('phone_number') }}">
              @error('phone_number')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </li>
          <!-- Email -->
          <li>
            <div class="login_group mb_30">
              <p class="label_from">Email <span>*</span></p>
              <input type="email" name="email" class="form-control info_form_control" value="{{ old('email') }}">
              @error('email')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </li>
          <!-- City -->
          <li>
            <div class="login_group mb_30">
              <p class="label_from">City <span>*</span></p>
              <input type="text" name="city" class="form-control info_form_control" value="{{ old('city') }}">
              @error('city')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </li>
          <!-- State -->
          <li>
            <div class="login_group mb_30">
              <p class="label_from">State <span>*</span></p>
              <input type="text" name="state" class="form-control info_form_control" value="{{ old('state') }}">
              @error('state')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </li>
          <!-- Zip/Postal Code -->
          <li>
            <div class="login_group mb_30">
              <p class="label_from">Zip/Postal Code <span>*</span></p>
              <input type="text" name="zip_code" class="form-control info_form_control" value="{{ old('zip_code') }}">
              @error('zip_code')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </li>
          <!-- Password -->
          <li>
            <div class="login_group mb_30">
              <p class="label_from">Password <span>*</span></p>
              <input type="password" name="password" class="form-control info_form_control">
              @error('password')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </li>
        
          <!-- Game Option -->
          <li>
    <div class="radio_box mb_30">
        <p class="label_from mb_30">{{ $official->game_name }}<span>*</span></p>
        <div class="form-check remember_check radio_check">
            <input class="form-check-input" type="radio" name="game_type" value="{{ $official->pricing }}" id="radiocheck_single">
            <label class="form-check-label" for="radiocheck_single">
                Singles - ${{ number_format($official->pricing, 2) }}
            </label>
        </div>
        <div class="form-check remember_check radio_check">
            <input class="form-check-input" type="radio" name="game_type" value="{{ $official->double_price }}" id="radiocheck_double">
            <label class="form-check-label" for="radiocheck_double">
                Doubles - ${{ number_format($official->double_price, 2) }}
            </label>
        </div>
    
        @error('game_type')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</li>

<li >
  <div class="radio_box mb_30">
    <p class="label_from mb_30">Skill Level<span>*</span></p>
    <div class="form-check join_now_radio">
        <input class="form-check-input" type="radio" name="flexRadioDefault" value="beginner" id="radiocheck1">
        <label class="form-check-label" for="radiocheck1">
            Beginner (1.0-3.0)
            <p class="tooltip_text">
                • 1.0- 1.5: Complete beginner who can hit the ball occasionally but struggles with control and rallies. <br>
                • 2.0- 2.5: Can sustain short rallies, understands basic rules, and is improving consistency. Can start a rally with serve and return; some control over direction but still inconsistent. <br>
                • 3.0: Can rally with moderate consistency; developing placement, serves, and volleys.
            </p>
        </label>
    </div>
    <div class="form-check join_now_radio">
        <input class="form-check-input" type="radio" name="flexRadioDefault" value="advanced" id="radiocheck2">
        <label class="form-check-label" for="radiocheck2">
            Advanced (3.5-4.0)
            <p class="tooltip_text">
                • 3.5: Can hit with depth and control; starts using strategy and is comfortable at the net. <br>
                • 4.0: Reliable strokes, good footwork, and can execute spin and directional shots under pressure.
            </p>
        </label>
    </div>
    @error('flexRadioDefault')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

            </li>


          <input type="hidden" name="latitude" id="latitude">
          <input type="hidden" name="longitude" id="longitude">

          <!-- Submit Button -->
          <li class="width_full">
          <button class="btn btn-primary mt-3" id="submit-button">Pay and Register</button>
          </li>
        </ul>
      </div>
    </div>
  </div>
</form>

      </div>
    </div>
    @include('layouts.footer')
  </div>

  <script src="{{ asset('assets/js/jquery.js') }}"></script>
  <script src="{{ asset('assets/js/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyANGZDqrXUiu4UkxKiZIaRe9jw&libraries=places"></script>

</body>

<script>
    // Use the Geolocation API
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;
            },
            function (error) {
                console.error('Error obtaining location:', error);
            }
        );
    } else {
        alert('Geolocation is not supported by this browser.');
    }
</script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    // Get the end date from server-side (use PHP/Laravel Blade to embed data)
    const endDate = new Date("{{ $official->enddate }}").getTime();

    function updateTimer() {
      const now = new Date().getTime();
      const timeRemaining = endDate - now;

      if (timeRemaining > 0) {
        // Calculate hours, minutes, and seconds
        const hours = Math.floor((timeRemaining / (1000 * 60 * 60)) % 24);
        const minutes = Math.floor((timeRemaining / (1000 * 60)) % 60);
        const seconds = Math.floor((timeRemaining / 1000) % 60);

        // Update the HTML content
        document.getElementById("hours").innerHTML = `${hours} <span>Hours</span>`;
        document.getElementById("minutes").innerHTML = `${minutes} <span>Minutes</span>`;
        document.getElementById("seconds").innerHTML = `${seconds} <span>Seconds</span>`;
      } else {
        // When the timer ends
        document.querySelector(".timer_list").innerHTML = "<p>The event has ended.</p>";
      }
    }

    // Update the timer every second
    setInterval(updateTimer, 1000);

    // Initialize the timer immediately
    updateTimer();
  });
</script>


</html>

