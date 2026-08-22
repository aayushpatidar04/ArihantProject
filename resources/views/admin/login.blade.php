@extends('layouts.app')

@section('title', 'Admin Login - ArihantPLUS')

@push('styles')
<style>
    .admin-login-page{min-height:100vh;padding:72px 24px;background:radial-gradient(circle at 50% 20%,rgba(184,102,247,.12),transparent 42%),var(--bg);display:flex;align-items:center;justify-content:center}
    .admin-login-card{width:100%;max-width:440px;padding:42px 36px;background:linear-gradient(165deg,#170b22 0%,#0b0511 100%);border:1px solid rgba(255,255,255,.09);border-radius:18px;box-shadow:0 24px 70px rgba(0,0,0,.35)}
    .admin-login-kicker{color:var(--purple-1);font-size:12px;font-weight:700;letter-spacing:1.6px;text-transform:uppercase;margin-bottom:12px}
    .admin-login-card h1{font-size:30px;margin-bottom:8px}
    .admin-login-copy{color:var(--muted);font-size:14px;line-height:1.6;margin-bottom:28px}
    .admin-login-field{margin-bottom:18px}
    .admin-login-field label{display:block;color:#e9e4f0;font-size:13px;font-weight:600;margin-bottom:8px}
    .admin-login-field input{width:100%;padding:13px 14px;background:rgba(255,255,255,.055);border:1px solid rgba(255,255,255,.1);border-radius:10px;color:var(--ink);font:14px 'Inter',sans-serif;outline:none}
    .admin-login-field input:focus{border-color:rgba(184,102,247,.7)}
    .admin-login-remember{display:flex;align-items:center;gap:8px;color:var(--muted);font-size:13px;margin:4px 0 22px}
    .admin-login-remember input{accent-color:var(--purple-1)}
    @media(max-width:480px){.admin-login-card{padding:32px 24px}.admin-login-card h1{font-size:26px}}
</style>
@endpush

@section('content')
<div class="admin-login-page">
    <div class="admin-login-card">
        <div class="admin-login-kicker">ArihantPLUS Control Center</div>
        <h1>Admin sign in</h1>
        <p class="admin-login-copy">Sign in with your authorized admin account to manage registrations, check-ins, stalls, referrals, and communications.</p>

        @if($errors->any())
            <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <input type="hidden" name="redirect" value="{{ old('redirect', $redirect) }}">
            <div class="admin-login-field">
                <label for="admin-email">Email address</label>
                <input id="admin-email" type="email" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
            </div>
            <div class="admin-login-field">
                <label for="admin-password">Password</label>
                <input id="admin-password" type="password" name="password" autocomplete="current-password" required>
            </div>
            <label class="admin-login-remember"><input type="checkbox" name="remember" value="1"> Keep me signed in</label>
            <button type="submit" class="btn btn-primary" style="width:100%">Sign in to admin</button>
        </form>
    </div>
</div>
@endsection