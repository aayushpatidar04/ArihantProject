@extends('layouts.app')

@section('title', 'Register — ArihantPLUS Conclave 2026')

@push('styles')
    <style>
        .reg-page {
            min-height: 100vh;
            padding: 100px 24px 60px;
            background: linear-gradient(180deg, #060208 0%, #0a0410 55%, #12081d 100%);
            position: relative;
            overflow: hidden
        }

        .reg-card {
            max-width: 460px;
            margin: 0 auto;
            background: linear-gradient(165deg, #170b22 0%, #0b0511 65%, #0a0410 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 26px;
            padding: 48px 36px;
            box-shadow: 0 40px 90px rgba(0, 0, 0, 0.6);
            position: relative;
            z-index: 2;
            text-align: center
        }

        .reg-card h1 {
            font-family: 'Sora', sans-serif;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px
        }

        .reg-card .subtitle {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 36px
        }

        .phone-wrap {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.055);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            padding: 4px;
            margin-bottom: 24px
        }

        .phone-prefix {
            padding: 0 14px;
            color: var(--muted);
            font-size: 15px;
            font-weight: 600;
            border-right: 1px solid rgba(255, 255, 255, 0.1)
        }

        .phone-wrap input {
            flex: 1;
            background: transparent;
            border: none;
            padding: 14px 16px;
            color: var(--ink);
            font-size: 16px;
            font-family: 'Inter', sans-serif;
            outline: none
        }

        .phone-wrap input::placeholder {
            color: rgba(230, 220, 240, 0.35)
        }

        .phone-wrap:focus-within {
            border-color: rgba(184, 102, 247, 0.55)
        }

        .hint {
            color: var(--muted-2);
            font-size: 12px;
            margin-top: 16px
        }

        .btn-loading {
            opacity: 0.6;
            cursor: not-allowed;
            pointer-events: none
        }

        .btn-spinner {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            margin-right: 8px;
            vertical-align: middle
        }

        @keyframes spin {
            to {
                transform: rotate(360deg)
            }
        }

        @media(max-width:480px) {
            .reg-card {
                padding: 32px 22px;
                border-radius: 22px
            }
        }

        /* Consent Modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(6px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.3s
        }

        .modal-overlay.active {
            display: flex;
            opacity: 1
        }

        .modal-box {
            max-width: 520px;
            width: 100%;
            max-height: 85vh;
            background: linear-gradient(165deg, #1a0f28 0%, #0d0614 100%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 22px;
            padding: 32px;
            overflow-y: auto;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.8);
            transform: translateY(20px);
            transition: transform 0.3s
        }

        .modal-overlay.active .modal-box {
            transform: translateY(0)
        }

        .modal-box h2 {
            font-family: 'Sora', sans-serif;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 6px;
            color: #fff
        }

        .modal-box .modal-sub {
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 20px
        }

        .modal-content {
            font-size: 13px;
            line-height: 1.7;
            color: rgba(230, 220, 240, 0.8);
            margin-bottom: 20px
        }

        .modal-content p {
            margin-bottom: 12px
        }

        .modal-content a {
            color: #d4a5ff;
            text-decoration: none
        }

        .modal-content a:hover {
            text-decoration: underline
        }

        .modal-content ul {
            list-style: none;
            padding: 0;
            margin: 0 0 12px 0
        }

        .modal-content ul li {
            position: relative;
            padding-left: 16px;
            margin-bottom: 6px
        }

        .modal-content ul li::before {
            content: '•';
            position: absolute;
            left: 0;
            color: var(--purple-1)
        }

        .modal-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.06);
            margin: 16px 0
        }

        .consent-row {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin: 16px 0;
            padding: 14px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px
        }

        .consent-row input[type="checkbox"] {
            width: 18px;
            height: 18px;
            min-width: 18px;
            accent-color: var(--purple-1);
            margin-top: 2px;
            cursor: pointer
        }

        .consent-row label {
            font-size: 13px;
            color: rgba(230, 220, 240, 0.85);
            cursor: pointer;
            line-height: 1.5
        }

        .consent-row label strong {
            color: #fff
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px
        }

        .modal-actions button {
            flex: 1;
            padding: 14px 16px;
            border-radius: 14px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            border: none
        }

        .modal-actions .btn-cancel {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--muted)
        }

        .modal-actions .btn-cancel:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #fff
        }

        .modal-actions .btn-agree {
            background: linear-gradient(135deg, #8b2fd9, #b866f7);
            color: #fff
        }

        .modal-actions .btn-agree:hover {
            opacity: 0.9
        }

        .modal-actions .btn-agree:disabled {
            opacity: 0.4;
            cursor: not-allowed
        }

        .consent-error {
            color: #ff6b6b;
            font-size: 12px;
            margin-top: 8px;
            display: none;
            text-align: center
        }

        @media(max-width:480px) {
            .modal-box {
                padding: 24px 20px;
                border-radius: 18px
            }

            .modal-actions {
                flex-direction: column
            }
        }
    </style>
@endpush

@section('content')
    <div class="reg-page">
        <div class="reg-card">
            <h1>Get Started</h1>
            <p class="subtitle">Enter your mobile number to check your eligibility</p>

            @if($errors->any())
                <div class="alert alert-error" style="margin-bottom:20px">{{ $errors->first() }} <a href="/login"
                        style="margin: 0 0 0 5px; font-style: italic;"><u>Click here to Login</u></a></div>
            @endif

            <form action="{{ route('registration.submit') }}" method="POST" id="phoneForm">
                @csrf
                <div class="phone-wrap">
                    <span class="phone-prefix">+91</span>
                    <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="10-digit mobile number"
                        maxlength="10" inputmode="numeric" pattern="[0-9]{10}" required autofocus>
                </div>
                <button type="submit" class="btn btn-primary" id="submitBtn" style="width:100%">
                    <span class="btn-text">Continue</span>
                </button>
            </form>

            <p class="hint" id="hintText">We will verify your number via WhatsApp & SMS.</p>
            <p class="hint">Already Registered? <a href="/login" style="color: white;">Login</a></p>
        </div>
    </div>

    <!-- Consent Modal -->
    <div class="modal-overlay" id="consentModal">
        <div class="modal-box">
            <h2>Consent Before Continuing</h2>
            <p class="modal-sub">Please review and confirm</p>

            <div class="modal-content">
                <p>By selecting <strong>"I Agree & Continue"</strong>, I confirm that I have read and agree to the
                    applicable:</p>
                <ul>
                    <li><a href="{{ route('event.policy') }}" target="_blank">Event Registration & Participation Policy</a>
                    </li>
                    <li><a href="{{ route('payment.terms') }}" target="_blank">Payment Terms</a></li>
                    <li><a href="{{ route('disclaimer') }}" target="_blank">Disclaimer / Risk Disclosure</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="{{ route('cookie.policy') }}" target="_blank">Cookie Policy</a></li>
                </ul>
                <p>I understand that the event may include educational content relating to <strong>AI, algorithmic trading,
                        options trading, financial markets,</strong> and trading strategies, and that such content does not
                    constitute personalized financial or investment advice.</p>
                <p>I understand that trading and investing involve risk, including the possible loss of capital, and that no
                    profit or return is guaranteed.</p>
                <p>I consent to the processing of my registration and verification information in accordance with the
                    applicable Privacy Policy.</p>
                <div class="modal-divider"></div>
                <p>I agree to receive all types of communication and updates on <strong>WhatsApp / SMS</strong> or
                    <strong>phone call</strong> by Arihant Capital.</p>
                <p>Your consent and OTP verification may be recorded electronically for registration, security, compliance,
                    and record-keeping purposes.</p>
            </div>

            <div class="consent-row">
                <input type="checkbox" id="consentCheck">
                <label for="consentCheck"><strong>I Agree</strong> to the above terms and disclosures.</label>
            </div>

            <div class="consent-error" id="consentError">Please check the box to agree and continue.</div>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" id="cancelBtn">Cancel</button>
                <button type="button" class="btn-agree" id="agreeBtn" disabled>I Agree & Continue</button>
            </div>
        </div>
    </div>

    <script>
        const phoneForm = document.getElementById('phoneForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = submitBtn.querySelector('.btn-text');
        const hintText = document.getElementById('hintText');
        const modal = document.getElementById('consentModal');
        const consentCheck = document.getElementById('consentCheck');
        const agreeBtn = document.getElementById('agreeBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const consentError = document.getElementById('consentError');

        // Intercept form submit — show modal instead
        phoneForm.addEventListener('submit', function (e) {
            e.preventDefault();
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        // Enable/disable agree button based on checkbox
        consentCheck.addEventListener('change', function () {
            agreeBtn.disabled = !this.checked;
            consentError.style.display = 'none';
        });

        // Cancel — close modal
        cancelBtn.addEventListener('click', function () {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        });

        // Click outside to close
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                modal.classList.remove('active');
                document.body.style.overflow = '';
            }
        });

        // Agree — submit the form
        agreeBtn.addEventListener('click', function () {
            if (!consentCheck.checked) {
                consentError.style.display = 'block';
                return;
            }

            modal.classList.remove('active');
            document.body.style.overflow = '';

            // Show loading state
            submitBtn.classList.add('btn-loading');
            btnText.innerHTML = '<span class="btn-spinner"></span>Sending OTP...';
            if (hintText) {
                hintText.textContent = 'Please wait while we send your verification code...';
            }

            // Submit the form
            phoneForm.submit();
        });
    </script>
@endsection