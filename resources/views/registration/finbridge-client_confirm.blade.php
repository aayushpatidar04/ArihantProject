@extends('layouts.app')

@section('title', 'Confirm Details — ArihantPLUS')

@push('styles')
    <style>
        option {
            color: #000000 !important;
        }
        .reg-page {
            min-height: 100vh;
            padding: 80px 24px 60px;
            background: var(--bg)
        }

        .reg-card {
            max-width: 520px;
            margin: 0 auto;
            background: linear-gradient(165deg, #170b22 0%, #0b0511 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 26px;
            padding: 42px 36px
        }

        .reg-card h1 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 8px
        }

        .reg-card .subtitle {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 28px
        }

        .client-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(40, 180, 100, 0.12);
            border: 1px solid rgba(40, 180, 100, 0.3);
            color: #8ff0b3;
            padding: 8px 16px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 24px
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

        .form-group input,
        .form-group select {
            width: 100%;
            background: rgba(255, 255, 255, 0.055);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            padding: 14px 16px;
            color: var(--ink);
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color .2s
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: rgba(184, 102, 247, 0.55)
        }

        .form-group input[readonly] {
            opacity: 0.6;
            cursor: not-allowed
        }

        .form-group select option {
            background: #1a0f24;
            color: #fff
        }

        .price-box {
            background: rgba(40, 180, 100, 0.08);
            border: 1px solid rgba(40, 180, 100, 0.2);
            border-radius: 14px;
            padding: 20px;
            text-align: center;
            margin: 24px 0
        }

        .price-box .price {
            font-size: 36px;
            font-weight: 800;
            color: #8ff0b3
        }

        .price-box .price span {
            font-size: 16px;
            color: var(--muted);
            font-weight: 400;
            text-decoration: line-through;
            margin-left: 8px
        }

        .price-box .lbl {
            font-size: 13px;
            color: var(--muted);
            margin-top: 4px
        }

        @media(max-width:480px) {
            .reg-card {
                padding: 28px 22px
            }
        }
    </style>
@endpush

