<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Join Waitlist | ARIHANT PLUS AI & ALGO CONCLAVE
    </title>

    <style>
        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #ffffff;

            min-height: 100vh;

            background:
                radial-gradient(circle at 50% 10%,
                    rgba(139, 47, 217, 0.20),
                    transparent 35%),
                radial-gradient(circle at 10% 80%,
                    rgba(168, 85, 247, 0.08),
                    transparent 30%),
                linear-gradient(180deg,
                    #08080d 0%,
                    #0c0912 50%,
                    #08080d 100%);
        }

        .page {
            min-height: 100vh;

            padding: 35px 20px 50px;

            display: flex;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 650px;
        }

        /* =========================
           HEADER
        ========================= */

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;

            margin-bottom: 65px;
        }

        .brand {
            text-align: left;
        }

        .brand-title {
            font-size: 34px;
            font-weight: 800;

            line-height: 0.95;
            letter-spacing: -1px;
        }

        .brand-title .ai {
            color: #a855f7;
        }

        .brand-title .algo {
            color: #ffffff;
        }

        .brand-subtitle {
            margin-top: 8px;

            font-size: 16px;
            font-weight: 700;

            letter-spacing: 1.5px;
        }

        .brand-tagline {
            margin-top: 9px;

            font-size: 10px;

            letter-spacing: 3px;

            color: #8f8f9b;
        }

        .header-right {
            text-align: left;

            font-size: 12px;
            line-height: 1.7;

            letter-spacing: 4px;

            color: #8f8f9b;
        }

        .header-line {
            width: 40px;
            height: 2px;

            margin-top: 10px;

            background: #8b2fd9;

            box-shadow:
                0 0 10px rgba(139, 47, 217, 0.8);
        }

        /* =========================
           MAIN
        ========================= */

        .content {
            text-align: center;
        }

        .icon {
            width: 72px;
            height: 72px;

            margin: 0 auto 25px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 20px;

            background:
                rgba(139, 47, 217, 0.12);

            border:
                1px solid rgba(168, 85, 247, 0.35);

            color: #a855f7;

            box-shadow:
                0 0 35px rgba(139, 47, 217, 0.15);
        }

        .heading {
            margin: 0;

            font-size: clamp(40px, 7vw, 58px);

            line-height: 1.05;

            font-weight: 800;
        }

        .heading span {
            display: block;

            background:
                linear-gradient(90deg,
                    #8b2fd9,
                    #c084fc);

            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;

            background-clip: text;
        }

        .description {
            margin: 20px auto 35px;

            max-width: 560px;

            font-size: 18px;

            line-height: 1.6;

            color: #a7a7b3;
        }

        /* =========================
           FORM CARD
        ========================= */

        .form-card {
            padding: 30px;

            text-align: left;

            border-radius: 20px;

            border:
                1px solid rgba(139, 47, 217, 0.30);

            background:
                linear-gradient(135deg,
                    rgba(139, 47, 217, 0.10),
                    rgba(18, 14, 24, 0.95));

            box-shadow:
                0 20px 60px rgba(0, 0, 0, 0.35),
                inset 0 1px 0 rgba(255, 255, 255, 0.03);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;

            margin-bottom: 8px;

            font-size: 14px;

            font-weight: 700;

            color: #d7d7df;
        }

        .form-control {
            width: 100%;

            padding: 14px 15px;

            border-radius: 10px;

            border:
                1px solid rgba(139, 47, 217, 0.25);

            background:
                rgba(7, 7, 11, 0.75);

            color: #ffffff;

            font-size: 16px;

            outline: none;

            transition: 0.2s ease;
        }

        .form-control::placeholder {
            color: #666672;
        }

        .form-control:focus {
            border-color: #a855f7;

            box-shadow:
                0 0 0 3px rgba(168, 85, 247, 0.10);
        }

        .error {
            margin-top: 6px;

            font-size: 13px;

            color: #f87171;
        }

        .submit-button {
            width: 100%;

            margin-top: 5px;

            padding: 16px 20px;

            border: 0;

            border-radius: 11px;

            background:
                linear-gradient(135deg,
                    #7c25c7,
                    #a855f7);

            color: #ffffff;

            font-size: 17px;

            font-weight: 800;

            cursor: pointer;

            box-shadow:
                0 8px 25px rgba(139, 47, 217, 0.25);

            transition: 0.2s ease;
        }

        .submit-button:hover {
            transform: translateY(-2px);

            box-shadow:
                0 12px 30px rgba(139, 47, 217, 0.40);
        }

        .back-button {
            display: block;

            width: fit-content;

            margin: 22px auto 0;

            color: #9999a5;

            text-decoration: none;

            font-size: 14px;

            transition: 0.2s ease;
        }

        .back-button:hover {
            color: #c084fc;
        }

        /* =========================
           MOBILE
        ========================= */

        @media (max-width: 700px) {

            .page {
                padding: 25px 15px 40px;
            }

            .header {
                margin-bottom: 50px;
            }

            .brand-title {
                font-size: 27px;
            }

            .brand-subtitle {
                font-size: 13px;
            }

            .header-right {
                display: none;
            }

            .form-card {
                padding: 22px 18px;
            }

            .description {
                font-size: 16px;
            }

        }
    </style>

</head>

<body>

    <div class="page">

        <div class="container">

            {{-- HEADER --}}

            <div class="header">

                <div class="brand">

                    <div class="brand-title">
                        <span class="ai">AI</span>
                        <span class="algo">&amp; ALGO</span>
                    </div>

                    <div class="brand-subtitle">
                        TRADING CONCLAVE
                    </div>

                    <div class="brand-tagline">
                        IDEAS &nbsp;|&nbsp; INSIGHTS &nbsp;|&nbsp; OPPORTUNITIES
                    </div>

                </div>

                <div class="header-right">

                    LEARN<br>
                    CONNECT<br>
                    TRADE<br>
                    GROW

                    <div class="header-line"></div>

                </div>

            </div>


            {{-- CONTENT --}}

            <div class="content">

                <div class="icon">

                    <svg width="38" height="38" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">

                        <path d="M16 21V19C16 17.3431 14.6569 16 13 16H6C4.34315 16 3 17.3431 3 19V21"
                            stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" />

                        <circle cx="9.5" cy="9" r="3" stroke="currentColor" stroke-width="1.8" />

                        <path d="M18 8C19.6569 8 21 9.3431 21 11C21 12.6569 19.6569 14 18 14" stroke="currentColor"
                            stroke-width="1.8" stroke-linecap="round" />

                        <path d="M18 16C19.6569 16 21 17.3431 21 19V21" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" />

                    </svg>

                </div>


                <h1 class="heading">
                    Missed your seat?
                    <span>Join the Waitlist</span>
                </h1>


                <div class="description">

                    Registrations for the ARIHANT PLUS AI &amp; ALGO
                    TRADING CONCLAVE are currently full.

                    <br>

                    Leave your details below and we'll keep you updated
                    about the next AI &amp; Algo Trading Conclave.

                </div>


                {{-- FORM --}}

                <div class="form-card">

                    <form method="POST" action="{{ route('waitlist.store') }}">

                        @csrf


                        {{-- NAME --}}

                        <div class="form-group">

                            <label for="name" class="form-label">
                                Full Name
                            </label>

                            <input type="text" id="name" name="name" class="form-control"
                                value="{{ old('name') }}" placeholder="Enter your full name" required
                                autocomplete="name">

                            @error('name')
                                <div class="error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- PHONE --}}

                        <div class="form-group">

                            <label for="phone" class="form-label">
                                Mobile Number
                            </label>

                            <input type="tel" id="phone" name="phone" class="form-control"
                                value="{{ old('phone') }}" placeholder="Enter 10-digit mobile number" maxlength="10"
                                inputmode="numeric" required autocomplete="tel">

                            @error('phone')
                                <div class="error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- EMAIL --}}

                        <div class="form-group">

                            <label for="email" class="form-label">
                                Email Address
                            </label>

                            <input type="email" id="email" name="email" class="form-control"
                                value="{{ old('email') }}" placeholder="Enter your email address" required
                                autocomplete="email">

                            @error('email')
                                <div class="error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- CITY --}}

                        <div class="form-group">

                            <label for="city" class="form-label">
                                City
                            </label>

                            <input type="text" id="city" name="city" class="form-control"
                                value="{{ old('city') }}" placeholder="Enter your city" required
                                autocomplete="address-level2">

                            @error('city')
                                <div class="error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <button type="submit" class="submit-button">
                            JOIN WAITLIST →
                        </button>

                    </form>


                    <a href="{{ route('index') }}" class="back-button">
                        ← Back to Home
                    </a>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
