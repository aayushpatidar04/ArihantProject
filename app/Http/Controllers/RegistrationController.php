<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use App\Models\KycDetail;
use App\Models\Payment;
use App\Models\Referral;
use App\Models\User;
use App\Models\WaitlistNumber;
use App\Services\ClientApiService;
use App\Services\WhatsAppService;
use App\Services\EmailService;
use App\Services\LeadScoringService;
use App\Services\PaymentGatewayService;
use App\Services\razorPaymentGatewayService;
use App\Services\QrCodeService;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RegistrationController extends Controller
{
    public function __construct(
        protected ClientApiService $clientApi,
        protected WhatsAppService $whatsapp,
        protected EmailService $email,
        protected PaymentGatewayService $payment,
        protected razorPaymentGatewayService $razor_payment,
        protected QrCodeService $qr,
        protected LeadScoringService $leadScore,
        protected SmsService $sms,
    ) {
    }

    /* ============================================================
       STEP 1: Enter Phone Number → Check Sub-Broker → Existing Client → New User
       ============================================================ */

    public function showForm(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('registration.success');
        }

        $referralCode = strtoupper((string) $request->query('ref', ''));
        if (preg_match('/^[A-Z0-9]{12}$/', $referralCode)) {
            Session::put('reg_referred_by', $referralCode);
        } else {
            Session::forget(['reg_referred_by']);
        }

        return view('registration.form');
    }

    // public function submitPhone(Request $request)
    // {
    //     $validated = $request->validate([
    //         'phone' => 'required|string|regex:/^[0-9]{10}$/|unique:event_registrations,phone',
    //     ], [
    //         'phone.unique' => 'This number is already registered. Try logging in or use another number.',
    //     ]);

    //     $phone = $validated['phone'];

    //     // PRIORITY 1: Check if sub-broker (free registration, no payment)
    //     $isSubBroker = $this->clientApi->checkSubBroker($phone);
    //     if ($isSubBroker) {
    //         Session::put('reg_phone', $phone);
    //         Session::put('is_subbroker', true);
    //         Session::put('is_existing_client', false);
    //         return redirect()->route('registration.details');
    //     }

    //     // PRIORITY 2: Check if existing Arihant client
    //     $clientData = $this->clientApi->checkClient($phone);
    //     if ($clientData) {
    //         Session::put('client_users', $clientData['users']);
    //         Session::put('reg_phone', $phone);
    //         Session::put('is_existing_client', true);
    //         return redirect()->route('registration.client.confirm');
    //     }

    //     // PRIORITY 3: New user flow (OTP + payment)
    //     $otp = random_int(100000, 999999);
    //     Session::put('reg_phone', $phone);
    //     Session::put('reg_otp', $otp);
    //     Session::put('otp_expires', now()->addMinutes(10));
    //     Session::put('is_existing_client', false);
    //     Session::put('is_subbroker', false);

    //     $this->whatsapp->sendOtpToPhone($phone, (string) $otp);

    //     return redirect()->route('registration.otp');
    // }

    /* ============================================================
       STEP 2A: Existing Client — Select UID & Confirm Details
       ============================================================ */

    public function submitPhone(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string|regex:/^[0-9]{10}$/|unique:waitlist_numbers,phone',
        ], [
            'phone.unique' => 'This number is already joined waitlist. Try logging in or use another number.',
        ]);

        $phone = $validated['phone'];

        // Save the number into waitlist_numbers table
        WaitlistNumber::create([
            'phone_number' => $phone,
        ]);

        // Return the closed registration view
        return view('registration.closed');
    }
    
       public function showClientConfirm()
    {
        if (Auth::check()) {
            return redirect()->route('registration.success');
        }
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
            'password' => Hash::make('ArihantCapitals'),
        ]);

        $referral = $this->findReferralForRegistration($request->email, $request->phone);
        $referrer = $referral?->referrer ?? $this->findReferrerByCode(Session::get('reg_referred_by'));

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
            'referred_by' => $referrer?->referral_code,
            'otp_verified_at' => now(),
            'kyc_completed_at' => now(),
            'platform' => Session::get('registration_platform'),
        ]);

        try {
            $response = Http::withBasicAuth(
                'sampark.arihantcapital',
                'Arihant@12345'
            )
                ->timeout(10)
                ->withQueryParameters([
                    'MobileNumber' => $reg->phone,
                ])
                ->post(
                    'https://inspection.arihantcapital.com/api/v1/CtC/branchclientValidationByMobileNo'
                );

            if ($response->successful()) {

                $data = $response->json();

                $reg->update([
                    'client_validation_data' => [
                        'branchlist' => $data['branchlist'] ?? [],
                        'clientlist' => $data['clientlist'] ?? [],
                    ],
                ]);

                Log::info('Arihant client validation API response', [
                    'registration_id' => $reg->id,
                    'registration_number' => $reg->registration_number,
                    'phone' => $reg->phone,
                    'status' => $response->status(),
                    'response' => $data,
                ]);

            } else {

                Log::error('Arihant client validation API failed', [
                    'registration_id' => $reg->id,
                    'registration_number' => $reg->registration_number,
                    'phone' => $reg->phone,
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);
            }

        } catch (\Throwable $e) {

            Log::error('Arihant client validation API exception', [
                'registration_id' => $reg->id,
                'registration_number' => $reg->registration_number,
                'phone' => $reg->phone,
                'error' => $e->getMessage(),
            ]);
        }

        // Push lead to CRM (fire-and-forget)
        try {
            $crmResponse = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Bearer 62c6067304882a00a922dcb4d89c51aab7c812f1d4371badedc531b5f737f8d3',
                'Content-Type' => 'application/json',
            ])->post('https://ekycadminapi.arihantcapital.com/api/users/admin/createEventLead', [
                        'name' => $reg->full_name,
                        'mobileNumber' => $reg->phone,
                        'email' => $reg->email,
                        'city' => $reg->city,
                        'sourceUrl' => 'https://event.arihantplus.com', // or your event landing page
                        'source' => 'AI & Algo Conclave',
                        'clientType' => $reg->is_subbroker ? 'Sub-broker' : ($reg->is_existing_client ? 'Existing Client' : 'New Client'),
                    ]);

        } catch (\Exception $e) {
            Log::error('CRM lead push failed: ' . $e->getMessage(), [
                'reg_id' => $reg->id,
            ]);
        }

        KycDetail::create([
            'event_registration_id' => $reg->id,
            'validation_status' => 'verified',
        ]);

        $this->attachReferral($referral, $referrer, $reg);

        Auth::login($user);
        $this->leadScore->calculateScore($reg);

        Session::forget(['client_users', 'reg_phone', 'is_existing_client', 'reg_referred_by', 'registration_platform']);

        $plainPassword = $request->password;
        $this->email->sendRegistrationSuccessful($reg, $plainPassword);


        return redirect()->route('registration.payment');
    }

    /* ============================================================
       STEP 2B: New User — OTP Verification
       ============================================================ */

    public function showOtp()
    {
        if (Auth::check()) {
            return redirect()->route('registration.success');
        }
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
        if (Auth::check()) {
            return redirect()->route('registration.success');
        }
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
            'referred_by' => 'nullable|string|size:12',
        ]);

        $user = User::create([
            'name' => $validated['full_name'],
            'email' => $validated['email'],
            'password' => Hash::make('ArihantCapitals'),
        ]);

        $referral = $this->findReferralForRegistration($validated['email'], Session::get('reg_phone'));
        $referrer = $referral?->referrer ?? $this->findReferrerByCode(Session::get('reg_referred_by'));

        $reg = EventRegistration::create([
            'user_id' => $user->id,
            'registration_number' => 'ARI-' . now()->format('Y') . '-' . strtoupper(Str::random(6)),
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => Session::get('reg_phone'),
            'city' => $validated['city'],
            'type' => $validated['type'],
            'is_existing_client' => $isSubBroker,
            'status' => 'kyc_completed',
            'referral_code' => strtoupper(Str::random(12)),
            'referred_by' => $referrer?->referral_code,
            'otp_verified_at' => now(),
            'kyc_completed_at' => now(),
            'is_subbroker' => $isSubBroker,
            'platform' => Session::get('registration_platform'),
        ]);

        try {
            $response = Http::withBasicAuth(
                'sampark.arihantcapital',
                'Arihant@12345'
            )
                ->timeout(10)
                ->withQueryParameters([
                    'MobileNumber' => $reg->phone,
                ])
                ->post(
                    'https://inspection.arihantcapital.com/api/v1/CtC/branchclientValidationByMobileNo'
                );

            if ($response->successful()) {

                $data = $response->json();

                $reg->update([
                    'client_validation_data' => [
                        'branchlist' => $data['branchlist'] ?? [],
                        'clientlist' => $data['clientlist'] ?? [],
                    ],
                ]);

                Log::info('Arihant client validation API response', [
                    'registration_id' => $reg->id,
                    'registration_number' => $reg->registration_number,
                    'phone' => $reg->phone,
                    'status' => $response->status(),
                    'response' => $data,
                ]);

            } else {

                Log::error('Arihant client validation API failed', [
                    'registration_id' => $reg->id,
                    'registration_number' => $reg->registration_number,
                    'phone' => $reg->phone,
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);
            }

        } catch (\Throwable $e) {

            Log::error('Arihant client validation API exception', [
                'registration_id' => $reg->id,
                'registration_number' => $reg->registration_number,
                'phone' => $reg->phone,
                'error' => $e->getMessage(),
            ]);
        }

        // Push lead to CRM (fire-and-forget)
        try {
            $crmResponse = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Bearer 62c6067304882a00a922dcb4d89c51aab7c812f1d4371badedc531b5f737f8d3',
                'Content-Type' => 'application/json',
            ])->post('https://ekycadminapi.arihantcapital.com/api/users/admin/createEventLead', [
                        'name' => $reg->full_name,
                        'mobileNumber' => $reg->phone,
                        'email' => $reg->email,
                        'city' => $reg->city,
                        'sourceUrl' => 'https://event.arihantplus.com',
                        'source' => 'AI & Algo Conclave',
                        'clientType' => $reg->is_subbroker ? 'Sub-broker' : ($reg->is_existing_client ? 'Existing Client' : 'New Client'),
                    ]);

        } catch (\Exception $e) {
            Log::error('CRM lead push failed: ' . $e->getMessage(), [
                'reg_id' => $reg->id,
            ]);
        }

        KycDetail::create([
            'event_registration_id' => $reg->id,
            'validation_status' => 'verified',
        ]);

        $this->attachReferral($referral, $referrer, $reg);

        Auth::login($user);
        $this->leadScore->calculateScore($reg);

        $plainPassword = 'ArihantCapitals';
        $this->email->sendRegistrationSuccessful($reg, $plainPassword);

        Session::forget(['reg_phone', 'phone_verified', 'reg_referred_by', 'registration_platform']);
        return redirect()->route('registration.payment');
    }

    /* ============================================================
       STEP 4: Payment (Existing ₹399 | New ₹599) — ATOM
       ============================================================ */

    public function showPayment()
    {
        if (!Auth::check()) {
            return redirect()->route('index');
        }

        $reg = $this->getCurrentRegistration();

        if (!$reg || $reg->status !== 'kyc_completed') {
            return redirect()->route('registration.form');
        }

        Session::put('payment_registration_id', $reg->id);

        $order = $this->razor_payment->createOrder($reg);

        if (!$order) {
            return redirect()
                ->route('registration.payment')
                ->withErrors([
                    'payment' => 'Unable to initialize payment gateway. Please try again.'
                ]);
        }

        return view('registration.payment', compact('reg', 'order'));
    }

    public function checkPromo(Request $request)
    {
        $validated = $request->validate([
            'promo_code' => 'required|string|max:50',
        ]);

        $enteredCode = strtoupper(trim($validated['promo_code']));
        $configuredCode = strtoupper(trim(config('event.promo.code')));

        if ($enteredCode !== $configuredCode) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid promo code.',
            ], 422);
        }

        $usedCount = EventRegistration::where('promo_code_used', true)
            ->where('promo_code', $configuredCode)
            ->count();

        $limit = (int) config('event.promo.limit');

        if ($usedCount >= $limit) {
            return response()->json([
                'valid' => false,
                'message' => 'This promo code has reached its usage limit.',
            ], 422);
        }

        $reg = $this->getCurrentRegistration();

        if (!$reg) {
            return response()->json([
                'valid' => false,
                'message' => 'Registration session expired. Please start again.',
            ], 422);
        }

        if ($reg->promo_code_used) {
            return response()->json([
                'valid' => false,
                'message' => 'A promo code has already been applied to this registration.',
            ], 422);
        }

        return response()->json([
            'valid' => true,
            'promo_code' => $configuredCode,
            'amount' => (int) config('event.promo.amount'),
            'remaining' => max(0, $limit - $usedCount),
            'message' => 'Promo code applied successfully.',
        ]);
    }

    public function createPaymentOrder(Request $request)
    {
        $reg = $this->getCurrentRegistration();

        if (!$reg) {
            return response()->json([
                'success' => false,
                'message' => 'Registration session expired. Please start again.',
            ], 422);
        }

        if ($reg->status === 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Registration is already paid.',
            ], 422);
        }

        $promoCode = strtoupper(
            trim($request->input('promo_code', ''))
        );

        $finalAmount = $reg->is_existing_client
            ? 399
            : 599;

        $promoApplied = false;

        if ($promoCode !== '') {

            $configuredCode = strtoupper(
                trim(config('event.promo.code'))
            );

            if ($promoCode !== $configuredCode) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid promo code.',
                ], 422);
            }

            if ($reg->promo_code_used) {
                return response()->json([
                    'success' => false,
                    'message' => 'Promo code has already been used.',
                ], 422);
            }

            $usedCount = EventRegistration::where(
                'promo_code_used',
                true
            )
                ->where(
                    'promo_code',
                    $configuredCode
                )
                ->count();

            $limit = (int) config('event.promo.limit');

            if ($usedCount >= $limit) {
                return response()->json([
                    'success' => false,
                    'message' => 'This promo code has reached its usage limit.',
                ], 422);
            }

            $finalAmount = (int) config(
                'event.promo.amount'
            );

            $promoApplied = true;
        }

        /*
         * Create Razorpay order using the SERVER calculated amount.
         */
        $order = $this->razor_payment->createOrder(
            $reg,
            $finalAmount
        );

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to initialize payment gateway.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'order_id' => $order['id'],
            'amount' => $finalAmount,
            'promo_applied' => $promoApplied,
            'promo_code' => $promoApplied
                ? $configuredCode
                : null,
        ]);
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

        $paymentMode = 'Bharat QR';
        if (!empty($payInstrument['payModeSpecificData']['subChannel']) && is_array($payInstrument['payModeSpecificData']['subChannel'])) {
            $paymentMode = $payInstrument['payModeSpecificData']['subChannel'][0] ?? 'Bharat QR';
        }

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

        $txnRef = $atomTxnId ?? $merchTxnId ?? 'TXN-' . $reg->registration_number;
        $amount = $reg->is_existing_client ? '399' : '599';

        // 1️⃣ Send Registration Confirmation (AW20699204)
        $this->whatsapp->sendRegistrationConfirmation(
            $reg,
            $atomTxnId ?? $merchTxnId ?? 'TXN-' . $reg->registration_number,
            $reg->is_existing_client ? '399' : '599',
            $paymentMode ?? 'Bharat QR'
        );

        $this->sms->sendRegistrationConfirmation($reg->phone, $txnRef, $amount, $paymentMode);

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

        return redirect()->route('registration.thankyou');
    }

    public function razorPaymentCallback(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()
                ->route('registration.form')
                ->withErrors([
                    'payment' => 'User not found.'
                ]);
        }

        Auth::login($user);

        $request->validate([
            'razorpay_payment_id' =>
                'required|string',

            'razorpay_order_id' =>
                'required|string',

            'razorpay_signature' =>
                'required|string',

            'promo_code' =>
                'nullable|string|max:50',
        ]);


        $reg = $this->getCurrentRegistration();

        if (!$reg) {
            return redirect()
                ->route('registration.form');
        }


        /*
         * Verify Razorpay signature.
         */
        $isValid =
            $this->razor_payment->verifySignature([
                'order_id' =>
                    $request->razorpay_order_id,

                'payment_id' =>
                    $request->razorpay_payment_id,

                'signature' =>
                    $request->razorpay_signature,
            ]);


        if (!$isValid) {

            return redirect()
                ->route('registration.payment')
                ->withErrors([
                    'payment' =>
                        'Payment verification failed.'
                ]);
        }


        /*
         * Already paid?
         *
         * Prevent duplicate callback processing.
         */
        if ($reg->status === 'paid') {
            return redirect()
                ->route('registration.thankyou');
        }


        $promoCode = strtoupper(
            trim($request->promo_code ?? '')
        );


        $promoApplied = false;

        $finalAmount =
            $reg->is_existing_client
            ? 399
            : 599;


        DB::transaction(function () use ($reg, $request, $promoCode, &$promoApplied, &$finalAmount) {

            /*
             * Lock registration.
             */
            $lockedReg =
                EventRegistration::where(
                    'id',
                    $reg->id
                )
                    ->lockForUpdate()
                    ->first();


            if ($lockedReg->status === 'paid') {
                return;
            }


            /*
             * Verify promo AGAIN.
             */
            if ($promoCode !== '') {

                $configuredCode =
                    strtoupper(
                        trim(
                            config('event.promo.code')
                        )
                    );


                if ($promoCode !== $configuredCode) {

                    throw ValidationException::withMessages([
                        'promo_code' =>
                            'Invalid promo code.'
                    ]);
                }


                if ($lockedReg->promo_code_used) {

                    throw ValidationException::withMessages([
                        'promo_code' =>
                            'Promo code has already been used.'
                    ]);
                }


                /*
                 * Count successful promo usages.
                 */
                $usedCount =
                    EventRegistration::where(
                        'promo_code_used',
                        true
                    )
                        ->where(
                            'promo_code',
                            $configuredCode
                        )
                        ->count();


                $limit =
                    (int) config(
                        'event.promo.limit'
                    );


                if ($usedCount >= $limit) {

                    throw ValidationException::withMessages([
                        'promo_code' =>
                            'Promo code usage limit has been reached.'
                    ]);
                }


                $finalAmount =
                    (int) config(
                        'event.promo.amount'
                    );

                $promoApplied = true;
            }


            /*
             * Get payment.
             */
            $payment =
                $lockedReg->payment;


            if ($payment) {

                $payment->update([

                    'gateway_payment_id' =>
                        $request->razorpay_payment_id,

                    'gateway_signature' =>
                        $request->razorpay_signature,

                    'status' =>
                        'paid',

                    'amount' =>
                        $finalAmount,

                    'paid_at' =>
                        now(),
                ]);

            } else {

                Payment::create([

                    'event_registration_id' =>
                        $lockedReg->id,

                    'gateway' =>
                        'razorpay',

                    'gateway_order_id' =>
                        $request->razorpay_order_id,

                    'gateway_payment_id' =>
                        $request->razorpay_payment_id,

                    'gateway_signature' =>
                        $request->razorpay_signature,

                    'amount' =>
                        $finalAmount,

                    'currency' =>
                        'INR',

                    'status' =>
                        'paid',

                    'paid_at' =>
                        now(),
                ]);
            }


            /*
             * Mark registration paid.
             *
             * Promo is consumed ONLY HERE.
             */
            $lockedReg->update([

                'status' =>
                    'paid',

                'paid_at' =>
                    now(),

                'promo_code_used' =>
                    $promoApplied,

                'promo_code' =>
                    $promoApplied
                    ? strtoupper(
                        trim(
                            config('event.promo.code')
                        )
                    )
                    : null,

                'promo_amount' =>
                    $promoApplied
                    ? $finalAmount
                    : null,
            ]);

        });


        /*
         * Refresh registration.
         */
        $reg->refresh();


        /*
         * Generate QR.
         */
        $qr =
            $this->qr->generateEntryQr($reg);

        $qrUrl =
            asset(
                'storage/' .
                $qr->image_path
            );


        /*
         * Send QR.
         */
        $this->whatsapp->sendQrImage(
            $reg,
            $qrUrl
        );


        $this->email->sendConfirmation(
            $reg,
            $qr->image_path
        );


        /*
         * Lead scoring.
         */
        $this->leadScore->calculateScore($reg);


        if ($reg->referred_by) {
            $this->awardReferralPoints($reg);
        }


        return redirect()
            ->route('registration.thankyou');
    }

    public function thankYou()
    {
        $reg = auth()->user()?->eventRegistrations()->latest()->first();

        if (!$reg || $reg->status !== 'paid') {
            return redirect()->route('registration.payment');
        }

        return view('registration.thankyou', compact('reg'));
    }

    /* ============================================================
       STEP 5: Success
       ============================================================ */

    public function success()
    {
        if (!Auth::check()) {
            return redirect()->route('index');
        }
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
        $referral = Referral::where('referred_id', $reg->id)
            ->where('status', '!=', 'paid')
            ->first();

        if ($referral) {
            $referral->update(['status' => 'paid', 'points_awarded' => 50]);
            $referrer = $referral->referrer;
            if ($referrer) {
                $this->leadScore->calculateScore($referrer);
            }
        }
    }

    protected function findReferralForRegistration(string $email, ?string $phone): ?Referral
    {
        $normalizedEmail = strtolower(trim($email));
        $normalizedPhone = $phone ? preg_replace('/\D+/', '', $phone) : null;

        return Referral::with('referrer')
            ->where(function ($query) use ($normalizedEmail, $normalizedPhone) {
                $query->where('referred_email', $normalizedEmail);
                if ($normalizedPhone) {
                    $query->orWhere('referred_phone', $normalizedPhone);
                }
            })
            ->orderBy('id')
            ->first();
    }

    protected function findReferrerByCode(?string $referralCode): ?EventRegistration
    {
        if (!$referralCode) {
            return null;
        }

        return EventRegistration::where('referral_code', $referralCode)->first();
    }

    protected function attachReferral(?Referral $referral, ?EventRegistration $referrer, EventRegistration $reg): void
    {
        if ($referral) {
            $referral->whereNull('referred_id')->update([
                'referred_id' => $reg->id,
                'status' => 'registered',
            ]);
            return;
        }

        if ($referrer && $referrer->id !== $reg->id) {
            Referral::create([
                'referrer_id' => $referrer->id,
                'referred_id' => $reg->id,
                'referred_name' => $reg->full_name,
                'referred_email' => strtolower(trim($reg->email)),
                'referred_phone' => preg_replace('/\D+/', '', $reg->phone),
                'status' => 'registered',
            ]);
        }
    }
}