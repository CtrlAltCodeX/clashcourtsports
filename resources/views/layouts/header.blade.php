<div class="header_section">
  <div class="container menu_container">
    <nav class="navbar navbar-expand-lg header_navbar">
      <a class="navbar-brand" href="/">
        <img src="{{ asset('assets/images/logo.svg') }}" alt="Clash Court Sports Logo" title="Clash Court Sports" />
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sportsmenunavbar"
        aria-controls="sportsmenunavbar" aria-expanded="false" aria-label="Toggle navigation">
        <img src="{{ asset('assets/images/menu.svg') }}" alt="">
      </button>
      <div class="collapse navbar-collapse" id="sportsmenunavbar">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link active" href="{{ route('clashsports') }}">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('user.auth.login') }}">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('clashsports.events') }}">Join Now</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('user.auth.faq') }}">FAQ</a></li>
        </ul>
      </div>
    </nav>
  </div>
</div>