<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate inputs
        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8']
        ]);

        $remember = $request->boolean('remember');

        // Attempt login
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        // If authentication fails
        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->onlyInput('email');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
