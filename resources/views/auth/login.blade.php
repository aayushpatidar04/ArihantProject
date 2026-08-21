@extends('layouts.app')

@section('title', 'Login — ArihantPLUS')

@push('styles')
    <style>
        .login-page {
            min-height: 100vh;
            padding: 100px 24px 60px;
            background: var(--bg);
            display: flex;
            align-items: center;
            justify-content: center
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: linear-gradient(165deg, #170b22 0%, #0b0511 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 26px;
            padding: 48px 36px
        }

        .login-card h1 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 8px
        }

        .login-card p {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 32px
        }

        .form-group {
            margin-bottom: 20px
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #e9e4f0
        }

        .form-group input {
            width: 100%;
            background: rgba(255, 255, 255, 0.055);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            padding: 14px 16px;
            color: var(--ink);
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            outline: none
        }

        .form-group input:focus {
            border-color: rgba(184, 102, 247, 0.55)
        }

        .form-group input::placeholder {
            color: rgba(230, 220, 240, 0.35)
        }

        .alt-link {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: var(--muted)
        }

        .alt-link a {
            color: var(--purple-1);
            font-weight: 600
        }

        .otp-hint {
            text-align: center;
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 20px;
        }

        .otp-hint strong {
            color: #e9e4f0;
            letter-spacing: 1px;
        }

        .resend-link {
            text-align: center;
            margin-top: 12px;
            font-size: 13px;
        }

        .resend-link a {
            color: var(--purple-1);
            font-weight: 600;
        }
    </style>
@endpush

@section('content')
    <div class="login-page">
        <div class="login-card">
            <h1>Welcome Back</h1>
            @if(session('otp_sent'))
            <p>Please authenticate using the OTP received via SMS and WhatsApp.</p>
            @endif
            @if($errors->any())
                <div class="alert alert-error" style="margin-bottom:20px">{{ $errors->first() }}</div>
            @endif

            {{-- STEP 1: Phone Number --}}
            @if(!session('otp_sent'))
                <form action="{{ route('login.otp.send') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}"
                            placeholder="Enter your registered phone number" required autofocus
                            maxlength="15" inputmode="tel">
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%">Send OTP</button>
                </form>
            @else
                {{-- STEP 2: OTP Verification --}}
                <div class="otp-hint">
                    OTP sent to <strong>+91 {{ session('login_phone') }}</strong>
                </div>

                <form action="{{ route('login.otp.verify') }}" method="POST">
                    @csrf
                    <input type="hidden" name="phone" value="{{ session('login_phone') }}">

                    <div class="form-group">
                        <label>Enter 6-Digit OTP</label>
                        <input type="text" name="otp" placeholder="------" required
                            maxlength="6" inputmode="numeric" pattern="\d{6}" autofocus
                            style="text-align:center; letter-spacing:12px; font-size:20px; font-weight:700;">
                    </div>

                    <button type="submit" class="btn btn-primary" style="width:100%">Verify & Login</button>

                    <div class="resend-link">
                        <a href="{{ route('login') }}">Change phone number</a>
                    </div>
                </form>
            @endif

            <div class="alt-link">
                Don't have an account? <a href="{{ route('registration.form') }}">Register now</a>
            </div>
        </div>
    </div>
@endsection