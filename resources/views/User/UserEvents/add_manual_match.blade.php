@extends('layouts.sidebar')

@section('admin-content')
<div class="card shadow-sm">
    <div class="card-header bg-blue-600 text-white text-center py-3">
        <h2 class="text-xl font-semibold">Add Manual Match</h2>
    </div>

    <div class="card-body px-6 py-4">
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif

        <form action="{{ route('user.events.save.match') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <!-- Select Event -->
                <div>
                    <label for="event_id" class="block font-semibold text-gray-700">Select Event</label>
                    <select id="event_id" name="event_id" class="w-full p-2 border border-gray-300 rounded" required>
                        <option value="">Select Event</option>
                        @foreach ($userEvents as $userEvent)
                            <option value="{{ $userEvent->id }}">{{ $userEvent->event->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- User Score (Multiple) -->
                <div id="scoresContainer">
                    <label for="scores" class="block font-semibold text-gray-700">Your Score</label>
                    <div class="flex items-center">
                        <div class="score-input flex-1">
                            <input type="number" name="scores[]" class="w-full p-2 border border-gray-300 rounded mb-2" required>
                        </div>
                        <button type="button" onclick="addMoreScores()" class="text-blue-600 ml-4">Add More</button>
                    </div>
                </div>

                <!-- Opponent Dropdown -->
                <div>
                    <label for="selected_user" class="block font-semibold text-gray-700">Select Opponent</label>
                    <select id="selected_user" name="selected_user" class="w-full p-2 border border-gray-300 rounded" required>
                        <option value="">Select Opponent</option>
                        @foreach ($usersForDropdown as $eventId => $users)
                            @foreach ($users as $user)
                                <option value="{{ $user->user_event_id }}">{{ $user->email }}</option> 
                            @endforeach
                        @endforeach
                    </select>
                </div>

                <!-- Opponent Score (Multiple) -->
                <div id="opponentScoresContainer">
                    <label for="opponent_scores" class="block font-semibold text-gray-700">Opponent Score</label>
                    <div class="flex items-center">
                        <div class="opponent-score-input flex-1">
                            <input type="number" name="opponent_scores[]" class="w-full p-2 border border-gray-300 rounded mb-2" required>
                        </div>
                        <button type="button" onclick="addMoreOpponentScores()" class="text-blue-600 ml-4">Add More</button>
                    </div>
                </div>
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
                <!-- Submit Button with Inline Styles -->
                <div>
                    <button type="submit" class="w-full py-2 rounded"
                        style="background-color: #2563eb; color: white; padding: 0.5rem 1.5rem; font-weight: 600; border-radius: 0.5rem; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); transition: background-color 0.3s ease-in-out, transform 0.3s ease-in-out;"
                        onmouseover="this.style.backgroundColor='#1d4ed8'; this.style.transform='scale(1.05)';"
                        onmouseout="this.style.backgroundColor='#2563eb'; this.style.transform='scale(1)';">
                        Add Match
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyANGZDqrXUiu4UkxKiZIaRe9jw&libraries=places"></script>
<script>
    // Use the Geolocation API
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;
            },
            function (error) {
                console.error('Error obtaining location:', error);
            }
        );
    } else {
        alert('Geolocation is not supported by this browser.');
    }
</script>
<script>
    let scoreCount = 1; // Initial count for score inputs
    let opponentScoreCount = 1; // Initial count for opponent score inputs

    // Function to add more score inputs
    function addMoreScores() {
        if (scoreCount < 5) { // Limiting to a maximum of 5 score fields
            scoreCount++;
            const scoreInputContainer = document.getElementById('scoresContainer');
            const newScoreInput = document.createElement('div');
            newScoreInput.classList.add('score-input', 'flex', 'items-center', 'mt-2');
            newScoreInput.innerHTML = `
                <div class="flex-1">
                    <input type="number" name="scores[]" class="w-full p-2 border border-gray-300 rounded mb-2" required>
                </div>
       
            `;
            scoreInputContainer.appendChild(newScoreInput);
        }
    }

    // Function to add more opponent score inputs
    function addMoreOpponentScores() {
        if (opponentScoreCount < 5) { // Limiting to a maximum of 5 opponent score fields
            opponentScoreCount++;
            const opponentScoreContainer = document.getElementById('opponentScoresContainer');
            const newOpponentScoreInput = document.createElement('div');
            newOpponentScoreInput.classList.add('opponent-score-input', 'flex', 'items-center', 'mt-2');
            newOpponentScoreInput.innerHTML = `
                <div class="flex-1">
                    <input type="number" name="opponent_scores[]" class="w-full p-2 border border-gray-300 rounded mb-2" required>
                </div>
              
            `;
            opponentScoreContainer.appendChild(newOpponentScoreInput);
        }
    }
</script>

@endsection
