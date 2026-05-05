<?php
namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Plan;
use Log;
use response;
use Stripe\Stripe;
use Stripe\Webhook;

class PaymentController extends Controller
{

    public function index()
    {
        $plans = Plan::with('features')->get();

        $user = Auth::user();
        $intent = (!$user) ? '' : $user->createSetupIntent();
        $monthlyPlans = $plans->where('duration', 'mon');
        $yearlyPlans = $plans->where('duration', 'yr');

        return response()->view('frontend.subscription', compact('monthlyPlans', 'yearlyPlans', 'intent'));
    }


    public function show(Plan $plan, Request $request)
    {
        // dd($plan);

        // Check if user is authenticated
        if (!auth()->check()) {
            return response()->redirectToRoute('login')->with('error', 'Please login to proceed.');
        }

        // Create Setup Intent
        $intent = auth()->user()->createSetupIntent();

        return view("frontend.subscription", compact("plan", "intent"));
    }


    public function handleStripeWebhook(Request $request)
    {
        // Set your Stripe secret key (or use environment variable)
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        // Retrieve the raw body of the webhook request
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        try {
            // Verify the webhook signature
            $event = Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            Log::error('Webhook Error: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            Log::error('Webhook Error: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the event based on its type
        switch ($event->type) {
            case 'invoice.payment_failed':
                $this->handlePaymentFailed($event);
                break;

            case 'invoice.payment_succeeded':
                $this->handlePaymentSucceeded($event);
                break;
            // You can add more cases as needed to handle other Stripe events
            default:
                Log::info('Unhandled event type: ' . $event->type);
        }

        // Return a response to acknowledge receipt of the event
        return response()->json(['status' => 'success']);
    }

    protected function handlePaymentSucceeded($event)
    {
        // Extract the relevant information from the event
        $invoice = $event->data->object;
        $userId = $invoice->customer;

        // Find the user by Stripe customer ID
        $user = User::where('stripe_id', $userId)->first();

        if ($user) {

            Log::info("Subscription activated after successful payment for user {$user->id}");
        }
    }
    protected function handlePaymentFailed($event)
    {
        // Extract the relevant information from the event
        Log::info("Got event $event");
        $invoice = $event->data->object;
        $userId = $invoice->customer;

        // Find the user by Stripe customer ID
        $user = User::where('stripe_id', $userId)->first();

        if ($user) {
            // Cancel or deactivate the subscription as the payment failed
            if ($user->subscription('default')->onTrial()) {
                $user->subscription('default')->endTrial();
            }

            if ($user->subscribed('default')) {
                // Mark the subscription as canceled or expired (or whatever action you want)
                $user->subscription('default')->cancelNow();

                // Optionally, notify the user or take other actions
                Log::info('Subscription canceled due to failed payment for user ' . $user->id);
            }
        }
    }


    public function subscription(Request $request)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'token' => 'required|string',
        ]);

        // Fetch the plan details from the database
        $plan = Plan::findOrFail($validated['plan_id']);

        // Check if the user already has an active subscription or has already used a trial
        $user = $request->user();

        // $existingSubscription = $user->subscriptions()->where('stripe_status', ['active', 'trialing'])->first();

        if ($user->subscribed('default') && $user->subscription('default')->onTrial()) {
            $subscription = $user->newSubscription('default', $plan->stripe_plan)
                ->create($validated['token']);

            return redirect()->route('subscription.index')
                ->with('success', 'Subscription purchased successfully!');

        }

        try {
            $subscription = $user->newSubscription('default', $plan->stripe_plan)->trialDays(90)
                ->create($validated['token']);

            return redirect()->route('subscription.index')
                ->with('success', 'Subscription purchased successfully!');
        } catch (\Exception $e) {
            return redirect()->route('subscription.index')
                ->with('error', 'There was an issue with your subscription.');
        }
    }

}
