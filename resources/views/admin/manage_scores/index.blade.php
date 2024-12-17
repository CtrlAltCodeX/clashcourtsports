@extends('layouts.sidebar')

@section('admin-content')
<div class="container">
    <h1 class="text-xl font-bold mb-4">Manage Event Scores</h1>

    @if (session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table-auto w-full border border-gray-300 text-center">
            <thead class="bg-blue-100 text-blue-700">
                <tr>
                  <th class="py-2 border">#</th>
                    <th class="px-4 py-2 border">Event Name</th>
                    <th class="px-4 py-2 border">User Name</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Score</th>
                 
                </tr>
            </thead>
            <tbody>
                @forelse ($userEvents  as $index => $userEvent)
                <tr class="hover:bg-gray-100">
                <td class="py-2 border">{{ $index + 1 }}</td>
                    <td class="px-4 py-2 border">{{ $userEvent->event->name }}</td>
                    <td class="px-4 py-2 border">{{ $userEvent->user->name }}</td>
                    <td class="px-4 py-2 border">{{ $userEvent->user->email }}</td>
                    <td class="px-4 py-2 border">{{ $userEvent->score }}</td>
                

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-gray-500 py-4">No Result Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection