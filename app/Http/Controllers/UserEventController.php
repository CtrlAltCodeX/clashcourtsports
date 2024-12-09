<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\UserEvent;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEventEmail;
class UserEventController extends Controller
{
    public function index()
    {
        $user = auth()->user();
    
        // Retrieve all user events
        $userEvents = UserEvent::where('user_id', $user->id)->get();
    
        $eventsWithNearbyUsers = [];
    
        foreach ($userEvents as $userEvent) {
            $event = Event::find($userEvent->event_id);
    
            $latitude = $userEvent->latitude;
            $longitude = $userEvent->longitude;
            $userSkillLevel = $user->Skill_Level;
    
            // Adjust distance calculation to filter users within 10 miles
            $nearbyUsers = UserEvent::select('user_events.*', 'users.name', 'users.email', 'users.Skill_Level')
                ->join('users', 'users.id', '=', 'user_events.user_id')
                ->where('user_events.selected_game', $userEvent->selected_game)
                ->where('user_events.event_id', $userEvent->event_id)
                ->where('users.skill_level', $userSkillLevel)
                ->where('users.id', '!=', $user->id)
                ->whereRaw("
                    3959 * acos(
                        cos(radians(?)) * cos(radians(latitude)) *
                        cos(radians(longitude) - radians(?)) +
                        sin(radians(?)) * sin(radians(latitude))
                    ) <= 10
                ", [$latitude, $longitude, $latitude])
                ->get();
    
            $eventsWithNearbyUsers[] = [
                'event' => $event,
                'nearby_users' => $nearbyUsers
            ];
        }
    
        return view('User.UserEvents.events', compact('eventsWithNearbyUsers'));
    }
    
    
    public function AddScore()
    {
        $user = auth()->user();
        
        // Fetch events where the logged-in user is participating
        $userEvents = UserEvent::with('event')
            ->where('user_id', $user->id)
            ->get();
        
        $userSkillLevel = $user->Skill_Level;
        $usersForDropdown = [];
        
        foreach ($userEvents as $userEvent) {
            // Fetch users for the dropdown (opponents for the current user's events)
            $usersForEvent = UserEvent::select(
                'user_events.*',
                'users.name',
                'users.email',
                'users.Skill_Level',
                'user_events.id as user_event_id'
            )
            ->join('users', 'users.id', '=', 'user_events.user_id')
            ->where('user_events.selected_game', $userEvent->selected_game)
            ->where('user_events.event_id', $userEvent->event_id)
            ->where('users.skill_level', $userSkillLevel)
            ->where('users.id', '!=', $user->id)
            ->get();
            
            $usersForDropdown[$userEvent->id] = $usersForEvent;
   
            if ($userEvent->reciver_opponent_id) {
                $receiverOpponentId = $userEvent->reciver_opponent_id;
                $opponentScore = UserEvent::where('id', $receiverOpponentId)
                    ->where('event_id', $userEvent->event_id)
                    ->first();
                
                // Get the opponent's email
                if ($opponentScore) {
                    $opponentUser = User::find($opponentScore->user_id); 
              
                    if ($opponentUser) {
                        $userEvent->opponent_email = $opponentUser->email; // Store opponent's email in the event
                        $userEvent->user_event_id = $opponentScore->id; // Store the user_event_id
                    }
                    $userEvent->opponent_score = json_decode($opponentScore->score); // Assuming score is stored as JSON
                }
            }elseif ($userEvent->sender_opponent_id) {

                $sender_opponent_id = $userEvent->sender_opponent_id;
                $opponentScore = UserEvent::where('id', $sender_opponent_id)
                    ->where('event_id', $userEvent->event_id)
                    ->first();
                
                // Get the opponent's email
                if ($opponentScore) {
                    $opponentUser = User::find($opponentScore->user_id); 
              
                    if ($opponentUser) {
                        $userEvent->opponent_email = $opponentUser->email; // Store opponent's email in the event
                        $userEvent->user_event_id = $opponentScore->id; // Store the user_event_id
                    }
                    $userEvent->opponent_score = json_decode($opponentScore->score); // Assuming score is stored as JSON
                }
                // If reciver_opponent_id is not set, check sender_opponent_id and assign approval status
                $userEvent->show_approval_buttons = true; // Add flag for showing approval buttons
            }
        }

        return view('User.UserEvents.add_score', compact('user', 'userEvents', 'usersForDropdown'));

    }
    
    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:Approved,Rejected', 
    ]);

    // Find the current user event by ID
    $userEvent = UserEvent::findOrFail($id);
    
    // Get the new status from the request
    $status = $request->status;
    
    // Update the status of the current event
    $userEvent->status = $status;
    $userEvent->updated_at = now();
    $userEvent->save();

    // Update the opponent's event status if applicable
    $this->updateOpponentStatus($userEvent, $status);
    return response()->json([
        'success' => true,
        'message' => 'Event status updated successfully.'
    ]);
}

private function updateOpponentStatus(UserEvent $userEvent, $status)
{
    // Check if the current event has a receiver opponent ID
    if ($userEvent->reciver_opponent_id) {
        $opponentEvent = UserEvent::find($userEvent->reciver_opponent_id);
        if ($opponentEvent) {
            $opponentEvent->status = $status;
            $opponentEvent->updated_at = now();
            $opponentEvent->save();
        }
    }

    // Check if the current event has a sender opponent ID
    if ($userEvent->sender_opponent_id) {
        $opponentEvent = UserEvent::find($userEvent->sender_opponent_id);
        if ($opponentEvent) {
            $opponentEvent->status = $status;
            $opponentEvent->updated_at = now();
            $opponentEvent->save();
        }
    }
}


public function SaveScore(Request $request)
{
    // Validate the necessary fields
    $request->validate([
        'scores' => 'required',
        'event_id' => 'required',
        'selected_users' => 'required',
        'opponent_scores' => 'required',
    ]);

    // Get the specific event_id for the clicked form
    $eventId = $request->input('event_id');
   

    // Get the scores, selected user, and opponent scores for the specific event
    $currentUserScore = $request->input("scores.$eventId", null);
    $opponentId = $request->input("selected_users.$eventId", null);
    $opponentScores = $request->input("opponent_scores.$eventId", null);

    // Check if current user's score exists and is not empty
    if ($currentUserScore !== null) {
        $userEvent = UserEvent::find($eventId);

        if ($userEvent && ($userEvent->score != json_encode($currentUserScore))) {
            $userEvent->score = json_encode($currentUserScore);
            $userEvent->status = 'Requested'; // Update status to 'Requested'
            $userEvent->reciver_opponent_id = $opponentId; // Set the opponent ID
            $userEvent->save(); // Save the updated user event
        }
    }

    // Check if opponent's score exists and is not empty
    if ($opponentId && $opponentScores !== null) {
        $opponentUserEvent = UserEvent::find($opponentId);

        if ($opponentUserEvent) {
            $opponentUserEvent->score = json_encode($opponentScores);
            $opponentUserEvent->sender_opponent_id = $eventId; // Set the sender_opponent_id to current user's event ID
            $opponentUserEvent->status = 'Requested'; // Update status to 'Requested'
            $opponentUserEvent->save(); // Save the updated opponent event
        }
    }

    // Redirect with success message
    return redirect()->route('user.events.score')->with('success', 'Scores updated successfully!');
}



public function showAddMatchForm()
{
    // Fetch the current logged-in user
    $user = auth()->user();
    
    // Fetch events where the logged-in user is participating
    $userEvents = UserEvent::with('event')
        ->where('user_id', $user->id)
        ->get();

    // Prepare a list of users for the dropdown
    $usersForDropdown = [];
    foreach ($userEvents as $userEvent) {
        $usersForEvent = UserEvent::select(
            'user_events.*',
            'users.name',
            'users.email',
            'users.Skill_Level',
            'user_events.id as user_event_id'
        )
        ->join('users', 'users.id', '=', 'user_events.user_id')
        ->where('user_events.selected_game', $userEvent->selected_game)
        ->where('user_events.event_id', $userEvent->event_id)
        ->where('users.id', '!=', $user->id)
        ->get();
        
        $usersForDropdown[$userEvent->id] = $usersForEvent;
    }

    // Pass the data to the view
    return view('User.UserEvents.add_manual_match', compact('user', 'userEvents', 'usersForDropdown'));
}

public function SaveManualMatch(Request $request)
{
    // Validate the form data if necessary
    $request->validate([
        'event_id' => 'required',
        'scores' => 'required|array',
        'opponent_scores' => 'required|array',
        'selected_user' => 'required|exists:user_events,id',  // Ensure selected user exists
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
    ]);

    // Get the event ID from the request
    $eventId = $request->input('event_id');
  
    $user = auth()->user(); // Current logged-in user

    // Get the selected opponent user (user_event_id) from the request
    $selectedUserEventId = $request->input('selected_user');
    
    // Find the selected user event record to get the associated user ID
    $selectedUserEvent = UserEvent::findOrFail($selectedUserEventId);
    // echo $eventId;
    // echo "<pre>";
    // print_r($request->all());
    // $event = Event::find($eventId);
    // print_r($selectedUserEvent);
    // die;
    $selectedUser = $selectedUserEvent->user;  // Get the actual User associated with the event

    // Retrieve the selected_game from the existing user event (instead of Event model)
    $selectedGame = $selectedUserEvent->selected_game;

    // Save the current user's UserEvent
    $currentUserEvent = new UserEvent();
    $currentUserEvent->user_id = $user->id; // Set the current user's ID
    $currentUserEvent->event_id =  $selectedUserEvent->event_id; // Set the event ID
    $currentUserEvent->score = json_encode($request->input('scores')); // Store current user's scores as JSON
    $currentUserEvent->selected_game = $selectedGame; // Use the selected game from the user's event
    $currentUserEvent->status = 'Requested'; // Set the status to 'Requested'
    $currentUserEvent->reciver_opponent_id = $selectedUserEventId; // Set the opponent's UserEvent ID (sender)
    $currentUserEvent->latitude = $request->input('latitude'); // Store latitude
    $currentUserEvent->longitude = $request->input('longitude'); // Store longitude
    $currentUserEvent->save(); // Save the current user's event

    // Save the selected opponent's UserEvent
    $opponentUserEvent = new UserEvent();
    $opponentUserEvent->user_id = $selectedUser->id; // Set the opponent's user ID
    $opponentUserEvent->event_id = $selectedUserEvent->event_id; // Set the event ID
    $opponentUserEvent->score = json_encode($request->input('opponent_scores')); // Store opponent's scores as JSON
    $opponentUserEvent->selected_game = $selectedGame; // Use the selected game from the user's event
    $opponentUserEvent->status = 'Requested'; // Set the status to 'Requested'
    $opponentUserEvent->sender_opponent_id = $currentUserEvent->id; // Set the current user's UserEvent ID (receiver)
    $opponentUserEvent->latitude = $request->input('latitude'); // Store latitude
    $opponentUserEvent->longitude = $request->input('longitude'); // Store longitude
    $opponentUserEvent->save(); // Save the opponent's event

    // Redirect with success message
    return redirect()->route('user.events.score')->with('success', 'Match added successfully!');
}



}