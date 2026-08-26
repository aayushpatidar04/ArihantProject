<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Google Tag Manager -->

    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':

    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],

    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=

    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);

    })(window,document,'script','dataLayer','GTM-NL23JDKS');</script>

    <!-- End Google Tag Manager -->
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ankit Rai — ArihantPLUS Speaker</title>
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

        h1, h3, .font-display {
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

    /* was the bug: position:static removed the positioning context that
       .speaker-photo-mask (position:absolute) relies on, causing it to
       balloon to full page height. Fixed to position:relative, and
       restyled as a small circular avatar to match the card design. */
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
    <!-- Google Tag Manager (noscript) -->

    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NL23JDKS"

    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

    <!-- End Google Tag Manager (noscript) -->
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
                    <img src="assets/images/24.png" alt="Ankit Rai">
                    <div class="speaker-photo-shade"></div>
                </div>
            </div>

            <div class="speaker-content">
                <span class="eyebrow">Speaker</span>
                <h1>Ankit Rai</h1>
                <p class="speaker-role">Derivatives Trader & Strategy Consultant | Options Trader, Achintya Securities</p>
                <div class="speaker-divider"></div>

                <div class="speaker-bio">
                    <p>A seasoned derivatives trader and strategy consultant with over six years of experience in Indian F&O markets. He began his trading career in 2019, gaining hands-on experience in derivatives execution and operations across multiple proprietary trading desks, including Hkkr Global and Shri Parasram Holdings.</p>
                    <p>Beyond trading, he has worked extensively on algorithmic trading and strategy development, serving as a freelance Strategy Consultant for Mastertrust, where he designed trading frameworks and helped develop execution strategies for clients.</p>
                    <p>Currently, he works as an Options Trader at Achintya Securities, focusing on F&O execution and active position management, while also building Quintal Mind — a platform at the intersection of trading, technology, and market psychology. His expertise spans options and derivatives trading, algorithmic strategy development using Python, quantitative execution, and disciplined risk management across volatile market conditions.</p>
                </div>

                <div class="speaker-highlights">
                    <h3>Key Highlights</h3>
                    <ul class="highlight-grid">
                        <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>6+ years of experience in Indian F&O markets</li>
                        <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>Options Trader at Achintya Securities</li>
                        <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>Former Strategy Consultant, Mastertrust</li>
                        <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>Experience across multiple proprietary trading desks</li>
                        <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>Algorithmic strategy development using Python</li>
                        <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>Founder, Quintal Mind</li>
                        <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>Focus on quantitative execution and risk management</li>
                    </ul>
                </div>

                <div class="speaker-social">
                    <a href="https://x.com/AnkitRai259" target="_blank" aria-label="X"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8"><path d="M4 4l16 16M20 4L4 20"/></svg></a>
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