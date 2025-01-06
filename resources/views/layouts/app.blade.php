<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Clash Court Sports</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Font Awesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <link rel="preload" as="style" href="https://clashcourtsports.com/build/assets/app-DtY2Ah0U.css" />
    <link rel="modulepreload" href="https://clashcourtsports.com/build/assets/app-BPnfBaih.js" />
    <link rel="stylesheet" href="https://clashcourtsports.com/build/assets/app-DtY2Ah0U.css" />
    <script type="module" src="https://clashcourtsports.com/build/assets/app-BPnfBaih.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<style>
    body {
        background-image: url('/assets/images/faq.jpeg');
        background-size: cover;
    }
</style>

<body class="font-sans antialiased">
    <div class="">
        <div class="header_section">
            <div class="container menu_container" style="max-width: 1800px;padding: 0px 50px;">
                <nav class="navbar header_navbar">
                    <a class="navbar-brand" href="/">
                        <img src="{{ asset('assets/images/logo.svg') }}" alt="Clash Court Sports Logo" title="Clash Court Sports" />
                    </a>
                    <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sportsmenunavbar"
                        aria-controls="sportsmenunavbar" aria-expanded="false" aria-label="Toggle navigation">
                        <img src="{{ asset('assets/images/menu.svg') }}" alt="">
                    </button> -->
                    <div class="" id="sportsmenunavbar">
                        <ul class="navbar-nav ms-auto" style="align-items:center;flex-direction: row;">
                            <li class="nav-item"><a class="nav-link active" href="{{ route('clashsports') }}">Home</a></li>
                            @if(!auth()->user())
                            <li class="nav-item"><a class="nav-link" href="{{ route('user.auth.login') }}">Login</a></li>
                            @endif
                            <li class="nav-item"><a class="nav-link" href="{{ route('clashsports.events') }}">Join Now</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('user.auth.faq') }}">FAQ</a></li>

                            @if(auth()->user())
                            <div class="relative">
                                <a href="#" id="profileDropdownButton" class="flex items-center focus:outline-none">
                                    @if (Auth::user()->profile_image)
                                    <div class="relative w-16 h-16">
                                        <img src="{{ asset('assets/storage/' . Auth::user()->profile_image) }}"
                                            alt="Profile Image"
                                            class="w-full h-full rounded-full object-cover border-2 border-gray-300 shadow">
                                    </div>
                                    @else
                                    <div class="relative w-16 h-16">
                                        <img src="{{ asset('assets/images/dummy.jpg') }}"
                                            alt="Default Profile Image"
                                            class="w-full h-full rounded-full object-cover border-2 border-gray-300 shadow">
                                    </div>
                                    @endif
                                </a>
                                <!-- Dropdown -->
                                <div id="profileDropdownMenu"
                                    class="absolute right-0 mt-2 w-48 bg-white border border-gray-300 rounded shadow-lg hidden">
                                    <a href="{{ route('profile.edit') }}"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-center">Profile</a>
                                    <form method="POST" action="{{ route('logout') }}" class="block">
                                        @csrf
                                        <button type="submit"
                                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <!-- Dropdown Toggle Script -->
                            <script>
                                document.getElementById('profileDropdownButton').addEventListener('click', function(e) {
                                    e.preventDefault();
                                    const menu = document.getElementById('profileDropdownMenu');
                                    menu.classList.toggle('hidden');
                                });

                                // Close dropdown when clicking outside
                                document.addEventListener('click', function(e) {
                                    const button = document.getElementById('profileDropdownButton');
                                    const menu = document.getElementById('profileDropdownMenu');
                                    if (!button.contains(e.target) && !menu.contains(e.target)) {
                                        menu.classList.add('hidden');
                                    }
                                });
                            </script>
                            @endif

                        </ul>
                    </div>
                </nav>
            </div>
        </div>

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

        <!-- Page Heading -->
        @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        @include('layouts.footer')

    </div>

    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>

</html>