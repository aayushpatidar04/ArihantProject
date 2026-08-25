@extends('layouts.app')

@section('title', 'Verify Admin OTP — ArihantPLUS')

@push('styles')
    <style>
        .admin-2fa-page {
            min-height: 100vh;
            padding: 72px 24px;
            background: radial-gradient(circle at 50% 20%, rgba(184, 102, 247, .12), transparent 42%), var(--bg);
            display: flex;
            align-items: center;
            justify-content: center
        }

        .admin-2fa-card {
            width: 100%;
            max-width: 440px;
            padding: 42px 36px;
            background: linear-gradient(165deg, #170b22 0%, #0b0511 100%);
            border: 1px solid rgba(255, 255, 255, .09);
            border-radius: 18px;
            box-shadow: 0 24px 70px rgba(0, 0, 0, .35)
        }

        .admin-2fa-kicker {
            color: var(--purple-1);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.6px;
            text-transform: uppercase;
            margin-bottom: 12px
        }

        .admin-2fa-card h1 {
            font-size: 26px;
            margin-bottom: 8px
        }

        .admin-2fa-copy {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 28px
        }

        .otp-inputs {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 28px
        }

        .otp-inputs input {
            width: 52px;
            height: 58px;
            text-align: center;
            font-size: 24px;
            font-weight: 700;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 14px;
            color: #fff;
            outline: none;
            transition: border-color .2s
        }

        .otp-inputs input:focus {
            border-color: var(--purple-1)
        }

        .resend {
            color: var(--muted);
            font-size: 13px;
            margin-top: 16px;
            text-align: center
        }

        .resend a {
            color: var(--purple-1);
            font-weight: 600
        }

        @media(max-width:480px) {
            .admin-2fa-card {
                padding: 32px 24px
            }

            .admin-2fa-card h1 {
                font-size: 22px
            }
        }
    </style>
@endpush

@section('content')
    <div class="admin-2fa-page">
        <div class="admin-2fa-card">
            <div class="admin-2fa-kicker">Two-Factor Authentication</div>
            <h1>Verify OTP</h1>
            <p class="admin-2fa-copy">Enter the 6-digit code sent to <strong>{{ $email }}</strong> to complete admin sign
                in.</p>

            @if($errors->any())
                <div class="alert alert-error" style="margin-bottom:20px">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('admin.2fa.submit') }}" method="POST" id="otpForm">
                @csrf
                <div class="otp-inputs">
                    <input type="text" maxlength="1" inputmode="numeric" oninput="moveNext(this, 0)"
                        onkeydown="moveBack(event, 0)">
                    <input type="text" maxlength="1" inputmode="numeric" oninput="moveNext(this, 1)"
                        onkeydown="moveBack(event, 1)">
                    <input type="text" maxlength="1" inputmode="numeric" oninput="moveNext(this, 2)"
                        onkeydown="moveBack(event, 2)">
                    <input type="text" maxlength="1" inputmode="numeric" oninput="moveNext(this, 3)"
                        onkeydown="moveBack(event, 3)">
                    <input type="text" maxlength="1" inputmode="numeric" oninput="moveNext(this, 4)"
                        onkeydown="moveBack(event, 4)">
                    <input type="text" maxlength="1" inputmode="numeric" oninput="moveNext(this, 5)"
                        onkeydown="moveBack(event, 5)">
                </div>
                <input type="hidden" name="otp" id="otpValue">
                <button type="submit" class="btn btn-primary" style="width:100%" onclick="combineOtp()">Verify & Sign
                    In</button>
            </form>

            <div class="resend">
                Didn't receive? <a href="{{ route('admin.login') }}">Start over</a>
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
    </script>
@endsection