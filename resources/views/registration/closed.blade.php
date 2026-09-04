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
            color: #ffffff;
            min-height: 100vh;

            background:
                radial-gradient(circle at 50% 15%,
                    rgba(139, 47, 217, 0.20),
                    transparent 35%),
                radial-gradient(circle at 10% 80%,
                    rgba(168, 85, 247, 0.08),
                    transparent 30%),
                linear-gradient(180deg,
                    #08080d 0%,
                    #0c0912 45%,
                    #08080d 100%);
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
            font-size: 38px;
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
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 1.5px;
            color: #ffffff;
        }

        .brand-tagline {
            margin-top: 10px;
            font-size: 11px;
            letter-spacing: 4px;
            color: #8f8f9b;
        }

        .header-right {
            text-align: left;
            font-size: 13px;
            line-height: 1.7;
            letter-spacing: 4px;
            color: #8f8f9b;
        }

        .header-line {
            width: 45px;
            height: 2px;
            background: #8b2fd9;
            margin-top: 12px;
            box-shadow: 0 0 10px rgba(139, 47, 217, 0.8);
        }

        /* =========================
   MAIN HEADING
========================= */

        .thank-you {
            font-size: clamp(48px, 8vw, 76px);
            font-weight: 800;
            line-height: 1;
            margin: 0;
            letter-spacing: 1px;
        }

        .indore {
            display: block;
            margin-top: 5px;

            background: linear-gradient(90deg,
                    #8b2fd9,
                    #c084fc);

            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .heart {
            color: #a855f7;
            -webkit-text-fill-color: #a855f7;
        }

        .response {
            font-size: clamp(20px, 3vw, 28px);
            color: #d1d1d8;
            margin: 25px auto 30px;
            line-height: 1.4;
        }

        /* =========================
   HOUSE FULL
========================= */

        .house-full {
            max-width: 760px;
            margin: 0 auto 40px;
            padding: 22px 30px;

            border: 1px solid rgba(168, 85, 247, 0.85);
            border-radius: 20px;

            background:
                linear-gradient(135deg,
                    rgba(139, 47, 217, 0.10),
                    rgba(20, 15, 27, 0.85));

            box-shadow:
                0 0 30px rgba(139, 47, 217, 0.15),
                inset 0 0 30px rgba(139, 47, 217, 0.04);

            display: flex;
            align-items: center;
            justify-content: center;
            gap: 25px;
        }

        .ticket-icon {
            font-size: 55px;
            filter: drop-shadow(0 0 12px rgba(168, 85, 247, 0.6));
        }

        .house-divider {
            width: 1px;
            height: 65px;
            background: rgba(168, 85, 247, 0.5);
        }

        .house-content {
            text-align: left;
        }

        .official {
            font-size: 20px;
            letter-spacing: 4px;
            font-weight: 600;
            color: #d6d3dc;
        }

        .full-text {
            font-size: clamp(40px, 7vw, 64px);
            line-height: 1;
            font-weight: 900;
            margin-top: 5px;

            background: linear-gradient(90deg,
                    #8b2fd9,
                    #c084fc);

            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* =========================
   DESCRIPTION
========================= */

        .description {
            font-size: 25px;
            line-height: 1.5;
            margin: 0 auto 10px;
            color: #e7e7ec;
        }

        .description .highlight {
            color: #a855f7;
            font-weight: 700;
        }

        .description strong {
            color: #ffffff;
            font-weight: 800;
        }

        .event-date {
            font-size: 22px;
            margin-top: 10px;
            color: #b6b6c1;
        }

        .event-date strong {
            color: #ffffff;
            font-weight: 800;
        }

        .separator {
            width: 75%;
            max-width: 700px;
            height: 1px;

            background: linear-gradient(90deg,
                    transparent,
                    rgba(139, 47, 217, 0.6),
                    transparent);

            margin: 30px auto;
        }

        /* =========================
   EVENT DETAILS
========================= */

        .details {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            max-width: 850px;
            margin: 0 auto 35px;
        }

        .detail {
            border: 1px solid rgba(139, 47, 217, 0.28);

            background:
                linear-gradient(145deg,
                    rgba(139, 47, 217, 0.09),
                    rgba(15, 13, 20, 0.9));

            border-radius: 14px;
            padding: 20px 15px;

            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 0.03);
        }

        .detail-icon {
            font-size: 38px;
            margin-bottom: 10px;
        }

        .detail-label {
            font-size: 14px;
            color: #8f8f9b;
            margin-bottom: 5px;
        }

        .detail-value {
            font-size: 20px;
            font-weight: 700;
            color: #ffffff;
        }

        /* =========================
   MESSAGE
========================= */

        .see-you {
            font-size: 28px;
            font-weight: 800;
            margin-top: 20px;
            color: #ffffff;
        }

        .future-text {
            font-size: 21px;
            line-height: 1.5;
            margin-top: 10px;
            color: #a7a7b3;
        }

        .remember {
            color: #a855f7;
            font-size: 28px;
            font-weight: 800;
            margin-top: 20px;
        }

        /* =========================
   ACTION CARD
========================= */

        .action-card {
            margin: 55px auto 20px;
            max-width: 900px;

            background:
                linear-gradient(135deg,
                    rgba(139, 47, 217, 0.14),
                    rgba(18, 14, 24, 0.95));

            border: 1px solid rgba(139, 47, 217, 0.35);

            color: #ffffff;

            border-radius: 20px;
            padding: 30px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;

            text-align: left;

            box-shadow:
                0 15px 50px rgba(0, 0, 0, 0.35),
                inset 0 1px 0 rgba(255, 255, 255, 0.03);
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
            color: #a7a7b3;
            line-height: 1.5;
        }

        .home-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            min-width: 210px;
            padding: 17px 28px;

            background:
                linear-gradient(135deg,
                    #7c25c7,
                    #a855f7);

            color: #ffffff;

            text-decoration: none;
            border-radius: 12px;

            font-size: 17px;
            font-weight: 800;

            box-shadow:
                0 8px 25px rgba(139, 47, 217, 0.3);

            transition: 0.2s ease;
        }

        .home-button:hover {
            transform: translateY(-2px);

            box-shadow:
                0 12px 30px rgba(139, 47, 217, 0.45);
        }

        .closed-text {
            margin-top: 20px;
            font-size: 15px;
            color: #777782;
        }

        /* =========================
   FOOTER
========================= */

        .footer {
            margin-top: 50px;
            padding-top: 25px;

            border-top: 1px solid rgba(139, 47, 217, 0.15);

            display: flex;
            justify-content: center;
            gap: 55px;

            color: #777782;
            font-size: 13px;
            letter-spacing: 2px;
        }

        /* =========================
   MOBILE
========================= */

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
                height: 1px;
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
