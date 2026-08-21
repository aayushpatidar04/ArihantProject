<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function __construct(
        protected SmsService $sms,
    ) {}

    public function index()
    {
        if (Auth::check()) {
            $registration = EventRegistration::where('user_id', Auth::id())->latest()->first();
            
            // if ($registration) {
            //     return match($registration->status) {
            //         'otp_verified' => redirect()->route('registration.kyc'),
            //         'kyc_completed' => redirect()->route('registration.payment'),
            //         'payment_pending' => redirect()->route('registration.payment'),
            //         'paid', 'checked_in' => redirect()->route('registration.success'),
            //         default => view('index', compact('registration')),
            //     };
            // }
            
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
        if (Auth::check()) {
            return redirect()->route('index');
        }

        // DON'T clear login_phone / otp_sent here — we need them
        // to survive the redirect from sendOtp() into the view.
        return view('auth.login');
    }

    /**
     * Step 1: Send OTP to registered phone.
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:10|max:15',
        ]);

        $phone = $this->normalizePhone($request->phone);

        // Verify phone exists in event_registrations
        $reg = EventRegistration::where('phone', $phone)->first();

        if (!$reg) {
            return back()
                ->withErrors(['phone' => 'No registration found for this phone number.'])
                ->withInput();
        }

        // Rate limit: max 3 attempts per 10 minutes
        $attempts = Cache::get('login_otp_attempts_' . $phone, 0);
        if ($attempts >= 3) {
            return back()
                ->withErrors(['phone' => 'Too many attempts. Please try again after 10 minutes.'])
                ->withInput();
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store OTP in cache for 2 minutes
        Cache::put('login_otp_' . $phone, $otp, now()->addMinutes(2));
        Cache::put('login_otp_attempts_' . $phone, $attempts + 1, now()->addMinutes(10));

        $sent = $this->sms->sendLoginOtp($phone, $otp);

        if (!$sent) {
            return back()
                ->withErrors(['phone' => 'Failed to send OTP. Please try again.'])
                ->withInput();
        }

        return redirect()->route('login')->with([
            'login_phone' => $phone,
            'otp_sent' => true,
        ]);
    }

    /**
     * Step 2: Verify OTP and log the user in.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'otp'   => 'required|string|size:6',
        ]);

        $phone = $this->normalizePhone($request->phone);
        $cachedOtp = Cache::get('login_otp_' . $phone);

        if (!$cachedOtp) {
            return redirect()->route('login')
                ->withErrors(['phone' => 'OTP expired. Please request a new one.']);
        }

        if ($cachedOtp !== $request->otp) {
            // Keep phone in session so the OTP form stays visible
            return back()
                ->withErrors(['otp' => 'Invalid OTP. Please try again.'])
                ->withInput()
                ->with('login_phone', $phone);
        }

        // Lookup registration → user
        $reg = EventRegistration::where('phone', $phone)->first();

        if (!$reg || !$reg->user_id) {
            return redirect()->route('login')
                ->withErrors(['phone' => 'User account not found.']);
        }

        $user = User::find($reg->user_id);

        if (!$user) {
            return redirect()->route('login')
                ->withErrors(['phone' => 'User account not found.']);
        }

        // Cleanup
        Cache::forget('login_otp_' . $phone);
        Cache::forget('login_otp_attempts_' . $phone);
        session()->forget(['login_phone', 'otp_sent']);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('index'));
    }

    protected function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);
        if (strlen($phone) === 12 && str_starts_with($phone, '91')) {
            $phone = substr($phone, 2);
        }
        return $phone;
    }
}
