@extends('layouts.sidebar')

@section('admin-content')
<h2 class="text-2xl font-semibold text-blue-600 mb-6">Add Manual Match</h2>

@if (session('success'))
<div class="bg-green-100 border border-green-300 text-green-700 p-4 rounded-lg mb-6">
    {{ session('success') }}
</div>
@endif

<form action="{{ route('user.events.save.match') }}" method="POST" class="bg-white p-8 rounded-lg max-w-lg mx-auto">
    @csrf
    <div class="space-y-6">
        <!-- Select Event -->
        <div>
            <label for="event_id" class="block font-medium text-gray-700 mb-2">Select Event</label>
            <select id="event_id" name="event_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                <option value="">Select Event</option>
                @foreach ($userEvents as $userEvent)
                <option value="{{ $userEvent[0]->id }}">{{ $userEvent[0]->event->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- User Score (Multiple) -->
        <div id="scoresContainer">
            <label for="scores" class="block font-medium text-gray-700 mb-2">Your Score</label>
            <div class="flex items-center space-x-4">
                <input type="number" name="scores[]" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Enter your score" required>
                <button type="button" onclick="addMoreScores()" class="text-blue-600 font-medium hover:underline">Add More</button>
            </div>
        </div>

        <!-- Opponent Dropdown -->
        <div>
            <label for="selected_user" class="block font-medium text-gray-700 mb-2">Select Opponent</label>
            <select id="selected_user" name="selected_user" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                <option value="">Select Opponent</option>
                @foreach ($usersForDropdown as $eventId => $users)
                @foreach ($users as $user)
                <option value="{{ $user[0]->user_event_id }}">{{ $user[0]->email }}</option>
                @endforeach
                @endforeach
            </select>
        </div>

        <!-- Opponent Score (Multiple) -->
        <div id="opponentScoresContainer">
            <label for="opponent_scores" class="block font-medium text-gray-700 mb-2">Opponent Score</label>
            <div class="flex items-center space-x-4">
                <input type="number" name="opponent_scores[]" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Enter opponent score" required>
                <button type="button" onclick="addMoreOpponentScores()" class="text-blue-600 font-medium hover:underline">Add More</button>
            </div>
        </div>

        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">

        <!-- Submit Button -->
        <div>
            <button type="submit" class="w-full py-3 text-white font-semibold rounded-lg shadow-md bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-transform transform hover:scale-105">
                Add Match
            </button>
        </div>
    </div>
</form>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyANGZDqrXUiu4UkxKiZIaRe9jw&libraries=places"></script>

<script>
    // Use the Geolocation API
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;
            },
            function(error) {
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