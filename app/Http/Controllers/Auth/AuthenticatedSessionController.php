<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Add this line to debug the input
        //  dd($request->all());

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user(); // Retrieve authenticated user

            if (!$user->is_active) {
                Auth::logout(); // Log out the user if suspended
                return redirect()->route('login')->withErrors(['email' => 'Your account is suspended. Please contact support.']);
            }

            // Redirect based on role
            if ($user->hasRole('admin')) {
                return redirect()->route('dashboard');
            } elseif ($user->hasRole('artist')) {
                return redirect()->route('artist.dashboard');
            } elseif ($user->hasRole('user')) {
                // return redirect()->route('user.dashboard');
                return redirect()->route('start-selling');
            } else {
                // Default redirection if role doesn't match any condition
                return redirect()->route('login')->with('info', 'Role did not match.');
            }
        }

        return back()->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
