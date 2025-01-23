@extends('layouts.sidebar')

@section('admin-content')
@if(session('alert'))
    <div class="alert alert-warning">
      {{ session('alert') }}
    </div>
    @endif

<div class="container-fuild mx-auto my-5">
    <div class="flex justify-between">
        <div class="flex justify-between items-center mb-4">
            <h5 class="text-lg font-medium">Win/Loss Dashboard</h5>
        </div>

        <div class="gap-2 flex items-center mb-2">
            <a href="{{ route('profile.edit') }}" style="background-color: #B95B00; color: white; padding: 0.5rem 1rem; border-radius: 0.25rem;">
                Update Profile
            </a>
            <a href="{{ route('user.events.add.manually') }}" style="background-color: #B95B00; color: white; padding: 0.5rem 1rem; border-radius: 0.25rem;">
                Update Score
            </a>
            <a href="{{ route('clashsports.events') }}" style="background-color: #B95B00; color: white; padding: 0.5rem 1rem; border-radius: 0.25rem;">
                Register For Next Sessions
            </a>
        </div>
    </div>


    <div class="table-responsive">
        <table class="table-auto w-full border border-gray-300 text-center">
            <thead class="bg-[#553D1D] text-[#FFE7B4]">
                <tr>
                    <th class="py-2 border">Event Name</th>
                    <th class="py-2 border">Wins</th>
                    <th class="py-2 border">Losses</th>
                    <th class="py-2 border">Total Score</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $entry)
                <tr class="hover:bg-gray-100">
                    <td class="py-2 border">{{ $entry['event_name'] }}</td>
                    <td class="py-2 border text-success font-semibold">{{ $entry['win_count'] }}</td>
                    <td class="py-2 border text-danger font-semibold">{{ $entry['loss_count'] }}</td>
                    <td class="py-2 border text-primary font-semibold">{{ $entry['total_score'] }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-4 text-gray-500">No data available.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection