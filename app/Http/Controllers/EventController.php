<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\UserEvent;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::paginate(10); // 10 records per page, you can adjust this number
        
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'capacity' => 'required|integer|min:1',
            'pricing' => 'required|numeric|min:0',
            'enddate' => 'nullable|date',
            'game_name' => 'nullable|string|max:255',
            'double_price' => 'nullable|numeric|min:0',
        ]);


        $request['user_id'] = auth()->id();

        Event::create($request->all());

        return redirect()->route('events.index')->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'capacity' => 'required|integer|min:1',
            'pricing' => 'required|numeric|min:0',
            'enddate' => 'nullable|date',
            'game_name' => 'nullable|string|max:255',
            'double_price' => 'nullable|numeric|min:0',
        ]);

        $event->update($request->all());

        return redirect()->route('events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }


    public function playerGroupWise(Request $request)
    {
        $events = Event::all();
        $groups = User::select('group')->distinct()->pluck('group');

        $usersevents = UserEvent::with('user', 'event');

        if (request()->event) {
            $usersevents->where('event_id', request()->event);
        }

        if ($request->group) {
            $usersevents->whereHas('user', function ($query) use ($request) {
                $query->where('group', $request->group);
            });
        }

        $users = $usersevents->paginate(10);

        // Fetch approved UserEvents where the user is the participant
        $userEvents = UserEvent::with('user')
            ->where('status', 'Approved');

        if (request()->event) {
            $userEvents->where('event_id', request()->event);
        }

        if ($request->group) {
            $userEvents->whereHas('user', function ($query) use ($request) {
                $query->where('group', $request->group);
            });
        }

        $userEvents = $userEvents->get();

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
                $eventData[$eventId]['user'][] = $userEvent->user;

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

        return view('admin.events.group_wise', compact('events', 'groups', 'users', 'data'));
    }

    public function upcomingEvents()
    {
        $events = Event::where('enddate', '>=', now())->paginate(10);

        return view('admin.events.upcoming', compact('events'));
    }
}
