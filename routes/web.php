<?php

use App\Http\Controllers\Admin\StallController as AdminStallController;
use App\Http\Controllers\Admin\AdminStallVisitController;
use App\Http\Controllers\Admin\StallQuizController;
use App\Http\Controllers\Admin\StallFeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\StallController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\InfluencerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use Illuminate\Support\Facades\Route;

/* ---------- Public Routes ---------- */
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::post('/logout', [HomeController::class, 'logout'])->name('logout');

Route::get('/login', [HomeController::class, 'showLogin'])->name('login');
Route::post('/login/otp/send', [HomeController::class, 'sendOtp'])->middleware('throttle:5,1')->name('login.otp.send');
Route::post('/login/otp/verify', [HomeController::class, 'verifyOtp'])->middleware('throttle:10,1')->name('login.otp.verify');

/* ---------- Registration Flow ---------- */

// Step 1: Phone number + client check
Route::get('/register', [RegistrationController::class, 'showForm'])->name('registration.form');
Route::post('/register', [RegistrationController::class, 'submitPhone'])->name('registration.submit');

// Step 2A: Existing client — confirm pre-filled details
Route::get('/register/confirm', [RegistrationController::class, 'showClientConfirm'])->name('registration.client.confirm');
Route::post('/register/confirm', [RegistrationController::class, 'submitClientConfirm'])->name('registration.client.confirm.submit');

// Step 2B: New user — OTP verification
Route::get('/register/otp', [RegistrationController::class, 'showOtp'])->name('registration.otp');
Route::post('/register/otp', [RegistrationController::class, 'verifyOtp'])->name('registration.otp.verify');
Route::post('/register/otp/resend', [RegistrationController::class, 'resendOtp'])->name('registration.otp.resend');

// Step 3: New user — fill details (after OTP)
Route::get('/register/details', [RegistrationController::class, 'showDetails'])->name('registration.details');
Route::post('/register/details', [RegistrationController::class, 'submitDetails'])->name('registration.details.submit');

Route::get('/event-policy', function () {return view('registration.policy'); })->name('event.policy');
Route::get('/payment-terms', function () {return view('registration.payment_terms'); })->name('payment.terms');
Route::get('/cookie-policy', function () {return view('registration.cookie_policy'); })->name('cookie.policy');
Route::get('/disclaimer', function () {return view('registration.disclaimer'); })->name('disclaimer');


Route::middleware(['auth'])->group(function () {
    // Step 5: Payment
    Route::get('/register/payment', [RegistrationController::class, 'showPayment'])->name('registration.payment');
    Route::get('/register/thank-you', [RegistrationController::class, 'thankYou'])->name('registration.thankyou');
    // Step 6: Success
    Route::get('/register/success', [RegistrationController::class, 'success'])->name('registration.success');

    /* ---------- Stalls ---------- */
    Route::get('/stalls', [StallController::class, 'index'])->name('stalls.index');
    Route::get('/stalls/scanner', [StallController::class, 'scanner'])->name('stalls.scanner');
    Route::get('/stalls/scan/{qr_token}', [StallController::class, 'scan'])->name('stalls.scan');
    Route::get('/stalls/{stall}', [StallController::class, 'show'])->name('stalls.show');
    Route::post('/stalls/{stall}/submit', [StallController::class, 'submitFeedback'])->name('stalls.submit');

    /* ---------- Referral ---------- */
    Route::get('/refer', [ReferralController::class, 'index'])->name('referral.index');
    Route::post('/refer', [ReferralController::class, 'invite'])->name('referral.invite');

    /* ---------- Influencer ---------- */
    Route::get('/influencer', [InfluencerController::class, 'index'])->name('influencer.index');
    Route::post('/influencer', [InfluencerController::class, 'submit'])->name('influencer.submit');
});

Route::get('/venue/login', [CheckInController::class, 'showVenueLogin'])->name('venue.login');
Route::post('/venue/login', [CheckInController::class, 'venueLogin'])->name('venue.login.post');
Route::middleware(['venue'])->group(function () {
    Route::get('/checkin/scanner', [CheckInController::class, 'scanner'])->name('checkin.scanner');
    Route::post('/checkin/validate', [CheckInController::class, 'validateQr'])->name('checkin.validate');
    Route::post('/checkin/allocate', [CheckInController::class, 'allocateSeat'])->name('checkin.allocate');
});
/* ---------- Payment Callback ---------- */
Route::post('/payment/callback/{id}', [RegistrationController::class, 'paymentCallback'])->name('payment.callback');
Route::post('/webhook/atom', [PaymentController::class, 'atomWebhook'])->name('webhook.atom');

