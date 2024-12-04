<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserEvent;

class ManageScoreController extends Controller
{
 
    public function index()
    {
      
        $userEvents = UserEvent::with(['event', 'user'])
            ->where('status', '!=', 'pending')
            ->whereNotNull('score')
            ->get();
    

        return view('admin.manage_scores.index', compact('userEvents'));
    }
    

   
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Approved,Rejected', 
        ]);

        $userEvent = UserEvent::findOrFail($id);
        $userEvent->status = $request->status;
        $userEvent->save();

        return redirect()->route('admin.manage_scores.index')->with('success', 'Status updated successfully!');
    }
}
