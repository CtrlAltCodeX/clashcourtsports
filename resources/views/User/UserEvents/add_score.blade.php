@extends('layouts.sidebar')

@section('admin-content')
<div class="card shadow-sm">
    <div class="card-header bg-blue-600 text-white text-center py-3">
        <h2 class="text-xl font-semibold">Participated Events</h2>
    </div>

    <div class="card-body px-6 py-4">
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <form action="{{ route('user.events.save_score') }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table-auto w-full border border-gray-300 text-center">
                    <thead class="bg-blue-100 text-blue-700">
                        <tr>
                            <th class="px-4 py-2 border">Event Name</th>
                            <th class="px-4 py-2 border">Game Name</th>
                            <th class="px-4 py-2 border">Score</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Select User</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userEvents as $userEvent)
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-2 border">{{ $userEvent->event->name }}</td>
                                <td class="px-4 py-2 border">{{ $userEvent->event->game_name }}</td>
                                <td class="px-4 py-2 border">
                                    @if ($userEvent->score === null)
                                        <div class="input-group">
                                            <input 
                                                type="number" 
                                                name="scores[{{ $userEvent->id }}][]" 
                                                class="form-control w-3/4 mx-auto border border-gray-300 rounded px-2 py-1"
                                                min="0" max="100" 
                                                placeholder="Enter score">
                                            <button type="button" class="btn btn-sm btn-success add-score" data-id="{{ $userEvent->id }}">+add</button>
                                        </div>
                                    @else
                                        {{ $userEvent->score }}
                                    @endif
                                </td>
                                <td class="px-4 py-2 border">
                                    {{ ucfirst($userEvent->status ?? 'pending') }}
                                </td>
                                <td class="px-4 py-2 border">
                                    @if ($userEvent->score === null)
                                        <!-- Dropdown for selecting users based on conditions -->
                                        <div class="mt-2">
                                        <select 
                                            name="selected_users[{{ $userEvent->id }}]" 
                                            id="users_{{ $userEvent->id }}" 
                                            class="form-control w-3/4 mx-auto border border-gray-300 rounded px-2 py-1">
                                            <option value="">Select a User</option>
                                            @foreach ($usersForDropdown[$userEvent->id] as $user)
                                                <option value="{{ $user->email }}">
                                                    {{ $user->name }} ({{ $user->email }})
                                                </option>
                                            @endforeach
                                        </select>

                                        </div>
                                    @else
                                        No user selection required
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 text-right">
                <button type="submit" style="background-color:blue;" class=" text-white px-4 py-2 rounded hover:bg-blue-700">
                    Save Scores
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const maxInputs = 5;

        // Add new input field when "+" is clicked
        document.querySelectorAll('.add-score').forEach(button => {
            button.addEventListener('click', function () {
                const userEventId = this.dataset.id;
                const scoreContainer = this.closest('.input-group');
                const inputFields = scoreContainer.querySelectorAll('input');
                
                if (inputFields.length < maxInputs) {
                    const newInput = document.createElement('input');
                    newInput.type = 'number';
                    newInput.name = `scores[${userEventId}][]`;
                    newInput.classList.add('form-control', 'w-3/4', 'mx-auto', 'border', 'border-gray-300', 'rounded', 'px-2', 'py-1');
                    newInput.min = '0';
                    newInput.max = '100';
                    newInput.placeholder = 'Enter score';
                    
                    scoreContainer.insertBefore(newInput, this);
                } else {
                    alert('You can only enter up to 5 scores.');
                }
            });
        });
    });
</script>
@endsection
