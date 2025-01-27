<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="title" content="Clash Court Sports - Events">
  <meta name="description" content="Clash Court Sports">
  <link rel="icon" type="image/ico" href="{{ asset('assets/images/favicon.ico') }}">
  <title>Clash Court Sports</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
</head>

<body>
  <div class="body_main">
    @include('layouts.header')

    @if(session('error'))
    <div class="alert alert-danger">
      {{ session('error') }}
    </div>
    @endif

    <div class="faq_section">
      <div class="container sports_container">
        <div class="faq_box">
          <h1 class="faq_heading">List of Events</h1>
          <div class="events_box">
            @forelse ($events as $event)
            @php
            $isExpired = \Carbon\Carbon::parse($event->enddate)->isPast(); // Check if the event is expired
            $registrationNotStarted = \Carbon\Carbon::parse($event->date)->isFuture(); // Check if registration has not started
            @endphp
            <div class="event_box_card">
              <h2 class="events_heading flex" style="display: flex;justify-content: space-between;">
                <p>
                  {{ $event->name }}
                </p>

                @if(auth()->user())
                <p>
                  $@if($event->selected_game == 'singles'){{$event->pricing}} @else{{$event->double_price}}@endif
                </p>
                @endif

              </h2>
              <p class="event_subheading">Session: {{ \Carbon\Carbon::parse($event->game_start_date)->format('F d Y') }} - {{ \Carbon\Carbon::parse($event->game_end_date)->format('F d Y') }}</p>

              <p class="event_date">
                Registration will start on: {{ \Carbon\Carbon::parse($event->date)->format('F d Y h:i A') }} <br>
                Registration will end on: {{ \Carbon\Carbon::parse($event->enddate)->format('F d Y h:i A') }}
              </p>

              @if ($isExpired)
              <span class="btn expired_btn" style="background-color: #ccc; cursor: not-allowed;">Expired Event</span>
              @elseif ($registrationNotStarted)
              <span class="btn disabled_btn" style="background-color: #ccc; cursor: not-allowed;">Registration Not Started</span>
              @else
              @if(auth()->user())
              <form action="{{ route('stripe.checkout.joinNow', $event->id) }}" method="POST">
                @csrf
                <input type="hidden" name="first_name" value="{{ Auth::user()->name }}">
                <input type="hidden" name="last_name" value="{{ Auth::user()->name }}">
                <input type="hidden" name="phone_number" value="{{ Auth::user()->phone_number }}">
                <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                <input type="hidden" name="city" value="{{ Auth::user()->city }}">
                <input type="hidden" name="state" value="{{ Auth::user()->state }}">
                <input type="hidden" name="zip_code" value="{{ Auth::user()->zip_code }}">
                <input type="hidden" name="selected_game" value="{{ $event->selected_game }}">
                <input type="hidden" name="flexRadioDefault" value="{{ $event->skill_level }}">
                <input type="hidden" name="game_type" value="@if($event->selected_game == 'singles'){{ $event->pricing }}@elseif($event->selected_game == 'doubles'){{ $event->double_price }}@endif">
                <input type="hidden" name="password" value="">
                <button class="btn join_now_btn">Register Now</button>
              </form>
              @else
              <a href="{{ route('user.auth.joinNow', ['id' => $event->id]) }}" class="btn join_now_btn">Register Now</a>
              @endif
              @endif
            </div>
            @empty
            <p class="text-center">No events available.</p>
            @endforelse
          </div>

        </div>
      </div>
    </div>


    @include('layouts.footer')
  </div>

  <script src="{{ asset('assets/js/jquery.js') }}"></script>
  <script src="{{ asset('assets/js/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
  <script src="{{ asset('assets/js/owl.carousel.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>

</html>