@section('content')
    <div class="reg-page">
        <div class="reg-card">
            <div class="client-badge">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 6L9 17l-5-5" />
                </svg>
                Existing Arihant Client
            </div>

            <h1>Confirm Your Details</h1>
            <p class="subtitle">Select your Client ID. Your name will auto-fill — please enter the remaining details.</p>

            @if($errors->any())
                <div class="alert alert-error" style="margin-bottom:20px">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('registration.finbridge-client.confirm.submit') }}" method="POST">
                @csrf

                <div style="margin-bottom:24px">
                    {{-- Client ID Selector (unchanged) --}}
                    @php
                        $mask40 = function ($s) {
                            $len = mb_strlen($s);
                            if ($len <= 2)
                                return $s;

                            $visible = (int) round($len * 0.6);
                            $maskCount = $len - $visible;
                            $startLen = (int) ceil($visible / 2);
                            $endLen = $visible - $startLen;

                            return mb_substr($s, 0, $startLen)
                                . str_repeat('*', $maskCount)
                                . mb_substr($s, -$endLen);
                        };

                        $mask = $mask40;
                        $maskedPhone = $mask40($phone);
                    @endphp

                    <div class="form-group">
                        <label>Select Client ID</label>
                        <select name="selected_uid" id="uid-select" required>
                            <option value="">-- Select your Client ID --</option>
                            @foreach($client_users as $user)
                                <option value="{{ $user['uid'] }}" data-name="{{ $user['uName'] }}">
                                    {{ $mask($user['uid']) }} — {{ $mask($user['uName']) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Name auto-fills from selected UID --}}
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" id="full-name-display" placeholder="Select a Client ID above" readonly>
                        <input type="hidden" name="full_name" id="full-name" required readonly>
                    </div>

                    {{-- Phone --}}
                    <div class="form-group">
                        <label>Mobile Number</label>
                        <input type="text" id="phone-display" value="{{ $maskedPhone }}" required readonly>
                        <input type="hidden" name="phone" value="{{ $phone }}">
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label>Email ID</label>
                        <input type="email" name="email" placeholder="Enter your email address" required>
                    </div>

                    {{-- City --}}
                    <div class="form-group">
                        <label>City</label>
                        <input type="text" name="city" placeholder="Enter your city" required>
                    </div>

                    {{-- 5. What are you primarily interested in? (replaces old "Type" field) --}}
                    <div class="form-group">
                        <label>What are you primarily interested in?</label>
                        <select name="interest" required>
                            <option value="">-- Select --</option>
                            <option value="investing">📈 Investing</option>
                            <option value="trading">📊 Trading</option>
                            <option value="both">📈📊 Both Investing &amp; Trading</option>
                            <option value="exploring">🔍 Just Exploring</option>
                        </select>
                    </div>

                    {{-- 6. Do you currently have a Demat & Trading Account? --}}
                    <div class="form-group">
                        <label>Do you currently have a Demat &amp; Trading Account?</label>
                        <select name="has_demat" required>
                            <option value="">-- Select --</option>
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                        </select>
                    </div>

                    {{-- 7. How frequently do you currently invest or trade? --}}
                    <div class="form-group">
                        <label>How frequently do you currently invest or trade?</label>
                        <select name="invest_frequency" required>
                            <option value="">-- Select --</option>
                            <option value="regularly">Regularly</option>
                            <option value="occasionally">Occasionally</option>
                            <option value="planning_to_start">I am planning to start</option>
                            <option value="dont_invest">I currently don't invest or trade</option>
                        </select>
                    </div>

                    {{-- 8. When are you planning to start or increase? --}}
                    <div class="form-group">
                        <label>When are you planning to start or increase your investing/trading?</label>
                        <select name="start_timeline" required>
                            <option value="">-- Select --</option>
                            <option value="immediately">Immediately</option>
                            <option value="within_1_month">Within 1 month</option>
                            <option value="within_3_months">Within 3 months</option>
                            <option value="not_sure">Not sure / Just Exploring</option>
                        </select>
                    </div>

                    {{-- 9. What are you most interested in? (multi-select checkboxes) --}}
                    <div class="form-group">
                        <label>What are you most interested in? <small>(select all that apply)</small></label>
                        <div class="checkbox-group">
                            <label class="checkbox-option"><input type="checkbox" name="products[]" value="stocks">
                                Stocks</label>
                            <label class="checkbox-option"><input type="checkbox" name="products[]" value="mutual_funds">
                                Mutual Funds</label>
                            <label class="checkbox-option"><input type="checkbox" name="products[]" value="ipos">
                                IPOs</label>
                            <label class="checkbox-option"><input type="checkbox" name="products[]" value="fno">
                                F&amp;O</label>
                            <label class="checkbox-option"><input type="checkbox" name="products[]" value="algo_trading">
                                Algo Trading</label>
                            <label class="checkbox-option"><input type="checkbox" name="products[]" value="us_stocks"> US
                                Stocks</label>
                            <label class="checkbox-option"><input type="checkbox" name="products[]" value="multiple">
                                Multiple Products</label>
                            <label class="checkbox-option"><input type="checkbox" name="products[]" value="not_sure"> Not
                                Sure Yet</label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%">Confirm</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('uid-select').addEventListener('change', function () {
            const option = this.options[this.selectedIndex];
            const name = option.dataset.name || '';

            const mask = (s) => {
                if (!s || s.length <= 2) return s;
                const len = s.length;
                const visible = Math.round(len * 0.6);
                const maskCount = len - visible;
                const startLen = Math.ceil(visible / 2);
                const endLen = visible - startLen;
                return s.slice(0, startLen) + '*'.repeat(maskCount) + s.slice(-endLen);
            };

            document.getElementById('full-name-display').value = mask(name);
            document.getElementById('full-name').value = name;
        });
    </script>
@endsection