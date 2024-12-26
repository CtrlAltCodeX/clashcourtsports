<!-- resources/views/admin/dashboard.blade.php -->
<x-app-layout>
    <div class="flex min-h-screen">
        <!-- sidebar -->
        <div class="w-64 bg-gray-800 text-white p-6">
            <ul class="space-y-2">
                <!-- Check user type -->
                @if(auth()->user()->type === 'Player')
                <li>
                    <a href="{{ route('user.dashboard') }}" class="block p-4 rounded-lg {{ str_contains(request()->route()->getName(), 'dashboard') == 'dashboard' ? 'bg-gray-700' : '' }} hover:bg-gray-700">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.events') }}" class="block p-4 rounded-lg {{ (str_contains(request()->route()->getName(), 'user.events') && request()->route()->getName() == 'user.events') ? 'bg-gray-700' : '' }} hover:bg-gray-700">
                        User Events
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.events.score') }}" class="block p-4 rounded-lg {{ str_contains(request()->route()->getName(), 'user.events.score') ? 'bg-gray-700' : '' }} hover:bg-gray-700">
                        Events Score
                    </a>
                </li>
                @else
                @if(auth()->user()->type != 'admin')
                <li>
                    <a href="{{ route('dashboard') }}" class="block p-4 rounded-lg {{ str_contains(request()->route()->getName(), 'dashboard') ? 'bg-gray-700' : '' }} hover:bg-gray-700">
                        Dashboard
                    </a>
                </li>
                @endif
                <li>
                    <a href="{{ route('events.index') }}" class="block p-4 rounded-lg {{ str_contains(request()->route()->getName(), 'events') ? 'bg-gray-700' : '' }} hover:bg-gray-700">
                        Event Management
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.manage_scores.index') }}" class="block p-4 {{ str_contains(request()->route()->getName(), 'admin') ? 'bg-gray-700' : '' }} rounded-lg hover:bg-gray-700">
                        Score Management
                    </a>
                </li>
                <li>
                    <a href="{{ route('officials_registration.index') }}" class="block p-4 {{ str_contains(request()->route()->getName(), 'officials_registration') ? 'bg-gray-700' : '' }} rounded-lg hover:bg-gray-700">
                        Officials Registration
                    </a>
                </li>
                <li>
                    <a href="{{ route('notifications.index') }}" class="block {{ str_contains(request()->route()->getName(), 'notification') ? 'bg-gray-700' : '' }} p-4 rounded-lg hover:bg-gray-700">
                        Notifications
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.contact.index') }}" class="block {{ str_contains(request()->route()->getName(), 'notification') ? 'bg-gray-700' : '' }} p-4 rounded-lg hover:bg-gray-700">
                        Contact Us
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

    @stack('scripts')
</x-app-layout>