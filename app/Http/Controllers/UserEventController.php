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
        $user = auth()->user();

        $userEvents = UserEvent::where('user_id', $user->id)->get();

        $eventsWithNearbyUsers = [];

        foreach ($userEvents as $userEvent) {
            $event = Event::find($userEvent->event_id);

            $latitude = $userEvent->latitude;
            $longitude = $userEvent->longitude;
            $userSkillLevel = $user->Skill_Level;

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

        return view('user.userevents.events', compact('eventsWithNearbyUsers'));
    }
    public function dashboard()
    {
        $user = auth()->user();
    
        // Fetch approved UserEvents where the user is the participant
        $userEvents = UserEvent::where('user_id', $user->id)
            ->where('status', 'Approved')
            ->get();
    
        $eventData = [];
    
        foreach ($userEvents as $userEvent) {
            // Fetch the opponent's UserEvent based on reciver_opponent_id or sender_opponent_id
            $opponentEvent = null;
            if ($userEvent->reciver_opponent_id) {
                $opponentEvent = UserEvent::find($userEvent->reciver_opponent_id);
            } elseif ($userEvent->sender_opponent_id) {
                $opponentEvent = UserEvent::find($userEvent->sender_opponent_id);
            }
    
            if ($opponentEvent) {
                // Safely decode and sum scores, ensuring they are integers
                $currentUserScore = is_array(json_decode($userEvent->score, true)) 
                    ? array_sum(json_decode($userEvent->score, true)) 
                    : (int) json_decode($userEvent->score, true);
    
                $opponentScore = is_array(json_decode($opponentEvent->score, true)) 
                    ? array_sum(json_decode($opponentEvent->score, true)) 
                    : (int) json_decode($opponentEvent->score, true);
    
                // Determine if the current user won or lost
                $result = $currentUserScore > $opponentScore ? 'Win' : 'Loss';
    
                // Group by event_id and accumulate win, loss counts
                $eventId = $userEvent->event_id;
                if (!isset($eventData[$eventId])) {
                    $eventData[$eventId] = [
                        'event_name' => $userEvent->event->name ?? 'N/A',
                        'win_count' => 0,
                        'loss_count' => 0,
                    ];
                }
    
                if ($result === 'Win') {
                    $eventData[$eventId]['win_count'] += 1;
                } else {
                    $eventData[$eventId]['loss_count'] += 1;
                }
            }
        }
    
        // Calculate total_score for each event
        foreach ($eventData as $eventId => &$event) {
            $event['total_score'] = ($event['win_count'] * 3) + ($event['loss_count'] * 1);
        }
    
        // Convert eventData to a simple array for the view
        $data = array_values($eventData);
    
        return view('user.dashboard', compact('data'));
    }
    

    public function AddScore()
    {
        $user = auth()->user();

        $userEvents = UserEvent::with('event')
            ->where('user_id', $user->id)
            ->get();

        $userSkillLevel = $user->Skill_Level;
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
                ->where('users.skill_level', $userSkillLevel)
                ->where('users.id', '!=', $user->id)
                ->get()
                ->groupBy('user_id');

            $usersForDropdown[$userEvent->id] = $usersForEvent;

            if ($userEvent->reciver_opponent_id) {
                $receiverOpponentId = $userEvent->reciver_opponent_id;
                $opponentScore = UserEvent::where('id', $receiverOpponentId)
                    ->where('event_id', $userEvent->event_id)
                    ->first();

                if ($opponentScore) {
                    $opponentUser = User::find($opponentScore->user_id);

                    if ($opponentUser) {
                        $userEvent->opponent_email = $opponentUser->email;
                        $userEvent->user_event_id = $opponentScore->id;
                    }
                    $userEvent->opponent_score = json_decode($opponentScore->score);
                }
            } elseif ($userEvent->sender_opponent_id) {

                $sender_opponent_id = $userEvent->sender_opponent_id;
                $opponentScore = UserEvent::where('id', $sender_opponent_id)
                    ->where('event_id', $userEvent->event_id)
                    ->first();

                if ($opponentScore) {
                    $opponentUser = User::find($opponentScore->user_id);

                    if ($opponentUser) {
                        $userEvent->opponent_email = $opponentUser->email;
                        $userEvent->user_event_id = $opponentScore->id;
                    }
                    $userEvent->opponent_score = json_decode($opponentScore->score);
                }

                $userEvent->show_approval_buttons = true;
            }
        }

        return view('user.userevents.add_score', compact('user', 'userEvents', 'usersForDropdown'));
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
    // echo $eventId;die;
   

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
            ->get()
            ->groupBy('event_id');

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
                ->where('user_events.selected_game', $userEvent[0]->selected_game)
                ->where('user_events.event_id', $userEvent[0]->event_id)
                ->where('users.id', '!=', $user->id)
                ->get()
                ->groupBy('user_id');

            if (count($usersForEvent)) {
                $usersForDropdown[$userEvent[0]->id] = $usersForEvent;
            }
        }

        // Pass the data to the view
        return view('user.userevents.add_manual_match', compact('user', 'userEvents', 'usersForDropdown'));
    }

    public function SaveManualMatch(Request $request)
    {
        // Validate the form data if necessary
        $request->validate([
            'event_id' => 'required',
            'scores' => 'required|array',
            'opponent_scores' => 'required|array',
            'selected_user' => 'required|exists:user_events,id', 
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $eventId = $request->input('event_id');
        $user = auth()->user();
        $selectedUserEventId = $request->input('selected_user');

        $selectedUserEvent = UserEvent::findOrFail($selectedUserEventId);
        $selectedeventData = UserEvent::findOrFail($eventId);
        $selectedUser = $selectedUserEvent->user;  
      
    
        // Retrieve the selected_game from the existing user event (instead of Event model)
        $selectedGame = $selectedeventData->selected_game;
        $latitude = $selectedeventData->latitude;
        $longitude = $selectedeventData->longitude;
        $event_id= $selectedeventData->event_id;
    
        // Save the current user's UserEvent
        $currentUserEvent = new UserEvent();
        $currentUserEvent->user_id = $user->id;
        $currentUserEvent->event_id =  $event_id;
        $currentUserEvent->score = json_encode($request->input('scores'));
        $currentUserEvent->selected_game = $selectedGame;
        $currentUserEvent->status = 'Requested';
        $currentUserEvent->latitude =   $latitude;
        $currentUserEvent->longitude =   $longitude;
        $currentUserEvent->save(); // Pehle save karein
    
        // Save the selected opponent's UserEvent
        $opponentUserEvent = new UserEvent();
        $opponentUserEvent->user_id = $selectedUser->id;
        $opponentUserEvent->event_id =  $event_id;
        $opponentUserEvent->score = json_encode($request->input('opponent_scores'));
        $opponentUserEvent->selected_game = $selectedGame;
        $opponentUserEvent->status = 'Requested';
        $opponentUserEvent->latitude =  $latitude;
        $opponentUserEvent->longitude =  $longitude;
        $opponentUserEvent->save();
    
        $currentUserEvent->reciver_opponent_id = $opponentUserEvent->id;
        $currentUserEvent->save();
    
        $opponentUserEvent->sender_opponent_id = $currentUserEvent->id;
        $opponentUserEvent->save(); 

        return redirect()->route('user.events.score')->with('success', 'Match added successfully!');
    }


}
