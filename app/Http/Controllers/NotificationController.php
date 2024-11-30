<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\UserEvent;
use Illuminate\Http\Request;
use App\Mail\SendEventEmail;

use Illuminate\Support\Facades\Mail;
class NotificationController extends Controller
{
    public function index()
    {
        // Get all events
        $events = Event::all();

        // Initialize an array to hold event-wise participant details
        $eventParticipants = [];

        foreach ($events as $event) {
            // Get participants (users) for each event
            $participants = UserEvent::where('event_id', $event->id)
                ->with('user') // eager load users who participated
                ->get();

            // Store the event data and participant count
            $eventParticipants[] = [
                'event' => $event,
                'participants' => $participants,
                'count' => $participants->count()
            ];
        }

        // Pass the data to the view
        return view('admin.Notification.notifications', compact('eventParticipants'));
    }


    public function getParticipants($eventId)
    {
        $participants = UserEvent::where('event_id', $eventId)
            ->with('user')
            ->get();

        return response()->json(['participants' => $participants]);
    }

    // Send email to event participants
    public function sendEmail(Request $request, $eventId)
    {
        $participants = UserEvent::where('event_id', $eventId)
            ->with('user')
            ->get();

        $emails = $participants->pluck('user.email')->toArray();
        $message = $request->input('message');

        try {
            foreach ($emails as $email) {
                Mail::to($email)->send(new SendEventEmail($message));
            }
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
