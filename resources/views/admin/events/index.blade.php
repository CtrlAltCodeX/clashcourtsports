@extends('layouts.Sidebar')

@section('admin-content')
    <div class="card shadow-sm">
        <div class="card-header bg-blue-600 text-white text-center py-3">
            <h2 class="text-xl font-semibold">Event Management</h2>
        </div>

        <div class="card-body px-6 py-4">
            <div class="flex justify-between items-center mb-4">
                <h5 class="text-lg font-medium">Event List</h5>
                <a href="{{ route('events.create') }}" style="background-color: #10B981; color: white; padding: 0.5rem 1rem; border-radius: 0.25rem;">
                    Add New Event
                </a>
            </div>

            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table-auto w-full border border-gray-300 text-center">
                    <thead class="bg-blue-100 text-blue-700">
                        <tr>
                            <th class="px-4 py-2 border">Name</th>
                            <th class="px-4 py-2 border">Game Name</th>  <!-- New column -->

                            <th class="px-4 py-2 border">Location</th>

                            <th class="px-4 py-2 border">Date</th>
                            <th class="px-4 py-2 border">End Date</th>    <!-- New column -->

                            <th class="px-4 py-2 border">Capacity</th>
                            <th class="px-4 py-2 border">Single Price</th>
                            <th class="px-4 py-2 border">Double Price</th> <!-- New column -->
                            <th class="px-4 py-2 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($events as $event)
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-2 border">{{ $event->name }}</td>
                            <td class="px-4 py-2 border">{{ $event->game_name }}</td>  <!-- Displaying the new field -->

                                <td class="px-4 py-2 border">{{ $event->location }}</td>
                                <td class="px-4 py-2 border">{{ $event->date }}</td>
                                <td class="px-4 py-2 border">{{ $event->enddate }}</td>    <!-- Displaying the new field -->

                                <td class="px-4 py-2 border">{{ $event->capacity }}</td>
                                <td class="px-4 py-2 border">${{ number_format($event->pricing, 2) }}</td>
                                <td class="px-4 py-2 border">${{ number_format($event->double_price, 2) }}</td> <!-- Displaying the new field -->
                                <td class="px-4 py-2 border">
                                    <div class="flex justify-center space-x-3">
                                        <a href="{{ route('events.edit', $event) }}" style="background-color: #10B981" class="text-white px-3 py-2 rounded text-sm flex items-center hover:bg-teal-600 focus:outline-none">
                                            <i class="fas fa-edit mr-1"></i> Edit
                                        </a>
                                        <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background-color: #f56565; margin-left: 10px;" class="text-white px-3 py-2 rounded text-sm flex items-center hover:bg-red-600 focus:outline-none" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash-alt mr-1"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-gray-500 py-4">No events available.</td>  <!-- Adjusted colspan -->
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
