@extends('layouts.sidebar')

@section('admin-content')

<div class="container">
    <div class="table-responsive">
        <table class="table-auto w-full border border-gray-300 text-center">
            <thead class="bg-blue-100 text-blue-700">
                <tr>
                    <th class="py-2 border">#</th>
                    <th class=" py-2 border">Event Name</th>
                    <th class=" py-2 border">Game Name</th>
                    <th class=" py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($events as $index => $event)
                <tr class="hover:bg-gray-100">
                    <td class="py-2 border">{{ $events->firstItem() + $index }}</td>

                    <td class=" py-2 border">{{ $event->name }}</td>
                    <td class=" py-2 border">{{ $event->game_name }}</td>

                    <td class="py-2 border">
                        <div class="flex justify-center space-x-3">
                            <a href="{{ route('user.auth.joinNow', $event->id) }}" target="_blank" style="background-color: #10B981" class="text-white px-3 py-2 rounded text-sm flex items-center hover:bg-teal-600 focus:outline-none">
                                <i class="fas fa-eye mr-1"></i>
                            </a>
                        </div>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="8" class="text-center text-gray-500 py-4">No events available.</td> <!-- Adjusted colspan -->
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $events->links('pagination::tailwind') }} <!-- Use TailwindCSS pagination links -->
    </div>
</div>

@endsection