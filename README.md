# ArihantPLUS Event Management System — Laravel Integration Guide

## 🚀 Overview
This module adds a complete event registration, check-in, stall engagement, referral, influencer, and lead-scoring system to your existing Laravel project.

## 📁 File Structure
Drop all files into your Laravel project maintaining the directory structure:

```
app/
  Http/
    Controllers/     → HomeController, RegistrationController, CheckInController, etc.
    Middleware/      → AdminMiddleware.php
  Models/            → EventRegistration, KycDetail, Payment, QrCode, Seat, Stall, StallVisit, Referral, InfluencerPost, LeadScore, Communication
  Services/          → WhatsAppService, EmailService, PaymentGatewayService, QrCodeService, LeadScoringService, SeatAllocationService
  Mail/              → EventConfirmationMail, SeatConfirmationMail
config/
  event.php          → Event config (prices, dates, admin emails, quiz answers)
database/migrations/ → 11 migration files
resources/views/
  layouts/app.blade.php
  index.blade.php (updated)
  registration/      → form, otp, kyc, payment, success
  checkin/           → scanner, confirmation
  stalls/            → index
  referral/          → index
  influencer/        → submit
  admin/             → dashboard, registrations, checkins, stalls, referrals, leaderboard, influencer, communications
  emails/            → confirmation, seat
routes/
  web.php (replace)
```

## ⚙️ Installation Steps

### 1. Copy Files
Copy all folders into your Laravel project root. Overwrite `routes/web.php` and `app/Http/Controllers/HomeController.php`.

### 2. Run Migrations
```bash
php artisan migrate
```

### 3. Seed Seats (run once before event)
```bash
php artisan tinker
>>> (new \App\Services\SeatAllocationService)->seedSeats(500);
```

Or create a seeder:
```php
// database/seeders/SeatSeeder.php
public function run() {
    (new \App\Services\SeatAllocationService)->seedSeats(500);
}
```

### 4. Configure Environment
Add to `.env`:

```env
# WhatsApp (Meta Business API)
WHATSAPP_ACCESS_TOKEN=your_meta_access_token
WHATSAPP_PHONE_NUMBER_ID=your_phone_number_id

# Payment (Razorpay)
RAZORPAY_KEY_ID=your_key_id
RAZORPAY_KEY_SECRET=your_key_secret
RAZORPAY_WEBHOOK_SECRET=your_webhook_secret

# Admin Access
ADMIN_EMAIL=admin@arihantcapital.com

# CRM Integration (optional)
CRM_PUSH_URL=https://your-crm.com/api/leads
CRM_API_KEY=your_crm_key
```

Add to `config/services.php`:
```php
'whatsapp' => [
    'api_url' => env('WHATSAPP_API_URL', 'https://graph.facebook.com/v18.0'),
    'access_token' => env('WHATSAPP_ACCESS_TOKEN'),
    'phone_number_id' => env('WHATSAPP_PHONE_NUMBER_ID'),
],
'payment' => [
    'gateway' => 'razorpay',
    'key_id' => env('RAZORPAY_KEY_ID'),
    'key_secret' => env('RAZORPAY_KEY_SECRET'),
    'webhook_secret' => env('RAZORPAY_WEBHOOK_SECRET'),
],
'crm' => [
    'push_url' => env('CRM_PUSH_URL'),
    'api_key' => env('CRM_API_KEY'),
],
```

### 5. Register Middleware
In `app/Http/Kernel.php` (or `bootstrap/app.php` for Laravel 11+):
```php
'admin' => \App\Http\Middleware\AdminMiddleware::class,
```

### 6. Storage Link
```bash
php artisan storage:link
```

### 7. Queue Worker (for emails)
```bash
php artisan queue:work
```

## 🔄 Registration Flow
1. **Landing Page** (`/`) → "Claim Your Spot" button → `/register`
2. **Registration Form** → submits details → OTP sent via WhatsApp
3. **OTP Verify** → auto-login → redirect to KYC
4. **KYC Form** → uploads PAN, Aadhaar, income proof, photo, signature
5. **Payment Page** → Razorpay checkout → callback verifies signature
6. **Success Page** → shows QR code, sends WhatsApp + Email confirmations
7. **Refer & Earn** → unique code generated, points awarded on paid conversion

