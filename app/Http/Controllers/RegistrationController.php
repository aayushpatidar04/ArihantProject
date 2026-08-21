<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use App\Models\KycDetail;
use App\Models\Payment;
use App\Models\User;
use App\Services\ClientApiService;
use App\Services\WhatsAppService;
use App\Services\EmailService;
use App\Services\PaymentGatewayService;
use App\Services\QrCodeService;
use App\Services\LeadScoringService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class RegistrationController extends Controller
{
    public function __construct(
        protected ClientApiService $clientApi,
        protected WhatsAppService $whatsapp,
        protected EmailService $email,
        protected PaymentGatewayService $payment,
        protected QrCodeService $qr,
        protected LeadScoringService $leadScore,
    ) {
    }

    /* ============================================================
       STEP 1: Enter Phone Number → Check Existing Client
       ============================================================ */

    public function showForm()
    {
        return view('registration.form');
    }

    public function submitPhone(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string|regex:/^[0-9]{10}$/|unique:event_registrations,phone',
        ], [
            'phone.unique' => 'This number is already registered. Try logging in or use another number. Your password has been sent to your email.',
        ]);


        $phone = $validated['phone'];
        $clientData = $this->clientApi->checkClient($phone);

        if ($clientData) {
            Session::put('client_users', $clientData['users']);
            Session::put('reg_phone', $phone);
            Session::put('is_existing_client', true);
            return redirect()->route('registration.client.confirm');
        }

        // New user flow
        $otp = random_int(100000, 999999);
        // if ($phone == '9982414226') {
        //     $otp = 998241;
        // }
        Session::put('reg_phone', $phone);
        Session::put('reg_otp', $otp);
        Session::put('otp_expires', now()->addMinutes(10));
        Session::put('is_existing_client', false);

        $this->whatsapp->sendOtpToPhone($phone, (string) $otp);

        return redirect()->route('registration.otp');
    }

    /* ============================================================
       STEP 2A: Existing Client — Select UID & Confirm Details
       ============================================================ */

    public function showClientConfirm()
    {
        if (!Session::get('is_existing_client') || !Session::has('client_users')) {
            return redirect()->route('registration.form');
        }

        return view('registration.client_confirm', [
            'client_users' => Session::get('client_users'),
            'phone' => Session::get('reg_phone'),
        ]);
    }

    public function submitClientConfirm(Request $request)
    {
        if (!Session::get('is_existing_client') || !Session::has('client_users')) {
            return redirect()->route('registration.form');
        }

        $request->validate([
            'selected_uid' => 'required|string',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:event_registrations,email',
            'phone' => 'required|unique:event_registrations,phone',
            'city' => 'required|string|max:100',
            'type' => 'required|in:investor,trader',
            'referred_by' => 'nullable|string|size:12',
            'password' => 'required'
        ]);

        $clientUsers = Session::get('client_users');
        $selectedUser = collect($clientUsers)->firstWhere('uid', $request->selected_uid);

        if (!$selectedUser) {
            return back()->withErrors(['selected_uid' => 'Invalid client ID selected.']);
        }

        $user = User::create([
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $reg = EventRegistration::create([
            'user_id' => $user->id,
            'registration_number' => 'ARI-' . now()->format('Y') . '-' . strtoupper(Str::random(6)),
            'full_name' => $request->full_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'city' => $request->city,
            'type' => $request->type,
            'is_existing_client' => true,
            'status' => 'kyc_completed',
            'referral_code' => strtoupper(Str::random(12)),
            'referred_by' => $request->referred_by ?? null,
            'otp_verified_at' => now(),
            'kyc_completed_at' => now(),
        ]);

        KycDetail::create([
            'event_registration_id' => $reg->id,
            'validation_status' => 'verified',
        ]);

        Auth::login($user);
        $this->leadScore->calculateScore($reg);

        Session::forget(['client_users', 'reg_phone', 'is_existing_client']);

        $plainPassword = $request->password;
        $this->email->sendRegistrationSuccessful($reg, $plainPassword);

        return redirect()->route('registration.payment');
    }

    /* ============================================================
       STEP 2B: New User — OTP Verification
       ============================================================ */

    public function showOtp()
    {
        if (Session::get('is_existing_client') || !Session::has('reg_phone')) {
            return redirect()->route('registration.form');
        }
        return view('registration.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $expires = Session::get('otp_expires');
        if (Session::get('is_existing_client') || !Session::has('reg_phone') || now()->gt($expires)) {
            return back()->withErrors(['otp' => 'OTP expired. Please start again.']);
        }

        $expected = Session::get('reg_otp');
        if ($request->otp != $expected) {
            return back()->withErrors(['otp' => 'Invalid OTP. Please try again.']);
        }

        Session::put('phone_verified', true);
        Session::forget(['reg_otp', 'otp_expires']);

        return redirect()->route('registration.details');
    }

    public function resendOtp()
    {
        $phone = Session::get('reg_phone');
        if (!$phone || Session::get('is_existing_client')) {
            return redirect()->route('registration.form');
        }

        $otp = random_int(100000, 999999);
        Session::put('reg_otp', $otp);
        Session::put('otp_expires', now()->addMinutes(10));
        $this->whatsapp->sendOtpToPhone($phone, (string) $otp);

        return back()->with('resent', true);
    }

    /* ============================================================
       STEP 3: New User — Fill Details (Name, City, Email, Type)
       → NOW SKIPS KYC AND GOES STRAIGHT TO PAYMENT
       ============================================================ */

    public function showDetails()
    {
        if (Session::get('is_existing_client') || !Session::get('phone_verified')) {
            return redirect()->route('registration.form');
        }
        return view('registration.details');
    }

    public function submitDetails(Request $request)
    {
        if (Session::get('is_existing_client') || !Session::get('phone_verified')) {
            return redirect()->route('registration.form');
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'city' => 'required|string|max:100',
            'type' => 'required|in:investor,trader',
            'password' => ['required', Password::defaults()],
            'referred_by' => 'nullable|string|size:12',
        ]);

        $user = User::create([
            'name' => $validated['full_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $reg = EventRegistration::create([
            'user_id' => $user->id,
            'registration_number' => 'ARI-' . now()->format('Y') . '-' . strtoupper(Str::random(6)),
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => Session::get('reg_phone'),
            'city' => $validated['city'],
            'type' => $validated['type'],
            'is_existing_client' => false,
            'status' => 'kyc_completed',              // ← CHANGED: skip KYC page
            'referral_code' => strtoupper(Str::random(12)),
            'referred_by' => $validated['referred_by'] ?? null,
            'otp_verified_at' => now(),
            'kyc_completed_at' => now(),              // ← NEW
        ]);

        // Minimal KYC record — details page itself acts as KYC
        KycDetail::create([
            'event_registration_id' => $reg->id,
            'validation_status' => 'verified',
        ]);

        Auth::login($user);
        $this->leadScore->calculateScore($reg);

        // NEW: send registration email to new clients too
        $plainPassword = $validated['password'];
        $this->email->sendRegistrationSuccessful($reg, $plainPassword);

        Session::forget(['reg_phone', 'phone_verified']);

        return redirect()->route('registration.payment'); // ← CHANGED: was registration.kyc
    }

    /* ============================================================
       STEP 4: KYC — REMOVED ENTIRELY
       ============================================================ */

    /* ============================================================
       STEP 5: Payment (Existing ₹299 | New 599) — ATOM
       ============================================================ */

    public function showPayment()
    {
        $reg = $this->getCurrentRegistration();
        if (!$reg || $reg->status !== 'kyc_completed') {
            return redirect()->route('registration.form');
        }

        $order = $this->payment->createOrder($reg);

        if (!$order) {
            return redirect()->route('registration.payment')->withErrors(['payment' => 'Unable to initialize payment gateway. Please try again.']);
        }

        return view('registration.payment', compact('reg', 'order'));
    }

    public function paymentCallback(Request $request, $id)
    {
        $user = User::find($id);
        Auth::login($user);
        $payload = $request->all();
        Log::info('Atom callback raw payload', $payload);

        $reg = $this->getCurrentRegistration();
        if (!$reg) {
            return redirect()->route('registration.form');
        }

        $decrypted = $this->payment->decryptCallback($payload);

        if (!$decrypted) {
            return redirect()->route('registration.payment')->withErrors(['payment' => 'Invalid or corrupted payment response.']);
        }

        Log::info('Atom callback decrypted', $decrypted);

        // Atom has TWO success formats — handle both
        $isSuccess = false;

        // Format 1: Some accounts return f_code === 'Ok'
        if (($decrypted['f_code'] ?? '') === 'Ok') {
            $isSuccess = true;
        }

        // Format 2: Your account returns responseDetails.statusCode === 'OTS0000'
        $statusCode = $decrypted['responseDetails']['statusCode'] ?? $decrypted['statusCode'] ?? null;
        $message = $decrypted['responseDetails']['message'] ?? $decrypted['message'] ?? null;

        if ($statusCode === 'OTS0000' || $message === 'SUCCESS') {
            $isSuccess = true;
        }

        if (!$isSuccess) {
            Log::warning('Atom payment failed/cancelled', $decrypted);
            return redirect()->route('registration.payment')->withErrors(['payment' => 'Payment was not successful. Please try again.']);
        }

        // Extract merchTxnId — nested in payInstrument.merchDetails
        $merchTxnId = $decrypted['payInstrument']['merchDetails']['merchTxnId']
            ?? $decrypted['merchTxnId']
            ?? null;

        // Extract atomTxnId — nested in payInstrument.payDetails
        $atomTxnId = $decrypted['payInstrument']['payDetails']['atomTxnId']
            ?? $decrypted['atomTxnId']
            ?? $decrypted['txnId']
            ?? null;

        $payment = Payment::where('merch_txn_id', $merchTxnId)
            ->where('event_registration_id', $reg->id)
            ->first();

        if ($payment && $payment->status !== 'paid') {
            $payment->update([
                'gateway_payment_id' => $atomTxnId,
                'status' => 'paid',
                'gateway_response' => $decrypted,
                'paid_at' => now(),
            ]);
        }

        $reg->update(['status' => 'paid', 'paid_at' => now()]);

        // Idempotent: only generate QR once
        $existingQr = $reg->qrCodes()->where('purpose', 'entry')->first();
        if (!$existingQr) {
            $qr = $this->qr->generateEntryQr($reg);
            $qrUrl = asset('storage/' . $qr->image_path);
            $this->whatsapp->sendQrImage($reg, $qrUrl);
            $this->email->sendConfirmation($reg, $qr->image_path);
        }

        $this->leadScore->calculateScore($reg);

        if ($reg->referred_by) {
            $this->awardReferralPoints($reg);
        }

        return redirect()->route('registration.success');
    }

    /* ============================================================
       STEP 6: Success
       ============================================================ */

    public function success()
    {
        $reg = $this->getCurrentRegistration();
        if ($reg->status == 'checked_in') {
            $seat = $reg->seat;
            return view('registration.success', compact('reg', 'seat'));
        }
        if (!$reg || $reg->status !== 'paid') {
            return redirect()->route('registration.payment');
        }
        $qr = $reg->qrCodes()->where('purpose', 'entry')->first();
        return view('registration.success', compact('reg', 'qr'));
    }

    /* ============================================================
       Helpers
       ============================================================ */

    protected function getCurrentRegistration(): ?EventRegistration
    {
        if (!Auth::check())
            return null;
        return EventRegistration::where('user_id', Auth::id())->latest()->first();
    }

    protected function awardReferralPoints(EventRegistration $reg): void
    {
        $referrer = EventRegistration::where('referral_code', $reg->referred_by)->first();
        if ($referrer) {
            $referrer->referralsMade()
                ->where('referred_email', $reg->email)
                ->update(['status' => 'paid', 'points_awarded' => 50]);
            $this->leadScore->calculateScore($referrer);
        }
    }
}