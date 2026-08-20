@extends('layouts.app')

@section('title', 'Your Details — ArihantPLUS')

@push('styles')
<style>
    .reg-page{min-height:100vh;padding:80px 24px 60px;background:var(--bg)}
    .reg-card{max-width:520px;margin:0 auto;background:linear-gradient(165deg,#170b22 0%,#0b0511 100%);border:1px solid rgba(255,255,255,0.08);border-radius:26px;padding:42px 36px}
    .reg-card h1{font-size:26px;font-weight:700;margin-bottom:8px}
    .reg-card .subtitle{color:var(--muted);font-size:14px;margin-bottom:32px}
    .form-group{margin-bottom:20px}
    .form-group label{display:block;font-size:13px;font-weight:600;margin-bottom:8px;color:#e9e4f0}
    .form-group input,.form-group select{width:100%;background:rgba(255,255,255,0.055);border:1px solid rgba(255,255,255,0.1);border-radius:14px;padding:14px 16px;color:var(--ink);font-size:14px;font-family:'Inter',sans-serif;outline:none;transition:border-color .2s}
    .form-group input:focus,.form-group select:focus{border-color:rgba(184,102,247,0.55)}
    .form-group input::placeholder{color:rgba(230,220,240,0.35)}
    .type-select{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:24px}
    .type-option{padding:16px;border-radius:14px;background:rgba(255,255,255,0.03);border:2px solid transparent;text-align:center;cursor:pointer;transition:all .2s}
    .type-option:hover{background:rgba(255,255,255,0.05)}
    .type-option.active{background:rgba(184,102,247,0.1);border-color:var(--purple-1)}
    .type-option .icon{font-size:24px;margin-bottom:6px}
    .type-option .lbl{font-size:14px;font-weight:600}
    .type-option .sub{font-size:12px;color:var(--muted);margin-top:2px}
    @media(max-width:480px){.reg-card{padding:28px 22px}}
</style>
@endpush

@section('content')
<div class="reg-page">
    <div class="reg-card">
        <h1>Tell Us About You</h1>
        <p class="subtitle">Complete your profile to secure your spot at the conclave.</p>

        @if($errors->any())
            <div class="alert alert-error" style="margin-bottom:20px">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('registration.details.submit') }}" method="POST" id="detailsForm">
            @csrf
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Enter your full name" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
            </div>
            <div class="form-group">
                <label>City</label>
                <input type="text" name="city" value="{{ old('city') }}" placeholder="Your city" required>
            </div>

            <label style="display:block;font-size:13px;font-weight:600;margin-bottom:10px;color:#e9e4f0">I am a</label>
            <div class="type-select">
                <div class="type-option active" onclick="selectType('investor', this)">
                    <div class="icon">📈</div>
                    <div class="lbl">Investor</div>
                    <div class="sub">Long-term wealth</div>
                </div>
                <div class="type-option" onclick="selectType('trader', this)">
                    <div class="icon">⚡</div>
                    <div class="lbl">Trader</div>
                    <div class="sub">Active markets</div>
                </div>
            </div>
            <input type="hidden" name="type" id="userType" value="investor">

            <div class="form-group">
                <label>Create Password</label>
                <input type="password" name="password" placeholder="Min 8 characters" required>
            </div>

            @if(request('ref'))
                <input type="hidden" name="referred_by" value="{{ request('ref') }}">
            @endif

            <button type="submit" class="btn btn-primary" style="width:100%">Continue → KYC</button>
        </form>
    </div>
</div>

<script>
function selectType(type, el) {
    document.querySelectorAll('.type-option').forEach(o => o.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('userType').value = type;
}
</script>
@endsection
