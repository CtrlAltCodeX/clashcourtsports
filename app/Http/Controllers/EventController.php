<?php

namespace App\Http\Controllers;

use App\Models\Event;
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
}
