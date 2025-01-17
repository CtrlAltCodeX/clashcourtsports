<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
  
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

 
 public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // dd($request->all());
        // Fill the user model with validated data
        $request->user()->fill($request->validated());

        if ($request->has('phone_number')) {
            $request->user()->phone_number = $request->input('phone_number');
        }
        if ($request->has('city')) {
            $request->user()->city = $request->input('city');
        }

        if ($request->has('state')) {
            $request->user()->state = $request->input('state');
        }

        if ($request->has('zip_code')) {
            $request->user()->zip_code = $request->input('zip_code');
        }
        // Check if the email field was modified and reset verification
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        if ($request->has('latitude')) {
            $request->user()->latitude = $request->input('latitude');
        }
        if ($request->has('longitude')) {
            $request->user()->longitude = $request->input('longitude');
        }
        
        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if it exists
            if ($request->user()->profile_image) {
                $oldImagePath = public_path('assets/storage/' . $request->user()->profile_image);
                if (file_exists($oldImagePath)) {
                    @unlink($oldImagePath);
                }
            }

            // Store new image in the custom folder
            $fileName = time() . '_' . $request->file('profile_image')->getClientOriginalName();
            $request->file('profile_image')->move('assets/storage', $fileName);

            // Save the file name in the database
            $request->user()->profile_image = $fileName;
        }

        // Save the updated user details
        $request->user()->save();

        // Redirect back with a success message
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
  
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
