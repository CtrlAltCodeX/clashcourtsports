@extends('layouts.sidebar')

@section('admin-content')
<div class="card shadow-sm">
    <div class="card-header bg-blue-600 text-white text-center py-3">
        <h2 class="text-xl font-semibold">Participated Events</h2>
    </div>

    <div class="mb-4 text-center">
    <a href="{{ route('user.events.add.manually') }}" style="background-color: #2563eb; color: white; padding: 0.5rem 1.5rem; font-weight: 600; border-radius: 0.5rem; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out;" 
        onmouseover="this.style.backgroundColor='#1d4ed8'; this.style.transform='scale(1.05)';" 
        onmouseout="this.style.backgroundColor='#2563eb'; this.style.transform='scale(1)';">
        Add Manually
    </a>
</div>



        <div class="table-responsive">
            <form action="{{ route('user.events.save_score') }}" method="POST">
                @csrf
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
                    <tbody>
                        @foreach ($userEvents as $userEvent)
                        <input type="hidden" name="event_id" value="{{ $userEvent->id }}"> <!-- Include the event_id for the form -->
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-2 border">{{ $userEvent->event->name }}</td>
                                <td class="px-4 py-2 border">{{ $userEvent->event->game_name }}</td>

                                <!-- Your Score -->
                                <td class="px-4 py-2 border">
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
                                                    class="form-control w-3/4 mx-auto mb-1 border border-gray-300 rounded px-2 py-1"
                                                    value="{{ $score }}" 
                                                    min="0" max="100">
                                            @endforeach
                                        </div>
                                        <button type="button" class="retry-btn text-red-600 font-semibold mt-2" data-id="{{ $userEvent->id }}">Retry</button>
                                    @elseif ($userEvent->status === 'pending')
                                        <div class="input-group" id="score-inputs-container-{{ $userEvent->id }}">
                                            <input 
                                                type="number" 
                                                name="scores[{{ $userEvent->id }}][]" 
                                                class="form-control w-3/4 mx-auto border border-gray-300 rounded px-2 py-1"
                                                min="0" max="100" 
                                                placeholder="Enter your score">
                                            <button type="button" class="btn btn-sm btn-success add-score" data-id="{{ $userEvent->id }}">+ Add</button>
                                        </div>
                                    @else
                                        <div>{{ $scores ? implode(', ', $scores) : 'No scores available' }}</div>
                                    @endif
                                </td>

                                <!-- Status -->
                                <td class="px-4 py-2 border">{{ ucfirst($userEvent->status) }}</td>
                                            <td class="px-4 py-2 border">
                                                @if ($userEvent->status === 'pending')
                                                    <select 
                                                        name="selected_users[{{ $userEvent->id }}]" 
                                                        class="form-control w-3/4 mx-auto border border-gray-300 rounded px-2 py-1">
                                                        <option value="">Select a User</option>
                                                        @foreach ($usersForDropdown[$userEvent->id] as $user)
                                                            <option value="{{ $user->user_event_id }}">
                                                                {{ $user->name }} ({{ $user->email }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    @if (isset($userEvent->opponent_email))
                                               <!-- If opponent_email exists, show it and store user_event_id -->
            <input type="hidden" 
                   value="{{ $userEvent->user_event_id }}" 
                   name="selected_users[{{ $userEvent->id }}]" 
                   class="form-control w-3/4 mx-auto border border-gray-300 rounded px-2 py-1" >
            <div>Opponent: {{ $userEvent->opponent_email }}</div>
                                                    @else
                                                     
                                                    @endif
                                                @endif
                                            </td>


                               <!-- Opponent Score -->
<td class="px-4 py-2 border">
    @if ($userEvent->status === 'Rejected')
        <div id="opponent-score-display-{{ $userEvent->id }}">
            @if (isset($userEvent->opponent_score))
                {{ implode(', ', $userEvent->opponent_score) }}
            @else
                No opponent score available
            @endif
        </div>
        <div class="hidden mt-2" id="opponent-score-inputs-{{ $userEvent->id }}">
            @foreach ($userEvent->opponent_score as $score)
                <input 
                    type="number" 
                    name="opponent_scores[{{ $userEvent->id }}][]" 
                    class="form-control w-3/4 mx-auto mb-1 border border-gray-300 rounded px-2 py-1"
                    value="{{ $score }}" 
                    min="0" max="100">
            @endforeach
        </div>
        
        <button type="button" class="retry-btn text-red-600 font-semibold mt-2" data-id="{{ $userEvent->id }}">Retry</button>
    @elseif ($userEvent->status === 'pending')
        <div class="input-group" id="opponent-score-inputs-container-{{ $userEvent->id }}">
            <input 
                type="number" 
                name="opponent_scores[{{ $userEvent->id }}][]" 
                class="form-control w-3/4 mx-auto border border-gray-300 rounded px-2 py-1"
                min="0" max="100" 
                placeholder="Enter opponent's score">
                <button type="button" class="btn btn-sm btn-success add-opponent-score" data-id="{{ $userEvent->id }}">+ Add</button>
        </div>
    @else
        @if (isset($userEvent->opponent_score))
            <div>{{ implode(', ', $userEvent->opponent_score) }}</div>
        @else
            <div>No opponent score available</div>
        @endif
    @endif
</td>


                           
                                <td class="px-4 py-2 border" style="text-align: center; padding: 10px; border: 1px solid #ccc;">
                                        <input type="hidden" name="event_ids[]" value="{{ $userEvent->id }}">

                                        @if (isset($userEvent->show_approval_buttons) && $userEvent->show_approval_buttons)
                                            @if ($userEvent->status == 'Requested')
                                             
                                                    <button type="button" class="status-btn approve-btn" data-status="Approved"
                                                        style="background-color: #22c55e; color: #fff; padding: 6px 12px; border-radius: 4px; border: none; cursor: pointer; margin-right: 8px;">
                                                        Approve
                                                    </button>
                                                    <button type="button" class="status-btn reject-btn" data-status="Rejected"
                                                        style="background-color: #ef4444; color: #fff; padding: 6px 12px; border-radius: 4px; border: none; cursor: pointer;">
                                                        Reject
                                                    </button>
                                             
                                            @elseif ($userEvent->status == 'Approved')
                                                <span style="color: #22c55e;">Event Approved</span>
                                            @elseif ($userEvent->status == 'Rejected')
                                                <span style="color: #ef4444;">Event Rejected</span>
                                            @endif
                                        @else
                                            <button type="submit" class="btn btn-sm btn-primary" style="padding: 5px 10px; background-color: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer;">
                                                Submit
                                            </button>
                                        @endif
                                    </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {


        
        // Retry button functionality for rejected events
        document.querySelectorAll('.retry-btn').forEach(button => {
            button.addEventListener('click', function () {
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
            button.addEventListener('click', function () {
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
                newInput.classList.add('form-control', 'w-3/4', 'mx-auto', 'border', 'border-gray-300', 'rounded', 'px-2', 'py-1');
                newInput.min = 0;
                newInput.max = 100;
                newInput.placeholder = "Enter score";

                container.insertBefore(newInput, this);
            });
        });


        document.querySelectorAll('.retry-btn').forEach(button => {
        button.addEventListener('click', function () {
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
            button.addEventListener('click', function () {
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
        button.addEventListener('click', function (e) {
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
