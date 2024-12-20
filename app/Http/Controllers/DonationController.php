<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Stripe;
class DonationController extends Controller
{

    public function index(){
        $donations = Donation::paginate(10);
        return view('admin.donations.index', compact('donations'));
    }
    public function submitDonation(Request $request)
    {
        $plan = $request->input('plan');
    
        // Determine the amount based on the selected plan
        $amount = $request->input('amount') === 'other'
            ? ($plan === 'monthly' ? $request->input('custom_amount_monthly') : $request->input('custom_amount_once'))
            : $request->input('amount');
    
        if (!$amount || !is_numeric($amount) || $amount <= 0) {
            return back()->with('error', 'Invalid donation amount.');
        }
    
        // Initialize Stripe client
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
    
        // Redirect URLs
        $successUrl = route('donation.checkout.success') . '?session_id={CHECKOUT_SESSION_ID}';
        $cancelUrl = route('donation.checkout.cancel');
    
        try {
            if ($plan === 'monthly') {
                // Dynamically create a price for the monthly subscription
                $dynamicPrice = $stripe->prices->create([
                    'unit_amount' => $amount * 100, // Amount in cents
                    'currency' => 'USD',
                    'recurring' => ['interval' => 'month'],
                    'product' => env('STRIPE_PRODUCT_ID'), // Replace with your existing product ID
                ]);
    
                // Create a checkout session with the dynamically created price
                $response = $stripe->checkout->sessions->create([
                    'success_url' => $successUrl,
                    'cancel_url' => $cancelUrl,
                    'payment_method_types' => ['card'],
                    'line_items' => [[
                        'price' => $dynamicPrice->id, // Use the dynamically created price ID
                        'quantity' => 1,
                    ]],
                    'mode' => 'subscription',
                    'allow_promotion_codes' => true,
                ]);
            } else {
                // Create one-time donation session
                $response = $stripe->checkout->sessions->create([
                    'success_url' => $successUrl,
                    'cancel_url' => $cancelUrl,
                    'payment_method_types' => ['card'],
                    'line_items' => [[
                        'price_data' => [
                            'currency' => 'USD',
                            'product_data' => [
                                'name' => 'One-Time Donation',
                            ],
                            'unit_amount' => $amount * 100, // Convert amount to cents
                        ],
                        'quantity' => 1,
                    ]],
                    'mode' => 'payment',
                    'allow_promotion_codes' => true,
                ]);
            }
    
            // Redirect to Stripe Checkout page
            return redirect($response->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating payment session: ' . $e->getMessage());
        }
    }
    
    public function DonationCheckoutSuccess(Request $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        try {
            $session = $stripe->checkout->sessions->retrieve($request->input('session_id'));

            if (!$session) {
                return back()->with('error', 'Payment session not found.');
            }
   
                   
                    $customerDetails = $session->customer_details;
                    $amountTotal = $session->amount_total / 100;
                    $plan = $session->mode === 'subscription' ? 'Monthly Subscription' : 'One-Time Donation';
                    $transactionId = $session->mode === 'subscription' 
                    ? $session->subscription 
                    : $session->payment_intent; 
                 
                    $donation = new Donation();
                    $donation->name = $customerDetails->name;
                    $donation->email = $customerDetails->email;
                    $donation->plan = $plan;
                    $donation->amount = $amountTotal;
                    $donation->payment_status = $session->payment_status;
                    $donation->transaction_id =  $transactionId; 
                    $donation->save();
                    return back()->with('success', 'Payment successful');
        } catch (\Exception $e) {
            return back()->with('error', 'Error retrieving payment session: ' . $e->getMessage());
        }
    }

    public function DonationCheckoutCancel()
    {
        return back()->with('error', 'Payment cancelled.');
    }
}
