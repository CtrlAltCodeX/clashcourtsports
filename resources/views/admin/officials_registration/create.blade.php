@extends('layouts.sidebar')

@section('admin-content')
<h1 class="text-2xl font-semibold mb-6">Add Official</h1>

<form action="{{ route('officials_registration.store') }}" method="POST" class="bg-white p-8 rounded-lg max-w-lg mx-auto">
    @csrf

    <!-- Organization Name -->
    <div class="mb-4">
        <label for="organization_name" class="block text-gray-700 font-medium mb-2">Organization Name</label>
        <input type="text" name="organization_name" id="organization_name" value="{{ old('organization_name') }}"
            placeholder="Enter organization name"
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        @error('organization_name')
        <span style="color: red; font-size: 0.875rem;">{{ $message }}</span>
        @enderror
    </div>

    <!-- Phone Number -->
    <div class="mb-4">
        <label for="phone_number" class="block text-gray-700 font-medium mb-2">Phone Number</label>
        <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}"
            placeholder="Enter phone number"
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        @error('phone_number')
        <span style="color: red; font-size: 0.875rem;">{{ $message }}</span>
        @enderror
    </div>

    <!-- Email -->
    <div class="mb-4">
        <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}"
            placeholder="Enter email address"
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        @error('email')
        <span style="color: red; font-size: 0.875rem;">{{ $message }}</span>
        @enderror
    </div>

    <!-- City -->
    <div class="mb-4">
        <label for="city" class="block text-gray-700 font-medium mb-2">City</label>
        <input type="text" name="city" id="city" value="{{ old('city') }}"
            placeholder="Enter city"
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        @error('city')
        <span style="color: red; font-size: 0.875rem;">{{ $message }}</span>
        @enderror
    </div>

    <!-- State -->
    <div class="mb-4">
        <label for="state" class="block text-gray-700 font-medium mb-2">State</label>
        <input type="text" name="state" id="state" value="{{ old('state') }}"
            placeholder="Enter state"
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        @error('state')
        <span style="color: red; font-size: 0.875rem;">{{ $message }}</span>
        @enderror
    </div>

    <!-- Zip Code -->
    <div class="mb-4">
        <label for="zip_code" class="block text-gray-700 font-medium mb-2">Zip Code</label>
        <input type="text" name="zip_code" id="zip_code" value="{{ old('zip_code') }}"
            placeholder="Enter zip code"
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        @error('zip_code')
        <span style="color: red; font-size: 0.875rem;">{{ $message }}</span>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-4">
        <label for="password" class="block text-gray-700 font-medium mb-2">New Password</label>
        <input type="password" name="password" id="password"
            placeholder="Enter new password"
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        @error('password')
        <span style="color: red; font-size: 0.875rem;">{{ $message }}</span>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="mb-4">
        <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation"
            placeholder="Confirm new password"
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        @error('password_confirmation')
        <span style="color: red; font-size: 0.875rem;">{{ $message }}</span>
        @enderror
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
