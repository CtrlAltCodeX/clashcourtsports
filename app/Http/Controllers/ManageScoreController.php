<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserEvent;

class ManageScoreController extends Controller
{
    // Show all user events with the status "Requested"
    public function index()
    {
        // Fetch all user events excluding those with "pending" status
        $userEvents = UserEvent::with(['event', 'user']) // Eager load event and user details
            ->where('status', '!=', 'pending') // Exclude events with "pending" status
            ->whereNotNull('score') // Ensure the score is not null
            ->get();
    
        // Return the view with the data
        return view('admin.manage_scores.index', compact('userEvents'));
    }
    

    // Handle approve/reject requests
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Approved,Rejected', // Validate status
        ]);

        $userEvent = UserEvent::findOrFail($id);
        $userEvent->status = $request->status;
        $userEvent->save();

        return redirect()->route('admin.manage_scores.index')->with('success', 'Status updated successfully!');
    }
}
