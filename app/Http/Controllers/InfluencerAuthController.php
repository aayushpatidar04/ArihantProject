<?php

namespace App\Http\Controllers;

use App\Mail\InfluencerLoginOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class InfluencerAuthController extends Controller
{
    /**
     * Show influencer login.
     */
    public function showLogin()
    {
        if (
            Auth::check() &&
            Auth::user()->role === 'influencer'
        ) {
            return redirect()->route('influencer.dashboard');
        }

        return view('influencer.auth.login');
    }

    /**
     * Authenticate influencer using email/password.
     *
     * Password authentication is only step 1.
     * Successful authentication generates an OTP.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],
            'password' => [
                'required',
                'string',
            ],
        ]);

        $remember = $request->boolean('remember');

        if (
            !Auth::validate([
                'email' => $credentials['email'],
                'password' => $credentials['password'],
                'role' => 'influencer',
            ])
        ) {
            return back()
                ->withErrors([
                    'email' => 'Invalid influencer credentials.',
                ])
                ->withInput($request->only('email'));
        }

        /*
        |--------------------------------------------------------------------------
        | Get influencer user
        |--------------------------------------------------------------------------
        */

        $user = \App\Models\User::where('email', $credentials['email'])
            ->where('role', 'influencer')
            ->first();

        if (!$user) {
            return back()
                ->withErrors([
                    'email' => 'Influencer account not found.',
                ])
                ->withInput($request->only('email'));
        }

        /*
        |--------------------------------------------------------------------------
        | Generate OTP
        |--------------------------------------------------------------------------
        */

        $otp = (string) random_int(100000, 999999);

        /*
        |--------------------------------------------------------------------------
        | Store temporary authentication data in session
        |--------------------------------------------------------------------------
        */

        $request->session()->put([
            'influencer_otp_user_id' => $user->id,
            'influencer_otp' => $otp,
            'influencer_otp_expires_at' => now()->addMinutes(10)->timestamp,
            'influencer_remember' => $remember,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Send OTP
        |--------------------------------------------------------------------------
        */

        Mail::to($user->email)->send(
            new InfluencerLoginOtpMail($otp)
        );

        return redirect()
            ->route('influencer.otp')
            ->with(
                'success',
                'A verification OTP has been sent to your registered email address.'
            );
    }

    /**
     * Show OTP verification page.
     */
    public function showOtp(Request $request)
    {
        if (!$request->session()->has('influencer_otp_user_id')) {
            return redirect()
                ->route('influencer.login')
                ->withErrors([
                    'email' => 'Please login first.',
                ]);
        }

        return view('influencer.auth.otp');
    }

    /**
     * Verify influencer OTP.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => [
                'required',
                'digits:6',
            ],
        ]);

        $sessionOtp = $request->session()->get('influencer_otp');
        $expiresAt = $request->session()->get('influencer_otp_expires_at');
        $userId = $request->session()->get('influencer_otp_user_id');

        /*
        |--------------------------------------------------------------------------
        | Check OTP session
        |--------------------------------------------------------------------------
        */

        if (!$sessionOtp || !$expiresAt || !$userId) {
            return redirect()
                ->route('influencer.login')
                ->withErrors([
                    'email' => 'Your OTP session has expired. Please login again.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Check expiry
        |--------------------------------------------------------------------------
        */

        if (now()->timestamp > $expiresAt) {

            $this->clearOtpSession($request);

            return back()
                ->withErrors([
                    'otp' => 'OTP has expired. Please request a new OTP.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Check OTP
        |--------------------------------------------------------------------------
        */

        if (!hash_equals((string) $sessionOtp, (string) $request->otp)) {
            return back()
                ->withErrors([
                    'otp' => 'Invalid OTP. Please try again.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Get influencer
        |--------------------------------------------------------------------------
        */

        $user = \App\Models\User::where('id', $userId)
            ->where('role', 'influencer')
            ->first();

        if (!$user) {

            $this->clearOtpSession($request);

            return redirect()
                ->route('influencer.login')
                ->withErrors([
                    'email' => 'Influencer account not found.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Complete authentication
        |--------------------------------------------------------------------------
        */

        $remember = $request->session()->get(
            'influencer_remember',
            false
        );

        Auth::login($user, $remember);

        $request->session()->regenerate();

        /*
        |--------------------------------------------------------------------------
        | Remove OTP data
        |--------------------------------------------------------------------------
        */

        $this->clearOtpSession($request);

        return redirect()->intended(
            route('influencer.dashboard')
        );
    }

    /**
     * Resend OTP.
     */
    public function resendOtp(Request $request)
    {
        $userId = $request->session()->get(
            'influencer_otp_user_id'
        );

        if (!$userId) {
            return redirect()
                ->route('influencer.login')
                ->withErrors([
                    'email' => 'Please login again.',
                ]);
        }

        $user = \App\Models\User::where('id', $userId)
            ->where('role', 'influencer')
            ->first();

        if (!$user) {

            $this->clearOtpSession($request);

            return redirect()
                ->route('influencer.login')
                ->withErrors([
                    'email' => 'Influencer account not found.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Generate new OTP
        |--------------------------------------------------------------------------
        */

        $otp = (string) random_int(100000, 999999);

        $request->session()->put([
            'influencer_otp' => $otp,
            'influencer_otp_expires_at' => now()->addMinutes(10)->timestamp,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Send new OTP
        |--------------------------------------------------------------------------
        */

        Mail::to($user->email)->send(
            new InfluencerLoginOtpMail($otp)
        );

        return back()->with(
            'success',
            'A new OTP has been sent to your registered email address.'
        );
    }

    /**
     * Clear temporary OTP session data.
     */
    protected function clearOtpSession(Request $request): void
    {
        $request->session()->forget([
            'influencer_otp_user_id',
            'influencer_otp',
            'influencer_otp_expires_at',
            'influencer_remember',
        ]);
    }
}