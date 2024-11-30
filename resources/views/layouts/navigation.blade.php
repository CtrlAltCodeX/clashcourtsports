<nav x-data="{ open: false }" class="text-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class=" mx-auto px-0 sm:px-0 lg:px-0">
        <div class="w-64 bg-gray-800 flex justify-between items-center h-16">
            <!-- Left side: Avatar and Admin Panel Text -->
            <div class=" flex items-center space-x-4">
    <!-- Avatar with First Letter of User's Name -->
    <div style="margin-left:10px;display: flex; align-items: center; justify-content: center; width: 50px; height: 50px; background-color: #6b7280; color: white; font-size: 1.125rem; font-weight: 600; border-radius: 9999px;">
        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
    </div>

    <!-- Admin Panel Text -->
    <span style="font-size: 1.125rem; font-weight: 600;margin-left:10px">Admin Panel</span>
</div>


            <!-- Right side: Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 ml-auto">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-white focus:outline-none transition ease-in-out duration-150">
    <div style="color: white;">{{ Auth::user()->name }}</div>
    <div class="ms-1">
        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" style="fill: white;">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </div>
</button>

                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
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
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
