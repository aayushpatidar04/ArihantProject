@extends('layouts.app')

@section('title', 'Verify Login — ArihantPLUS')

@push('styles')

    <style>
        .influencer-auth {
            min-height: 100vh;
            padding: 80px 24px;
            background: var(--bg);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-card {
            width: 100%;
            max-width: 440px;
            background: linear-gradient(160deg,
                    rgba(22, 12, 30, 0.95),
                    rgba(8, 4, 12, 0.98));
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 22px;
            padding: 34px;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .auth-icon {
            width: 58px;
            height: 58px;
            border-radius: 16px;
            margin: 0 auto 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(184, 102, 247, 0.12);
            color: var(--purple-1);
            font-size: 24px;
        }

        .auth-header h1 {
            font-size: 26px;
            margin-bottom: 8px;
        }

        .auth-header p {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            margin-bottom: 8px;
            color: #ded7e6;
        }

        .form-control {
            width: 100%;
            padding: 14px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.04);
            color: var(--ink);
            outline: none;
            text-align: center;
            font-size: 22px;
            letter-spacing: 8px;
        }

        .form-control:focus {
            border-color: rgba(184, 102, 247, 0.6);
        }

        .auth-btn {
            width: 100%;
        }

        .auth-error {
            color: #ffaaaa;
            font-size: 12px;
            margin-top: 6px;
        }

        .resend-wrap {
            margin-top: 20px;
            text-align: center;
        }

        .resend-wrap p {
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 8px;
        }

        .resend-btn {
            border: 0;
            background: transparent;
            color: var(--purple-1);
            font-size: 13px;
            cursor: pointer;
            padding: 0;
        }

        .resend-btn:hover {
            text-decoration: underline;
        }

        .back-login {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: var(--muted);
            font-size: 13px;
            text-decoration: none;
        }

        .back-login:hover {
            color: var(--purple-1);
        }
    </style>

@endpush

@section('content')

    <div class="influencer-auth">

        <div class="auth-card">

            <div class="auth-header">

                <div class="auth-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>

                <h1>Verify Your Login</h1>

                <p>
                    We've sent a 6-digit verification code to your
                    registered email address.
                </p>

            </div>

            @if(session('success'))

                <div class="alert alert-success mb-3">
                    {{ session('success') }}
                </div>

            @endif

            @if($errors->any())

                <div class="alert alert-error mb-3">
                    {{ $errors->first() }}
                </div>

            @endif

            <form method="POST" action="{{ route('influencer.otp.verify') }}">

                @csrf

                <div class="form-group">

                    <label for="otp">
                        Verification Code
                    </label>

                    <input type="text" id="otp" name="otp" class="form-control" inputmode="numeric"
                        autocomplete="one-time-code" maxlength="6" pattern="[0-9]{6}" placeholder="000000" required
                        autofocus>

                    @error('otp')

                        <div class="auth-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

                <button type="submit" class="btn btn-primary auth-btn">
                    Verify & Login
                </button>

            </form>

            <div class="resend-wrap">

                <p>
                    Didn't receive the code?
                </p>

                <form method="POST" action="{{ route('influencer.otp.resend') }}">

                    @csrf

                    <button type="submit" class="resend-btn">
                        Resend OTP
                    </button>

                </form>

            </div>

            <a href="{{ route('influencer.login') }}" class="back-login">
                ← Back to Login
            </a>

        </div>

    </div>

@endsection