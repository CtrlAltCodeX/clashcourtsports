<nav x-data="{ open: false }" class="text-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <!-- Primary Navigation Menu -->
    <div class=" mx-auto px-0 sm:px-0 lg:px-0 flex justify-between">
        <div class="w-64 bg-gray-800 flex items-center h-16 p-4">
            <!-- Avatar with First Letter of User's Name -->
            @if (Auth::user()->profile_image)
            <div class="relative w-16 h-16">
                <img src="{{ asset('assets/storage/' . Auth::user()->profile_image) }}"
                    alt="Profile Image"
                    class="w-full h-full rounded-full object-cover border-2 border-gray-300 shadow">
            </div>
            @else
            <div class="relative w-16 h-16">
                <img src="{{ asset('assets/images/default_profile.png') }}"
                    alt="Default Profile Image"
                    class="w-full h-full rounded-full object-cover border-2 border-gray-300 shadow">
            </div>
            @endif

            @if (Auth::user()->type==="Player")
            <!-- Admin Panel Text -->
            <span class="text-lg font-semibold ml-2">{{Auth::user()->name}}</span>
            @else
            <!-- Admin Panel Text -->
            <span class="text-lg font-semibold ml-2">Admin Panel</span>
            @endif

        </div>

        <!-- Right side Dropdown -->
        <div class="hidden sm:flex sm:items-center ml-auto">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 focus:outline-none transition ease-in-out duration-150">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-white-500 text-black font-bold text-xl border">
                            @if(!auth()->user()->profile_image)
                            {{ Auth::user()->name[0] }}
                            @else
                            <img src="/assets/storage/{{auth()->user()->profile_image }}" class="flex items-center justify-center h-12 w-12 rounded-full bg-white-500 border text-black font-bold text-xl" />
                            @endif
                        </div>

                        <div class="ml-1">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</nav>