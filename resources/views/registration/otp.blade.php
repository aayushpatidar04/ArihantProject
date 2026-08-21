@extends('layouts.app')

@section('title', 'Verify OTP — ArihantPLUS')

@push('styles')
<style>
    .otp-page{min-height:100vh;padding:100px 24px 60px;background:var(--bg);text-align:center}
    .otp-card{max-width:420px;margin:0 auto;background:linear-gradient(165deg,#170b22 0%,#0b0511 100%);border:1px solid rgba(255,255,255,0.08);border-radius:26px;padding:48px 36px}
    .otp-card h1{font-size:26px;font-weight:700;margin-bottom:12px}
    .otp-card p{color:var(--muted);font-size:14px;margin-bottom:32px}
    .otp-inputs{display:flex;gap:10px;justify-content:center;margin-bottom:28px}
    .otp-inputs input{width:52px;height:58px;text-align:center;font-size:24px;font-weight:700;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);border-radius:14px;color:#fff;outline:none;transition:border-color .2s}
    .otp-inputs input:focus{border-color:var(--purple-1)}
    
    .resend-wrap{margin-top:20px;font-size:13px}
    .resend-wrap .countdown{color:#7c7188}
    .resend-wrap .countdown span{font-variant-numeric:tabular-nums;color:#b866f7;font-weight:600}
    .resend-btn{display:inline-flex;align-items:center;gap:6px;background:none;border:none;color:var(--purple-1);font-weight:600;cursor:pointer;font-size:13px;padding:0;text-decoration:none}
    .resend-btn:disabled{color:#4a3f5c;cursor:not-allowed}
    .resend-btn svg{width:14px;height:14px}
</style>
@endpush

@section('content')
<div class="otp-page">
    <div class="otp-card">
        <h1>Verify Number</h1>
        <p>We've sent a 6-digit OTP to your number. Enter it below to continue.</p>

        @if(session('resent'))
            <div class="alert alert-success" style="margin-bottom:20px">OTP resent successfully!</div>
        @endif

        @if($errors->any())
            <div class="alert alert-error" style="margin-bottom:20px">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('registration.otp.verify') }}" method="POST" id="otpForm">
            @csrf
            <div class="otp-inputs">
                <input type="text" maxlength="1" inputmode="numeric" oninput="moveNext(this, 0)" onkeydown="moveBack(event, 0)">
                <input type="text" maxlength="1" inputmode="numeric" oninput="moveNext(this, 1)" onkeydown="moveBack(event, 1)">
                <input type="text" maxlength="1" inputmode="numeric" oninput="moveNext(this, 2)" onkeydown="moveBack(event, 2)">
                <input type="text" maxlength="1" inputmode="numeric" oninput="moveNext(this, 3)" onkeydown="moveBack(event, 3)">
                <input type="text" maxlength="1" inputmode="numeric" oninput="moveNext(this, 4)" onkeydown="moveBack(event, 4)">
                <input type="text" maxlength="1" inputmode="numeric" oninput="moveNext(this, 5)" onkeydown="moveBack(event, 5)">
            </div>
            <input type="hidden" name="otp" id="otpValue">
            <button type="submit" class="btn btn-primary" style="width:100%" onclick="combineOtp()">Verify & Continue</button>
        </form>

        <form action="{{ route('registration.otp.resend') }}" method="POST" id="resendForm" style="display:none">
            @csrf
        </form>

        <div class="resend-wrap" id="resendWrap">
            <div class="countdown" id="countdown">Resend available in <span id="timer">00:40</span></div>
            <button type="button" class="resend-btn" id="resendBtn" onclick="document.getElementById('resendForm').submit()" disabled style="display:none">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                Resend OTP
            </button>
        </div>
    </div>
</div>

<script>
const inputs = document.querySelectorAll('.otp-inputs input');
function moveNext(el, idx) {
    el.value = el.value.replace(/\D/g, '');
    if (el.value && idx < inputs.length - 1) inputs[idx + 1].focus();
}
function moveBack(e, idx) {
    if (e.key === 'Backspace' && !e.target.value && idx > 0) inputs[idx - 1].focus();
}
function combineOtp() {
    let otp = '';
    inputs.forEach(i => otp += i.value);
    document.getElementById('otpValue').value = otp;
}
inputs[0].focus();

/* ---- Resend Countdown ---- */
const COOLDOWN = 40; // seconds
const STORAGE_KEY = 'otp_resend_until';

function startTimer() {
    const now = Math.floor(Date.now() / 1000);
    let until = parseInt(sessionStorage.getItem(STORAGE_KEY)) || 0;

    // If no timer stored (first load), start fresh
    if (!until || until < now) {
        until = now + COOLDOWN;
        sessionStorage.setItem(STORAGE_KEY, until);
    }

    const timerEl = document.getElementById('timer');
    const countdownEl = document.getElementById('countdown');
    const resendBtn = document.getElementById('resendBtn');

    function tick() {
        const remaining = until - Math.floor(Date.now() / 1000);

        if (remaining <= 0) {
            sessionStorage.removeItem(STORAGE_KEY);
            countdownEl.style.display = 'none';
            resendBtn.style.display = 'inline-flex';
            resendBtn.disabled = false;
            return;
        }

        const m = String(Math.floor(remaining / 60)).padStart(2, '0');
        const s = String(remaining % 60).padStart(2, '0');
        timerEl.textContent = `${m}:${s}`;
        requestAnimationFrame(() => setTimeout(tick, 1000));
    }

    tick();
}

startTimer();
</script>
@endsection