Route::post('/razor/payment/callback/{id}', [RegistrationController::class, 'razorPaymentCallback'])->name('razor.payment.callback');
Route::post('/razor/payment/webhook', [PaymentController::class, 'razorWebhook'])->name('razor.payment.webhook');

/* ---------- Check-In (Venue Staff) ---------- */
Route::get('/checkin/confirmation', [CheckInController::class, 'mobileConfirmation'])->name('checkin.confirmation');

/* ---------- Admin Routes ---------- */
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->middleware('throttle:5,1')->name('admin.login.submit');
Route::get('/admin/2fa', [AdminAuthController::class, 'show2fa'])->name('admin.2fa');
Route::post('/admin/2fa', [AdminAuthController::class, 'verify2fa'])->name('admin.2fa.submit');

Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/registrations/mark-paid', [AdminController::class, 'markAsPaid'])->name('registrations.mark-paid');
    Route::get('/registrations', [AdminController::class, 'registrations'])->name('registrations');
    Route::get('/checkins', [AdminController::class, 'checkIns'])->name('checkins');
    // Route::get('/stalls', [AdminController::class, 'stalls'])->name('stalls');
    Route::get('/referrals', [AdminController::class, 'referrals'])->name('referrals');
    Route::get('/leaderboard', [AdminController::class, 'leaderboard'])->name('leaderboard');
    Route::get('/influencer', [AdminController::class, 'influencerPosts'])->name('influencer');
    Route::post('/influencer/{post}/approve', [AdminController::class, 'approvePost'])->name('influencer.approve');
    Route::post('/influencer/{post}/reject', [AdminController::class, 'rejectPost'])->name('influencer.reject');
    Route::get('/communications', [AdminController::class, 'communications'])->name('communications');

    Route::resource('stalls', AdminStallController::class);
    Route::prefix('stalls/{stall}')->name('stalls.')->group(function () {
        // Quiz
        Route::post('/quiz', [StallQuizController::class, 'store'])->name('quiz.store');
        Route::put('/quiz', [StallQuizController::class, 'update'])->name('quiz.update');
        Route::post('/quiz/questions', [StallQuizController::class, 'storeQuestion'])->name('quiz.questions.store');
        Route::put('/quiz/questions/{question}', [StallQuizController::class, 'updateQuestion'])->name('quiz.questions.update');
        Route::delete('/quiz/questions/{question}', [StallQuizController::class, 'destroyQuestion'])->name('quiz.questions.destroy');
        // Feedback
        Route::post('/feedback/questions', [StallFeedbackController::class, 'store'])->name('feedback.questions.store');
        Route::put('/feedback/questions/{question}', [StallFeedbackController::class, 'update'])->name('feedback.questions.update');
        Route::delete('/feedback/questions/{question}', [StallFeedbackController::class, 'destroy'])->name('feedback.questions.destroy');

        Route::get('/visits', [AdminStallVisitController::class, 'index'])->name('visits.index');
        Route::get('/visits/{visit}', [AdminStallVisitController::class, 'show'])->name('visits.show');
    });

});

Route::get('/vishal-mehta', [HomeController::class, 'vishal_mehta'])->name('vishal-mehta');
Route::get('/saurabh-sisodia', [HomeController::class, 'saurabh_sisodia'])->name('saurabh-sisodia');
Route::get('/santosh-pasi', [HomeController::class, 'santosh_pasi'])->name('santosh-pasi');
Route::get('/ankit-rai', [HomeController::class, 'ankit_rai'])->name('ankit-rai');
Route::get('/rajesh-shrivastav', [HomeController::class, 'rajesh_shrivastav'])->name('rajesh-shrivastav');
Route::get('/rahul-saroge', [HomeController::class, 'rahul_saroge'])->name('rahul-saroge');
Route::get('/detail', [HomeController::class, 'detail'])->name('detail');