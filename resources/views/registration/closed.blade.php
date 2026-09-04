<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Thank You, Indore! | ARIHANT PLUS AI & ALGO CONCLAVE</title>

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
            background:
                radial-gradient(circle at 50% 25%,
                    rgba(31, 65, 120, 0.65),
                    transparent 42%),
                linear-gradient(180deg,
                    #061a3a 0%,
                    #071d40 45%,
                    #06152f 100%);

            color: #ffffff;
            min-height: 100vh;
        }

        .page {
            min-height: 100vh;
            padding: 35px 20px 45px;
            display: flex;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 1000px;
            text-align: center;
        }

        /* HEADER */

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
            font-size: 38px;
            font-weight: 800;
            line-height: 0.95;
            letter-spacing: -1px;
        }

        .brand-title .ai {
            color: #00a9e8;
        }

        .brand-title .algo {
            color: #ffffff;
        }

        .brand-subtitle {
            margin-top: 8px;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 1.5px;
        }

        .brand-tagline {
            margin-top: 10px;
            font-size: 11px;
            letter-spacing: 4px;
            color: #d9dce5;
        }

        .header-right {
            text-align: left;
            font-size: 13px;
            line-height: 1.7;
            letter-spacing: 4px;
            color: #d8dce7;
        }

        .header-line {
            width: 45px;
            height: 2px;
            background: #e7bd45;
            margin-top: 12px;
        }

        /* MAIN HEADING */

        .thank-you {
            font-size: clamp(48px, 8vw, 76px);
            font-weight: 800;
            line-height: 1;
            margin: 0;
            letter-spacing: 1px;
        }

        .indore {
            display: block;
            color: #f5bd3e;
            margin-top: 5px;
        }

        .heart {
            color: #ef3340;
        }

        .response {
            font-size: clamp(20px, 3vw, 28px);
            margin: 25px auto 30px;
            line-height: 1.4;
        }

        /* HOUSE FULL */

        .house-full {
            max-width: 760px;
            margin: 0 auto 40px;
            padding: 22px 30px;
            border: 2px solid #e7bd45;
            border-radius: 20px;

            background: rgba(25, 25, 29, 0.75);

            box-shadow:
                0 0 15px rgba(231, 189, 69, 0.35),
                inset 0 0 30px rgba(0, 0, 0, 0.25);

            display: flex;
            align-items: center;
            justify-content: center;
            gap: 25px;
        }

        .ticket-icon {
            font-size: 55px;
            color: #f5bd3e;
        }

        .house-divider {
            width: 2px;
            height: 65px;
            background: rgba(255, 255, 255, 0.7);
        }

        .house-content {
            text-align: left;
        }

        .official {
            font-size: 20px;
            letter-spacing: 4px;
            font-weight: 600;
        }

        .full-text {
            color: #f5bd3e;
            font-size: clamp(40px, 7vw, 64px);
            line-height: 1;
            font-weight: 900;
            margin-top: 5px;
        }

        /* DESCRIPTION */

        .description {
            font-size: 25px;
            line-height: 1.5;
            margin: 0 auto 10px;
        }

        .description .highlight {
            color: #00a9e8;
            font-weight: 700;
        }

        .description strong {
            font-weight: 800;
        }

        .event-date {
            font-size: 22px;
            margin-top: 10px;
        }

        .event-date strong {
            font-weight: 800;
        }

        .separator {
            width: 75%;
            max-width: 700px;
            height: 1px;
            background: rgba(255, 255, 255, 0.35);
            margin: 30px auto;
        }

        /* DETAILS */

        .details {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            max-width: 850px;
            margin: 0 auto 35px;
        }

        .detail {
            border: 1px solid rgba(101, 143, 207, 0.7);
            background: rgba(12, 39, 81, 0.75);
            border-radius: 14px;
            padding: 20px 15px;
        }

        .detail-icon {
            font-size: 38px;
            margin-bottom: 10px;
        }

        .detail-label {
            font-size: 14px;
            color: #e1e5ee;
            margin-bottom: 5px;
        }

        .detail-value {
            font-size: 20px;
            font-weight: 700;
        }

        /* SEE YOU */

        .see-you {
            font-size: 28px;
            font-weight: 800;
            margin-top: 20px;
        }

        .future-text {
            font-size: 21px;
            line-height: 1.5;
            margin-top: 10px;
            color: #e6e9f0;
        }

        .remember {
            color: #f5bd3e;
            font-size: 28px;
            font-weight: 800;
            margin-top: 20px;
        }

        /* WAITLIST / HOME */

        .action-card {
            margin: 55px auto 20px;
            max-width: 900px;

            background: linear-gradient(135deg,
                    #edf3ff,
                    #d9e5fa);

            color: #09214a;
            border-radius: 20px;
            padding: 30px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;

            text-align: left;
        }

        .action-content {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .action-icon {
            font-size: 55px;
        }

        .action-title {
            font-size: 26px;
            font-weight: 800;
        }

        .action-description {
            font-size: 18px;
            margin-top: 7px;
        }

        .home-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            min-width: 210px;
            padding: 18px 28px;

            background: #0b367c;
            color: #ffffff;

            text-decoration: none;
            border-radius: 12px;

            font-size: 17px;
            font-weight: 800;

            transition: 0.2s ease;
        }

        .home-button:hover {
            background: #124b9d;
            transform: translateY(-2px);
        }

        .closed-text {
            margin-top: 20px;
            font-size: 15px;
            color: #d9deea;
        }

        /* FOOTER */

        .footer {
            margin-top: 50px;
            padding-top: 25px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);

            display: flex;
            justify-content: center;
            gap: 55px;

            color: #dfe4ee;
            font-size: 13px;
            letter-spacing: 2px;
        }

        /* MOBILE */

        @media (max-width: 700px) {

            .page {
                padding: 25px 15px 35px;
            }

            .header {
                margin-bottom: 45px;
            }

            .brand-title {
                font-size: 28px;
            }

            .brand-subtitle {
                font-size: 14px;
            }

            .header-right {
                display: none;
            }

            .house-full {
                flex-direction: column;
                padding: 25px 15px;
            }

            .house-content {
                text-align: center;
            }

            .house-divider {
                width: 60px;
                height: 2px;
            }

            .official {
                font-size: 14px;
            }

            .full-text {
                font-size: 45px;
            }

            .description {
                font-size: 20px;
            }

            .event-date {
                font-size: 18px;
            }

            .details {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .detail {
                display: flex;
                align-items: center;
                text-align: left;
                gap: 15px;
            }

            .detail-icon {
                margin: 0;
            }

            .action-card {
                flex-direction: column;
                text-align: center;
                padding: 25px 20px;
            }

            .action-content {
                flex-direction: column;
            }

            .home-button {
                width: 100%;
            }

            .footer {
                gap: 20px;
                flex-wrap: wrap;
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


            {{-- THANK YOU --}}
            <h1 class="thank-you">
                THANK YOU,
                <span class="indore">
                    INDORE! <span class="heart">♥</span>
                </span>
            </h1>

            <div class="response">
                We're overwhelmed by your incredible response!
            </div>


            {{-- HOUSE FULL --}}
            <div class="house-full">

                <div class="ticket-icon">
                    🎟️
                </div>

                <div class="house-divider"></div>

                <div class="house-content">

                    <div class="official">
                        WE'RE OFFICIALLY
                    </div>

                    <div class="full-text">
                        HOUSE FULL!
                    </div>

                </div>

            </div>


            {{-- DESCRIPTION --}}
            <div class="description">

                Central India's Largest
                <br>

                <span class="highlight">
                    AI &amp; Algo Trading
                </span>
                Conclave

            </div>

            <div class="event-date">
                is all set for <strong>September 5th, 2026.</strong>
            </div>


            <div class="separator"></div>


            {{-- EVENT DETAILS --}}
            <div class="details">

                <div class="detail">

                    <div class="detail-icon">
                        📅
                    </div>

                    <div>
                        <div class="detail-label">
                            Date
                        </div>

                        <div class="detail-value">
                            September 5, 2026
                        </div>
                    </div>

                </div>


                <div class="detail">

                    <div class="detail-icon">
                        🕐
                    </div>

                    <div>
                        <div class="detail-label">
                            Time
                        </div>

                        <div class="detail-value">
                            10:00 AM
                        </div>
                    </div>

                </div>


                <div class="detail">

                    <div class="detail-icon">
                        📍
                    </div>

                    <div>
                        <div class="detail-label">
                            Venue
                        </div>

                        <div class="detail-value">
                            Indore
                        </div>
                    </div>

                </div>

            </div>


            {{-- MESSAGE --}}
            <div class="see-you">
                See you tomorrow at 10 AM —
            </div>

            <div class="future-text">
                Get ready for an exciting day of AI, Algo Trading,
                <br class="desktop">
                Strategy &amp; the Future of Trading.
            </div>

            <div class="remember">
                Let's make it one to remember! 🚀
            </div>


            {{-- HOME ACTION --}}
            <div class="action-card">

                <div class="action-content">

                    <div class="action-icon">
                        🏠
                    </div>

                    <div>

                        <div class="action-title">
                            Registrations are closed
                        </div>

                        <div class="action-description">
                            Thank you for the overwhelming response.
                            <br>
                            We look forward to welcoming you at the Conclave.
                        </div>

                    </div>

                </div>

                <a href="{{ route('index') }}" class="home-button">
                    BACK TO HOME →
                </a>

            </div>


            <div class="closed-text">
                Registrations for this event are now closed.
            </div>


            {{-- FOOTER --}}
            <div class="footer">

                <span>🧠 AI</span>
                <span>📈 ALGO TRADING</span>
                <span>📊 STRATEGY</span>
                <span>👥 COMMUNITY</span>

            </div>

        </div>

    </div>

</body>

</html>
