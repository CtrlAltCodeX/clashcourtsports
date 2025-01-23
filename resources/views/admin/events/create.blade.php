@extends('layouts.sidebar')

@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <!-- Back Button -->
    <a href="{{ url()->previous() }}"
        style="background-color: #f3f4f6; color: #1f2937; padding: 0.5rem 1.5rem; border-radius: 0.375rem; font-weight: 500; text-align: center; display: inline-block; transition: background-color 0.2s;">
        Back
    </a>

    <!-- Heading -->
    <h1 class="text-2xl font-semibold">Create Event</h1>
</div>
<form action="{{ route('events.store') }}" method="POST" class="bg-white p-8 rounded-lg max-w-lg mx-auto">
    @csrf

    <!-- Event Name -->
    <div class="mb-4">
        <label for="name" class="block text-gray-700 font-medium mb-2">Event Name</label>
        <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>

    <!-- Game Name -->
    <div class="mb-4">
        <label for="game_name" class="block text-gray-700 font-medium mb-2">Game Name</label>
        <input type="text" name="game_name" id="game_name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>

    <!-- Game Start Date -->
    <div class="mb-4">
        <label for="game_start_date" class="block text-gray-700 font-medium mb-2">Session start date</label>
        <input type="datetime-local" name="game_start_date" id="game_start_date" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>

    <!-- Game End Date -->
    <div class="mb-4">
        <label for="game_end_date" class="block text-gray-700 font-medium mb-2">Session end date</label>
        <input type="datetime-local" name="game_end_date" id="game_end_date" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>
    <!-- Location -->
    <div class="mb-4">
        <label for="location" class="block text-gray-700 font-medium mb-2">Location</label>
        <input type="text" name="location" id="location" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>



    <!-- Date -->
    <div class="mb-4">
        <label for="date" class="block text-gray-700 font-medium mb-2">Registration Start Date</label>
        <input type="datetime-local" name="date" id="date" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>

    <!-- End Date -->
    <div class="mb-4">
        <label for="enddate" class="block text-gray-700 font-medium mb-2">Registration End Date</label>
        <input type="datetime-local" name="enddate" id="enddate" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>

    <!-- Capacity -->
    <div class="mb-4">
        <label for="capacity" class="block text-gray-700 font-medium mb-2">Capacity</label>
        <input type="number" name="capacity" id="capacity" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
    </div>

    <!-- Pricing -->
    <div class="mb-6 hidden" id='single'>
        <label for="pricing" class="block text-gray-700 font-medium mb-2">Single Price</label>
        <input type="number" name="pricing" id="pricing"
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" step="0.01" >
    </div>

    <div class="mb-4 hidden" id='double'>
        <label for="double_price" class="block text-gray-700 font-medium mb-2">Double Price</label>
        <input type="number" name="double_price" id="double_price"
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" step="0.01" >
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-2">Game Type</label>
        <select id='game_type' class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name='selected_game'>
            <option value="">Select</option>
            <option value="singles">Singles</option>
            <option value="doubles">Doubles</option>
        </select>
    </div>

    <div class="mb-4">
        <label class="block text-gray-700 font-medium mb-2">Skill Level</label>
        <select class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name='skill_level'>
            <option value="">Select</option>
            <option value="beginner">Beginner</option>
            <option value="advanced">Advanced</option>
        </select>
    </div>

    <!-- Submit Button -->
    <div class="flex justify-center">
        <button type="submit" style="width:50%;background-color: #10B981; color: white; padding: 0.5rem 1.5rem; border-radius: 0.375rem; font-weight: 500; transition: background-color 0.2s;"
            onmouseover="this.style.backgroundColor='#059669'"
            onmouseout="this.style.backgroundColor='#10B981'">
            Create Event
        </button>
    </div>
</form>
@endsection

@push('scripts')

<script>
    // Current date and time ko YYYY-MM-DDTHH:MM format mein convert karte hain
    function setMinDateTime() {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');

        const currentDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;

        // Sare datetime-local fields mein minimum date set karte hain
        document.getElementById('game_start_date').min = currentDateTime;
        document.getElementById('game_end_date').min = currentDateTime;
        document.getElementById('date').min = currentDateTime;
        document.getElementById('enddate').min = currentDateTime;
    }

    // Page load hone par function call karte hain
    window.onload = setMinDateTime;
</script>

<script>
    $(document).ready(function() {
        $("#game_type").change(function() {
            if ($(this).val() == 'singles') {
                $("#single").removeClass('hidden');
                $("#double").addClass('hidden');
            } else if ($(this).val() == 'doubles') {
                $("#single").addClass('hidden');
                $("#double").removeClass('hidden');
            } else {
                $("#single").addClass('hidden');
                $("#double").addClass('hidden');
            }
        });
    });
</script>
@endpush