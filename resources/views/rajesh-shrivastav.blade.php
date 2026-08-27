<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rajesh Srivastav — ArihantPLUS Speaker</title>
    <link rel="icon" type="image/png" href="assets/images/favicon-2.png">

    <style>
        @font-face {
            font-family: 'AktivGrotesk';
            src: url('assets/fonts/AktivGrotesk-Regular.woff2') format('woff2'),
                url('assets/fonts/AktivGrotesk-Regular.woff') format('woff');
            font-weight: 400;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'AktivGrotesk';
            src: url('assets/fonts/AktivGrotesk-Bold.woff2') format('woff2'),
                url('assets/fonts/AktivGrotesk-Bold.woff') format('woff');
            font-weight: 700;
            font-style: normal;
            font-display: swap;
        }
    </style>

    <style>
        :root {
            --bg: #060208;
            --bg-soft: #0b0510;
            --purple-1: #b866f7;
            --purple-2: #8b2fd9;
            --magenta: #c92fd0;
            --ink: #f6f3fa;
            --muted: #a79bb5;
            --muted-2: #7c7188;
            --btn-grad: linear-gradient(135deg, #d43fe0 0%, #7a1fc9 55%, #601fae 100%);
            --max: 1160px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: var(--bg);
            color: var(--ink);
            font-family: 'AktivGrotesk', sans-serif;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        h1,
        h3,
        .font-display {
            font-family: 'AktivGrotesk', sans-serif;
            font-weight: 700;
        }

        img {
            display: block;
            max-width: 100%;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .wrap {
            max-width: var(--max);
            margin: 0 auto;
            padding: 0 24px;
        }

        .eyebrow {
            display: inline-block;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .02em;
            color: var(--purple-1);
            background: rgba(160, 90, 230, 0.12);
            border: 1px solid rgba(180, 120, 255, 0.35);
            padding: 6px 16px;
            border-radius: 999px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
            padding: 12px 24px;
            border-radius: 999px;
            border: none;
            cursor: pointer;
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: var(--btn-grad);
            color: #fff;
            box-shadow: 0 8px 24px rgba(160, 40, 200, 0.45), inset 0 1px 0 rgba(255, 255, 255, 0.25);
        }

        .btn-ghost {
            background: rgba(255, 255, 255, 0.05);
            color: #e9defa;
            border: 1px solid rgba(180, 120, 255, 0.35);
        }

        .btn-ghost:hover {
            background: rgba(184, 102, 247, 0.15);
            border-color: rgba(184, 102, 247, 0.55);
        }

        /* ---------- HEADER ---------- */
        header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(5, 2, 8, 0.75);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 24px;
            max-width: var(--max);
            margin: 0 auto;
        }

        .logo-img {
            height: 30px;
            width: auto;
            display: block;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: var(--muted);
            transition: color .2s ease, transform .2s ease;
        }

        .back-link:hover {
            color: var(--purple-1);
            transform: translateX(-3px);
        }

        .back-link svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
        }

        /* ---------- SPEAKER DETAIL ---------- */
        .speaker-page {
            position: relative;
            padding: 90px 24px 100px;
            overflow: hidden;
            background:
                radial-gradient(900px 520px at 12% -8%, rgba(184, 102, 247, 0.20), transparent 60%),
                radial-gradient(760px 480px at 100% 12%, rgba(201, 47, 208, 0.16), transparent 60%),
                var(--bg);
        }

        .speaker-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            pointer-events: none;
            z-index: 0;
        }

        .speaker-orb-1 {
            width: 420px;
            height: 420px;
            top: -12%;
            left: -10%;
            background: radial-gradient(circle, rgba(184, 102, 247, 0.35), transparent 70%);
        }

        .speaker-orb-2 {
            width: 380px;
            height: 380px;
            bottom: -18%;
            right: -8%;
            background: radial-gradient(circle, rgba(201, 47, 208, 0.3), transparent 70%);
        }

        .speaker-grid {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 380px 1fr;
            gap: 72px;
            align-items: start;
            max-width: var(--max);
            margin: 0 auto;
        }

        /* Photo card */
        .speaker-photo-card {
            position: relative;
            border-radius: 32px;
            aspect-ratio: 0.85;
            background: #1c0e30;
            border: 4px solid #0a0410;
            box-shadow:
                0 0 0 10px rgba(255, 255, 255, 0.06),
                0 40px 90px rgba(120, 40, 200, 0.35);
            position: sticky;
            top: 110px;
        }

        .speaker-photo-card::before {
            content: "";
            position: absolute;
            inset: -4px;
            border-radius: 34px;
            padding: 2px;
            background: linear-gradient(160deg,
                    rgba(216, 110, 255, 0.9) 0%,
                    rgba(140, 40, 200, 0.2) 35%,
                    rgba(140, 40, 200, 0.2) 65%,
                    rgba(201, 47, 208, 0.9) 100%);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
            z-index: 2;
        }

        .speaker-photo-mask {
            position: absolute;
            inset: 0;
            border-radius: 26px;
            overflow: hidden;
        }

        .speaker-photo-mask img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top center;
        }

        .speaker-photo-shade {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg,
                    rgba(6, 2, 8, 0) 45%,
                    rgba(6, 2, 8, 0.55) 78%,
                    rgba(6, 2, 8, 0.9) 100%);
            pointer-events: none;
        }

        /* Content */
        .speaker-content {
            position: relative;
            z-index: 1;
        }

        .speaker-content h1 {
            font-size: clamp(30px, 4vw, 46px);
            line-height: 1.12;
            margin-top: 18px;
            letter-spacing: -.01em;
        }

        .speaker-role {
            margin-top: 10px;
            font-size: 15px;
            font-weight: 600;
            color: var(--purple-1);
            line-height: 1.5;
        }

        .speaker-divider {
            width: 64px;
            height: 3px;
            border-radius: 999px;
            margin: 24px 0;
            background: var(--btn-grad);
        }

        .speaker-bio p {
            font-size: 15px;
            line-height: 1.85;
            color: var(--muted);
            max-width: 620px;
            margin-bottom: 16px;
        }

        .speaker-bio p:last-child {
            margin-bottom: 0;
        }

        .speaker-highlights {
            margin-top: 38px;
        }

        .speaker-highlights h3 {
            font-size: 15px;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 18px;
            letter-spacing: .01em;
        }

        .highlight-grid {
            list-style: none;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px 28px;
            max-width: 640px;
        }

        .highlight-grid li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 13.5px;
            line-height: 1.55;
            color: var(--muted);
        }

        .highlight-grid li svg {
            width: 16px;
            height: 16px;
            stroke: var(--purple-1);
            flex-shrink: 0;
            margin-top: 2px;
        }

        .speaker-social {
            display: flex;
            gap: 12px;
            margin-top: 36px;
        }

        .speaker-social a {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(180, 120, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .2s ease, transform .2s ease, border-color .2s ease;
        }

        .speaker-social a:hover {
            background: rgba(184, 102, 247, 0.18);
            border-color: rgba(184, 102, 247, 0.6);
            transform: translateY(-3px);
        }

        .speaker-social svg {
            width: 20px;
            height: 20px;
            stroke: var(--purple-1);
        }

        .speaker-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 32px;
        }

        /* ---------- RESPONSIVE ---------- */
        @media (max-width: 900px) {
            .speaker-page {
                padding: 56px 16px 70px;
            }

            .speaker-grid {
                grid-template-columns: 1fr;
                gap: 0;
                text-align: center;
                background: linear-gradient(165deg, #170b22 0%, #0b0511 60%, #0a0410 100%);
                border: 1px solid rgba(184, 102, 247, 0.35);
                border-radius: 28px;
                padding: 40px 24px 34px;
                box-shadow:
                    0 0 0 1px rgba(184, 102, 247, 0.12),
                    0 30px 80px rgba(120, 40, 200, 0.35);
            }

            .speaker-photo-card {
                position: relative;
                top: auto;
                width: 96px;
                height: 96px;
                aspect-ratio: 1;
                border-radius: 50%;
                margin: 0 auto 6px;
                border: 3px solid rgba(184, 102, 247, 0.55);
                box-shadow: 0 0 0 6px rgba(184, 102, 247, 0.14);
            }

            .speaker-photo-card::before {
                display: none;
            }

            .speaker-photo-mask {
                border-radius: 50%;
            }

            .speaker-photo-shade {
                display: none;
            }

            .speaker-content {
                text-align: center;
            }

            .speaker-content .eyebrow {
                margin-top: 18px;
            }

            .speaker-role {
                max-width: 320px;
                margin: 10px auto 0;
            }

            .speaker-divider {
                margin: 22px auto;
            }

            .speaker-bio {
                text-align: left;
            }

            .speaker-bio p {
                margin-left: auto;
                margin-right: auto;
                max-width: 100%;
            }

            .highlight-grid {
                text-align: left;
                grid-template-columns: 1fr;
                max-width: 100%;
                margin-top: 4px;
            }

            .speaker-social,
            .speaker-actions {
                justify-content: center;
            }

            .speaker-actions {
                flex-direction: column;
                width: 100%;
            }

            .speaker-actions .btn {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .speaker-page {
                padding: 44px 14px 60px;
            }

            .speaker-grid {
                padding: 32px 18px 28px;
                border-radius: 22px;
            }

            .speaker-photo-card {
                width: 84px;
                height: 84px;
            }

            .speaker-content h1 {
                margin-top: 14px;
            }

            .speaker-bio p {
                font-size: 14px;
            }

            .speaker-social a {
                width: 42px;
                height: 42px;
                border-radius: 12px;
            }
        }

        /* ---------- FOOTER ---------- */
        footer {
            background: #000;
            padding: 30px 24px;
            text-align: center;
            font-size: 13px;
            color: var(--muted-2);
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }
    </style>
</head>

<body>

    <header>
        <div class="nav">
            <div class="logo"><img src="assets/images/logo-2.png" alt="ArihantPLUS" class="logo-img"></div>
            <a href="/#speaker" class="back-link">
                <svg viewBox="0 0 24 24">
                    <path d="M15 6l-6 6 6 6" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Back to all speakers
            </a>
        </div>
    </header>

    <section class="speaker-page">
        <div class="speaker-orb speaker-orb-1" aria-hidden="true"></div>
        <div class="speaker-orb speaker-orb-2" aria-hidden="true"></div>

        <div class="speaker-grid wrap">
            <div class="speaker-photo-card">
                <div class="speaker-photo-mask">
                    <img src="assets/images/25.png" alt="Rajesh Srivastav">
                    <div class="speaker-photo-shade"></div>
                </div>
            </div>

            <div class="speaker-content">
                <span class="eyebrow">Speaker</span>
                <h1>Rajesh Srivastav</h1>
                <p class="speaker-role">Founder, QuantLab Technologies | Professional Derivatives Trader</p>
                <div class="speaker-divider"></div>

                <div class="speaker-bio">
                    <p>Rajesh Srivastav is a derivatives and financial technology professional with deep experience at
                        the intersection of trading, technology and capital-market infrastructure.</p>
                    <p>He is the Founder of QuantLab Technologies, where he leads the development of enterprise-grade
                        technology for capital markets. The company builds systems that power critical functions across
                        the financial ecosystem — from options analytics and algorithmic execution to market-data
                        infrastructure, pre-trade risk management, portfolio and wealth platforms, and OMS connectivity.
                    </p>
                    <p>His expertise extends beyond building technology. Rajesh brings a strong understanding of how
                        derivatives markets function in real trading environments, with particular focus on options
                        strategies, execution, risk management and market behaviour. His approach combines practical
                        trading experience with a technology-first mindset, helping bridge the gap between sophisticated
                        institutional systems and the evolving needs of modern traders.</p>
                    <p>Rajesh has also been featured as a speaker at leading market conferences, where he has shared
                        insights on topics such as weekly expiry mechanics and options strategies in different
                        volatility environments (Finbridge Expo).</p>
                    <p>With a strong focus on building systems that can withstand real-world market conditions, Rajesh
                        brings a practical perspective on how technology, derivatives and execution come together in
                        modern trading.</p>
                </div>

                <div class="speaker-highlights">
                    <h3>Key Highlights</h3>
                    <ul class="highlight-grid">
                        <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>Founder, QuantLab Technologies</li>
                        <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>Builds enterprise-grade capital-market technology</li>
                        <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>Options analytics & algorithmic execution systems</li>
                        <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>Pre-trade & intraday risk management systems</li>
                        <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>Market-data ingestion & distribution infrastructure</li>
                        <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>Portfolio & wealth technology, OMS connectivity</li>
                        <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>Professional derivatives trader — options, execution & risk</li>
                        <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M20 6L9 17l-5-5" />
                            </svg>Speaker at Finbridge Expo on expiry mechanics & volatility</li>
                    </ul>
                </div>

                <div class="speaker-social">
                    {{-- <a href="#" target="_blank" aria-label="Rajesh Srivastav Instagram"><svg viewBox="0 0 24 24"
                            fill="none" stroke-width="1.8">
                            <rect x="3" y="3" width="18" height="18" rx="5" />
                            <circle cx="12" cy="12" r="4" />
                            <circle cx="17.3" cy="6.7" r="1" fill="currentColor" stroke="none" />
                        </svg></a>
                    <a href="#" target="_blank" aria-label="Rajesh Srivastav X"><svg viewBox="0 0 24 24" fill="none"
                            stroke-width="1.8">
                            <path d="M4 4l16 16M20 4L4 20" />
                        </svg></a>
                    <a href="#" target="_blank" aria-label="Rajesh Srivastav LinkedIn"><svg viewBox="0 0 24 24"
                            fill="none" stroke-width="1.8">
                            <rect x="3" y="3" width="18" height="18" rx="3" />
                            <path d="M7 10v7M7 7v.01M11 17v-4.5a2 2 0 014-.2M15 17v-4.5" />
                        </svg></a>
                    <a href="#" target="_blank" aria-label="Rajesh Srivastav YouTube"><svg viewBox="0 0 24 24"
                            fill="none" stroke-width="1.8">
                            <rect x="3" y="3" width="18" height="18" rx="4" />
                            <polygon points="10,8 16,12 10,16" fill="currentColor" stroke="none" />
                        </svg></a> --}}
                </div>

                <div class="speaker-actions">
                    <a href="/register" class="btn btn-primary">Claim your spot</a>
                    <a href="/#speaker" class="btn btn-ghost">All Speakers</a>
                </div>
            </div>
        </div>
    </section>

    <footer>
        All copyrights are reserved © Arihant Capital Markets Limited
    </footer>

</body>

</html>