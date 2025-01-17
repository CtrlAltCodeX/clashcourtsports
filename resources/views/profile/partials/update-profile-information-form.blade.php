<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information, email address, phone number, and profile image etc.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6 w-[50%]">
        @csrf
        @method('patch')

        <!-- Hidden Fields for Location -->
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">

      

        <!-- Profile Image -->
        <div class="flex items-center">
            <div class="mr-4">
                @if ($user->profile_image)
                    <div class="relative w-20 h-20">
                        <img src="{{ asset('assets/storage/' . $user->profile_image) }}" 
                            alt="Profile Image" 
                            class="w-full h-full rounded-full object-cover border-2 border-gray-300 shadow">
                    </div>
                @else
                    <div class="relative w-20 h-20">
                        <img src="{{ asset('assets/images/default_profile.png') }}" 
                            alt="Default Profile Image" 
                            class="w-full h-full rounded-full object-cover border-2 border-gray-300 shadow">
                    </div>
                @endif
            </div>
            <div>
                <x-input-label for="profile_image" :value="__('Profile Image')" />
                <input id="profile_image" name="profile_image" type="file" class="mt-1 block w-full">
                <x-input-error class="mt-2" :messages="$errors->get('profile_image')" />
            </div>
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <!-- Phone Number -->
        <div>
            <x-input-label for="phone_number" :value="__('Phone Number')" />
            <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" :value="old('phone_number', $user->phone_number)" required autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>

        <!-- City, State, and Zip Code -->
        <div>
            <x-input-label for="city" :value="__('City')" />
            <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $user->city)" required autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('city')" />
        </div>

        <div>
            <x-input-label for="state" :value="__('State')" />
            <x-text-input id="state" name="state" type="text" class="mt-1 block w-full" :value="old('state', $user->state)" required autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('state')" />
        </div>

        <div>
            <x-input-label for="zip_code" :value="__('Zip Code')" />
            <x-text-input id="zip_code" name="zip_code" type="text" class="mt-1 block w-full" :value="old('zip_code', $user->zip_code)" required autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('zip_code')" />
        </div>
  <!-- Change Location Button -->
  <div>
            <x-input-label for="change_location" :value="__('Change Location')" />
            <button type="button" id="get-location" class="mt-1 block w-full bg-blue-500 text-white rounded px-4 py-2">
                {{ __('Get Current Location') }}
            </button>
            <p id="location-message" class="mt-2 text-sm text-gray-600 hidden"></p>
        </div>
        <!-- Save Button -->
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyANGZDqrXUiu4UkxKiZIaRe9jw&libraries=places"></script>

<script>
    document.getElementById('get-location').addEventListener('click', function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                    document.getElementById('location-message').innerText = 'Your location has been updated. Please click save to confirm.';
                    document.getElementById('location-message').classList.remove('hidden');
                },
                function(error) {
                    console.error('Error obtaining location:', error);
                }
            );
        } else {
            alert('Geolocation is not supported by this browser.');
        }
    });
</script>
