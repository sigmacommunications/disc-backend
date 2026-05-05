<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectAuthenticatedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) { // Check if the user is authenticated
            $user = Auth::user();

            if ($user->hasRole('admin')) {
                return redirect()->route('dashboard');
            } elseif ($user->hasRole('artist')) {
                return redirect()->route('artist.dashboard');
            } elseif ($user->hasRole('user')) {
                // Uncomment the next line if you have a 'user.dashboard' route
                // return redirect()->route('user.dashboard');
                return redirect()->route('start-selling'); // Redirect to 'start-selling' route
            } else {
                // Default redirection if role doesn't match any condition
                return redirect()->route('login')->with('info', 'Role did not match.');
            }
        }

        return $next($request); // Proceed if the user is not authenticated
    }
}
