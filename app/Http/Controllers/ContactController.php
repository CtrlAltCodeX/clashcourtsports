<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{

    public function index()
    {
        // Fetch all contact messages
        $contacts = Contact::all();
        return view('admin.contact.index', compact('contacts'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Save data to the database
        $contact = Contact::create($request->only('first_name', 'email', 'message'));

        // Send email
        try {
            Mail::send('emails.contact', ['contact' => $contact], function ($message) {
                $message->to('support@clashcourtsports.com')
                    ->subject('New Contact Us Message');
            });

            // return response()->json(['success' => true, 'message' => 'Message sent successfully!']);
            return redirect()->route('clashsports')->with('alert', 'Mail sent successfully!');
        } catch (\Exception $e) {
            return redirect()->route('clashsports')->with('alert', $e->getMessage());
        }
    }
}