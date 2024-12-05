@extends('layouts.sidebar')

@section('admin-content')
    <div class="flex justify-between items-center mb-6">
        <!-- Back Button -->
        <a href="{{ url()->previous() }}" 
           style="background-color: #f3f4f6; color: #1f2937; padding: 0.5rem 1.5rem; border-radius: 0.375rem; font-weight: 500; text-align: center; display: inline-block; transition: background-color 0.2s;">
            Back
        </a>

        <!-- Heading -->
        <h1 class="text-2xl font-semibold">Edit Event</h1>
    </div>
    <form action="{{ route('events.update', $event->id) }}" method="POST" class="bg-white p-8 rounded-lg max-w-lg mx-auto">
        @csrf
        @method('PUT')

        <!-- Event Name -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-medium mb-2">Event Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $event->name) }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

     
        <div class="mb-4">
            <label for="game_name" class="block text-gray-700 font-medium mb-2">Game Name</label>
            <input type="text" name="game_name" id="game_name" value="{{ old('game_name', $event->game_name) }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>
  
     <div class="mb-4">
            <label for="game_start_date" class="block text-gray-700 font-medium mb-2">Game Start Date</label>
            <input type="datetime-local" name="game_start_date" id="game_start_date" value="{{ old('game_start_date', $event->game_start_date) }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

      
        <div class="mb-4">
            <label for="game_end_date" class="block text-gray-700 font-medium mb-2">Game End Date</label>
            <input type="datetime-local" name="game_end_date" id="game_end_date" value="{{ old('game_end_date', $event->game_end_date) }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label for="location" class="block text-gray-700 font-medium mb-2">Location</label>
            <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>


        <div class="mb-4">
            <label for="date" class="block text-gray-700 font-medium mb-2">Start Date Time</label>
            <input type="datetime-local" name="date" id="date" value="{{ old('date', $event->date) }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

     
        <div class="mb-4">
            <label for="enddate" class="block text-gray-700 font-medium mb-2">End Date Time</label>
            <input type="datetime-local" name="enddate" id="enddate" value="{{ old('enddate', $event->enddate) }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

  
        <div class="mb-4">
            <label for="capacity" class="block text-gray-700 font-medium mb-2">Capacity</label>
            <input type="number" name="capacity" id="capacity" value="{{ old('capacity', $event->capacity) }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <div class="mb-6">
            <label for="pricing" class="block text-gray-700 font-medium mb-2">Single Price</label>
            <input type="number" name="pricing" id="pricing" value="{{ old('pricing', $event->pricing) }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" step="0.01" required>
        </div>

  
        <div class="mb-4">
            <label for="double_price" class="block text-gray-700 font-medium mb-2">Double Price</label>
            <input type="number" name="double_price" id="double_price" value="{{ old('double_price', $event->double_price) }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" step="0.01" required>
        </div>

     
        <div class="flex justify-center">
            <button type="submit" style="width:50%;background-color: #10B981; color: white; padding: 0.5rem 1.5rem; border-radius: 0.375rem; font-weight: 500; transition: background-color 0.2s;" 
                    onmouseover="this.style.backgroundColor='#059669'"
                    onmouseout="this.style.backgroundColor='#10B981'">
                Update Event
            </button>
        </div>
    </form>
@endsection