## 🎫 Check-In Flow (Venue)
1. Staff opens `/checkin/scanner`
2. Scans participant QR code
3. System validates → allocates seat (first-come-first-serve, pessimistic lock)
4. Sends seat confirmation via WhatsApp + Email
5. Participant sees seat on mobile at `/checkin/confirmation?reg=ARI-2026-XXXX`

## 🏪 Stall Engagement
1. Participant visits stall → staff scans QR
2. System records `StallVisit` with engagement points
3. Participant submits feedback + quiz
4. Lead score recalculated automatically

## 📱 Influencer Activity
1. User submits post URL at `/influencer`
2. Admin reviews at `/admin/influencer` → Approve/Reject
3. Approved posts award 20 points + recalculate lead score

## 📊 Admin Dashboard
Access: `/admin` (restricted to emails in `config/event.php`)
- Real-time stats cards
- Registration list with filters
- Check-in log
- Stall statistics
- Referral & Leaderboard tables
- Influencer approval queue
- Communication log

## 🔧 Commands & Jobs You Should Create

### Automated Reminders (run via cron)
Create `app/Console/Commands/SendEventReminders.php`:
```php
// 2 days before
$regs = EventRegistration::where('status', 'paid')
    ->whereDate('created_at', '<=', now()->subDays(2))
    ->get();
foreach ($regs as $reg) {
    app(WhatsAppService::class)->sendReminder($reg, '2 days');
    app(EmailService::class)->sendReminder($reg, '2 Days to Go!', '...');
}
```

Schedule in `app/Console/Kernel.php`:
```php
$schedule->command('event:reminders')->dailyAt('09:00');
```

### Post-Event Communications
- After 2 hours: Thank you + feedback request
- After 24 hours: Summary + follow-up

## 🔐 Security Notes
- Payment signatures are verified with HMAC SHA256
- QR codes are 32-char SHA256 hashes, unique per registration
- Seat allocation uses `lockForUpdate()` to prevent double allocation
- Admin routes protected by email whitelist middleware
- File uploads restricted to PDF/JPG/PNG with size limits

## 📦 Dependencies to Install
```bash
composer require razorpay/razorpay  # if using their SDK instead of HTTP
# OR keep using Laravel HTTP client (no extra package needed)

# For QR generation (optional, currently using API)
composer require endroid/qr-code
```

## 🎨 Frontend Notes
- All views use the same dark theme as your existing landing page
- `layouts/app.blade.php` includes the sticky header with logo
- Responsive design included
- No external CSS framework required (pure CSS custom properties)

## 🐛 Troubleshooting

**WhatsApp messages not sending?**
→ Check `WHATSAPP_ACCESS_TOKEN` and `WHATSAPP_PHONE_NUMBER_ID`. Messages are logged in `communications` table as "queued" if credentials missing.

**Payment callback failing?**
→ Ensure `RAZORPAY_KEY_SECRET` is correct. Check `payments` table for order records.

**Seats not allocating?**
→ Run seat seeder. Check `seats` table has rows with `status = 'available'`.

**QR images not showing?**
→ Run `php artisan storage:link`. Check `storage/app/public/qrcodes/`.

## ✅ Checklist Before Going Live
- [ ] Meta WhatsApp Business API approved & template messages configured
- [ ] Razorpay webhook URL set to `https://yourdomain.com/payment/webhook`
- [ ] SMTP configured for Laravel Mail
- [ ] Admin email added to `ADMIN_EMAIL` env
- [ ] Seat seeder executed
- [ ] Stall records created in `stalls` table
- [ ] Queue worker running for emails
- [ ] SSL certificate active (required for Razorpay)

---
Built for Arihant Capital Markets Ltd. | ArihantPLUS AI & Algo Conclave 2026
