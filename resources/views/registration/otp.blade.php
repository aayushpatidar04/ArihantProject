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
    .resend{color:var(--muted);font-size:13px;margin-top:16px}
    .resend a{color:var(--purple-1);font-weight:600}
</style>
@endpush

@section('content')
<div class="otp-page">
    <div class="otp-card">
        <h1>Verify WhatsApp</h1>
        <p>We've sent a 6-digit OTP to your WhatsApp number. Enter it below to continue.</p>

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

        <form action="{{ route('registration.otp.resend') }}" method="POST" style="margin-top:16px">
            @csrf
            <button type="submit" class="resend" style="background:none;border:none;cursor:pointer">Didn't receive? <a href="#" onclick="this.closest('form').submit();return false;">Resend OTP</a></button>
        </form>
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
</script>
@endsection
