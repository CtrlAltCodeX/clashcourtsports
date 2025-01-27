<!-- resources/views/admin/dashboard.blade.php -->
<x-app-layout>
    <div class="flex min-h-screen flex-wrap">
        <!-- sidebar -->
        <div class="w-64 text-white p-6" style="background-color: #553D1D;">
            <ul class="space-y-2 p-0">
                <!-- Check user type -->
                @if(auth()->user()->type === 'Player')
                <li>
                    <a href="{{ route('user.dashboard') }}" class="block p-2 rounded-lg {{ str_contains(request()->route()->getName(), 'dashboard') == 'dashboard' ? 'text-[#FFE7B4]' : 'text-white' }} hover:bg-gray-700 ">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.events') }}" class="block p-2 rounded-lg {{ (str_contains(request()->route()->getName(), 'user.events') && request()->route()->getName() == 'user.events') ? 'text-[#FFE7B4]' : 'text-white' }} hover:bg-gray-700 ">
                        Events
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.events.score') }}" class="block p-2 rounded-lg {{ str_contains(request()->route()->getName(), 'user.events.score') ? 'text-[#FFE7B4]' : 'text-white' }} hover:bg-gray-700">
                        Events Score
                    </a>
                </li>
                <li>
                    <a href="{{ route('events.group.wise', ['group', auth()->user()->group]) }}" class="block {{ str_contains(request()->route()->getName(), 'group.wise') ? 'text-[#FFE7B4]' : 'text-white' }} p-2 rounded-lg hover:bg-gray-700">
                        Event Group Wise
                    </a>
                </li>
                <li>
                    <a href="{{ route('events.upcoming') }}" class="block {{ str_contains(request()->route()->getName(), 'events.upcoming') ? 'text-[#FFE7B4]' : 'text-white' }} p-2 rounded-lg hover:bg-gray-700">
                        Upcoming Events
                    </a>
                </li>
                @else
                <li>
                    <a href="{{ route('events.index') }}" class="block p-2 rounded-lg {{ str_contains(request()->route()->getName(), 'events') ? 'text-[#FFE7B4]' : 'text-white' }} hover:bg-gray-700">
                        Event Management
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.manage_scores.index') }}" class="block p-2 {{ str_contains(request()->route()->getName(), 'manage_scores') ? 'text-[#FFE7B4]' : 'text-white' }} rounded-lg hover:bg-gray-700">
                        Score Management
                    </a>
                </li>
                @if(auth()->user()->type != 'official')
                <li>
                    <a href="{{ route('officials_registration.index') }}" class="block p-2 {{ str_contains(request()->route()->getName(), 'officials_registration') ? 'text-[#FFE7B4]' : 'text-white' }} rounded-lg hover:bg-gray-700">
                        Officials Registration
                    </a>
                </li>
                @endif
                <li>
                    <a href="{{ route('notifications.index') }}" class="block {{ str_contains(request()->route()->getName(), 'notification') ? 'text-[#FFE7B4]' : 'text-white' }} p-2 rounded-lg hover:bg-gray-700">
                        Event Participants
                    </a>
                </li>
                @if(auth()->user()->type != 'official')
                <li>
                    <a href="{{ route('show.donations.index') }}" class="block {{ str_contains(request()->route()->getName(), 'donations') ? 'text-[#FFE7B4]' : 'text-white' }} p-2 rounded-lg hover:bg-gray-700">
                        Donations
                    </a>
                </li>
                @endif
                @if(auth()->user()->type != 'official')
                <li>
                    <a href="{{ route('admin.contact.index') }}" class="block {{ str_contains(request()->route()->getName(), 'contact') ? 'text-[#FFE7B4]' : 'text-white' }} p-2 rounded-lg hover:bg-gray-700">
                        Contact Us
                    </a>
                </li>
                @endif
                <li>
                    <a href="{{ route('events.group.wise') }}" class="block {{ str_contains(request()->route()->getName(), 'group.wise') ? 'text-[#FFE7B4]' : 'text-white' }} p-2 rounded-lg hover:bg-gray-700">
                        Event Group Wise
                    </a>
                </li>
                @endif
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    @yield('admin-content')
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    @stack('scripts')

</x-app-layout>