<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vishal Mehta — ArihantPLUS Speaker</title>
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

        h1, .font-display {
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
            min-height: calc(100vh - 68px);
            padding: 90px 24px 110px;
            display: flex;
            align-items: center;
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
            grid-template-columns: 400px 1fr;
            gap: 72px;
            align-items: center;
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
            font-size: clamp(32px, 4.4vw, 50px);
            line-height: 1.1;
            margin-top: 18px;
            letter-spacing: -.01em;
        }

        .speaker-role {
            margin-top: 10px;
            font-size: 16px;
            font-weight: 600;
            color: var(--purple-1);
        }

        .speaker-divider {
            width: 64px;
            height: 3px;
            border-radius: 999px;
            margin: 24px 0;
            background: var(--btn-grad);
        }

        .speaker-bio {
            font-size: 15.5px;
            line-height: 1.8;
            color: var(--muted);
            max-width: 560px;
        }

        .speaker-social {
            display: flex;
            gap: 12px;
            margin-top: 32px;
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
            margin-top: 40px;
        }

        /* ---------- RESPONSIVE ---------- */
        @media (max-width: 900px) {
            .speaker-grid {
                grid-template-columns: 1fr;
                gap: 36px;
                text-align: center;
            }

            .speaker-photo-card {
                max-width: 300px;
                aspect-ratio: 0.85;
                margin: 0 auto;
            }

            .speaker-bio {
                margin-left: auto;
                margin-right: auto;
            }

            .speaker-social {
                justify-content: center;
            }

            .speaker-actions {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .speaker-page {
                padding: 60px 20px 80px;
            }

            .speaker-photo-card {
                max-width: 240px;
            }

            .speaker-content h1 {
                margin-top: 14px;
            }

            .speaker-bio {
                font-size: 14.5px;
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
                <svg viewBox="0 0 24 24"><path d="M15 6l-6 6 6 6" stroke-linecap="round" stroke-linejoin="round" /></svg>
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
                    <img src="assets/images/21.png" alt="Vishal Mehta">
                    <div class="speaker-photo-shade"></div>
                </div>
            </div>

            <div class="speaker-content">
                <span class="eyebrow">Speaker</span>
                <h1>Vishal Mehta</h1>
                <p class="speaker-role">Algo Trader | Market Educator</p>
                <div class="speaker-divider"></div>
                <p class="speaker-bio">
                    Vishal has spent over a decade building and trading rule-based strategies across equity and
                    derivatives markets. Known for breaking down complex algo concepts into plain language, he now
                    helps everyday traders understand how AI and automation are reshaping the way markets are read
                    and acted on.
                </p>

                <div class="speaker-social">
                    <a href="#" target="_blank" aria-label="Instagram">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                            <rect x="3" y="3" width="18" height="18" rx="5" />
                            <circle cx="12" cy="12" r="4" />
                            <circle cx="17.3" cy="6.7" r="1" fill="currentColor" stroke="none" />
                        </svg>
                    </a>
                    <a href="#" target="_blank" aria-label="X">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                            <path d="M4 4l16 16M20 4L4 20" />
                        </svg>
                    </a>
                    <a href="#" target="_blank" aria-label="LinkedIn">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                            <rect x="3" y="3" width="18" height="18" rx="3" />
                            <path d="M7 10v7M7 7v.01M11 17v-4.5a2 2 0 014-.2M15 17v-4.5" />
                        </svg>
                    </a>
                    <a href="#" target="_blank" aria-label="YouTube">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                            <rect x="3" y="3" width="18" height="18" rx="4" />
                            <polygon points="10,8 16,12 10,16" fill="currentColor" stroke="none" />
                        </svg>
                    </a>
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