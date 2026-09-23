@extends('layouts.app')

@section('title', 'Your Details — ArihantPLUS')

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

        .form-group input::placeholder {
            color: rgba(230, 220, 240, 0.35)
        }

        .form-group input[type="password"] {
            color-scheme: dark;
        }

        .type-select {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 24px
        }

        .type-option {
            padding: 16px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.03);
            border: 2px solid transparent;
            text-align: center;
            cursor: pointer;
            transition: all .2s
        }

        .type-option:hover {
            background: rgba(255, 255, 255, 0.05)
        }

        .type-option.active {
            background: rgba(184, 102, 247, 0.1);
            border-color: var(--purple-1)
        }

        .type-option .icon {
            font-size: 24px;
            margin-bottom: 6px
        }

        .type-option .lbl {
            font-size: 14px;
            font-weight: 600
        }

        .type-option .sub {
            font-size: 12px;
            color: var(--muted);
            margin-top: 2px
        }

        .step-bar {
            display: flex;
            gap: 8px;
            margin-bottom: 32px
        }

        .step-bar span {
            height: 4px;
            flex: 1;
            border-radius: 2px;
            background: rgba(255, 255, 255, 0.08)
        }

        .step-bar span.active {
            background: var(--purple-1)
        }

        .price-box {
            background: rgba(184, 102, 247, 0.08);
            border: 1px solid rgba(184, 102, 247, 0.2);
            border-radius: 14px;
            padding: 20px;
            text-align: center;
            margin: 24px 0
        }

        .price-box .price {
            font-size: 36px;
            font-weight: 800;
            color: #d4a5ff
        }

        .price-box .lbl {
            font-size: 13px;
            color: var(--muted);
            margin-top: 4px
        }

        .subbroker-badge {
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

        .free-badge {
            background: rgba(40, 180, 100, 0.08);
            border: 1px solid rgba(40, 180, 100, 0.2)
        }

        .free-badge .price {
            color: #8ff0b3
        }

        @media(max-width:480px) {
            .reg-card {
                padding: 28px 22px
            }
        }

        .checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 8px;
            margin-top: 8px;
        }

        .checkbox-option {
            display: flex;
            align-items: center;
            text-align: center;
            gap: 8px;
            padding: 8px 12px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            color: #e9e4f0;
            transition: border-color 0.2s;
        }

        .checkbox-option:hover {
            border-color: #6f42c1;
        }

        .checkbox-option input[type="checkbox"] {
            accent-color: #6f42c1;
        }
    </style>
@endpush

