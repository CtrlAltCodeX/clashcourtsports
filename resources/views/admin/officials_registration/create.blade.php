@extends('layouts.sidebar')

@section('admin-content')
    <h1 class="text-2xl font-semibold mb-6">Add Official</h1>

    <form action="{{ route('officials_registration.store') }}" method="POST" class="bg-white p-8 rounded-lg max-w-lg mx-auto">
        @csrf

        <!-- Organization Name -->
        <div class="mb-4">
            <label for="organization_name" class="block text-gray-700 font-medium mb-2">Organization Name</label>
            <input type="text" name="organization_name" id="organization_name" value="{{ old('organization_name') }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <!-- Phone Number -->
        <div class="mb-4">
            <label for="phone_number" class="block text-gray-700 font-medium mb-2">Phone Number</label>
            <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <!-- City -->
        <div class="mb-4">
            <label for="city" class="block text-gray-700 font-medium mb-2">City</label>
            <input type="text" name="city" id="city" value="{{ old('city') }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <!-- State -->
        <div class="mb-4">
            <label for="state" class="block text-gray-700 font-medium mb-2">State</label>
            <input type="text" name="state" id="state" value="{{ old('state') }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <!-- Zip Code -->
        <div class="mb-4">
            <label for="zip_code" class="block text-gray-700 font-medium mb-2">Zip Code</label>
            <input type="text" name="zip_code" id="zip_code" value="{{ old('zip_code') }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-medium mb-2">New Password</label>
            <input type="password" name="password" id="password" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-center">
        <button type="submit" style="width:50%;background-color: #10B981; color: white; padding: 0.5rem 1.5rem; border-radius: 0.375rem; font-weight: 500; transition: background-color 0.2s;" 
                        onmouseover="this.style.backgroundColor='#059669'"
                        onmouseout="this.style.backgroundColor='#10B981'">
                        Register Official
                </button>

</div>
    </form>
@endsection
