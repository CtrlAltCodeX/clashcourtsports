@extends('layouts.sidebar')

@section('admin-content')
<div class="container">

    @if (session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    @if(auth()->user()->type === 'admin')
    <!-- Filters -->
    <div class="bg-gray-100 p-4 rounded mb-4">
        <form method="GET" action="{{ route('events.group.wise') }}" class="flex flex-wrap gap-4">
            <!-- Event Filter -->
            <div class="flex flex-col">
                <label for="event" class="text-sm font-medium mb-1">Event</label>
                <select name="event" id="event" class="border border-gray-300 rounded p-2 w-64">
                    <option value="">All Events</option>
                    @foreach ($events as $event)
                    <option value="{{ $event->id }}" {{ request('event') == $event->id ? 'selected' : '' }}>
                        {{ $event->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Group Filter -->
            <div class="flex flex-col">
                <label for="group" class="text-sm font-medium mb-1">Group</label>
                <select name="group" id="group" class="border border-gray-300 rounded p-2 w-64">
                    <option value="">All Groups</option>
                    @foreach ($groups as $group)
                    <option value="{{ $group }}" {{ request('group') == $group ? 'selected' : '' }}>
                        {{ $group }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Filter
                </button>
            </div>
        </form>
    </div>
    @endif
    <h1 class="text-2xl font-semibold mb-2">Event Group Wise</h1>

    <!-- User Table -->
    <!-- <div class="table-responsive">
        <table class="table-auto w-full border border-gray-300 text-center">
            <thead class="bg-blue-100 text-blue-700">
                <tr>
                    <th class="py-2 border">#</th>
                    <th class="py-2 border">Name</th>
                    <th class="py-2 border">Email</th>
                    <th class="py-2 border">Event</th>
                    <th class="py-2 border">Group</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                <tr>
                    <td class="py-2 border">{{ $loop->iteration }}</td>
                    <td class="py-2 border">{{ $user->user->name }}</td>
                    <td class="py-2 border">{{ $user->user->email }}</td>
                    <td class="py-2 border">{{ $user->event->name ?? 'N/A' }}</td>
                    <td class="py-2 border">{{ $user->user->group }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-4 text-gray-500">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div> -->

    <div class="table-responsive">
        <table class="table-auto w-full border border-gray-300 text-center">
            <thead class="bg-blue-100 text-blue-700">
                <tr>
                    <th class="py-2 border">Event Name</th>
                    <th class="py-2 border">Player 1</th>
                    <th class="py-2 border">Group 1</th>
                    <th class="py-2 border">Player 2</th>
                    <th class="py-2 border">Group 2</th>
                    <th class="py-2 border">Wins</th>
                    <th class="py-2 border">Losses</th>
                    <th class="py-2 border">Total Score</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $entry)
                <tr class="hover:bg-gray-100">
                    <td class="py-2 border">{{ $entry['event_name'] }}</td>
                    <td class="py-2 border">{{ $entry['user'][0]->name }}</td>
                    <td class="py-2 border">{{ $entry['user'][0]->group }}</td>
                    <td class="py-2 border">{{ $entry['user'][1]->name }}</td>
                    <td class="py-2 border">{{ $entry['user'][1]->group }}</td>
                    <td class="py-2 border text-success font-semibold">{{ $entry['win_count'] }}</td>
                    <td class="py-2 border text-danger font-semibold">{{ $entry['loss_count'] }}</td>
                    <td class="py-2 border text-primary font-semibold">{{ $entry['total_score'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection