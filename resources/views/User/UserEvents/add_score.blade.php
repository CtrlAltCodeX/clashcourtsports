@extends('layouts.sidebar')

@section('admin-content')
<div class="card shadow-sm">
    <h2 class="text-xl font-semibold">Participated Events</h2>

    <div class="mb-4 text-right">
        <a href="{{ route('user.events.add.manually') }}" style="background-color: #2563eb; color: white; padding: 0.5rem 1.5rem; font-weight: 600; border-radius: 0.5rem; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out;"
            onmouseover="this.style.backgroundColor='#1d4ed8'; this.style.transform='scale(1.05)';"
            onmouseout="this.style.backgroundColor='#2563eb'; this.style.transform='scale(1)';">
            Add Manually
        </a>
    </div>
    
    <div class="table-responsive">
        <table class="table-auto w-full border border-gray-300 text-center">
            <thead class="bg-blue-100 text-blue-700">
                <tr>
                    <th class="px-4 py-2 border">Event Name</th>
                    <th class="px-4 py-2 border">Game Name</th>
                    <th class="px-4 py-2 border">Your Score</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Select Opponent</th>
                    <th class="px-4 py-2 border">Opponent Score</th>
                    <th class="px-4 py-2 border">Action</th>
                </tr>
            </thead>
        </table>
        
        <div class="table-row-group">
            @foreach ($userEvents as $userEvent)
            <form action="{{ route('user.events.save_score') }}" method="POST" class="table-row hover:bg-gray-100">
                @csrf
                <input type="hidden" name="event_id" value="{{ $userEvent->id }}">
    
                <!-- Event Name -->
                <div class="table-cell px-4 py-2 border">
                    {{ $userEvent->event->name }}
                </div>
    
                <!-- Game Name -->
                <div class="table-cell px-4 py-2 border">
                    {{ $userEvent->event->game_name }}
                </div>
    
                <!-- Your Score -->
                <div class="table-cell px-4 py-2 border">
                    @php $scores = json_decode($userEvent->score); @endphp
                    @if ($userEvent->status === 'Rejected')
                    <div id="score-display-{{ $userEvent->id }}">
                        {{ $scores ? implode(', ', $scores) : 'No scores available' }}
                    </div>
                    <div class="hidden mt-2" id="score-inputs-{{ $userEvent->id }}">
                        @foreach ($scores as $score)
                        <input
                            type="number"
                            name="scores[{{ $userEvent->id }}][]"
                            class="form-input w-3/4 mx-auto mb-1 border border-gray-300 rounded px-2 py-1"
                            value="{{ $score }}" min="0" max="100">
                        @endforeach
                    </div>
                    <button type="button" class="retry-btn text-red-600 font-semibold mt-2" data-id="{{ $userEvent->id }}">Retry</button>
                    @elseif ($userEvent->status === 'pending')
                    <div class="flex flex-col gap-2">
                        <input
                            type="number"
                            name="scores[{{ $userEvent->id }}][]"
                            class="form-input w-full mx-auto border border-gray-300 rounded px-2 py-1"
                            min="0" max="100"
                            placeholder="Enter your score">
                        <button type="button" class="btn btn-success text-white bg-green-500 rounded px-3 py-1" data-id="{{ $userEvent->id }}">Add</button>
                    </div>
                    @else
                    <div>{{ $scores ? implode(', ', $scores) : 'No scores available' }}</div>
                    @endif
                </div>
    
                <!-- Status -->
                <div class="table-cell px-4 py-2 border">
                    {{ ucfirst($userEvent->status) }}
                </div>
    
                <!-- Select Opponent -->
                <div class="table-cell px-4 py-2 border">
                    @if ($userEvent->status === 'pending')
                    <select
                        name="selected_users[{{ $userEvent->id }}]"
                        class="form-select w-3/4 mx-auto border border-gray-300 rounded px-2 py-1">
                        <option value="">Select a User</option>
                        @if(isset($usersForDropdown[$userEvent->id]))
                        @foreach ($usersForDropdown[$userEvent->id] as $users)
                        <option value="{{ $users[0]?->user_event_id }}">{{ $users[0]?->name }} {{ $users[0]?->email }}</option>
                        @endforeach
                        @endif
                    </select>
                    @else
                    <div>Opponent: {{ $userEvent->opponent_email ?? 'No opponent' }}</div>
                    @endif
                </div>
    
                <!-- Opponent Score -->
                <div class="table-cell px-4 py-2 border">
                    @if ($userEvent->status === 'Rejected')
                    <div>{{ $userEvent->opponent_score ? implode(', ', $userEvent->opponent_score) : 'No opponent score available' }}</div>
                    @elseif ($userEvent->status === 'pending')
                    <div class="flex flex-col gap-2">
                        <input
                            type="number"
                            name="opponent_scores[{{ $userEvent->id }}][]"
                            class="form-input w-3/4 mx-auto border border-gray-300 rounded px-2 py-1"
                            min="0" max="100"
                            placeholder="Enter opponent's score">
                        <button type="button" class="btn btn-success text-white bg-green-500 rounded px-3 py-1" data-id="{{ $userEvent->id }}">Add</button>
                    </div>
                    @else
                    <div>{{ $userEvent->opponent_score ? implode(', ', $userEvent->opponent_score) : 'No opponent score available' }}</div>
                    @endif
                </div>
    
                <!-- Actions -->
                <div class="table-cell px-4 py-2 border text-center">
                    @if ($userEvent->status === 'Requested')
                    <button type="button" class="text-white bg-green-500 px-3 py-1 rounded" data-status="Approved">Approve</button>
                    <button type="button" class="text-white bg-red-500 px-3 py-1 rounded" data-status="Rejected">Reject</button>
                    @else
                    <button type="submit" class="text-white bg-blue-500 px-3 py-1 rounded">Submit</button>
                    @endif
                </div>
            </form>
            @endforeach
        </div>
    <div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.retry-btn').forEach(button => {
            button.addEventListener('click', function() {
                const userEventId = this.dataset.id;
                const scoreDisplay = document.getElementById(`score-display-${userEventId}`);
                const scoreInputs = document.getElementById(`score-inputs-${userEventId}`);

                if (scoreDisplay && scoreInputs) {
                    scoreDisplay.classList.add('hidden');
                    scoreInputs.classList.remove('hidden');
                }
            });
        });

        // Add additional score input for user score when the + Add button is clicked
        document.querySelectorAll('.add-score').forEach(button => {
            button.addEventListener('click', function() {
                const userEventId = this.dataset.id;
                const container = document.getElementById(`score-inputs-container-${userEventId}`);

                const currentInputs = container.querySelectorAll('input[type="number"]').length;
                if (currentInputs >= 5) {
                    alert("You cannot add more than 5 score inputs.");
                    return;
                }
                const newInput = document.createElement('input');
                newInput.type = 'number';
                newInput.name = `scores[${userEventId}][]`;
                newInput.classList.add('form-control', 'w-full', 'mx-auto', 'border', 'border-gray-300', 'rounded', 'px-2', 'py-1');
                newInput.min = 0;
                newInput.max = 100;
                newInput.placeholder = "Enter score";

                container.insertBefore(newInput, this);
            });
        });

        document.querySelectorAll('.retry-btn').forEach(button => {
            button.addEventListener('click', function() {
                const userEventId = this.dataset.id;
                const scoreDisplay = document.getElementById(`opponent-score-display-${userEventId}`);
                const scoreInputs = document.getElementById(`opponent-score-inputs-${userEventId}`);

                if (scoreDisplay && scoreInputs) {
                    scoreDisplay.classList.add('hidden');
                    scoreInputs.classList.remove('hidden');
                }
            });
        });


        // Add additional score input for opponent score when the + Add button is clicked
        document.querySelectorAll('.add-opponent-score').forEach(button => {
            button.addEventListener('click', function() {
                const userEventId = this.dataset.id;
                const container = document.getElementById(`opponent-score-inputs-container-${userEventId}`);

                const currentInputs = container.querySelectorAll('input[type="number"]').length;
                if (currentInputs >= 5) {
                    alert("You cannot add more than 5 opponent score inputs.");
                    return;
                }
                const newInput = document.createElement('input');
                newInput.type = 'number';
                newInput.name = `opponent_scores[${userEventId}][]`;
                newInput.classList.add('form-control', 'w-3/4', 'mx-auto', 'border', 'border-gray-300', 'rounded', 'px-2', 'py-1');
                newInput.min = 0;
                newInput.max = 100;
                newInput.placeholder = "Enter opponent's score";

                container.insertBefore(newInput, this);
            });
        });

        //   here my update status code :
        // Handle the status update on clicking the approve or reject buttons
        document.querySelectorAll('.status-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent default link behavior

                const userEventId = this.closest('tr').querySelector('input[name="event_ids[]"]').value; // Get the event ID
                const newStatus = this.dataset.status; // Get the new status (Approved/Rejected)

                // Make the AJAX request
                fetch("{{ route('user.userevents.updateStatus', ['event' => '__eventId__']) }}".replace('__eventId__', userEventId), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            status: newStatus
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Status updated successfully!');
                            // Update the status on the page (you could update the text or reload the row)
                            const statusCell = this.closest('tr').querySelector('.status');
                            statusCell.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
                        } else {
                            alert('Failed to update status');
                        }
                    })
                    .catch(error => {
                        // Refresh the page
                        location.reload();

                        // alert('An error occurred');
                    });
            });
        });
    });
</script>
@endsection