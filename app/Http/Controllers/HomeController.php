<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $registration = EventRegistration::where('user_id', Auth::id())->latest()->first();
            
            if ($registration) {
                return match($registration->status) {
                    'otp_verified' => redirect()->route('registration.kyc'),
                    'kyc_completed' => redirect()->route('registration.payment'),
                    'payment_pending' => redirect()->route('registration.payment'),
                    'paid', 'checked_in' => redirect()->route('registration.success'),
                    default => view('index', compact('registration')),
                };
            }
            
            return view('index', compact('registration'));
        }
        
        return view('index', ['registration' => null]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('index');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('index'));
        }

        return back()->withErrors(['email' => 'Invalid credentials.'])->onlyInput('email');
    }
}
