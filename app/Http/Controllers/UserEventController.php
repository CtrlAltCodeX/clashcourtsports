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
    
      
        $userEvents = UserEvent::where('user_id', $user->id)->get();
    
        
        $eventsWithNearbyUsers = [];
    
        foreach ($userEvents as $userEvent) {
            $event = Event::find($userEvent->event_id);
  
            $latitude = $userEvent->latitude;
            $longitude = $userEvent->longitude;
            $userSkillLevel = $user->Skill_Level;
   
            $nearbyUsers = UserEvent::select('user_events.*', 'users.name', 'users.email','users.Skill_Level')
                ->join('users', 'users.id', '=', 'user_events.user_id')
                
                ->where('user_events.selected_game', $userEvent->selected_game)
                ->where('users.skill_level', $userSkillLevel)->where('users.id','!=', $user->id)
                ->whereRaw("
                    6371 * acos(
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
        
      
        $userEvents = UserEvent::with('event')
            ->where('user_id', $user->id)
            ->get();
    
            $userSkillLevel = $user->Skill_Level;
        $usersForDropdown = [];
    
        foreach ($userEvents as $userEvent) {
           
            $usersForEvent = UserEvent::select('user_events.*', 'users.name', 'users.email','users.Skill_Level')
            ->join('users', 'users.id', '=', 'user_events.user_id')
            ->where('user_events.selected_game', $userEvent->selected_game)
            ->where('users.skill_level', $userSkillLevel)
            ->where('users.id','!=', $user->id)
         
            ->get();
          
            $usersForDropdown[$userEvent->id] = $usersForEvent;
        }
    
  
        return view('User.UserEvents.add_score', compact('userEvents', 'usersForDropdown'));
    }
    
    

    
    public function SaveScore(Request $request)
    {
        $request->validate([
            'scores' => 'required|array',
        ]);
    
 
        foreach ($request->scores as $userEventId => $score) {
        
            $userEvent = UserEvent::find($userEventId);
    
            if ($userEvent && $score !== null) {
             
                if ($userEvent->score === null || $userEvent->score != $score) {
                    $userEvent->score = json_encode($score);
                    $userEvent->status = 'Requested';
                    $userEvent->save();
    
                    $selectedUserEmail = $request->input('selected_users.' . $userEventId);
    
                    if ($selectedUserEmail) {
                       
                        $message = "You have been notified that the user " . auth()->user()->name . " has added a score of " . implode(', ', $score) . " for your event.";
    
                        try {
                            Mail::to($selectedUserEmail)->send(new SendEventEmail($message));
                        } catch (\Exception $e) {
                        
                            return response()->json(['success' => false, 'error' => $e->getMessage()]);
                        }
                    }
                }
            }
        }
    
        return redirect()->route('user.events.score')->with('success', 'Scores updated successfully and email sent!');
    }
    
}
