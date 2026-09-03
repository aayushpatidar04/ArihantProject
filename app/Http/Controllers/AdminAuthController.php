<?php

namespace App\Http\Controllers;

use App\Mail\Admin2faOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{
    public function showLogin(Request $request)
    {
        if (Auth::check()) {
            if ($this->isAdmin(Auth::user()->email)) {
                return redirect()->intended(route('admin.dashboard'));
            }
            Auth::logout();
        }

        $redirect = session('url.intended') ?? $request->query('redirect');
        return view('admin.login', ['redirect' => $redirect]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'redirect' => ['nullable', 'string'],
        ]);

        $email = strtolower(trim($credentials['email']));
        $user = \App\Models\User::where('email', $email)->first();

        Log::info('Admin login attempt', [
            'is_admin' => $this->isAdmin($email),
            'user' => $user,
            'password_match' => Hash::check($credentials['password'], $user->password)
        ]);
        if (!$user || !$this->isAdmin($email) || !Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withErrors(['email' => 'These credentials do not match an admin account.'])
                ->withInput($request->only('email', 'redirect'));
        }

        // Generate OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        Log::info($otp);

        Cache::put('admin_2fa_otp_' . $email, $otp, now()->addMinutes(5));

        Session::put('admin_2fa_user_id', $user->id);
        Session::put('admin_2fa_email', $email);
        Session::put('admin_2fa_redirect', $request->input('redirect'));
        Session::put('admin_2fa_remember', $request->boolean('remember'));

        try {
            Mail::to($user->email)->send(new Admin2faOtpMail($user, $otp));
        } catch (\Exception $e) {
            Log::error('Admin 2FA OTP email failed: ' . $e->getMessage());
            return back()
                ->withErrors(['email' => 'Failed to send OTP. Please try again.'])
                ->withInput($request->only('email', 'redirect'));
        }

        return redirect()->route('admin.2fa');
    }

    public function show2fa()
    {
        if (!Session::has('admin_2fa_user_id')) {
            return redirect()->route('admin.login');
        }

        return view('auth.admin-2fa', [
            'email' => Session::get('admin_2fa_email'),
        ]);
    }

    public function verify2fa(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $email = Session::get('admin_2fa_email');
        $userId = Session::get('admin_2fa_user_id');
        $redirect = Session::get('admin_2fa_redirect');
        $remember = Session::get('admin_2fa_remember', false);

        if (!$email || !$userId) {
            return redirect()->route('admin.login');
        }

        $cachedOtp = Cache::get('admin_2fa_otp_' . $email);

        if (!$cachedOtp || $cachedOtp !== $request->otp) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        $user = \App\Models\User::find($userId);

        if (!$user) {
            return redirect()->route('admin.login')
                ->withErrors(['email' => 'Session expired. Please login again.']);
        }

        // Set super admin flag based on email config
        $superAdminEmails = array_map('strtolower', config('event.super_admin_emails', []));
        $user->is_super_admin = in_array(strtolower($user->email), $superAdminEmails, true);
        $user->save();

        // Cleanup
        Cache::forget('admin_2fa_otp_' . $email);
        Session::forget(['admin_2fa_user_id', 'admin_2fa_email', 'admin_2fa_redirect', 'admin_2fa_remember']);

        Auth::login($user, $remember);
        $request->session()->regenerate();

        return redirect()->intended(
            $redirect && str_starts_with($redirect, '/admin') ? $redirect : route('admin.dashboard')
        );
    }

    protected function isAdmin(string $email): bool
    {
        return in_array(strtolower($email), array_map('strtolower', config('event.admin_emails', [])), true);
    }
}
