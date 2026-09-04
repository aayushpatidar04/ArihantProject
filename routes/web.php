<?php

use App\Http\Controllers\Admin\StallController as AdminStallController;
use App\Http\Controllers\Admin\AdminStallVisitController;
use App\Http\Controllers\Admin\StallQuizController;
use App\Http\Controllers\Admin\StallFeedbackController;
use App\Http\Controllers\Admin\AdminPermissionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\StallController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\InfluencerAuthController;
use App\Http\Controllers\InfluencerController;
use App\Http\Controllers\Admin\InfluencerAdminController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\EventFeedbackController;
use App\Http\Controllers\WaitlistController;
use Illuminate\Support\Facades\Route;

/* ---------- Public Routes ---------- */
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::post('/logout', [HomeController::class, 'logout'])->name('logout');

Route::get('/login', [HomeController::class, 'showLogin'])->name('login');
Route::post('/login/otp/send', [HomeController::class, 'sendOtp'])->middleware('throttle:5,1')->name('login.otp.send');
Route::post('/login/otp/verify', [HomeController::class, 'verifyOtp'])->middleware('throttle:10,1')->name('login.otp.verify');

Route::get('/join-waitlist', [WaitlistController::class, 'create'])->name('waitlist.create');
Route::post('/join-waitlist', [WaitlistController::class, 'store'])->name('waitlist.store');


Route::prefix('influencer')->name('influencer.')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('/login', [InfluencerAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [InfluencerAuthController::class, 'login'])->name('login.submit');
        Route::get('/verify-otp', [InfluencerAuthController::class, 'showOtp'])->name('otp');
        Route::post('/verify-otp', [InfluencerAuthController::class, 'verifyOtp'])->name('otp.verify');
        Route::post('/resend-otp', [InfluencerAuthController::class, 'resendOtp'])->name('otp.resend');
    });
});
/* ---------- Registration Flow ---------- */

// Step 1: Phone number + client check
// Route::get('/register', [RegistrationController::class, 'showForm'])->name('registration.form');
Route::get('/register', function () {return view('registration.closed'); })->name('registration.form');
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

Route::get('/event-policy', function () {
    return view('registration.policy');
})->name('event.policy');
Route::get('/payment-terms', function () {
    return view('registration.payment_terms');
})->name('payment.terms');
Route::get('/cookie-policy', function () {
    return view('registration.cookie_policy');
})->name('cookie.policy');
Route::get('/disclaimer', function () {
    return view('registration.disclaimer');
})->name('disclaimer');


Route::middleware(['auth'])->group(function () {
    // Step 5: Payment
    Route::get('/register/payment', [RegistrationController::class, 'showPayment'])->name('registration.payment');
    Route::post('/registration/check-promo', [RegistrationController::class, 'checkPromo'])->name('registration.check-promo');
    // Route::post('/registration/payment/create-order', [RegistrationController::class, 'createPaymentOrder'])->name('registration.payment.create-order');
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

    Route::get('/feedback', [EventFeedbackController::class, 'create'])->name('event.feedback');
    Route::post('/event-feedback', [EventFeedbackController::class, 'store'])->name('event.feedback.store');

});

