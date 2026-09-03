# Intended Redirect Feature - Testing Guide

## 🎯 Overview
Your Laravel project now implements the **Intended Redirect** feature. When a logged-out user tries to access a protected page (like `/register/payment`), they're redirected to login. After successfully logging in, they're automatically redirected back to the page they originally tried to access—instead of being sent to the default home page.

---

## 🧪 How to Test This Feature

### Test Case 1: Regular User Registration Payment Flow
**Scenario**: User tries to access payment page without login

**Steps**:
1. Open your browser and go to: `http://your-app/register/payment`
2. Since you're not logged in, you'll be redirected to: `/login`
3. Notice in the browser console or session storage that `url.intended` contains `/register/payment`
4. Enter your phone number and verify the OTP
5. After successful login, you should be **automatically redirected to `/register/payment`**
   - ✅ NOT to the home page
   - ✅ NOT to the default redirect location

### Test Case 2: Admin Panel Access
**Scenario**: Admin tries to access admin dashboard without login

**Steps**:
1. Navigate to: `http://your-app/admin`
2. You'll be redirected to: `/admin/login`
3. Complete the admin login (email + password)
4. Verify 2FA OTP
5. After login, you should be redirected back to `/admin` (or the specific admin page you tried to access)

### Test Case 3: Influencer Dashboard Access
**Scenario**: Influencer tries to access dashboard without login

**Steps**:
1. Navigate to: `http://your-app/influencer/dashboard`
2. You'll be redirected to: `/influencer/login`
3. Complete the influencer login (email + password)
4. Verify OTP
5. After login, you should be redirected to `/influencer/dashboard`

### Test Case 4: Verify Session Storage
**To verify that intended URL is being stored**:

1. Open your browser's Developer Tools (F12)
2. Go to Application → Cookies or Storage
3. Look for your Laravel session cookie (usually `LARAVEL_SESSION`)
4. Or check the server logs by adding this to a middleware:
   ```php
   \Log::info('Intended URL: ' . session('url.intended'));
   ```

---

## 🔍 How It Works Under the Hood

### The Three Key Files

#### 1. **Custom Authenticate Middleware** (`app/Http/Middleware/Authenticate.php`)
```php
// When user tries to access protected route without login:
session(['url.intended' => $request->fullUrl()]);
return redirect()->route('login');
```
- Intercepts unauthenticated requests to protected routes
- Stores the current URL in the session under `url.intended`
- Redirects to login page

#### 2. **Login Controller** (`app/Http/Controllers/HomeController.php`)
```php
// After OTP verification in verifyOtp():
Auth::login($user);
return redirect()->intended(route('index'));
```
- Logs in the user
- Uses `redirect()->intended()` which:
  - Checks for `url.intended` in session
  - If found: redirects to that URL
  - If not found: redirects to the fallback route (home page)
- Automatically clears the intended URL from session

#### 3. **AdminAuthController & InfluencerAuthController**
- Both follow the same pattern
- Store and redirect using `redirect()->intended()`
- With appropriate fallback routes

---

## 🔐 Security Considerations

✅ **Session-based storage**: URL is stored in the server session, not in cookies
✅ **Automatic cleanup**: `redirect()->intended()` automatically removes `url.intended` after use
✅ **Validation**: Admin redirects only to admin routes (`str_starts_with($redirect, '/admin')`)
✅ **Fallback routes**: If intended URL is invalid, uses safe default routes

---

## 🎨 Customization

### Change the Fallback Route
If you want to redirect to a different page instead of the home page when there's no intended URL:

**In `HomeController::verifyOtp()`**:
```php
// Change this:
return redirect()->intended(route('index'));

// To this (example):
return redirect()->intended(route('registration.form'));
```

### Disable Intended Redirect for Specific Routes
If you want certain routes to always redirect to the same place (no intended redirect), don't use the `auth` middleware. Create a custom redirect instead:

```php
// Instead of using middleware('auth')
Route::middleware('custom-auth')->group(function () {
    // Your routes here
});
```

### Add Logging for Debugging
In `HomeController::verifyOtp()`:
```php
$intendedUrl = session()->pull('url.intended');
\Log::info('User redirecting to: ' . ($intendedUrl ?? 'default route'));
return redirect()->intended(route('index'));
```

---

## 🚨 Troubleshooting

### Problem: User not being redirected to intended URL

**Check list**:
1. Verify the middleware is registered in `bootstrap/app.php`:
   ```php
   'auth' => \App\Http\Middleware\Authenticate::class,
   ```

2. Verify the route has the `auth` middleware:
   ```php
   Route::middleware(['auth'])->group(function () {
       Route::get('/register/payment', ...);
   });
   ```

3. Check that `redirect()->intended()` is used in the login controller:
   ```php
   return redirect()->intended(route('index'));
   ```

4. Look at server logs for any errors during login

### Problem: "Too many redirects" error

This usually means:
- The intended URL is being stored but the login route also requires authentication
- Solution: Make sure your login routes are NOT protected by the `auth` middleware

**In `routes/web.php`**:
```php
// ✅ CORRECT: Login routes not protected
Route::get('/login', [HomeController::class, 'showLogin'])->name('login');
Route::post('/login/otp/verify', [HomeController::class, 'verifyOtp'])->name('login.otp.verify');

// ✅ CORRECT: Payment route IS protected
Route::middleware(['auth'])->group(function () {
    Route::get('/register/payment', [RegistrationController::class, 'showPayment'])->name('registration.payment');
});
```

---

## 📝 Related Files Modified

- `app/Http/Middleware/Authenticate.php` - **NEW** (custom middleware)
- `app/Http/Middleware/AdminMiddleware.php` - Updated
- `app/Http/Middleware/InfluencerMiddleware.php` - Updated
- `app/Http/Controllers/AdminAuthController.php` - Updated
- `bootstrap/app.php` - Updated (registered middleware)

---

## ✨ Features

- ✅ Works with all three auth flows (Regular, Admin, Influencer)
- ✅ Automatic cleanup of session data
- ✅ Safe fallback routes
- ✅ Session-based (not URL-based) for security
- ✅ Backward compatible with existing code
- ✅ Built on Laravel's native `redirect()->intended()` method

---

## 📚 Laravel Documentation

Learn more about intended redirects:
- https://laravel.com/docs/routing#intended-requests
- https://laravel.com/docs/authentication

---

**Need help?** Check the repository memory file: `intended-redirect-implementation.md`
