<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\UserEvent;

class UserEventController extends Controller
{
    public function index()
    {
        // Current logged-in user
        $user = auth()->user();

        // Step 1: Get all events the user has participated in
        $userEvents = UserEvent::where('user_id', $user->id)->get();

        // Prepare the data structure for event details with nearby users
        $eventsWithNearbyUsers = [];

        foreach ($userEvents as $userEvent) {
            $event = Event::find($userEvent->event_id);

            // Step 2: Find users within 10km radius of this event
            $latitude = $userEvent->latitude;
            $longitude = $userEvent->longitude;
            $nearbyUsers = UserEvent::select('user_events.*', 'users.name', 'users.email')
                ->join('users', 'users.id', '=', 'user_events.user_id')
                ->where('user_events.event_id', $userEvent->event_id)
                ->whereRaw("
                    6371 * acos(
                        cos(radians(?)) * cos(radians(latitude)) *
                        cos(radians(longitude) - radians(?)) +
                        sin(radians(?)) * sin(radians(latitude))
                    ) <= 10
                ", [$latitude, $longitude, $latitude])
                ->get();

            // Step 3: Prepare data for listing
            $eventsWithNearbyUsers[] = [
                'event' => $event,
                'nearby_users' => $nearbyUsers
            ];
        }

        // Return data to a view
        return view('User.UserEvents.events', compact('eventsWithNearbyUsers'));
    }
    public function AddScore()
    {
        $user = auth()->user();
    
        // Get all events the user has participated in
        $userEvents = UserEvent::with('event') // Eager load event details
            ->where('user_id', $user->id)
            ->get();
    
        // Return view with data
        return view('User.UserEvents.add_score', compact('userEvents'));
    }

    

    
    public function SaveScore(Request $request)
    {
        $request->validate([
            'scores' => 'required|array',
        ]);
    
        foreach ($request->scores as $userEventId => $score) {
            // Check if the score is not null in the request
            if ($score !== null) {
                // Find the user event record
                $userEvent = UserEvent::find($userEventId);
    
                if ($userEvent) {
                    // Check if the score is different from the existing value
                    if ($userEvent->score === null || $userEvent->score != $score) {
                        $userEvent->score = json_encode($score);;
                        $userEvent->status = 'Requested'; // Update status only for changed scores
                        $userEvent->save();
                    }
                }
            }
        }
    
        return redirect()->route('user.events.score')->with('success', 'Scores updated successfully!');
    }
    
}
