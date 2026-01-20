<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index() {
        return view('auth.login');
    }

    public function login() {
        // Create a unique throttle key
        $throttleKey = 'login:' . Str::lower($request->email) . '|' . $request->ip();
        
        // Check rate limiting (5 attempts per minute)
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'email' => 'Too many login attempts. Please try again in ' . $seconds . ' seconds.',
            ])->onlyInput('email');
        }

        // Validate inputs
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8']
        ])

        $remember = $request->boolean('remember');

        // Attempt login
        if (Auth::attempt($credentials, $remember)) {
            // Clear rate limiter on success
            RateLimiter::clear($throttleKey);
            
            // Regenerate session for security
            $request->session()->regenerate();
            
            // Redirect to dashboard
            return redirect()->route('dashboard');
        }

        // Increment rate limiter on failure
        RateLimiter::hit($throttleKey, 60);

        // If authentication fails
        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->onlyInput('email');
    }
}
