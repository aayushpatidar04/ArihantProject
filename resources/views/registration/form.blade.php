@extends('layouts.app')

@section('title', 'Register — ArihantPLUS Conclave 2026')

@push('styles')
<style>
    .reg-page{min-height:100vh;padding:100px 24px 60px;background:linear-gradient(180deg,#060208 0%,#0a0410 55%,#12081d 100%);position:relative;overflow:hidden}
    .reg-card{max-width:460px;margin:0 auto;background:linear-gradient(165deg,#170b22 0%,#0b0511 65%,#0a0410 100%);border:1px solid rgba(255,255,255,0.08);border-radius:26px;padding:48px 36px;box-shadow:0 40px 90px rgba(0,0,0,0.6);position:relative;z-index:2;text-align:center}
    .reg-card h1{font-family:'Sora',sans-serif;font-size:28px;font-weight:700;margin-bottom:8px}
    .reg-card .subtitle{color:var(--muted);font-size:14px;margin-bottom:36px}
    .phone-wrap{display:flex;align-items:center;background:rgba(255,255,255,0.055);border:1px solid rgba(255,255,255,0.1);border-radius:14px;padding:4px;margin-bottom:24px}
    .phone-prefix{padding:0 14px;color:var(--muted);font-size:15px;font-weight:600;border-right:1px solid rgba(255,255,255,0.1)}
    .phone-wrap input{flex:1;background:transparent;border:none;padding:14px 16px;color:var(--ink);font-size:16px;font-family:'Inter',sans-serif;outline:none}
    .phone-wrap input::placeholder{color:rgba(230,220,240,0.35)}
    .phone-wrap:focus-within{border-color:rgba(184,102,247,0.55)}
    .hint{color:var(--muted-2);font-size:12px;margin-top:16px}
    .btn-loading{opacity:0.6;cursor:not-allowed;pointer-events:none}
    .btn-spinner{display:inline-block;width:14px;height:14px;border:2px solid rgba(255,255,255,0.3);border-top-color:#fff;border-radius:50%;animation:spin 0.6s linear infinite;margin-right:8px;vertical-align:middle}
    @keyframes spin{to{transform:rotate(360deg)}}
    @media(max-width:480px){.reg-card{padding:32px 22px;border-radius:22px}}
</style>
@endpush

@section('content')
<div class="reg-page">
    <div class="reg-card">
        <h1>Get Started</h1>
        <p class="subtitle">Enter your mobile number to check your eligibility</p>

        @if($errors->any())
            <div class="alert alert-error" style="margin-bottom:20px">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('registration.submit') }}" method="POST" id="phoneForm">
            @csrf
            <div class="phone-wrap">
                <span class="phone-prefix">+91</span>
                <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="10-digit mobile number" maxlength="10" inputmode="numeric" pattern="[0-9]{10}" required autofocus>
            </div>
            <button type="submit" class="btn btn-primary" id="submitBtn" style="width:100%">
                <span class="btn-text">Continue</span>
            </button>
        </form>

        <p class="hint" id="hintText">We will verify your number via WhatsApp & SMS.</p>
        <p class="hint">Already Registered? <a href="/login" style="color: white;">Login</a></p>
    </div>
</div>

<script>
document.getElementById('phoneForm').addEventListener('submit', function(e) {
    const btn = document.getElementById('submitBtn');
    const btnText = btn.querySelector('.btn-text');
    const hint = document.getElementById('hintText');

    // Disable button and show loading state
    btn.classList.add('btn-loading');
    btnText.innerHTML = '<span class="btn-spinner"></span>Sending OTP...';

    // Update hint
    if (hint) {
        hint.textContent = 'Please wait while we send your verification code...';
    }

    // Allow form to submit normally
});
</script>
@endsection