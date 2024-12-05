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
                    <th class="px-4 py-2 border">Event Name</th>
                    <th class="px-4 py-2 border">User Name</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Score</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($userEvents as $userEvent)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-2 border">{{ $userEvent->event->name }}</td>
                        <td class="px-4 py-2 border">{{ $userEvent->user->name }}</td>
                        <td class="px-4 py-2 border">{{ $userEvent->user->email }}</td>
                        <td class="px-4 py-2 border">{{ $userEvent->score }}</td>
                        <td class="px-4 py-2 border">
    @if ($userEvent->status == 'Requested')
        <form action="{{ route('admin.manage_scores.update_status', $userEvent->id) }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" name="status" value="Approved"
                style="background-color: #22c55e; color: #fff; padding: 6px 12px; border-radius: 4px; border: none; cursor: pointer; margin-right: 8px;">
                Approve
            </button>
            <button type="submit" name="status" value="Rejected"
                style="background-color: #ef4444; color: #fff; padding: 6px 12px; border-radius: 4px; border: none; cursor: pointer;">
                Reject
            </button>
        </form>
    @elseif ($userEvent->status == 'Approved')
        <span style="color: #22c55e;">Event Approved</span> <!-- Green color for approved -->
    @elseif ($userEvent->status == 'Rejected')
        <span style="color: #ef4444;">Event Rejected</span> <!-- Red color for rejected -->
    @endif
</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-gray-500 py-4">No scores to manage.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