Route::get('/venue/login', [CheckInController::class, 'showVenueLogin'])->name('venue.login');
Route::post('/venue/login', [CheckInController::class, 'venueLogin'])->name('venue.login.post');
Route::middleware(['venue'])->group(function () {
    Route::get('/checkin/scanner', [CheckInController::class, 'scanner'])->name('checkin.scanner');
    Route::post('/checkin/validate', [CheckInController::class, 'validateQr'])->name('checkin.validate');
    Route::post('/checkin/allocate', [CheckInController::class, 'allocateSeat'])->name('checkin.allocate');

    Route::get('/checkout/scanner', [CheckOutController::class, 'scanner'])->name('checkout.scanner');
    Route::post('/checkout/validate', [CheckOutController::class, 'validateQr'])->name('checkout.validate');
    Route::post('/checkout', [CheckOutController::class, 'checkOut'])->name('checkout.perform');
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

// Permission management (super admins only)
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/permissions', [AdminPermissionController::class, 'index'])->name('permissions.index');
    Route::post('/permissions/{admin}', [AdminPermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/{admin}/edit-data', [AdminPermissionController::class, 'editData'])->name('permissions.edit-data');
});

Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard — view only
    Route::get('/', [AdminController::class, 'dashboard'])
        ->middleware('permission:dashboard,view')
        ->name('dashboard');

    // Registrations — view + mark-paid action
    Route::get('/registrations', [AdminController::class, 'registrations'])
        ->middleware('permission:registrations,view')
        ->name('registrations');
    Route::post('/registrations/mark-paid', [AdminController::class, 'markAsPaid'])
        ->middleware('permission:registrations,edit')
        ->name('registrations.mark-paid');
    Route::get('/export', [AdminController::class, 'export'])
        ->middleware('permission:registrations,export')
        ->name('export');

    // Check-Ins
    Route::get('/checkins', [AdminController::class, 'checkIns'])
        ->middleware('permission:checkins,view')
        ->name('checkins');

    // Event Feedback
    Route::get('/event-feedback', [AdminController::class, 'eventFeedback'])
        ->middleware('permission:event-feedback,view')
        ->name('event-feedback');

    // Referrals
    Route::get('/referrals', [AdminController::class, 'referrals'])
        ->middleware('permission:referrals,view')
        ->name('referrals');

    // Leaderboard
    Route::get('/leaderboard', [AdminController::class, 'leaderboard'])
        ->middleware('permission:leaderboard,view')
        ->name('leaderboard');

    // Communications — view only
    Route::get('/communications', [AdminController::class, 'communications'])
        ->middleware('permission:communications,view')
        ->name('communications');

    /* ---------- Influencers ---------- */
    Route::prefix('influencers')
        ->name('influencers.')
        ->middleware('permission:influencers,view')
        ->group(function () {
            Route::get('/', [InfluencerAdminController::class, 'index'])->name('index');
            Route::get('/create', [InfluencerAdminController::class, 'create'])
                ->middleware('permission:influencers,create')
                ->name('create');
            Route::post('/', [InfluencerAdminController::class, 'store'])
                ->middleware('permission:influencers,create')
                ->name('store');
            Route::get('/{user}', [InfluencerAdminController::class, 'show'])->name('show');
            Route::get('/{user}/edit', [InfluencerAdminController::class, 'edit'])
                ->middleware('permission:influencers,edit')
                ->name('edit');
            Route::put('/{user}', [InfluencerAdminController::class, 'update'])
                ->middleware('permission:influencers,edit')
                ->name('update');
            Route::delete('/{user}', [InfluencerAdminController::class, 'destroy'])
                ->middleware('permission:influencers,delete')
                ->name('destroy');

            Route::post('/influencer-posts/{post}/approve', [InfluencerAdminController::class, 'approvePost'])
                ->middleware('permission:influencers,edit')
                ->name('posts.approve');
            Route::post('/influencer-posts/{post}/reject', [InfluencerAdminController::class, 'rejectPost'])
                ->middleware('permission:influencers,edit')
                ->name('posts.reject');
        });

    /* ---------- Stalls ---------- */
    Route::resource('stalls', AdminStallController::class)
        ->middleware('permission:stalls,view')
        ->parameters(['stalls' => 'stall']);

    Route::prefix('stalls/{stall}')->name('stalls.')->group(function () {
        // Quiz — create/edit/delete permissions
        Route::post('/quiz', [StallQuizController::class, 'store'])
            ->middleware('permission:stalls,create')
            ->name('quiz.store');
        Route::put('/quiz', [StallQuizController::class, 'update'])
            ->middleware('permission:stalls,edit')
            ->name('quiz.update');
        Route::post('/quiz/questions', [StallQuizController::class, 'storeQuestion'])
            ->middleware('permission:stalls,create')
            ->name('quiz.questions.store');
        Route::put('/quiz/questions/{question}', [StallQuizController::class, 'updateQuestion'])
            ->middleware('permission:stalls,edit')
            ->name('quiz.questions.update');
        Route::delete('/quiz/questions/{question}', [StallQuizController::class, 'destroyQuestion'])
            ->middleware('permission:stalls,delete')
            ->name('quiz.questions.destroy');
        // Feedback
        Route::post('/feedback/questions', [StallFeedbackController::class, 'store'])
            ->middleware('permission:stalls,create')
            ->name('feedback.questions.store');
        Route::put('/feedback/questions/{question}', [StallFeedbackController::class, 'update'])
            ->middleware('permission:stalls,edit')
            ->name('feedback.questions.update');
        Route::delete('/feedback/questions/{question}', [StallFeedbackController::class, 'destroy'])
            ->middleware('permission:stalls,delete')
            ->name('feedback.questions.destroy');

        Route::get('/visits', [AdminStallVisitController::class, 'index'])
            ->middleware('permission:stalls,view')
            ->name('visits.index');
        Route::get('/visits/{visit}', [AdminStallVisitController::class, 'show'])
            ->middleware('permission:stalls,view')
            ->name('visits.show');
    });

});

Route::prefix('influencer')
    ->name('influencer.')
    ->middleware(['auth', 'influencer'])
    ->group(function () {

        Route::get('/dashboard', [InfluencerController::class, 'dashboard'])->name('dashboard');
        Route::get('/posts', [InfluencerController::class, 'posts'])->name('posts.index');
        Route::get('/posts/create', [InfluencerController::class, 'createPost'])->name('posts.create');
        Route::post('/posts', [InfluencerController::class, 'storePost'])->name('posts.store');
        Route::post('/logout', [InfluencerController::class, 'logout'])->name('logout');
    });

Route::get('/vishal-mehta', [HomeController::class, 'vishal_mehta'])->name('vishal-mehta');
Route::get('/saurabh-sisodia', [HomeController::class, 'saurabh_sisodia'])->name('saurabh-sisodia');
Route::get('/santosh-pasi', [HomeController::class, 'santosh_pasi'])->name('santosh-pasi');
// Route::get('/ankit-rai', [HomeController::class, 'ankit_rai'])->name('ankit-rai');
Route::get('/rajesh-shrivastav', [HomeController::class, 'rajesh_shrivastav'])->name('rajesh-shrivastav');
Route::get('/rahul-saroge', [HomeController::class, 'rahul_saroge'])->name('rahul-saroge');
Route::get('/nikhil-bhandari', [HomeController::class, 'nikhil_bhandari'])->name('nikhil-bhandari');
Route::get('/detail', [HomeController::class, 'detail'])->name('detail');