@section('content')
    <div class="reg-page">
        <div class="reg-card">
            <div class="step-bar">
                <span></span><span></span><span class="active"></span><span></span>
            </div>

            <h1>Tell Us About You</h1>
            <p class="subtitle">Complete your profile to secure your spot at the conclave.</p>

            @if($errors->any())
                <div class="alert alert-error" style="margin-bottom:20px">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('registration.finbridge-details.submit') }}" method="POST" id="detailsForm">
                @csrf

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Enter your full name"
                        required>
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
                </div>

                <div class="form-group">
                    <label>City</label>
                    <input type="text" name="city" value="{{ old('city') }}" placeholder="Your city" required>
                </div>

                {{-- 5. What are you primarily interested in? (extended card picker) --}}
                <label style="display:block;font-size:13px;font-weight:600;margin-bottom:10px;color:#e9e4f0">
                    What are you primarily interested in?
                </label>
                <div class="type-select">
                    <div class="type-option active" onclick="selectType('investing', this)">
                        <div class="icon">📈</div>
                        <div class="lbl">Investing</div>
                        <div class="sub">Long-term wealth</div>
                    </div>
                    <div class="type-option" onclick="selectType('trading', this)">
                        <div class="icon">⚡</div>
                        <div class="lbl">Trading</div>
                        <div class="sub">Active markets</div>
                    </div>
                    <div class="type-option" onclick="selectType('both', this)">
                        <div class="icon">📊</div>
                        <div class="lbl">Both</div>
                        <div class="sub">Invest &amp; trade</div>
                    </div>
                    <div class="type-option" onclick="selectType('exploring', this)">
                        <div class="icon">🔍</div>
                        <div class="lbl">Exploring</div>
                        <div class="sub">Just browsing</div>
                    </div>
                </div>
                <input type="hidden" name="interest" id="userType" value="investing">

                {{-- 6. Demat account --}}
                <div class="form-group">
                    <label>Do you currently have a Demat &amp; Trading Account?</label>
                    <select name="has_demat" required>
                        <option value="">-- Select --</option>
                        <option value="yes" {{ old('has_demat') == 'yes' ? 'selected' : '' }}>Yes</option>
                        <option value="no" {{ old('has_demat') == 'no' ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                {{-- 7. Frequency --}}
                <div class="form-group">
                    <label>How frequently do you currently invest or trade?</label>
                    <select name="invest_frequency" required>
                        <option value="">-- Select --</option>
                        <option value="regularly" {{ old('invest_frequency') == 'regularly' ? 'selected' : '' }}>Regularly
                        </option>
                        <option value="occasionally" {{ old('invest_frequency') == 'occasionally' ? 'selected' : '' }}>
                            Occasionally</option>
                        <option value="planning_to_start" {{ old('invest_frequency') == 'planning_to_start' ? 'selected' : '' }}>I am planning to start</option>
                        <option value="dont_invest" {{ old('invest_frequency') == 'dont_invest' ? 'selected' : '' }}>I
                            currently don't invest or trade</option>
                    </select>
                </div>

                {{-- 8. Timeline --}}
                <div class="form-group">
                    <label>When are you planning to start or increase your investing/trading?</label>
                    <select name="start_timeline" required>
                        <option value="">-- Select --</option>
                        <option value="immediately" {{ old('start_timeline') == 'immediately' ? 'selected' : '' }}>Immediately
                        </option>
                        <option value="within_1_month" {{ old('start_timeline') == 'within_1_month' ? 'selected' : '' }}>
                            Within 1 month</option>
                        <option value="within_3_months" {{ old('start_timeline') == 'within_3_months' ? 'selected' : '' }}>
                            Within 3 months</option>
                        <option value="not_sure" {{ old('start_timeline') == 'not_sure' ? 'selected' : '' }}>Not sure / Just
                            Exploring</option>
                    </select>
                </div>

                {{-- 9. Products (multi-select checkboxes) --}}
                <div class="form-group">
                    <label>What are you most interested in?</label>
                    <div class="checkbox-group">
                        <label class="checkbox-option"><input type="checkbox" name="products[]" value="stocks" {{ 'stocks' === old('products') ? 'checked' : '' }}>
                            Stocks</label>
                        <label class="checkbox-option"><input type="checkbox" name="products[]" value="mutual_funds" {{ 'mutual_funds' === old('products') ? 'checked' : '' }}>
                            Mutual Funds</label>
                        <label class="checkbox-option"><input type="checkbox" name="products[]" value="ipos" {{ 'ipos' === old('products') ? 'checked' : '' }}>
                            IPOs</label>
                        <label class="checkbox-option"><input type="checkbox" name="products[]" value="fno" {{ 'fno' === old('products') ? 'checked' : '' }}>
                            F&amp;O</label>
                        <label class="checkbox-option"><input type="checkbox" name="products[]" value="algo_trading" {{ 'algo_trading' === old('products') ? 'checked' : '' }}>
                            Algo Trading</label>
                        <label class="checkbox-option"><input type="checkbox" name="products[]" value="us_stocks" {{ 'us_stocks' === old('products') ? 'checked' : '' }}> US
                            Stocks</label>
                        <label class="checkbox-option"><input type="checkbox" name="products[]" value="multiple" {{ 'multiple' === old('products') ? 'checked' : '' }}>
                            Multiple Products</label>
                        <label class="checkbox-option"><input type="checkbox" name="products[]" value="not_sure" {{ 'not_sure' === old('products') ? 'checked' : '' }}> Not
                            Sure Yet</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%">Complete Registration →</button>
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