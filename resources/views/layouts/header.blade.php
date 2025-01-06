<div class="header_section">
  <div class="container menu_container" style="max-width: 1800px;padding: 0px 50px;">
    <nav class="navbar navbar-expand-lg header_navbar">
      <a class="navbar-brand" href="/">
        <img src="{{ asset('assets/images/logo.svg') }}" alt="Clash Court Sports Logo" title="Clash Court Sports" />
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sportsmenunavbar"
        aria-controls="sportsmenunavbar" aria-expanded="false" aria-label="Toggle navigation">
        <img src="{{ asset('assets/images/menu.svg') }}" alt="">
      </button>
      <div class="collapse navbar-collapse" id="sportsmenunavbar">
        <ul class="navbar-nav ms-auto" style="align-items:center;">
          <li class="nav-item"><a class="nav-link active" href="{{ route('clashsports') }}">Home</a></li>
          @if(!auth()->user())
          <li class="nav-item"><a class="nav-link" href="{{ route('user.auth.login') }}">Login</a></li>
          @endif
          <li class="nav-item"><a class="nav-link" href="{{ route('clashsports.events') }}">Join Now</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('user.auth.faq') }}">FAQ</a></li>
          @if(auth()->user())
          @if (Auth::user()->profile_image)
          <a href="{{ route('user.dashboard') }}">
            <div class="relative w-16 h-16">
              <img src="{{ asset('assets/storage/' . Auth::user()->profile_image) }}"
                alt="Profile Image"
                class="w-full h-full rounded-full object-cover border-2 border-gray-300 shadow" style="width: 50px;border-radius: 50px;">
            </div>
          </a>
          @else
          <a href="{{ route('user.dashboard') }}">
            <div class="relative w-16 h-16">
              <img src="{{ asset('assets/images/dummy.jpg') }}"
                alt="Default Profile Image"
                class="w-full h-full rounded-full object-cover border-2 border-gray-300 shadow" style="width: 50px;border-radius: 50px;">
            </div>
          </a>
          @endif
          <!-- <li class="nav-item"><a class="nav-link" href="{{ route('user.auth.login') }}">Login</a></li> -->
          @endif
        </ul>
      </div>
    </nav>
  </div>
</div>