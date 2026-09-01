@extends('layouts.app')

@section('title', 'Influencer Login — ArihantPLUS')

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
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.04);
            color: var(--ink);
            outline: none;
        }

        .form-control:focus {
            border-color: rgba(184, 102, 247, 0.6);
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 22px;
        }

        .auth-btn {
            width: 100%;
        }

        .auth-error {
            color: #ffaaaa;
            font-size: 12px;
            margin-top: 6px;
        }
    </style>
@endpush

@section('content')

    <div class="influencer-auth">

        <div class="auth-card">

            <div class="auth-header">

                <div class="auth-icon">
                    <i class="fas fa-star"></i>
                </div>

                <h1>Influencer Login</h1>

                <p>
                    Login to submit your event posts and track your score.
                </p>

            </div>

            @if(session('success'))
                <div class="alert alert-success mb-3">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('influencer.login.submit') }}">

                @csrf

                <div class="form-group">

                    <label for="email">
                        Email Address
                    </label>

                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required
                        autofocus>

                    @error('email')
                        <div class="auth-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <input type="password" id="password" name="password" class="form-control" required>

                    @error('password')
                        <div class="auth-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <label class="remember">

                    <input type="checkbox" name="remember" value="1">

                    Remember me

                </label>

                <button type="submit" class="btn btn-primary auth-btn">
                    Send OTP
                </button>

            </form>

        </div>

    </div>

@endsection