<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Models\User;
use App\Models\UserEvent;
use Stripe;
use Carbon\Carbon;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; // Add this line
use Illuminate\Http\Request;

class ManagePlayersController extends Controller
{
    
    public function index()
    {
        $currentDate = Carbon::now();
    
        // Fetch and sort events
        $events = Event::all()->sortBy(function ($event) use ($currentDate) {
            return $event->enddate < $currentDate ? 1 : 0; // Active events first, expired events last
        });
    
        return view('user.events.index', compact('events'));
    }

        public function JoinNow($id)
        {
            // Retrieve the user by ID
            $official = Event::findOrFail($id);
  
            return view('user.auth.joinNow', compact('official'));
        }



public function StripeCheckout(Request $request, $id)
        {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone_number' => 'required|string|max:20',
                'email' => 'required|email',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'zip_code' => 'required|string|max:10',
                'game_type' => 'required',
                'flexRadioDefault' => 'required', // Validation for Beginner/Advanced radio buttons
                'password' => 'nullable|string', // Password optional for existing users
            ]);
        
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        
            $redirectUrl = route('stripe.checkout.success').'?session_id={CHECKOUT_SESSION_ID}';
        
            $response = $stripe->checkout->sessions->create([
                'success_url' => $redirectUrl,
                'customer_email' => $request->email,
                'payment_method_types' => ['link', 'card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'product_data' => [
                                'name' => "Event Participation: {$request->first_name}",
                            ],
                            'unit_amount' => $request->game_type * 100, // Convert to cents
                            'currency' => "USD",
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'allow_promotion_codes' => true,
                'metadata' => [
                    'event_id' => $id,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone_number' => $request->phone_number,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip_code' => $request->zip_code,
                    'Skill_Level' => $request->flexRadioDefault,
                    'password' => $request->password,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                ],
            ]);
        
            return redirect($response['url']);
        }
        


 public function StripeCheckoutSuccess(Request $request)
        {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        
            try {
                $session = $stripe->checkout->sessions->retrieve($request->session_id);
        
                if (!$session) {
                    return redirect()->route('user.auth.login')->with('error', 'Payment session not found.');
                }
        
                $event = Event::findOrFail($session->metadata->event_id);
        
                $paymentData = [
                    'user_id' => null,
                    'event_id' => $event->id,
                    'amount' => $session->amount_total / 100,
                    'payment_status' => $session->payment_status,
                    'transaction_id' => $session->id,
                ];
        
                $user = User::firstOrCreate(
                    ['email' => $session->customer_email],
                    [
                        'name' => $session->metadata->first_name . ' ' . $session->metadata->last_name,
                        'type' => 'Player',
                        'phone_number' => $session->metadata->phone_number ?? '',
                        'city' => $session->metadata->city ?? '',
                        'state' => $session->metadata->state ?? '',
                        'zip_code' => $session->metadata->zip_code ?? '', 
                        'Skill_Level' => $session->metadata->Skill_Level ?? '', 
                       'password' => Hash::make($session->metadata->password),
                    ]
                );
        
                $paymentData['user_id'] = $user->id;
        
                \App\Models\Payment::create($paymentData);
        
                UserEvent::updateOrCreate(
                    ['user_id' => $user->id, 'event_id' => $event->id],
                    ['latitude' => $session->metadata->latitude, 'longitude' => $session->metadata->longitude]
                );
        
                return redirect()->route('user.auth.login')->with('alert', 'Payment successful and event joined.');
            } catch (\Exception $e) {
                return redirect()->route('user.auth.login')->with('error', 'Payment failed. Please try again.');
            }
        }
        


 public function Store(Request $request, $id)
        {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone_number' => 'required|string|max:20',
                'email' => 'required|email',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'zip_code' => 'required|string|max:10',
             
                'password' => 'nullable|string', // Password optional for existing users
            ]);
        
            // Check if the email exists in the users table
            $existingUser = User::where('email', $request->email)->first();
        
            if ($existingUser) {
                // If the user already exists, return with an alert and save their participation
                UserEvent::create([
                    'user_id' => $existingUser->id,
                    'event_id' => $id,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                ]);
        
                return redirect()->back()->with('alert', 'Your account already exists. You have successfully joined the event with same email id and password');
            }
        
            // Create a new user
            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'type' => 'Player',
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,

                'password' => Hash::make($request->password),
            ]);
        
            // Save the event participation
            UserEvent::create([
                'user_id' => $user->id,
                'event_id' => $id,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
        
            return redirect()->route('user.auth.login')->with('success', 'Account created and event joined successfully.');
        }
        

          // Show the login form
    public function loginForm()
    {
        return view('user.auth.login');
    }

    // Handle the login request
    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
    
        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Check if the authenticated user is of type 'Player'
            $user = Auth::user(); // Get the authenticated user
            
            if ($user->type !== 'Player') {
                // If the user type is not 'Player', log them out and show an error
                Auth::logout();
                return back()->withErrors(['email' => 'You are not authorized to access this page.'])->withInput();
            }
    
            // Redirect to the user's dashboard or home page
            return redirect()->route('dashboard');
        } else {
            // If authentication fails, redirect back with an error
            return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
        }
    }
    

    // Handle the logout request
    // public function logout()
    // {
    //     // Log the user out
    //     Auth::logout();

    //     // Redirect to the login page
    //     return redirect()->route('user.auth.login')->with('success', 'Logged out successfully.');
    // }
}
