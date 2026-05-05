<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscriptionActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Check if user has the 'user' role (or any other role you want)
            if ($user->hasRole('user')) {

                // Fetch all subscriptions for the user
                $subscriptions = $user->subscribed('default');
//                 $subscriptions = $user->subscriptions;
// dd($subscriptions);
                // Check if user has any active subscription
                // $activeSubscription = $subscriptions->first(function ($subscription) {
                //     return $subscription->active();  // Checks if the subscription is active
                // });

                if ($subscriptions) {
                    // If there's an active subscription, continue with the request
                    return $next($request);
                }

                // If no active subscription found, redirect to the subscription page with a toastr message
                return redirect()->route('subscription.index')->with('error', 'Your subscription is inactive or expired. Please renew to continue.'); // Redirect to the subscription page
            }
        }

        // If user is not authenticated, redirect to login or another page
        return redirect()->route('login');
    }
}
