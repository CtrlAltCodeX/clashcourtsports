<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OfficialsRegistrationController extends Controller
{

    public function index()
    {
        $officials = User::where('type', '!=', 'Supper')->get();
        return view('admin.officials_registration.index', compact('officials'));
    }

    public function create()
    {
        return view('admin.officials_registration.create');
    }


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

   
        $user = new User();
        $user->name = $request->organization_name;
        $user->type = 'admin';
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->zip_code = $request->zip_code;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('officials_registration.index')->with('success', 'Official registered successfully.');
    }

 
    public function show($id)
    {
  
        $official = User::findOrFail($id);
        return view('admin.officials_registration.show', compact('official'));
    }


    public function edit($id)
    {
    
        $official = User::findOrFail($id);
        return view('admin.officials_registration.edit', compact('official'));
    }

 
    public function update(Request $request, $id)
    {
        $request->validate([
            'organization_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email,' . $id,
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'password' => 'nullable|string|min:8|confirmed', 
        ]);

     
        $user = User::findOrFail($id);

        $user->name = $request->organization_name;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->zip_code = $request->zip_code;


        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('officials_registration.index')->with('success', 'Official updated successfully.');
    }

   
    public function destroy($id)
    {
      
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('officials_registration.index')->with('success', 'Official deleted successfully.');
    }
}