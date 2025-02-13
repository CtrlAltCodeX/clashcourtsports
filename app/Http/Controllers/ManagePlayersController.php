<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\UserEvent;
use Stripe;
use Carbon\Carbon;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ManagePlayersController extends Controller
{

    public function index()
    {
        $currentDate = Carbon::now();

        $events = Event::all()->sortBy(function ($event) use ($currentDate) {
            return $event->enddate < $currentDate ? 1 : 0;
        });

        return view('user.events.index', compact('events'));
    }

    public function JoinNow($id)
    {
        $event = Event::findOrFail($id);

        return view('user.auth.joinNow', compact('event'));
    }

    public function StripeCheckout(Request $request, $id)
    {
        try {
            $validation = [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone_number' => 'required|string|max:20',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'zip_code' => 'required|string|max:10',
                'game_type' => 'required',
                'selected_game' => 'required',
                'flexRadioDefault' => 'required',
                'password' => 'nullable|string'
            ];

            if (!auth()->user()) {
                $validation['email'] = 'required|email|unique:users,email';
            }

            $request->validate($validation);

            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

            $redirectUrl = route('stripe.checkout.success') . '?session_id={CHECKOUT_SESSION_ID}';

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
                            'unit_amount' => $request->game_type * 100,
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
                    'selected_game' => $request->selected_game,
                    'longitude' => $request->longitude,
                    'session_name' => $request->session_name,
                ],
            ]);

            return redirect($response['url']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
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

            // Determine group name dynamically
            $userCount = User::count() + 1; // Add 1 to include the new user being registered
            $groupIndex = intdiv($userCount - 1, 10); // Determine group index
            $groupName = 'Group ' . chr(65 + $groupIndex); // Convert index to letter (A, B, C...)

            $user = User::firstOrCreate(
                ['email' => $session->customer_email],
                [
                    'name' => $session->metadata->first_name . ' ' . $session->metadata->last_name,
                    'type' => 'Player',
                    'phone_number' => $session->metadata->phone_number ?? '',
                    'city' => $session->metadata->city ?? '',
                    'state' => $session->metadata->state ?? '',
                    'zip_code' => $session->metadata->zip_code ?? '',
                    'password' => Hash::make($session->metadata->password),
                    'Skill_Level' => $session->metadata->Skill_Level ?? '',
                    'group' => $groupName,
                ]
            );

            $paymentData['user_id'] = $user->id;

            \App\Models\Payment::create($paymentData);

            UserEvent::updateOrCreate(
                ['user_id' => $user->id, 'event_id' => $event->id],
                [
                    'latitude' => $session->metadata->latitude,
                    'longitude' => $session->metadata->longitude,
                    'selected_game' => $session->metadata->selected_game,
                    'Skill_Level' => $session->metadata->Skill_Level ?? '',
                ]
            );

            // Send the welcome email
            Mail::send('emails.register', [
                'contact' => [
                    'first_name' => $session->metadata->first_name,
                    'season_name' => $session->metadata->session_name ?? '',
                ],
                'skill_level' => $session->metadata->Skill_Level ?? '',
                'selected_game' => $session->metadata->selected_game,
            ], function ($message) use ($session) {
                $message->to($session->customer_email)
                    ->subject('Welcome to Clash Court Sports!');
            });

            if (Auth::check()) {
                return redirect()->route('user.dashboard')->with('alert', ' Thank you for joining , See you on the courts!. Please click the Event Tab.');
            } else {
                return redirect()->route('user.auth.login')->with('alert', ' Thank you for joining , See you on the courts!. Please click the Event Tab.');
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
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

            'password' => 'nullable|string',
        ]);

        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser) {
            UserEvent::create([
                'user_id' => $existingUser->id,
                'event_id' => $id,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            return redirect()->back()->with('alert', 'Your account already exists. You have successfully joined the event with same email id and password');
        }

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

        UserEvent::create([
            'user_id' => $user->id,
            'event_id' => $id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->route('user.auth.login')->with('success', 'Account created and event joined successfully.');
    }


    public function loginForm()
    {
        return view('user.auth.login');
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = Auth::user();

            if ($user->type !== 'Player') {

                Auth::logout();
                return back()->withErrors(['email' => 'You are not authorized to access this page.'])->withInput();
            }


            return redirect()->route('user.dashboard');
        } else {

            return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
        }
    }
}
