<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OfficialsRegistrationController extends Controller
{
    // Display all users except 'Supper'
    public function index()
    {
        $officials = User::where('type', '!=', 'Supper')->get();
        return view('admin.officials_registration.index', compact('officials'));
    }

    // Show form for creating a new official
    public function create()
    {
        return view('admin.officials_registration.create');
    }

    // Store a new official user
    public function store(Request $request)
    {
        $request->validate([
            'organization_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create and save a new user instance
        $user = new User();
        $user->name = $request->organization_name;
        $user->type = 'admin'; // default type as 'admin'
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->zip_code = $request->zip_code;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('officials_registration.index')->with('success', 'Official registered successfully.');
    }

    // Show the details of the official
    public function show($id)
    {
        // Retrieve the user by ID without using the official model variable
        $official = User::findOrFail($id);
        return view('admin.officials_registration.show', compact('official'));
    }

    // Edit the official's details
    public function edit($id)
    {
        // Retrieve the user by ID
        $official = User::findOrFail($id);
        return view('admin.officials_registration.edit', compact('official'));
    }

    // Update an official's details
    public function update(Request $request, $id)
    {
        $request->validate([
            'organization_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email,' . $id,
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'password' => 'nullable|string|min:8|confirmed', // Password update is optional
        ]);

        // Find the user by ID and update
        $user = User::findOrFail($id);

        $user->name = $request->organization_name;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->zip_code = $request->zip_code;

        // Update password if provided
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('officials_registration.index')->with('success', 'Official updated successfully.');
    }

    // Delete an official
    public function destroy($id)
    {
        // Find the user by ID and delete
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('officials_registration.index')->with('success', 'Official deleted successfully.');
    }
}

// use Illuminate\Support\Facades\DB;

// public function getNearbyUsers()
// {
//     $user = Auth::user();
//     $latitude = $user->latitude;
//     $longitude = $user->longitude;

//     $nearbyUsers = User::select('*', DB::raw("(
//         6371 * acos(
//             cos(radians($latitude)) *
//             cos(radians(latitude)) *
//             cos(radians(longitude) - radians($longitude)) +
//             sin(radians($latitude)) *
//             sin(radians(latitude))
//         )
//     ) AS distance"))
//     ->having('distance', '<', 10) // 10 kilometers radius
//     ->orderBy('distance')
//     ->get();

//     return view('user.nearby_users', compact('nearbyUsers'));
// } 
