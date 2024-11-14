<!-- resources/views/admin/dashboard.blade.php -->
<x-app-layout>
    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white p-6">
            <h3 class="text-lg font-bold mb-4">Admin Panel</h3>
            <ul class="space-y-2">
            <li>
                    <a href="{{ route('dashboard') }}" class="block p-4 rounded-lg hover:bg-gray-700">
                    Dashboard                    </a>
                </li>
                <li>
                    <a href="{{ route('events.index') }}" class="block p-4 rounded-lg hover:bg-gray-700">
                        Event Management
                    </a>
                </li>
                <li>
                    <a href="{{ route('officials_registration.index') }}" class="block p-4 rounded-lg hover:bg-gray-700">
                        Officials Registration
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg border border-gray-200">
                    <div class="p-6 text-gray-900">
                        @yield('admin-content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
