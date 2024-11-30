<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="title" content="Clash Court Sports - Events">
  <meta name="description" content="Clash Court Sports">
  <link rel="icon" type="image/ico" href="{{ asset('assets/images/favicon.ico') }}">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
</head>

<body>
  <div class="body_main">
    @include('layouts.header')

    <div class="faq_section">
  <div class="container sports_container">
    <div class="faq_box">
      <h1 class="faq_heading">List of Events</h1>
      <div class="events_box">
        @forelse ($events as $event)
          @php
            $isExpired = \Carbon\Carbon::parse($event->enddate)->isPast(); // Check if event is expired
          @endphp
          <div class="event_box_card">
            <h2 class="events_heading">{{ $event->name }}</h2>
            <p class="event_subheading">{{ $event->game_name }} - {{ $event->location }}</p>
            <p class="event_date">
              {{ \Carbon\Carbon::parse($event->date)->format('d F Y') }} To 
              {{ \Carbon\Carbon::parse($event->enddate)->format('d F Y') }}
            </p>
            @if ($isExpired)
              <span class="btn expired_btn" style="background-color: #ccc; cursor: not-allowed;">Expired Event</span>
            @else
              <a href="{{ route('user.auth.joinNow', ['id' => $event->id]) }}" class="btn join_now_btn" target="_blank">Register Now</a>
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
