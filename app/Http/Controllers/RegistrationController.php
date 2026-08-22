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
       STEP 1: Enter Phone Number → Check Sub-Broker → Existing Client → New User
       ============================================================ */

    public function showForm()
    {
        if(Auth::check()){
            return redirect()->route('registration.success');
        }
        return view('registration.form');
    }

    public function submitPhone(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string|regex:/^[0-9]{10}$/|unique:event_registrations,phone',
        ], [
            'phone.unique' => 'This number is already registered. Try logging in or use another number.',
        ]);

        $phone = $validated['phone'];

        // PRIORITY 1: Check if sub-broker (free registration, no payment)
        $isSubBroker = $this->clientApi->checkSubBroker($phone);
        if ($isSubBroker) {
            Session::put('reg_phone', $phone);
            Session::put('is_subbroker', true);
            Session::put('is_existing_client', false);
            return redirect()->route('registration.details');
        }

        // PRIORITY 2: Check if existing Arihant client
        $clientData = $this->clientApi->checkClient($phone);
        if ($clientData) {
            Session::put('client_users', $clientData['users']);
            Session::put('reg_phone', $phone);
            Session::put('is_existing_client', true);
            return redirect()->route('registration.client.confirm');
        }

        // PRIORITY 3: New user flow (OTP + payment)
        $otp = random_int(100000, 999999);
        Session::put('reg_phone', $phone);
        Session::put('reg_otp', $otp);
        Session::put('otp_expires', now()->addMinutes(10));
        Session::put('is_existing_client', false);
        Session::put('is_subbroker', false);

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
            // 'password' => 'required'
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
        if (Session::get('is_existing_client') || Session::get('is_subbroker') || !Session::has('reg_phone')) {
            return redirect()->route('registration.form');
        }
        return view('registration.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $expires = Session::get('otp_expires');
        if (Session::get('is_existing_client') || Session::get('is_subbroker') || !Session::has('reg_phone') || now()->gt($expires)) {
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
        if (!$phone || Session::get('is_existing_client') || Session::get('is_subbroker')) {
            return redirect()->route('registration.form');
        }

        $otp = random_int(100000, 999999);
        Session::put('reg_otp', $otp);
        Session::put('otp_expires', now()->addMinutes(10));
        $this->whatsapp->sendOtpToPhone($phone, (string) $otp);

        return back()->with('resent', true);
    }

    /* ============================================================
       STEP 3: Fill Details (New User + Sub-Broker)
       ============================================================ */

    public function showDetails()
    {
        $isSubBroker = Session::get('is_subbroker');
        $phoneVerified = Session::get('phone_verified');
        $isExisting = Session::get('is_existing_client');

        // Sub-brokers skip OTP — just need phone
        if ($isSubBroker && Session::has('reg_phone')) {
            return view('registration.details', ['is_subbroker' => true]);
        }

        // New users need OTP verified
        if ($isExisting || !$phoneVerified) {
            return redirect()->route('registration.form');
        }

        return view('registration.details', ['is_subbroker' => false]);
    }

    public function submitDetails(Request $request)
    {
        $isSubBroker = Session::get('is_subbroker');

        // Validate access
        if ($isSubBroker) {
            if (!Session::has('reg_phone')) {
                return redirect()->route('registration.form');
            }
        } else {
            if (Session::get('is_existing_client') || !Session::get('phone_verified')) {
                return redirect()->route('registration.form');
            }
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'city' => 'required|string|max:100',
            'type' => 'required|in:investor,trader',
            // 'password' => 'required',
            'referred_by' => 'nullable|string|size:12',
        ]);

        $user = User::create([
            'name' => $validated['full_name'],
            'email' => $validated['email'],
            'password' => Hash::make('ArihantCapitals'),
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
            'status' => 'kyc_completed',
            'referral_code' => strtoupper(Str::random(12)),
            'referred_by' => $validated['referred_by'] ?? null,
            'otp_verified_at' => now(),
            'kyc_completed_at' => now(),
            'is_subbroker' => $isSubBroker,
        ]);

        KycDetail::create([
            'event_registration_id' => $reg->id,
            'validation_status' => 'verified',
        ]);

        Auth::login($user);
        $this->leadScore->calculateScore($reg);

        $plainPassword = $validated['password'];
        $this->email->sendRegistrationSuccessful($reg, $plainPassword);

        // SUB-BROKER: Skip payment, mark paid, send both WhatsApp templates + Email
        if ($isSubBroker) {
            $reg->update(['status' => 'paid', 'paid_at' => now()]);

            // AW20699204 — Complimentary registration confirmation
            $this->whatsapp->sendRegistrationConfirmation(
                $reg,
                'SUB-' . strtoupper(Str::random(8)),
                '0',
                'Complimentary'
            );

            $qr = $this->qr->generateEntryQr($reg);
            $qrUrl = asset('storage/' . $qr->image_path);

            // GW20590908 — QR Ticket
            $this->whatsapp->sendQrImage($reg, $qrUrl);
            $this->email->sendConfirmation($reg, $qr->image_path);
            $this->leadScore->calculateScore($reg);

            Session::forget(['reg_phone', 'is_subbroker']);

            return redirect()->route('registration.success');
        }

        Session::forget(['reg_phone', 'phone_verified']);
        return redirect()->route('registration.payment');
    }

    /* ============================================================
       STEP 4: Payment (Existing ₹299 | New ₹599) — ATOM
       ============================================================ */

    public function showPayment()
    {
        $reg = $this->getCurrentRegistration();
        if (!$reg || $reg->status !== 'kyc_completed') {
            return redirect()->route('registration.form');
        }

        Session::put('payment_registration_id', $reg->id);

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

        $decrypted = $this->payment->decryptCallback($payload);
        if (!$decrypted) {
            return redirect()->route('registration.payment')->withErrors(['payment' => 'Invalid or corrupted payment response.']);
        }

        Log::info('Atom callback decrypted', $decrypted);

        $payInstrument = $decrypted['payInstrument'] ?? $decrypted;

        $isSuccess = false;
        if (($payInstrument['f_code'] ?? '') === 'Ok') {
            $isSuccess = true;
        }

        $statusCode = $payInstrument['responseDetails']['statusCode'] ?? $payInstrument['statusCode'] ?? null;
        $message = $payInstrument['responseDetails']['message'] ?? $payInstrument['message'] ?? null;

        if ($statusCode === 'OTS0000' || $message === 'SUCCESS') {
            $isSuccess = true;
        }

        if (!$isSuccess) {
            Log::warning('Atom payment failed/cancelled', $decrypted);
            return redirect()->route('registration.payment')->withErrors(['payment' => 'Payment was not successful. Please try again.']);
        }

        $regIdFromCallback = $payInstrument['extras']['udf2'] ?? Session::get('payment_registration_id');
        $reg = EventRegistration::find($regIdFromCallback);

        if (!$reg) {
            Log::error('Atom callback: registration not found', ['reg_id' => $regIdFromCallback]);
            return redirect()->route('registration.form');
        }

        $merchTxnId = $payInstrument['merchDetails']['merchTxnId'] ?? null;
        $atomTxnId = $payInstrument['payDetails']['atomTxnId'] ?? null;

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
        Session::forget('payment_registration_id');

        // 1️⃣ Send Registration Confirmation (AW20699204)
        $this->whatsapp->sendRegistrationConfirmation(
            $reg,
            $atomTxnId ?? $merchTxnId ?? 'TXN-' . $reg->registration_number,
            '599',
            'Bharat QR'
        );

        // 2️⃣ Generate & send QR Ticket (GW20590908) + Email
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
       STEP 5: Success
       ============================================================ */

    public function success()
    {
        $reg = $this->getCurrentRegistration();

        // Fallback: find any paid/checked_in registration for this user
        if (!$reg || ($reg->status !== 'paid' && $reg->status !== 'checked_in')) {
            $reg = EventRegistration::where('user_id', Auth::id())
                ->whereIn('status', ['paid', 'checked_in'])
                ->latest()
                ->first();
        }

        if (!$reg) {
            return redirect()->route('registration.payment');
        }

        if ($reg->status === 'checked_in') {
            $seat = $reg->seat;
            return view('registration.success', compact('reg', 'seat'));
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