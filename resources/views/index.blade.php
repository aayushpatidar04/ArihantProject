<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ArihantPLUS — Central India's Largest AI &amp; Algo Conclave</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">
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
            --panel: #0e0812;
            --purple-1: #b866f7;
            --purple-2: #8b2fd9;
            --purple-3: #6a1fb8;
            --magenta: #c92fd0;
            --ink: #f6f3fa;
            --muted: #a79bb5;
            --muted-2: #7c7188;
            --border: rgba(180, 120, 255, 0.28);
            --card-grad: linear-gradient(180deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.01) 100%);
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
        h2,
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

        section {
            position: relative;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 15px;
            padding: 13px 26px;
            border-radius: 999px;
            border: none;
            cursor: pointer;
            transition: transform .25s ease, box-shadow .25s ease, filter .25s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: var(--btn-grad);
            color: #fff;
            box-shadow: 0 8px 24px rgba(160, 40, 200, 0.45), inset 0 1px 0 rgba(255, 255, 255, 0.25);
        }

        .btn-primary:hover {
            box-shadow: 0 12px 32px rgba(190, 50, 230, 0.6), inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        .btn-white {
            background: #fff;
            color: #150a1e;
            box-shadow: 0 8px 30px rgba(200, 140, 255, 0.25);
        }

        .btn-ghost {
            background: rgba(120, 60, 180, 0.35);
            color: #e9defa;
            font-size: 13px;
            border: 1px solid rgba(180, 130, 255, 0.35);
            padding: 10px 22px;
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
            /* max-width: var(--max); */
            margin: 0 15px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 20px;
        }

        .logo .mark {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: linear-gradient(135deg, #d43fe0, #7a1fc9);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: 800;
        }

        .logo .plus {
            font-weight: 400;
            color: var(--muted);
            margin-left: 2px;
        }

        nav.links {
            display: flex;
            gap: 22px;
            font-size: 14.5px;
            color: #e9e4f0;
        }

        nav.links a {
            opacity: .85;
            transition: opacity .2s;
        }

        nav.links a:hover {
            opacity: 1;
            color: var(--purple-1);
        }

        .nav-cta {
            display: inline-flex;
        }

        .menu-toggle {
            display: none;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.14);
            align-items: center;
            justify-content: center;
            color: #f6f3fa;
            cursor: pointer;
            flex-shrink: 0;
        }

        .menu-toggle svg {
            width: 20px;
            height: 20px;
        }

        .mobile-menu {
            display: none;
            flex-direction: column;
            gap: 2px;
            position: fixed;
            left: 0;
            right: 0;
            top: 70px;
            bottom: 0;
            padding: 16px 24px 32px;
            background: #050208;
            z-index: 90;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        .mobile-menu.open {
            display: flex;
        }

        .mobile-menu a:not(.btn) {
            padding: 14px 2px;
            font-size: 15px;
            color: #e9e4f0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
        }

        .mobile-menu a:not(.btn):active {
            color: var(--purple-1);
        }

        .mobile-menu .btn {
            margin-top: 16px;
            width: 100%;
        }

        @media(max-width:1080px) {
            nav.links {
                display: none;
            }

            .nav-cta {
                display: none;
            }

            .menu-toggle {
                display: flex;
            }
        }

        @media(min-width:1081px) {
            .mobile-menu {
                display: none !important;
            }
        }

        /* ---------- HERO ---------- */
        .hero {
            padding: 64px 24px 0;
            text-align: center;
            background:
                radial-gradient(ellipse 620px 640px at 50% 0%, rgba(6, 2, 8, 0.96) 0%, rgba(6, 2, 8, 0.9) 45%, rgba(6, 2, 8, 0.55) 68%, rgba(6, 2, 8, 0.15) 85%, transparent 100%),
                linear-gradient(180deg, rgba(6, 2, 8, 0.4) 0%, rgba(6, 2, 8, 0.2) 40%, rgba(6, 2, 8, 0.08) 68%, rgba(6, 2, 8, 0.4) 100%),
                url('assets/images/skyline.png') center bottom / cover no-repeat,
                linear-gradient(180deg, #060208 0%, #0a0410 55%, #12081d 100%);
            position: relative;
            overflow: hidden;
        }

        @media(max-width:700px) {
            .hero {
                background:
                    radial-gradient(ellipse 92% 640px at 50% 0%, rgba(6, 2, 8, 0.96) 0%, rgba(6, 2, 8, 0.9) 45%, rgba(6, 2, 8, 0.55) 68%, rgba(6, 2, 8, 0.15) 85%, transparent 100%),
                    linear-gradient(180deg, rgba(6, 2, 8, 0.4) 0%, rgba(6, 2, 8, 0.2) 40%, rgba(6, 2, 8, 0.08) 68%, rgba(6, 2, 8, 0.4) 100%),
                    url('assets/images/skyline.png') center bottom / cover no-repeat,
                    linear-gradient(180deg, #060208 0%, #0a0410 55%, #12081d 100%);
            }
        }

        @media(max-width:700px) {
            .hero {
                padding-bottom: 40px;
            }
        }

        .hero-beam {
            position: absolute;
            pointer-events: none;
            user-select: none;
            mix-blend-mode: screen;
            z-index: 0;
        }

        .beam-right-top {
            top: -6%;
            right: -4%;
            width: 46%;
            max-width: 620px;
            opacity: .95;
        }

        .beam-left {
            top: 18%;
            left: -8%;
            width: 36%;
            max-width: 480px;
            opacity: .85;
        }

        .beam-right-bottom {
            bottom: -4%;
            right: 2%;
            width: 24%;
            max-width: 340px;
            opacity: .8;
        }

        .logo-img {
            height: 32px;
            width: auto;
            display: block;
        }

        .hero-video {
            position: absolute;
            top: 0;
            right: 0;
            width: 55%;
            height: 100%;
            object-fit: cover;
            opacity: .25;
            mix-blend-mode: screen;
            filter: blur(4px) saturate(.55) brightness(.85);
            -webkit-mask-image: linear-gradient(to right, transparent 0%, #000 40%);
            mask-image: linear-gradient(to right, transparent 0%, #000 40%);
            pointer-events: none;
            z-index: 1;
        }

        .hero-video-veil {
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at center 35%,
                    rgba(6, 2, 8, 0.35) 0%,
                    rgba(6, 2, 8, 0.6) 55%,
                    rgba(6, 2, 8, 0.85) 100%);
            pointer-events: none;
            z-index: 1;
        }

        .hero-sparkles {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
        }

        .spark {
            position: absolute;
            color: #e6d4ff;
            opacity: 0;
            animation: sparkTwinkle 3.4s ease-in-out infinite;
        }

        @keyframes sparkTwinkle {

            0%,
            100% {
                opacity: 0;
                transform: scale(.6);
            }

            50% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .hero>*:not(.hero-beam):not(.hero-sparkles):not(.hero-video) {
            position: relative;
            z-index: 2;
        }

        .countdown {
            display: flex;
            justify-content: center;
            gap: 18px;
            margin: 26px 0 34px;
            position: relative;
            z-index: 2;
        }

        .countdown-rays {
            position: absolute;
            left: 50%;
            top: 50%;
            width: 900px;
            height: 900px;
            transform: translate(-50%, -52%);
            background: repeating-conic-gradient(from 0deg,
                    rgba(200, 150, 255, 0.10) 0deg 1.2deg,
                    transparent 1.2deg 9deg);
            -webkit-mask-image: radial-gradient(circle at 50% 40%, rgba(0, 0, 0, 0.9) 0%, transparent 62%);
            mask-image: radial-gradient(circle at 50% 40%, rgba(0, 0, 0, 0.9) 0%, transparent 62%);
            pointer-events: none;
            z-index: -1;
            animation: raysSpin 60s linear infinite;
        }

        @keyframes raysSpin {
            from {
                transform: translate(-50%, -52%) rotate(0deg);
            }

            to {
                transform: translate(-50%, -52%) rotate(360deg);
            }
        }

        .cbox {
            width: 104px;
            height: 104px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: url('assets/images/gradiant.png') center / cover no-repeat;
            border: 1px solid rgba(200, 160, 255, 0.28);
            border-radius: 24px;
            padding: 0;
            box-shadow:
                0 18px 40px rgba(90, 30, 160, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.15);
        }

        .cbox .num {
            font-family: 'Sora', sans-serif;
            font-size: 46px;
            font-weight: 700;
            line-height: 1;
            color: #fff;
        }

        .cbox .lbl {
            font-size: 16px;
            color: var(--muted);
            margin-top: 10px;
            font-weight: 400;
        }

        @media(max-width:700px) {
            .countdown {
                gap: 12px;
                margin: 20px 0 26px;
            }

            .cbox {
                width: 76px;
                height: 76px;
                border-radius: 18px;
            }

            .cbox .num {
                font-size: 28px;
            }

            .cbox .lbl {
                font-size: 12px;
                margin-top: 5px;
            }
        }

        .hero h1 {
            font-size: clamp(34px, 5.5vw, 60px);
            font-weight: 700;
            line-height: 1.08;
            max-width: 900px;
            margin: 0 auto;
            letter-spacing: -.01em;
        }

        .hero p.sub {
            max-width: 680px;
            margin: 22px auto 0;
            color: #D5D5D5;
            font-size: clamp(15px, 1.7vw, 18px);
            line-height: 1.6;
            text-transform: capitalize;
        }

        .hero-tagline {
            font-size: clamp(36px, 5.2vw, 52px);
            font-weight: 700;
            color: #F5CDFF;
            text-shadow: 0 0 30px rgba(184, 102, 247, 0.45);
            letter-spacing: -.01em;
            margin-bottom: 6px;
        }

        .hero-pills {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 26px;
        }

        .hero-pill {
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--ink);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 999px;
            padding: 8px 18px;
            background: rgba(255, 255, 255, 0.04);
            white-space: nowrap;
        }

        @media(max-width:700px) {
            .hero-pills {
                gap: 8px;
                margin-top: 20px;
            }

            .hero-pill {
                font-size: 10.5px;
                padding: 6px 14px;
            }
        }

        .hero-pill-img {
            height: 29px;
            width: auto;
            display: block;
        }

        @media(max-width:700px) {
            .hero-pill-img {
                height: 24px;
            }
        }

        .hero-visual {
            position: relative;
            margin-top: 44px;
            height: 420px;
        }

        .hero-visual img {
            display: none;
        }

        .hero-visual::after {
            display: none;
        }

        @media(max-width:700px) {
            .hero-visual {
                margin-top: 28px;
                height: auto;
            }
        }

        /* ---------- INFO CARD (date / time / venue pill) ---------- */
        .info-card {
            position: absolute;
            left: 50%;
            top: 56px;
            transform: translateX(-50%);
            z-index: 3;
            width: fit-content;
            max-width: calc(100% - 48px);
            background: linear-gradient(90deg,
                    rgba(8, 4, 14, 0.92) 0%,
                    rgba(10, 5, 16, 0.8) 55%,
                    rgba(12, 6, 18, 0.4) 88%,
                    rgba(12, 6, 18, 0.1) 100%);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 999px;
            padding: 22px 40px;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
        }

        .info-fields {
            display: flex;
            flex-wrap: nowrap;
            align-items: center;
            gap: 36px;
        }

        .info-field {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 14px;
            color: var(--muted);
            text-align: left;
            line-height: 1.4;
            white-space: nowrap;
        }

        .info-field strong {
            color: #f6f3fa;
            font-size: 12px;
            font-weight: 600;
        }

        .info-field .ic {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .info-field .ic svg {
            width: 20px;
            height: 20px;
            stroke: #f4edfb;
            fill: none;
            stroke-width: 1.6;
        }

        @media(max-width:700px) {
            .info-card {
                position: static;
                left: auto;
                top: auto;
                transform: none;
                width: 100%;
                max-width: 100%;
                margin: 0 auto;
                padding: 0;
                background: none;
                border: none;
                box-shadow: none;
                backdrop-filter: none;
                -webkit-backdrop-filter: none;
            }

            .info-fields {
                display: grid;
                grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
                gap: 10px;
            }

            .info-field {
                white-space: normal;
                min-width: 0;
                background: rgba(8, 4, 14, 0.94);
                border: 1px solid rgba(255, 255, 255, 0.08);
                border-radius: 18px;
                padding: 14px 14px;
                backdrop-filter: blur(14px);
                -webkit-backdrop-filter: blur(14px);
                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.35);
            }

            .info-field>div {
                min-width: 0;
                overflow-wrap: break-word;
            }

            .info-field .ic {
                width: 38px;
                height: 38px;
                flex-shrink: 0;
            }

            .info-field:nth-child(3) {
                grid-column: 1 / -1;
            }
        }

        @media(max-width:360px) {
            .info-fields {
                grid-template-columns: 1fr;
            }

            .info-field:nth-child(3) {
                grid-column: 1;
            }
        }

        .info-bar {
            position: relative;
            z-index: 2;
            margin-top: -1px;
            background: linear-gradient(180deg, #160a22, #0c0614);
            border-top: 1px solid rgba(255, 255, 255, 0.06);
        }

        .info-inner {
            max-width: var(--max);
            margin: 0 auto;
            padding: 22px 24px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .price-tiers {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .price-tier {
            display: flex;
            align-items: baseline;
            gap: 10px;
            flex-wrap: wrap;
            font-size: 14px;
            color: var(--muted);
        }

        .price-tier .tier-label {
            white-space: nowrap;
        }

        .price-old {
            color: var(--muted-2);
            text-decoration: line-through;
            font-size: 14px;
        }

        .price-new {
            font-weight: 700;
            font-size: 16px;
            color: var(--ink);
        }

        .price-tier.client .tier-label {
            color: var(--muted);
        }

        .price-tier.client .price-new {
            color: var(--purple-1);
            font-size: 16px;
        }

        @media(max-width:600px) {
            .info-inner {
                justify-content: space-between;
                text-align: left;
                flex-direction: row;
                flex-wrap: nowrap;
                gap: 12px;
                padding: 18px 16px;
            }

            .price-tiers {
                align-items: flex-start;
                flex-shrink: 1;
                min-width: 0;
                gap: 4px;
            }

            .price-tier {
                justify-content: flex-start;
                flex-wrap: wrap;
                font-size: 12.5px;
            }

            .price-tier .price-new {
                font-size: 14px;
            }

            .price-tier.client .price-new {
                font-size: 14px;
            }

            .info-inner .btn {
                flex-shrink: 0;
                padding: 11px 18px;
                font-size: 13.5px;
                white-space: nowrap;
            }
        }

        /* ---------- SECTION HEADS ---------- */
        .section-head {
            text-align: center;
            max-width: 640px;
            margin: 0 auto 48px;
        }

        .section-head h2 {
            font-size: clamp(32px, 5.2vw, 52px);
            font-weight: 800;
            letter-spacing: -.01em;
        }

        .section-head.purple h2 {
            color: var(--purple-1);
            text-shadow: 0 0 40px rgba(184, 102, 247, 0.45);
        }

        .section-head p {
            color: var(--muted);
            margin-top: 12px;
            font-size: 15px;
            line-height: 1.6;
        }

        /* ---------- LEARN / GET WRAPPER (shared top-left glow) ---------- */
        .learn-get-wrap {
            position: relative;
            overflow: hidden;
            background: linear-gradient(180deg, var(--bg) 0%, var(--bg) 55%, var(--bg-soft) 55%, var(--bg-soft) 100%);
        }

        .lg-glow {
            position: absolute;
            top: 0;
            left: 0;
            pointer-events: none;
            user-select: none;
            mix-blend-mode: screen;
            z-index: 0;
        }

        .lg-glow-soft {
            width: 520px;
            max-width: 65%;
        }

        .lg-glow-beam {
            width: 400px;
            max-width: 52%;
            top: 0;
            left: 0;
        }

        /* ---------- LEARN / GET CARDS ---------- */
        .learn {
            padding: 90px 24px 70px;
            position: relative;
        }

        .learn>* {
            position: relative;
            z-index: 1;
        }

        .grid6 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            max-width: var(--max);
            margin: 0 auto;
        }

        @media(max-width:900px) {
            .grid6 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:600px) {
            .grid6 {
                grid-template-columns: 1fr;
            }
        }

        .card {
            background: linear-gradient(160deg, rgba(22, 12, 30, 0.9) 0%, rgba(8, 4, 12, 0.96) 100%);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 28px 26px 24px;
            text-align: center;
            position: relative;
            overflow: hidden;
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .card::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 20px;
            padding: 1.5px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.05) 55%, rgba(216, 110, 255, 0.55) 85%, rgba(224, 110, 255, 0.95) 100%);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 1;
            transition: opacity .3s ease;
            pointer-events: none;
        }

        .card::after {
            content: "";
            position: absolute;
            left: 8%;
            right: 8%;
            bottom: 0;
            height: 36px;
            background: radial-gradient(ellipse at center, rgba(210, 120, 255, 0.5) 0%, transparent 72%);
            filter: blur(10px);
            pointer-events: none;
            z-index: 0;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 24px 48px rgba(140, 40, 200, 0.35);
        }

        .card:hover::before {
            opacity: 1;
        }

        .card>* {
            position: relative;
            z-index: 1;
        }

        .icon-circle {
            width: 64px;
            height: 64px;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .icon-circle img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }

        .card h3 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .card p {
            font-size: 14.5px;
            color: var(--muted);
            line-height: 1.55;
        }

        .get {
            padding: 20px 24px 90px;
            position: relative;
        }

        .get>* {
            position: relative;
            z-index: 1;
        }

        .center-btn {
            text-align: center;
            margin-top: 44px;
        }

        .center-btn.left {
            text-align: center;
            max-width: var(--max);
            margin: 44px auto 0;
            padding: 0 24px;
        }

        /* ---------- SCHEDULE ---------- */
        .schedule {
            padding: 100px 24px;
            background: #000;
            position: relative;
            overflow: hidden;
        }

        .schedule-glow {
            position: absolute;
            top: 10%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(150, 60, 230, 0.35), transparent 70%);
            filter: blur(20px);
            pointer-events: none;
        }

        .schedule-box {
            max-width: var(--max);
            margin: 0 auto;
            position: relative;
            z-index: 2;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.03), rgba(0, 0, 0, 0));
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 10px 40px;
            overflow: visible;
            box-shadow:
                -35px -25px 90px rgba(150, 90, 230, 0.14),
                55px 55px 120px rgba(210, 90, 235, 0.30),
                inset 0 0 40px rgba(150, 60, 230, 0.05);
        }

        .schedule-box::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 24px;
            padding: 1.4px;
            pointer-events: none;
            z-index: 3;
            background:
                radial-gradient(150px 150px at 0% 0%, rgba(240, 215, 255, 0.95) 0%, rgba(200, 140, 255, 0.35) 45%, transparent 72%),
                radial-gradient(210px 210px at 100% 100%, rgba(226, 140, 255, 0.95) 0%, rgba(190, 80, 225, 0.4) 45%, transparent 72%),
                linear-gradient(180deg, rgba(255, 255, 255, 0.07), rgba(255, 255, 255, 0.07));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
        }

        .corner-light {
            position: absolute;
            pointer-events: none;
            user-select: none;
            mix-blend-mode: screen;
            z-index: 1;
        }

        .corner-light-tl-1 {
            top: -72px;
            left: -160px;
            width: 480px;
            opacity: .5;
        }

        .corner-light-tl-2 {
            top: -42px;
            left: -125px;
            width: 420px;
            opacity: .7;
            transform: rotate(-4deg);
        }

        .corner-light-tl-3 {
            top: -98px;
            left: -182px;
            width: 380px;
            opacity: .45;
            transform: rotate(5deg);
        }

        .corner-light-br-1 {
            bottom: -160px;
            right: -150px;
            width: 500px;
            opacity: .7;
        }

        .corner-light-br-2 {
            bottom: -95px;
            right: -70px;
            width: 360px;
            opacity: .85;
        }

        @media(max-width:760px) {

            .corner-light-tl-1,
            .corner-light-tl-2,
            .corner-light-tl-3,
            .corner-light-br-1,
            .corner-light-br-2 {
                width: 260px;
            }
        }

        .agenda-wrap {
            position: relative;
            z-index: 2;
        }

        .agenda-item {
            display: flex;
            align-items: flex-start;
            gap: 28px;
            padding: 28px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            flex-wrap: wrap;
        }

        .agenda-item:last-child {
            border-bottom: none;
        }

        .agenda-time {
            width: 150px;
            flex-shrink: 0;
            color: var(--muted);
            font-size: 15px;
            font-weight: 500;
        }

        .agenda-body {
            flex: 1;
            min-width: 220px;
        }

        .agenda-body h4 {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: .02em;
            margin-bottom: 6px;
        }

        .agenda-body p {
            font-size: 14px;
            color: var(--muted);
            line-height: 1.55;
        }

        .pill {
            background: #f4defc;
            color: #8a1fae;
            font-size: 12.5px;
            font-weight: 600;
            padding: 7px 18px;
            border-radius: 999px;
            height: fit-content;
            flex-shrink: 0;
        }

        /* ---------- EVENT GALLERY ---------- */
        .gallery {
            padding: 100px 24px;
            background: var(--bg-soft);
            position: relative;
            overflow: hidden;
        }

        .gallery>* {
            position: relative;
            z-index: 1;
        }

        .gallery-side-glow {
            position: absolute;
            top: 0;
            left: 0;
            pointer-events: none;
            user-select: none;
            mix-blend-mode: screen;
            z-index: 0;
        }

        .gallery-side-glow-soft {
            width: 520px;
            max-width: 65%;
        }

        .gallery-side-glow-beam {
            width: 400px;
            max-width: 52%;
            top: 0;
            left: 0;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            max-width: var(--max);
            margin: 0 auto;
        }

        .gallery-item {
            position: relative;
            border-radius: 18px;
            overflow: hidden;
            cursor: pointer;
            border: 1px solid rgba(255, 255, 255, 0.06);
            background: linear-gradient(160deg, rgba(70, 26, 112, 0.4) 0%, rgba(10, 4, 16, 0.97) 60%);
            aspect-ratio: 3/2;
            opacity: 0;
            transform: translateY(30px);
            box-shadow: 0 10px 26px rgba(100, 30, 160, 0.16);
            transition: opacity .7s ease, transform .7s ease, box-shadow .4s ease, border-color .35s ease;
        }

        .gallery-item.reveal {
            opacity: 1;
            transform: translateY(0);
        }

        .gallery-item.hidden {
            display: none;
        }

        .gallery-item img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .7s cubic-bezier(.2, .8, .2, 1), filter .5s ease;
            filter: saturate(1.02);
        }

        .gallery-item:hover img {
            transform: scale(1.09);
        }

        .gallery-item::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 18px;
            padding: 1.5px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0.08) 55%, rgba(216, 110, 255, 0.6) 85%, rgba(224, 110, 255, 1) 100%);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: .4;
            transition: opacity .4s ease;
            pointer-events: none;
            z-index: 3;
        }

        .gallery-item:hover::before {
            opacity: 1;
        }

        .gallery-item:hover {
            box-shadow:
                0 24px 55px rgba(140, 40, 200, 0.42),
                0 0 0 4px rgba(184, 102, 247, 0.3),
                0 0 46px rgba(184, 102, 247, 0.32);
        }

        .gallery-shade {
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            background: linear-gradient(180deg, rgba(6, 2, 8, 0) 38%, rgba(6, 2, 8, 0.88) 100%);
        }

        .gallery-overlay {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 20px 22px;
            z-index: 2;
            transform: translateY(10px);
            opacity: .94;
            transition: transform .35s ease;
        }

        .gallery-item:hover .gallery-overlay {
            transform: translateY(0);
        }

        .gallery-cat {
            display: inline-block;
            background: #f4defc;
            color: #8a1fae;
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: .02em;
            padding: 5px 14px;
            border-radius: 999px;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .gallery-overlay h4 {
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            font-family: 'Sora', sans-serif;
            line-height: 1.35;
        }

        .gallery-zoom-hint {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(8, 4, 14, 0.55);
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            opacity: .4;
            transform: scale(.9);
            transition: opacity .3s ease, transform .3s ease;
        }

        .gallery-item:hover .gallery-zoom-hint {
            opacity: 1;
            transform: scale(1);
        }

        .gallery-zoom-hint svg {
            width: 16px;
            height: 16px;
            stroke: #fff;
            fill: none;
            stroke-width: 1.8;
        }

        @media(max-width:900px) {
            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media(max-width:600px) {
            .gallery-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }
        }

        .gallery-more-wrap {
            text-align: center;
            margin-top: 44px;
        }

        .gallery-more-btn {
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 600;
            color: var(--ink);
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border);
            padding: 13px 34px;
            border-radius: 999px;
            cursor: pointer;
            transition: background .25s ease, border-color .25s ease, transform .25s ease, box-shadow .25s ease;
        }

        .gallery-more-btn:hover {
            background: rgba(184, 102, 247, 0.15);
            border-color: rgba(184, 102, 247, 0.55);
            transform: translateY(-2px);
        }

        .gallery-more-btn.hidden {
            display: none;
        }

        /* Lightbox */
        .lightbox-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 1000;
            background: rgba(3, 1, 6, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .lightbox-overlay.open {
            display: flex;
        }

        .lightbox-inner {
            position: relative;
            max-width: 960px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .lightbox-media {
            position: relative;
            max-width: 100%;
            max-height: 82vh;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.65);
            background: #0a0410;
            opacity: 0;
            transform: scale(.96);
            transition: opacity .35s ease, transform .35s ease;
        }

        .lightbox-overlay.open .lightbox-media {
            opacity: 1;
            transform: scale(1);
        }

        .lightbox-media img {
            display: block;
            max-width: 100%;
            max-height: 82vh;
            width: auto;
            height: auto;
            margin: 0 auto;
            object-fit: contain;
        }

        .lightbox-caption {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 22px 26px;
            background: linear-gradient(180deg, rgba(6, 2, 8, 0) 0%, rgba(6, 2, 8, 0.85) 100%);
        }

        .lightbox-caption h4 {
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            font-family: 'Sora', sans-serif;
            margin-top: 6px;
        }

        .lightbox-close {
            position: absolute;
            top: -52px;
            right: 0;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            cursor: pointer;
            z-index: 5;
            transition: background .2s, transform .2s;
        }

        .lightbox-close:hover {
            background: rgba(184, 102, 247, 0.25);
            transform: rotate(90deg);
        }

        .lightbox-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: rgba(10, 5, 16, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.16);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            cursor: pointer;
            z-index: 5;
            transition: background .25s, border-color .25s, transform .25s;
        }

        .lightbox-nav svg {
            width: 20px;
            height: 20px;
            stroke: #fff;
            fill: none;
            stroke-width: 2;
        }

        .lightbox-nav:hover {
            background: rgba(184, 102, 247, 0.3);
            border-color: rgba(184, 102, 247, 0.6);
        }

        .lightbox-prev {
            left: -16px;
        }

        .lightbox-next {
            right: -16px;
        }

        .lightbox-counter {
            position: absolute;
            top: -52px;
            left: 0;
            color: var(--muted);
            font-size: 13px;
            font-weight: 500;
        }

        @media(max-width:760px) {
            .lightbox-close {
                top: -48px;
                width: 38px;
                height: 38px;
            }

            .lightbox-nav {
                width: 42px;
                height: 42px;
            }

            .lightbox-prev {
                left: 4px;
            }

            .lightbox-next {
                right: 4px;
            }

            .lightbox-counter {
                top: -46px;
            }
        }

        /* Respect reduced motion across the whole page */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: .001ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .001ms !important;
                scroll-behavior: auto !important;
            }

            .gallery-item {
                opacity: 1;
                transform: none;
            }

            .gallery-item:hover img {
                transform: none;
            }
        }

        /* ---------- PANELIST ---------- */
        .panel-sec {
            padding: 100px 24px;
            background: var(--bg-soft);
            position: relative;
            overflow: hidden;
        }

        .panel-sec .center-btn {
            position: relative;
            z-index: 1;
        }

        .panelist-slider-wrap {
            max-width: var(--max);
            margin: 0 auto;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        .panelist-track {
            display: flex;
            gap: 32px;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scrollbar-width: none;
            -ms-overflow-style: none;
            padding: 14px 24px 18px;
        }

        .panelist-track::-webkit-scrollbar {
            display: none;
        }

        .panelist-slide {
            flex: 0 0 30%;
            scroll-snap-align: start;
        }

        @media(max-width:900px) {
            .panelist-slide {
                flex: 0 0 46%;
            }
        }

        @media(max-width:600px) {
            .panelist-track {
                padding: 14px 26px 18px;
                gap: 20px;
                scroll-padding: 0 26px;
            }

            .panelist-slide {
                flex: 0 0 88%;
                scroll-snap-align: start;
            }

            .panelist-nav {
                width: 100%;
                justify-content: center;
                margin: 22px 0 40px;
                padding: 0 24px;
            }
        }


        .panelist-photo-card {
            position: relative;
            border-radius: 28px;
            aspect-ratio: 0.95;
            background: #1c0e30;
            border: 4px solid #0a0410;
            box-shadow: 0 0 0 10px rgba(255, 255, 255, 0.18);
            padding: 0;
        }

        .panelist-photo-mask {
            position: absolute;
            inset: 0;
            border-radius: 24px;
            overflow: hidden;
        }

        .panelist-photo-card img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top center;
        }

        .panelist-info {
            padding: 16px 4px 0;
        }

        .panelist-info h4 {
            font-size: 17px;
            font-weight: 700;
            color: #fff;
            text-transform: capitalize;
            margin: 0;
        }

        .panelist-info span {
            font-size: 13.5px;
            color: var(--muted);
            display: block;
        }

        .panelist-photo-shade {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg,
                    rgba(6, 2, 8, 0) 30%,
                    rgba(6, 2, 8, 0.55) 62%,
                    rgba(6, 2, 8, 0.92) 100%);
            pointer-events: none;
            z-index: 1;
        }

        .panelist-info {
            position: absolute;
            left: 18px;
            right: 18px;
            bottom: 18px;
            z-index: 2;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .panelist-social {
            display: flex;
            gap: 8px;
        }

        .panelist-social a {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: #4D4D4D;
            border: 1px solid rgba(255, 255, 255, 0.18);
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            transition: background .2s ease, transform .2s ease;
        }

        .panelist-social a:hover {
            background: rgba(184, 102, 247, 0.35);
            transform: translateY(-2px);
        }

        .panelist-social svg {
            width: 16px;
            height: 16px;
            stroke: #fff;
            fill: none;
        }

        .panelist-know-btn {
            margin-top: 2px;
            align-self: flex-start;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 9px 22px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            background: rgba(6, 2, 8, 0.35);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            transition: background .2s ease, border-color .2s ease;
        }

        .panelist-know-btn:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: #fff;
        }

        .panelist-nav {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            max-width: var(--max);
            margin: 22px auto 40px;
            padding: 0 24px;
            position: relative;
            z-index: 1;
        }

        .panelist-arrow {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            flex-shrink: 0;
            background: #f4f1f7;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform .2s ease, background .2s ease;
        }

        .panelist-arrow:hover {
            background: #fff;
            transform: translateY(-2px);
        }

        .panelist-arrow:disabled {
            opacity: .35;
            cursor: default;
            transform: none;
        }

        .panelist-arrow svg {
            width: 18px;
            height: 18px;
            stroke: #150a1e;
            stroke-width: 2;
            fill: none;
        }

        @media(max-width:600px) {
            .panelist-nav {
                width: 100%;
                justify-content: center;
                margin: 22px 0 40px;
                padding: 0 24px;
            }
        }

        @media(max-width:600px) {
            .panelist-info {
                gap: 5px;
                left: 12px;
                right: 12px;
                bottom: 12px;
            }

            .panelist-social a {
                width: 26px;
                height: 26px;
                border-radius: 8px;
            }

            .panelist-social svg {
                width: 13px;
                height: 13px;
            }

            .panelist-info h4 {
                font-size: 14px;
            }

            .panelist-info span {
                font-size: 11.5px;
            }

            .panelist-know-btn {
                padding: 6px 16px;
                font-size: 11.5px;
                margin-top: 0;
            }
        }

        /* ---------- INVITE & EARN (FIXED) ---------- */
        .invite {
            padding: 130px 24px 110px;
            background: #000;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .invite-sphere {
            width: min(760px, 94vw);
            height: min(760px, 94vw);
            margin: 0 auto;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .sphere-img {
            position: absolute;
            transform: translate(-50%, -50%);
            pointer-events: none;
            user-select: none;
            mix-blend-mode: screen;
            width: min(660px, 90vw);
            height: min(660px, 90vw);
        }

        .sphere-img-left {
            top: 45%;
            left: 42%;
            opacity: .9;
            z-index: 0;
        }

        .sphere-img-right {
            top: 45%;
            left: 58%;
            opacity: .9;
            z-index: 0;
        }

        .sphere-img-base {
            top: 50%;
            left: 50%;
            z-index: 2;
            opacity: 1;
        }

        .invite-sphere>*:not(.sphere-img) {
            position: relative;
            z-index: 2;
        }

        .invite h2 {
            font-size: clamp(30px, 4.5vw, 44px);
            font-weight: 700;
        }

        .invite p {
            color: #f0e6fa;
            max-width: 460px;
            margin: 18px auto 0;
            font-size: 15px;
            line-height: 1.6;
        }

        .invite .btn-ghost {
            margin-top: 26px;
        }

        .invite .btn-primary {
            margin-top: 16px;
        }

        /* ---------- READY TO TRADE / SPHERE ---------- */
        .cta-sphere-sec {
            padding: 110px 24px 260px;
            background: #000;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        /* Fan of soft diagonal light beams rising from each bottom corner toward
     the orb — screen-blended, untouched originals, several per side so it
     reads as a converging glow rather than two flat beams. */
        .light-ray {
            position: absolute;
            bottom: -6%;
            pointer-events: none;
            user-select: none;
            mix-blend-mode: screen;
            z-index: 0;
        }

        /* left family: mirrored so each beam's bright source points inward
     toward the orb instead of outward off the edge of the page */
        .light-ray-left-1 {
            left: -6%;
            bottom: -8%;
            width: min(360px, 42vw);
            opacity: .55;
            transform: scaleX(-1);
        }

        .light-ray-left-2 {
            left: 0%;
            bottom: -10%;
            width: min(460px, 48vw);
            opacity: .45;
            transform: scaleX(-1);
        }

        .light-ray-left-3 {
            left: 8%;
            bottom: -5%;
            width: min(300px, 36vw);
            opacity: .6;
            transform: scaleX(-1);
        }

        /* right family: mirrored so each beam's bright source points inward
     toward the orb instead of outward off the edge of the page */
        .light-ray-right-1 {
            right: -6%;
            bottom: -8%;
            width: min(360px, 42vw);
            opacity: .55;
            transform: scaleX(-1);
        }

        .light-ray-right-2 {
            right: 0%;
            bottom: -10%;
            width: min(460px, 48vw);
            opacity: .45;
            transform: scaleX(-1);
        }

        .light-ray-right-3 {
            right: 8%;
            bottom: -5%;
            width: min(300px, 36vw);
            opacity: .6;
            transform: scaleX(-1);
        }

        /* Two DISTINCT glass-shard assets (not one image mirrored twice) — left
     skews blue/violet, right skews pink/magenta, matching the reference.
     They anchor to the bottom edge and flare outward past the padding. */
        .shard {
            position: absolute;
            bottom: -70px;
            width: 320px;
            max-width: 38vw;
            pointer-events: none;
            z-index: 1;
            opacity: .95;
            filter: drop-shadow(0 30px 70px rgba(120, 40, 200, 0.4));
        }

        .shard.left {
            left: -50px;
        }

        .shard.right {
            right: -50px;
        }

        .cta-sphere-sec .wrap-inner {
            position: relative;
            z-index: 3;
            max-width: 640px;
            margin: 0 auto;
        }

        .cta-sphere-sec h2 {
            font-size: clamp(32px, 5vw, 50px);
            font-weight: 700;
            line-height: 1.12;
        }

        .cta-sphere-sec p {
            color: var(--muted);
            margin: 20px auto 0;
            max-width: 520px;
            font-size: 15.5px;
            line-height: 1.6;
        }

        .cta-sphere-sec .btn-white {
            margin-top: 34px;
        }

        .orb-stage {
            margin: 70px auto 0;
            width: 380px;
            height: 380px;
            position: relative;
            perspective: 900px;
        }

        .orb-wobble {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            position: relative;
            z-index: 2;
        }

        .orb-mask {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            overflow: hidden;
            position: relative;
            background: transparent;
        }

        .orb-img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        /* ---------- FAQ ---------- */
        .faq {
            padding: 100px 24px;
            background: var(--bg-soft);
        }

        .faq-inner {
            max-width: var(--max);
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1.4fr;
            gap: 60px;
        }

        @media(max-width:800px) {
            .faq-inner {
                grid-template-columns: 1fr;
                gap: 36px;
            }
        }

        .faq-inner h2 {
            font-size: clamp(28px, 4vw, 38px);
            font-weight: 700;
            line-height: 1.15;
        }

        .faq-inner .faq-lead p {
            color: var(--muted);
            margin-top: 14px;
            font-size: 15px;
            line-height: 1.6;
            max-width: 340px;
        }

        .faq-item {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 20px 0;
        }

        .faq-q {
            display: flex;
            align-items: center;
            gap: 16px;
            cursor: pointer;
            user-select: none;
        }

        .faq-q .dot {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 15px;
            transition: background .25s, border-color .25s;
        }

        .faq-item.open .faq-q .dot {
            background: rgba(180, 110, 255, 0.2);
            border-color: var(--purple-1);
        }

        .faq-q h4 {
            font-size: 15.5px;
            font-weight: 600;
        }

        .faq-a {
            max-height: 0;
            overflow: hidden;
            transition: max-height .35s ease;
            padding-left: 44px;
            color: var(--muted);
            font-size: 14.5px;
            line-height: 1.7;
        }

        .faq-item.open .faq-a {
            max-height: 260px;
            padding-top: 14px;
        }

        .faq-q .dot svg {
            transition: transform .25s;
        }

        .faq-item.open .faq-q .dot svg {
            transform: rotate(45deg);
        }

        /* ---------- FOOTER ---------- */
        footer {
            background: #000;
            padding: 80px 24px 30px;
            position: relative;
            overflow: hidden;
        }

        .footer-social {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-bottom: 60px;
            position: relative;
            z-index: 2;
        }

        .social-ic {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            border: 1px solid rgba(180, 120, 255, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .2s, transform .2s;
        }

        .social-ic:hover {
            background: rgba(180, 120, 255, 0.15);
            transform: translateY(-3px);
        }

        .social-ic svg {
            width: 22px;
            height: 22px;
            stroke: var(--purple-1);
        }

        .footer-bottom {
            max-width: var(--max);
            margin: 0 auto;
            padding-top: 26px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 13.5px;
            color: var(--muted-2);
            position: relative;
            z-index: 2;
        }

        .footer-bottom .heart {
            color: #c92fd0;
        }

        .footer-glow {
            position: absolute;
            bottom: -40%;
            left: 50%;
            transform: translateX(-50%);
            width: 120%;
            height: 340px;
            background: radial-gradient(ellipse at center, rgba(150, 50, 220, 0.35), transparent 70%);
            filter: blur(10px);
            pointer-events: none;
        }

        ::selection {
            background: rgba(180, 80, 255, 0.4);
        }

        /* ---------- RESERVE / CLAIM MODAL ---------- */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 1000;
            background: rgba(3, 1, 6, 0.72);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-overlay.open {
            display: flex;
        }

        .modal-card {
            position: relative;
            width: 100%;
            max-width: 460px;
            background: linear-gradient(165deg, #170b22 0%, #0b0511 65%, #0a0410 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 26px;
            padding: 38px 34px 34px;
            overflow: hidden;
            box-shadow: 0 40px 90px rgba(0, 0, 0, 0.6);
        }

        .modal-card::before {
            content: "";
            position: absolute;
            top: -45%;
            left: -32%;
            width: 75%;
            height: 85%;
            background: radial-gradient(circle, rgba(196, 120, 255, 0.4) 0%, rgba(140, 70, 220, 0.14) 45%, transparent 75%);
            filter: blur(22px);
            pointer-events: none;
            z-index: 0;
        }

        .modal-card::after {
            content: "";
            position: absolute;
            right: 0;
            bottom: 0;
            width: 55%;
            height: 60%;
            background-image: radial-gradient(rgba(255, 255, 255, 0.14) 1px, transparent 1.4px);
            background-size: 9px 9px;
            -webkit-mask-image: radial-gradient(circle at 100% 100%, rgba(0, 0, 0, 0.9) 0%, transparent 70%);
            mask-image: radial-gradient(circle at 100% 100%, rgba(0, 0, 0, 0.9) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        .modal-close {
            position: absolute;
            top: 18px;
            right: 18px;
            z-index: 2;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.14);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f6f3fa;
            cursor: pointer;
        }

        .modal-close svg {
            width: 14px;
            height: 14px;
        }

        .modal-title {
            position: relative;
            z-index: 1;
            font-family: 'Sora', sans-serif;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: .01em;
            margin-bottom: 26px;
        }

        .modal-field {
            position: relative;
            z-index: 1;
            width: 100%;
            background: rgba(255, 255, 255, 0.055);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            padding: 16px 18px;
            color: var(--ink);
            font-size: 14.5px;
            font-family: 'Inter', sans-serif;
            margin-bottom: 14px;
            outline: none;
            transition: border-color .2s;
        }

        .modal-field::placeholder {
            color: rgba(230, 220, 240, 0.4);
        }

        .modal-field:focus {
            border-color: rgba(184, 102, 247, 0.55);
        }

        .modal-check-row {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 6px 0 24px;
            font-size: 13px;
            color: var(--muted);
        }

        .modal-check-row input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            width: 17px;
            height: 17px;
            flex-shrink: 0;
            border-radius: 5px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.05);
            cursor: pointer;
            position: relative;
        }

        .modal-check-row input[type="checkbox"]:checked {
            background: var(--btn-grad);
            border-color: transparent;
        }

        .modal-check-row input[type="checkbox"]:checked::after {
            content: "";
            position: absolute;
            left: 5px;
            top: 1px;
            width: 4px;
            height: 9px;
            border: solid #fff;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .modal-check-row a {
            color: var(--purple-1);
            font-weight: 500;
        }

        .modal-check-row a:hover {
            text-decoration: underline;
        }

        .modal-submit {
            position: relative;
            z-index: 1;
            width: 100%;
        }

        @media(max-width:480px) {
            .modal-card {
                padding: 30px 22px 26px;
                border-radius: 22px;
            }
        }

        /* ---------- VIDEOS ---------- */
        .videos-sec {
            padding: 100px 24px;
            background: var(--bg);
            position: relative;
            overflow: hidden;
        }

        .videos-sec::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            background:
                radial-gradient(700px 500px at 12% 20%, rgba(184, 102, 247, 0.16), transparent 65%),
                radial-gradient(760px 560px at 90% 85%, rgba(201, 47, 208, 0.14), transparent 65%);
        }

        .videos-glow {
            position: absolute;
            pointer-events: none;
            user-select: none;
            z-index: 0;
            border-radius: 50%;
            filter: blur(70px);
        }

        .videos-glow-1 {
            top: -8%;
            left: -6%;
            background: radial-gradient(circle, rgba(184, 102, 247, 0.4), transparent 70%);
        }

        .videos-glow-2 {
            bottom: -16%;
            right: -8%;
            background: radial-gradient(circle, rgba(201, 47, 208, 0.35), transparent 70%);
        }

        .videos-sec::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 140%;
            height: 33%;
            background: radial-gradient(ellipse at center bottom, rgba(150, 50, 220, 0.55) 0%, rgba(120, 30, 190, 0.3) 45%, transparent 75%);
            filter: blur(30px);
            pointer-events: none;
            z-index: 0;
        }

        .videos-sec>* {
            position: relative;
            z-index: 1;
        }

        .video-layout {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 28px;
            align-items: start;
        }

        @media(max-width:900px) {
            .video-layout {
                grid-template-columns: 1fr;
            }
        }

        /* Main player — animated rotating gradient ring instead of the static
     mask-border pattern used on cards/gallery elsewhere on the page */
        .video-main {
            background: linear-gradient(160deg, rgba(70, 26, 112, 0.3) 0%, rgba(8, 4, 12, 0.97) 60%);
            border-radius: 22px;
            padding: 14px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(90, 30, 160, 0.25);
        }

        .video-main::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 22px;
            padding: 2.5px;
            z-index: 1;
            background: linear-gradient(160deg,
                    rgba(201, 47, 208, 0.85) 0%,
                    rgba(216, 110, 255, 0.5) 12%,
                    rgba(255, 255, 255, 0.06) 30%,
                    rgba(255, 255, 255, 0.06) 70%,
                    rgba(216, 110, 255, 0.5) 88%,
                    rgba(201, 47, 208, 0.85) 100%);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        .video-main>* {
            position: relative;
            z-index: 2;
        }

        .video-frame-wrap {
            position: relative;
            width: 100%;
            aspect-ratio: 16/9;
            border-radius: 14px;
            overflow: hidden;
            background:
                radial-gradient(circle at 25% 20%, rgba(184, 102, 247, 0.35), transparent 55%),
                radial-gradient(circle at 80% 85%, rgba(201, 47, 208, 0.3), transparent 55%),
                linear-gradient(160deg, #2a1240 0%, #180a28 55%, #0a0410 100%);
            cursor: pointer;
        }

        .video-frame-wrap::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.045) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.045) 1px, transparent 1px);
            background-size: 22px 22px;
        }

        .video-frame-wrap iframe {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        .video-frame-wrap img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video-frame-wrap .video-shade {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(6, 2, 8, 0.15) 0%, rgba(6, 2, 8, 0.55) 100%);
        }

        .video-play-btn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 76px;
            height: 76px;
            border-radius: 50%;
            background: var(--btn-grad);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 34px rgba(160, 40, 200, 0.55), inset 0 1px 0 rgba(255, 255, 255, 0.3);
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .video-frame-wrap:hover .video-play-btn {
            transform: translate(-50%, -50%) scale(1.08);
            box-shadow: 0 14px 42px rgba(190, 50, 230, 0.7);
        }

        .video-play-btn svg {
            width: 26px;
            height: 26px;
            fill: #fff;
            margin-left: 4px;
        }

        .video-info {
            padding: 20px 10px 6px;
            position: relative;
            z-index: 1;
        }

        .video-tag {
            display: inline-block;
            background: #f4defc;
            color: #8a1fae;
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: .02em;
            padding: 5px 14px;
            border-radius: 999px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .video-info h3 {
            font-size: 18px;
            font-weight: 700;
            font-family: 'Sora', sans-serif;
            line-height: 1.35;
        }

        .video-playlist {
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-height: 520px;
            overflow-y: auto;
            padding-right: 4px;
        }

        .video-playlist::-webkit-scrollbar {
            width: 6px;
        }

        .video-playlist::-webkit-scrollbar-thumb {
            background: rgba(184, 102, 247, 0.35);
            border-radius: 999px;
        }

        .video-playlist::-webkit-scrollbar-track {
            background: transparent;
        }

        .video-playlist-item {
            display: flex;
            gap: 12px;
            align-items: center;
            cursor: pointer;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 14px;
            padding: 8px;
            transition: background .25s ease, border-color .25s ease, transform .25s ease, box-shadow .25s ease;
        }

        .video-playlist-item:hover {
            background: rgba(184, 102, 247, 0.1);
            border-color: rgba(184, 102, 247, 0.4);
            transform: translateX(-2px);
            box-shadow: 0 0 0 1px rgba(184, 102, 247, 0.2), 0 10px 26px rgba(140, 40, 200, 0.22);
        }

        .video-playlist-item:hover .video-thumb .video-thumb-play {
            background: rgba(140, 40, 200, 0.32);
        }

        .video-playlist-item.active {
            background: rgba(184, 102, 247, 0.16);
            border-color: rgba(184, 102, 247, 0.6);
            box-shadow: 0 0 0 1px rgba(184, 102, 247, 0.35), 0 10px 30px rgba(140, 40, 200, 0.32);
        }

        .video-thumb {
            position: relative;
            flex-shrink: 0;
            width: 104px;
            aspect-ratio: 16/9;
            border-radius: 9px;
            overflow: hidden;
            background:
                radial-gradient(circle at 25% 20%, rgba(184, 102, 247, 0.35), transparent 60%),
                linear-gradient(160deg, #2a1240 0%, #180a28 60%, #0a0410 100%);
        }

        .video-frame-wrap img[data-broken="1"],
        .video-thumb img[data-broken="1"] {
            display: none;
        }

        .video-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video-thumb .video-thumb-play {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(6, 2, 8, 0.25);
            transition: background .25s ease;
        }

        .video-thumb .video-thumb-play svg {
            width: 20px;
            height: 20px;
            fill: #fff;
            opacity: .9;
        }

        .video-playlist-item.active .video-thumb .video-thumb-play {
            background: rgba(140, 40, 200, 0.4);
        }

        .video-meta {
            min-width: 0;
        }

        .video-meta h4 {
            font-size: 13.5px;
            font-weight: 600;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .video-meta span {
            font-size: 11.5px;
            color: var(--muted);
            margin-top: 4px;
            display: inline-block;
        }

        @media(max-width:900px) {
            .video-playlist {
                flex-direction: row;
                max-height: none;
                overflow-x: auto;
                overflow-y: visible;
                padding-bottom: 6px;
            }

            .video-playlist-item {
                flex-direction: column;
                align-items: stretch;
                width: 180px;
                flex-shrink: 0;
            }

            .video-thumb {
                width: 100%;
            }
        }

        /* ---------- PRICING ---------- */
        .pricing-sec {
            position: relative;
            overflow: hidden;
            padding: 100px 24px;
            background: var(--bg);
        }

        .pricing-sec .lg-glow {
            position: absolute;
            top: 0;
            left: 0;
            pointer-events: none;
            user-select: none;
            mix-blend-mode: screen;
            z-index: 0;
        }

        .pricing-sec>* {
            position: relative;
            z-index: 1;
        }

        .pricing-sec .section-head p {
            max-width: 520px;
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            max-width: 820px;
            margin: 0 auto;
        }

        @media(max-width:800px) {
            .pricing-grid {
                grid-template-columns: 1fr;
            }
        }

        .price-card {
            background: #0d0712;
            border-radius: 20px;
            padding: 34px 32px;
            min-height: 500px;
            position: relative;
            overflow: hidden;
        }

        .price-card::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 20px;
            padding: 1.5px;
            background: radial-gradient(650px 650px at 0% 0%, rgba(240, 190, 255, 1) 0%, rgba(216, 110, 255, 0.9) 20%, rgba(216, 110, 255, 0.55) 45%, rgba(216, 110, 255, 0.2) 65%, transparent 85%);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        .price-card>* {
            position: relative;
            z-index: 1;
        }

        .price-card h3 {
            font-size: 19px;
            font-weight: 700;
            margin-bottom: 18px;
        }

        .price-row {
            display: flex;
            align-items: baseline;
            gap: 10px;
        }

        .price-row .price-old {
            color: var(--muted-2);
            text-decoration: line-through;
            font-size: 18px;
        }

        .price-row .price-new {
            font-size: 28px;
            font-weight: 700;
            color: var(--ink);
            font-family: 'Sora', sans-serif;
        }

        .price-card .price-gst {
            color: var(--muted);
            font-size: 13px;
            margin-top: 8px;
        }

        .price-card .price-divider {
            border: none;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin: 22px 0;
        }

        .price-features {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .price-features li {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14.5px;
            color: var(--ink);
        }

        .price-features li svg {
            width: 17px;
            height: 17px;
            stroke: var(--purple-1);
            flex-shrink: 0;
        }

        .pricing-sec .center-btn {
            margin-top: 44px;
        }

        /* ---------- BENEFITS MODAL ---------- */
        .benefits-modal .modal-card {
            max-width: 360px;
            padding: 40px 34px 36px;
            background: linear-gradient(165deg, #1b0e2c 0%, #12081d 60%, #0c0616 100%);
            border: 1px solid rgba(180, 120, 255, 0.35);
            box-shadow:
                0 0 0 1px rgba(184, 102, 247, 0.15),
                0 30px 80px rgba(120, 40, 200, 0.4),
                0 0 60px rgba(184, 102, 247, 0.3);
        }

        .benefits-list {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            gap: 40px;
            padding-left: 6px;
            margin-top: 4px;
        }

        .benefits-list::before {
            content: "";
            position: absolute;
            left: 24px;
            top: 18.5px;
            bottom: 18.5px;
            width: 0;
            border-left: 2px dotted rgba(122, 230, 194, 0.6);
            z-index: 0;
            transform: translateX(-1px);
        }

        .benefit-row {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .benefit-num {
            width: 37px;
            height: 37px;
            border-radius: 50%;
            flex-shrink: 0;
            background: rgba(18, 38, 32, 0.95);
            border: 1.5px solid rgba(122, 230, 194, 0.75);
            color: #7fe6c2;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            font-size: 14.5px;
            box-shadow: 0 0 14px rgba(122, 230, 194, 0.35);
        }

        .benefit-text {
            font-size: 15.5px;
            font-weight: 600;
            color: var(--ink);
            line-height: 1.3;
        }
    </style>
    <style>
        footer {
            position: relative;
            background: linear-gradient(180deg, #0a0410 0%, #060208 100%);
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            padding: 60px 24px 0;
            overflow: hidden;
        }

        .footer-glow {
            position: absolute;
            top: -100px;
            left: 50%;
            transform: translateX(-50%);
            width: 600px;
            height: 200px;
            background: radial-gradient(ellipse, rgba(184, 102, 247, 0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        .footer-main {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: 40px;
            padding-bottom: 40px;
        }

        .footer-col h4 {
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 16px;
            letter-spacing: 0.5px;
        }

        .footer-col ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-col ul li {
            margin-bottom: 10px;
            font-size: 13px;
            color: rgba(230, 220, 240, 0.6);
            line-height: 1.5;
        }

        .footer-col ul li a {
            color: rgba(230, 220, 240, 0.6);
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-col ul li a:hover {
            color: #d4a5ff;
        }

        .brand-col .footer-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Sora', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 12px;
        }

        .brand-col .footer-desc {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .footer-social {
            display: flex;
            gap: 12px;
        }

        .social-ic {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--muted);
            transition: all 0.2s;
        }

        .social-ic:hover {
            background: rgba(184, 102, 247, 0.1);
            border-color: rgba(184, 102, 247, 0.3);
            color: #d4a5ff;
        }

        .social-ic svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
        }

        .footer-sebi {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .footer-sebi p {
            font-size: 12px;
            line-height: 1.7;
            color: rgba(230, 220, 240, 0.5);
            margin-bottom: 12px;
        }

        .footer-sebi p strong {
            color: rgba(230, 220, 240, 0.75);
        }

        .sebi-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 8px 20px;
            margin-bottom: 16px;
        }

        .sebi-grid span {
            font-size: 11px;
            color: rgba(230, 220, 240, 0.45);
            background: rgba(255, 255, 255, 0.03);
            padding: 4px 10px;
            border-radius: 6px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .sebi-notice {
            font-style: italic;
            padding: 12px 16px;
            background: rgba(255, 200, 0, 0.04);
            border-left: 3px solid rgba(255, 200, 0, 0.3);
            border-radius: 0 8px 8px 0;
        }

        .sebi-attention {
            padding: 12px 16px;
            background: rgba(40, 180, 100, 0.04);
            border-left: 3px solid rgba(40, 180, 100, 0.3);
            border-radius: 0 8px 8px 0;
        }

        .sebi-links {
            display: flex;
            flex-wrap: wrap;
            gap: 4px 12px;
            margin-top: 12px;
        }

        .sebi-links a {
            font-size: 11px;
            color: rgba(184, 102, 247, 0.7);
            text-decoration: none;
            transition: color 0.2s;
        }

        .sebi-links a:hover {
            color: #d4a5ff;
            text-decoration: underline;
        }

        .footer-bottom {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            font-size: 12px;
            color: rgba(230, 220, 240, 0.35);
        }

        .footer-bottom a {
            color: rgba(230, 220, 240, 0.5);
            text-decoration: none;
        }

        .footer-bottom a:hover {
            color: #d4a5ff;
        }

        .heart {
            color: #ff6b81;
        }

        @media (max-width: 900px) {
            .footer-main {
                grid-template-columns: 1fr 1fr;
                gap: 32px;
            }
        }

        @media (max-width: 600px) {
            .footer-main {
                grid-template-columns: 1fr;
                gap: 28px;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }

            .sebi-grid {
                gap: 6px 10px;
            }

            .sebi-links {
                flex-direction: column;
                gap: 6px;
            }
        }

        /* ---------- VALUE BANNER (pricing cards + checklist) ---------- */
        .value-banner {
            padding: 100px 24px;
            background: var(--bg);
        }

        .value-inner {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: stretch;
            max-width: var(--max);
            margin: 0 auto;
        }

        @media(max-width:900px) {
            .value-inner {
                grid-template-columns: 1fr;
                gap: 40px;
            }
        }

        .value-left h2 {
            font-size: clamp(28px, 4vw, 40px);
            font-weight: 700;
            line-height: 1.15;
            color: var(--ink);
        }

        .value-sub {
            color: var(--muted);
            margin-top: 10px;
            font-size: 14px;
        }

        .value-checklist {
            list-style: none;
            margin-top: 28px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            padding: 0;
        }

        .value-checklist li {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14.5px;
            color: var(--ink);
        }

        .value-checklist .check {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: rgba(184, 102, 247, 0.15);
            color: var(--purple-1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .value-right {
            display: flex;
            flex-direction: column;
            gap: 16px;
            height: 100%;
        }

        .value-right .value-card {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .value-cta-row {
            max-width: var(--max);
            margin: 24px auto 0;
            padding: 0 24px;
            display: flex;
            justify-content: flex-end;
        }

        @media(max-width:900px) {
            .value-cta-row {
                justify-content: center;
            }

            .value-cta-row .btn {
                width: 100%;
            }
        }

        .value-card {
            display: block;
            background: #0d0712;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 20px 22px;
            position: relative;
            transition: transform .25s ease, border-color .25s ease, box-shadow .25s ease;
        }

        .value-card:hover {
            transform: translateY(-3px);
            border-color: rgba(184, 102, 247, 0.45);
            box-shadow: 0 16px 34px rgba(140, 40, 200, 0.28);
        }

        .value-card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .value-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .value-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .value-arrow {
            width: 18px;
            height: 18px;
            color: var(--muted);
            flex-shrink: 0;
        }

        .value-card h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 8px;
        }

        .value-price-row {
            display: flex;
            align-items: baseline;
            gap: 8px;
        }

        .value-price-row .price-old {
            color: var(--muted-2);
            text-decoration: line-through;
            font-size: 13px;
        }

        .value-price-row .price-new {
            font-size: 18px;
            font-weight: 700;
            color: var(--ink);
        }

        .value-gst {
            color: var(--muted);
            font-size: 11.5px;
            margin-top: 6px;
        }

        /* ---------- WIN BIG TICKER ---------- */
        .winbig-banner {
            width: 100%;
            overflow: hidden;
            padding: 18px 0;
            background: var(--bg);
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .ticker-track {
            display: flex;
            width: max-content;
            animation: tickerScroll 22s linear infinite;
        }

        .ticker-group {
            display: flex;
            flex-shrink: 0;
            padding-right: 60px;
        }

        .ticker-item {
            font-size: clamp(14px, 1.6vw, 18px);
            font-weight: 600;
            color: var(--ink);
            white-space: nowrap;
            letter-spacing: .01em;
        }

        @keyframes tickerScroll {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        @media(max-width:700px) {
            .winbig-banner {
                padding: 14px 0;
            }

            .ticker-group {
                padding-right: 40px;
            }
        }

        .value-heading {
            text-align: center;
            margin-bottom: 48px;
        }

        .value-heading h2 {
            font-size: clamp(32px, 5.2vw, 52px);
            font-weight: 800;
            letter-spacing: -.01em;
            color: var(--purple-1);
            text-shadow: 0 0 40px rgba(184, 102, 247, 0.45);
        }

        @media(max-width:600px) {
            .value-heading {
                margin-bottom: 32px;
            }
        }

        .value-left-card {
            background: #0d0712;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 32px 34px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        @media(max-width:600px) {
            .value-left-card {
                padding: 26px 22px;
            }
        }

        @media(max-width:900px) {

            .value-left-card,
            .value-right {
                height: auto;
            }
        }
    </style>
    <style>
        .quiz-banner {
            text-align: center;
            margin: 20px;
        }

        .quiz-label {
            font-size: 13px;
            font-weight: 600;
            color: #b866f7;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }

        .quiz-text {
            font-size: 17px;
            font-weight: 500;
            color: #e9e4f0;
            line-height: 1.6;
        }

        .quiz-text span {
            color: #b866f7;
            font-weight: 700;
        }

        .quiz-divider {
            margin-top: 14px;
            width: 48px;
            height: 3px;
            background: linear-gradient(90deg, transparent, #b866f7, transparent);
            border-radius: 2px;
            display: inline-block;
        }
    </style>
</head>

<body>

    <header>
        <div class="nav">
            <div style="display: flex; align-items: center;">
                <div class="logo" style="margin-right: 50px;"><img src="assets/images/logo-2.png" alt="ArihantPLUS"
                        class="logo-img"></div>
                <nav class="links">
                    <a href="#home">Home</a>
                    <a href="#speaker">Speaker</a>
                    @auth
                        <a href="/register/success">My Ticket</a>
                    @endauth
                    {{-- <a href="#agenda">Agenda</a> --}}
                </nav>
            </div>
            <div>
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="nav-cta">
                        @csrf
                        <button type="submit" class="btn btn-ghost" style="width:100%;margin-top:10px">Logout</button>
                    </form>
                @else
                    <a href="/login" class="btn btn-primary nav-cta">Login</a>
                    <a href="/register" class="btn btn-primary nav-cta">Claim Your Spot</a>
                @endauth
            </div>
            <button class="menu-toggle" id="menuToggle" aria-label="Open menu" aria-expanded="false">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M4 7h16M4 12h16M4 17h16" />
                </svg>
            </button>
        </div>
    </header>
    <div class="mobile-menu" id="mobileMenu">
        <a href="#home">Home</a>
        <a href="#speaker">Speaker</a>
        {{-- <a href="#agenda">Agenda</a> --}}

        @auth
            <a href="/register/success">My Ticket</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-ghost" style="width:100%;margin-top:10px">Logout</button>
            </form>
        @else
            <a href="/login" class="btn btn-primary">Login</a>
            <a href="/register" class="btn btn-primary">Claim Your Spot</a>
        @endauth
    </div>

    <section class="hero" id="home">
        <img class="hero-beam beam-right-top" src="assets/images/right-top.png" alt="" aria-hidden="true">
        <img class="hero-beam beam-left" src="assets/images/left-shade.png" alt="" aria-hidden="true">
        <img class="hero-beam beam-right-bottom" src="assets/images/right-bottom.png" alt="" aria-hidden="true">
        <div class="hero-sparkles" id="hero-sparkles"></div>

        <video class="hero-video" autoplay muted loop playsinline>
            <source src="assets/images/fireworks.mp4" type="video/mp4">
        </video>
        <div class="hero-video-veil" aria-hidden="true"></div>


        <span class="eyebrow">#Live Event</span>
        <div class="countdown">
            <div class="cbox">
                <div class="num" id="cd-days">28</div>
                <div class="lbl">Days</div>
            </div>
            <div class="cbox">
                <div class="num" id="cd-hours">12</div>
                <div class="lbl">Hours</div>
            </div>
            <div class="cbox">
                <div class="num" id="cd-mins">24</div>
                <div class="lbl">Minutes</div>
            </div>
        </div>
        <p class="hero-tagline">Central India's Largest</p>
        <h1>AI &amp; Algo Trading Conclave</h1>
        <p class="sub">Discover how artificial intelligence is transforming trading — and learn to use it to read the
            markets, manage risk and build smarter strategies.</p>

        <div class="hero-pills">
            <img src="assets/images/pill-2.png" alt="Learn" class="hero-pill-img">
            <img src="assets/images/pill-3.png" alt="Experience" class="hero-pill-img">
            <img src="assets/images/pill-4.png" alt="Connect" class="hero-pill-img">
            <img src="assets/images/pill-5.png" alt="Compete" class="hero-pill-img">
            <img src="assets/images/pill-1.png" alt="Win" class="hero-pill-img">
        </div>
        <div class="hero-visual">
            <img src="assets/images/skyline.png" alt="City skyline">
            <div class="info-card">
                <div class="info-fields">
                    <div class="info-field">
                        <span class="ic">
                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="5" width="18" height="16" rx="2" />
                                <path d="M3 10h18M8 3v4M16 3v4" stroke-linecap="round" />
                            </svg>
                        </span>
                        <div>Date<br><strong>5 September 2026</strong></div>
                    </div>
                    <div class="info-field">
                        <span class="ic">
                            <svg viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9" />
                                <path d="M12 7v5l3.5 2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <div>Time<br><strong>10:00 AM - 5:00 PM</strong></div>
                    </div>
                    <div class="info-field" id="venueField">
                        <span class="ic">
                            <svg viewBox="0 0 24 24">
                                <path d="M3 11l18-7-7 18-2.5-7.5L3 11z" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <div>Venue<br><strong id="venueText">Marriott Hotel, Indore</strong></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <section class="pricing-sec" id="pricing">
        <img class="lg-glow lg-glow-soft" src="assets/images/7.png" alt="" aria-hidden="true">
        <img class="lg-glow lg-glow-beam" src="assets/images/8.png" alt="" aria-hidden="true">

        <div class="section-head">
            <h2>Choose Your Way To<br>Experience The Conclave</h2>
            <p>Same Full-Day Experience, Same Takeaways — Just Special Pricing For Our ArihantPlus Family.</p>
        </div>

        <div class="pricing-grid">
            <div class="price-card">
                <h3>Arihant Users</h3>
                <div class="price-row">
                    <span class="price-old">₹599</span>
                    <span class="price-new">₹299</span>
                </div>
                <div class="price-gst">Incl 18% GST</div>
                <hr class="price-divider">
                <ul class="price-features">
                    <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5" />
                        </svg>Full day event access</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5" />
                        </svg>All session included</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5" />
                        </svg>Complimentary meal during the event</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5" />
                        </svg>Free AI toolkit + partner subscription</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5" />
                        </svg>Certificate of participation</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5" />
                        </svg>Access to the Experience Zone</li>
                </ul>
            </div>

            <div class="price-card">
                <h3>Standard Entry</h3>
                <div class="price-row">
                    <span class="price-old">₹999</span>
                    <span class="price-new">₹599</span>
                </div>
                <div class="price-gst">Incl 18% GST</div>
                <hr class="price-divider">
                <ul class="price-features">
                    <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5" />
                        </svg>Full day event access</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5" />
                        </svg>All session included</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5" />
                        </svg>Complimentary meal during the event</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5" />
                        </svg>Free AI toolkit + partner subscription</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5" />
                        </svg>Certificate of participation</li>
                    <li><svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5" />
                        </svg>Access to the Experience Zone</li>
                </ul>
            </div>
        </div>

        <div class="center-btn"><a href="/register" class="btn btn-primary">Claim your spot</a></div>
    </section> --}}

    <div class="learn-get-wrap">
        <img class="lg-glow lg-glow-soft" src="assets/images/7.png" alt="" aria-hidden="true">
        <img class="lg-glow lg-glow-beam" src="assets/images/8.png" alt="" aria-hidden="true">

        <section class="learn" id="learn">
            <div class="section-head purple">
                <h2>What You'll Experience</h2>
            </div>
            <div class="grid6 wrap" style="padding:0;">
                <div class="card">
                    <div class="icon-circle"><img src="assets/images/icons/1.png" alt="AI In Action"></div>
                    <h3>AI In Action</h3>
                    <p>Discover how AI can help you research, analyse and make smarter market decisions.</p>
                </div>
                <div class="card">
                    <div class="icon-circle"><img src="assets/images/icons/10.png" alt="Live algo demos"></div>
                    <h3>Live algo demos</h3>
                    <p>Watch trading strategies being built, tested and demonstrated live.</p>
                </div>
                <div class="card">
                    <div class="icon-circle"><img src="assets/images/icons/2.png" alt="Real trading experiences"></div>
                    <h3>Real trading experiences</h3>
                    <p>Learn actionable strategies and frameworks you can take back to the markets.</p>
                </div>
                <div class="card">
                    <div class="icon-circle"><img src="assets/images/icons/3.png" alt="Meet your trade circle"></div>
                    <h3>Meet your trade circle</h3>
                    <p>Network with fellow traders, algo enthusiasts, market experts and investing minds.</p>
                </div>
                <div class="card">
                    <div class="icon-circle"><img src="assets/images/icons/4.png" alt="Compete and win"></div>
                    <h3>Compete and win</h3>
                    <p>Put your market knowledge to the test with live quizzes, challenges and lucky draws.</p>
                </div>
                <div class="card">
                    <div class="icon-circle"><img src="assets/images/icons/5.png" alt="Live Debate, Real Answers"></div>
                    <h3>Live Debate, Real Answers</h3>
                    <p>AI, algos, and human judgment clash.</p>
                </div>
            </div>
        </section>

        <section class="get">
            <div class="section-head">
                <h2>What you'll get</h2>
            </div>
            <div class="grid6 wrap" style="padding:0;">
                <div class="card">
                    <div class="icon-circle"><img src="assets/images/icons/6.png" alt="AI + Algo cheat sheet"></div>
                    <h3>AI + Algo cheat sheet</h3>
                    <p>Ready-to-use AI prompts, trading frameworks and practical takeaways.</p>
                </div>
                <div class="card">
                    <div class="icon-circle"><img src="assets/images/icons/7.png" alt="₹4,999 Stratzy access at ₹999">
                    </div>
                    <h3>₹4,999 Stratzy access at ₹99</h3>
                    <p>Unlock exclusive Conclave-only Stratzy pricing.</p>
                </div>
                <div class="card">
                    <div class="icon-circle"><img src="assets/images/icons/12.png" alt="Exciting rewards"></div>
                    <h3>Exciting rewards</h3>
                    <p>Win smartphones, smartwatches, goodies & more through quizzes and lucky draws.</p>
                </div>
                <div class="card">
                    <div class="icon-circle"><img src="assets/images/icons/11.png" alt="Traders toolkit"></div>
                    <h3>Traders toolkit</h3>
                    <p>Take home useful tools, strategy templates and resources from the Conclave.</p>
                </div>
                <div class="card">
                    <div class="icon-circle"><img src="assets/images/icons/8.png" alt="Certificate of participation">
                    </div>
                    <h3>Certificate of participation</h3>
                    <p>A certificate for being part of Central India's largest AI & Algo Conclave.</p>
                </div>
                <div class="card">
                    <div class="icon-circle"><img src="assets/images/icons/9.png" alt="Food & Refreshments"></div>
                    <h3>Food & Refreshments</h3>
                    <p>Enjoy a delicious lunch, high tea & snacks throughout the day.</p>
                </div>
            </div>
            <div class="center-btn left">
                <a href="/register" class="btn btn-primary">Claim your spot</a>
            </div>
        </section>
    </div>

    {{-- <section class="schedule" id="agenda">
        <div class="schedule-glow"></div>
        <div class="section-head" style="position:relative;z-index:2;">
            <h2>Here's What's Happening</h2>
            <p>Two hours of practical learning, market insights and conversations with experienced traders.</p>
        </div>

        <div class="schedule-box">
            <img class="corner-light corner-light-tl-1" src="assets/images/9.png" alt="" aria-hidden="true">
            <img class="corner-light corner-light-tl-2" src="assets/images/10.png" alt="" aria-hidden="true">
            <img class="corner-light corner-light-tl-3" src="assets/images/11.png" alt="" aria-hidden="true">
            <img class="corner-light corner-light-br-1" src="assets/images/13.png" alt="" aria-hidden="true">
            <img class="corner-light corner-light-br-2" src="assets/images/12.png" alt="" aria-hidden="true">
            <div class="agenda-wrap" id="agenda-list"></div>
        </div>

        <div class="center-btn"><a href="/register" class="btn btn-primary">Claim your spot</a></div>
    </section> --}}

    <section class="panel-sec" id="speaker">
        <div class="section-head">
            <h2>Meet Our Speakers</h2>
        </div>

        <div class="panelist-slider-wrap">
            <div class="panelist-track" id="panelistTrack"></div>
        </div>

        <div class="panelist-nav">
            <button type="button" class="panelist-arrow" id="panelistPrev" aria-label="Previous panelist">
                <svg viewBox="0 0 24 24">
                    <path d="M15 6l-6 6 6 6" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
            <button type="button" class="panelist-arrow" id="panelistNext" aria-label="Next panelist">
                <svg viewBox="0 0 24 24">
                    <path d="M9 6l6 6-6 6" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>

        <div class="center-btn"><a href="/register" class="btn btn-primary">Claim your spot</a></div>
    </section>

    <section class="value-banner" id="value">
        <div class="value-heading wrap">
            <h2>Pricing</h2>
        </div>
        <div class="value-inner wrap">
            <div class="value-left value-left-card">
                <h2>One Day.<br>Massive Value.</h2>

                <ul class="value-checklist">
                    <li><span class="check">✓</span> Live AI + Algo Demos</li>
                    <li><span class="check">✓</span> AI + Algo Cheat Sheet</li>
                    <li><span class="check">✓</span> ₹4,999 Stratzy Access @ ₹99*</li>
                    <li><span class="check">✓</span> Trader Networking</li>
                    <li><span class="check">✓</span> Expert Sessions</li>
                    <li><span class="check">✓</span> Quizzes + Big Rewards</li>
                </ul>
            </div>

            <div class="value-right">
                <a href="/register" class="value-card">
                    <div class="value-card-top">
                        <span class="value-icon"><img src="assets/images/icon-1.png" alt="ArihantPlus users"></span>
                        <svg class="value-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M7 17L17 7M7 7h10v10" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h3>ArihantPlus users</h3>
                    <div class="value-price-row">
                        <span class="price-old">₹599</span>
                        <span class="price-new">₹399</span>
                    </div>
                    <div class="value-gst">Incl 18% GST</div>
                </a>

                <a href="/register" class="value-card">
                    <div class="value-card-top">
                        <span class="value-icon"><img src="assets/images/icon-2.png" alt="Standard Entry"></span>
                        <svg class="value-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M7 17L17 7M7 7h10v10" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h3>Regular Entry</h3> <br>
                    <h3>For Non-Arihant users</h3>
                    <div class="value-price-row">
                        <span class="price-old">₹999</span>
                        <span class="price-new">₹599</span>
                    </div>
                    <div class="value-gst">Incl 18% GST</div>
                </a>

            </div>
        </div>

        <div class="value-cta-row">
            <a href="/register" class="btn btn-primary">Claim Your Spot</a>
        </div>
    </section>

    <section class="winbig-banner">
        <div class="ticker-track" id="tickerTrack">
            <div class="ticker-group">
                <span class="ticker-item">🎁 WIN BIG AT THE CONCLAVE! 📱⌚ Participate in the Live Quiz &amp; stand a
                    chance to win Smartphone, Smartwatch &amp; many more exciting prizes</span>
            </div>
            <div class="ticker-group" aria-hidden="true">
                <span class="ticker-item">🎁 WIN BIG AT THE CONCLAVE! 📱⌚ Participate in the Live Quiz &amp; stand a
                    chance to win Smartphone, Smartwatch &amp; many more exciting prizes</span>
            </div>
        </div>
    </section>

    <section class="gallery" id="gallery">
        <img class="gallery-side-glow gallery-side-glow-soft" src="assets/images/7.png" alt="" aria-hidden="true">
        <img class="gallery-side-glow gallery-side-glow-beam" src="assets/images/8.png" alt="" aria-hidden="true">
        <div class="section-head purple">
            <h2>Event Gallery</h2>
            <p>Moments from past ArihantPLUS conclaves, workshops and community meetups.</p>
        </div>

        <div class="gallery-grid" id="gallery-grid"></div>
        <div class="gallery-more-wrap">
            <button type="button" class="gallery-more-btn" id="galleryLoadMore">Load More</button>
        </div>

        <div class="center-btn"><a href="/register" class="btn btn-primary">Claim your spot</a></div>
    </section>

    <section class="videos-sec" id="videos">
        <div class="videos-glow videos-glow-1" aria-hidden="true"></div>
        <div class="videos-glow videos-glow-2" aria-hidden="true"></div>
        <div class="section-head purple">
            <h2>SEE ARIHANT PLUS IN ACTION</h2>
            <p>Master AI, MCP, Algo tools and advanced features with quick, practical videos.</p>
        </div>

        <div class="video-layout wrap">
            <div class="video-main">
                <div class="video-frame-wrap" id="videoFrameWrap"></div>
                <div class="video-info">
                    <span class="video-tag" id="videoTag">Featured</span>
                    <h3 id="videoTitle"></h3>
                </div>
            </div>

            <div class="video-playlist" id="videoPlaylist"></div>
        </div>
    </section>

    <section class="invite">
        <div class="invite-sphere">
            <img class="sphere-img sphere-img-left" src="assets/images/14.png" alt="" aria-hidden="true">
            <img class="sphere-img sphere-img-right" src="assets/images/15.png" alt="" aria-hidden="true">
            <img class="sphere-img sphere-img-base" src="assets/images/16.png" alt="" aria-hidden="true">
            <h2>Invite &amp; Earn</h2>
            <p>The best traders don't learn alone. Bring your circle, get rewarded for it.</p>
            <a href="#" class="btn btn-ghost" id="benefitsBtn">Benefits</a>
            @auth
                <a href="/refer" class="btn btn-primary">Refer a friend</a>
            @endauth
        </div>
    </section>

    <section class="cta-sphere-sec">
        <!-- Left fan: source at bottom-left, beams rise toward center/top -->
        <img class="light-ray light-ray-left-1" src="assets/images/glow/1.png" alt="" aria-hidden="true">
        <img class="light-ray light-ray-left-2" src="assets/images/glow/2.png" alt="" aria-hidden="true">
        <img class="light-ray light-ray-left-3" src="assets/images/glow/4.png" alt="" aria-hidden="true">
        <!-- Right fan: source at bottom-right, beams rise toward center/top -->
        <img class="light-ray light-ray-right-1" src="assets/images/glow/6.png" alt="" aria-hidden="true">
        <img class="light-ray light-ray-right-2" src="assets/images/glow/6.png" alt="" aria-hidden="true">
        <img class="light-ray light-ray-right-3" src="assets/images/glow/6.png" alt="" aria-hidden="true">
        <img class="shard left" src="assets/images/shard-left.png" alt="">
        <img class="shard right" src="assets/images/shard-right.png" alt="">
        <div class="wrap-inner">
            <h2>Ready To Trade<br>Smarter?</h2>
            <p>Join the masterclass and discover how experienced traders think, analyse and act in changing markets.</p>
            <a href="/register" class="btn btn-white">Reserve Your Spot</a>

            <div class="orb-stage">
                <div class="orb-wobble">
                    <div class="orb-mask">
                        <video class="orb-img" autoplay muted loop playsinline>
                            <source src="assets/images/orb-video.mp4" type="video/mp4">
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="faq" id="faq">
        <div class="faq-inner">
            <div class="faq-lead">
                <h2>Frequently asked questions</h2>
                <p>Have questions about the conclave, registration, or trading account setup? We've got you covered.</p>
            </div>
            <div id="faq-list"></div>
        </div>
    </section>

    <footer>
        <div class="footer-glow"></div>

        <div class="footer-main">
            <div class="footer-col brand-col">
                <div class="footer-logo">
                    <div class="logo"><img src="assets/images/logo-2.png" alt="ArihantPLUS" class="logo-img"></div>
                </div>
                <p class="footer-desc">AI & Algo Conclave 2026 — Empowering investors and traders with cutting-edge
                    technology.</p>
                <div class="footer-social">
                    <a class="social-ic" target="_blank" href="https://www.instagram.com/arihant_plus/"
                        aria-label="Instagram">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                            <rect x="3" y="3" width="18" height="18" rx="5" />
                            <circle cx="12" cy="12" r="4" />
                            <circle cx="17.3" cy="6.7" r="1" fill="currentColor" stroke="none" />
                        </svg>
                    </a>
                    <a class="social-ic" target="_blank"
                        href="https://www.linkedin.com/company/arihant-capital-markets-ltd/about/?viewAsMember=true"
                        aria-label="LinkedIn">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                            <rect x="3" y="3" width="18" height="18" rx="3" />
                            <path d="M7 10v7M7 7v.01M11 17v-4.5a2 2 0 014-.2M15 17v-4.5" />
                        </svg>
                    </a>
                    <a class="social-ic" target="_blank" href="https://x.com/ArihantPlus" aria-label="X">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                            <path d="M4 4l16 16M20 4L4 20" />
                        </svg>
                    </a>
                    <a class="social-ic" target="_blank" href="https://www.youtube.com/@arihant_plus"
                        aria-label="YouTube">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                            <rect x="3" y="3" width="18" height="18" rx="4" />
                            <polygon points="10,8 16,12 10,16" fill="currentColor" stroke="none" />
                        </svg>
                    </a>
                    <a class="social-ic" target="_blank" href="https://www.facebook.com/arihantcapitalmarket"
                        aria-label="Facebook">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                            <rect x="3" y="3" width="18" height="18" rx="4" />
                            <path d="M13 10h2v-2h-2c-1.1 0-2 .9-2 2v2h-2v2h2v6h2v-6h2l1-2h-3v-2c0-.55.45-1 1-1z" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="{{ route('event.policy') }}">Event Policy</a></li>
                    <li><a href="{{ route('payment.terms') }}">Payment Terms</a></li>
                    <li><a href="{{ route('cookie.policy') }}">Cookie Policy</a></li>
                    <li><a href="{{ route('disclaimer') }}">Disclaimer & Risk Disclosure</a></li>
                    <li><a href="/login">Login</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Contact</h4>
                <ul>
                    <li><a href="mailto:customersupport@arihantcapital.com">customersupport@arihantcapital.com</a></li>
                    <li><a href="tel:07314217003">0731-4217003</a></li>
                    <li><a href="mailto:compliance@arihantcapital.com">compliance@arihantcapital.com</a></li>
                    <li><a href="mailto:depository@arihantcapital.com">depository@arihantcapital.com</a></li>
                    <li>601, Atlantis Tower, Plot No. 13A, Scheme No. 78, Indore – 452010</li>
                    <li>#1011 Solitaire Corporate Park, Andheri Ghatkopar Link Road, Chakala, Andheri (E), Mumbai -
                        400093</li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Important Links</h4>
                <ul>
                    <li><a href="https://www.sebi.gov.in" target="_blank">SEBI</a></li>
                    <li><a href="https://www.bseindia.com" target="_blank">BSE</a></li>
                    <li><a href="https://www.nseindia.com" target="_blank">NSE</a></li>
                    <li><a href="https://www.mcxindia.com" target="_blank">MCX</a></li>
                    <li><a href="https://www.cdslindia.com" target="_blank">CDSL</a></li>
                    <li><a href="https://scores.sebi.gov.in" target="_blank">SEBI SCORES</a></li>
                    <li><a href="https://smartodr.in" target="_blank">ODR Portal</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-sebi">
            <p><strong>Arihant Capital Markets Limited</strong> is a SEBI registered stock broker and depository
                participant.</p>
            <div class="sebi-grid">
                <span>SEBI Stock Broker: INZ000180939</span>
                <span>DP: IN301983</span>
                <span>NSDL: IN-DP-127-2015</span>
                <span>CDSL DP ID: 43000</span>
                <span>NCDEX: 01274</span>
                <span>MCX: 56565</span>
                <span>AMFI: ARN 15114</span>
                <span>SEBI Research Analyst: INH000002764</span>
            </div>
            <p class="sebi-notice">
                Investments in securities market are subject to market risks; read all the related documents carefully
                before investing.
                Brokerage will not exceed the SEBI prescribed limit. The securities are quoted as an example and not as
                a recommendation.
            </p>
            <p class="sebi-attention">
                <strong>Attention Investors:</strong> KYC is one time exercise while dealing in securities markets.
                Prevent unauthorised transactions in your account — update your mobile numbers/email IDs with your
                stockbrokers. Receive information of your transactions directly from Exchange on your mobile/email at
                the end of the day. Update your Mobile Number with your Depository Participant to receive alerts for all
                debit and other important transactions in your demat account directly from CDSL/NSDL on the same day.
            </p>
            <p class="sebi-links">
                <a href="https://www.bseindia.com/investors/aperc.aspx" target="_blank">BSE Rights & Obligations</a> |
                <a href="https://www.nseindia.com/invest/resources/download-documents" target="_blank">NSE Do's &
                    Don'ts</a> |
                <a href="https://www.mcxindia.com/investor-education" target="_blank">MCX Investor Charter</a> |
                <a href="https://www.cdslindia.com/investor-charter.aspx" target="_blank">CDSL Investor Charter</a> |
                <a href="https://smartodr.in" target="_blank">ODR Portal</a>
            </p>
        </div>

        <div class="footer-bottom">
            <span>All copyrights are reserved © Arihant Capital Markets Limited</span>
        </div>
    </footer>

    <div class="modal-overlay" id="reserveModal">
        <div class="modal-card">
            <div class="modal-close" id="modalClose" role="button" aria-label="Close">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M4 4l16 16M20 4L4 20" />
                </svg>
            </div>
            <div class="modal-title">AI TRADING SUMMIT</div>
            <input class="modal-field" type="tel" placeholder="+91 00000 00000">
            <input class="modal-field" type="text" placeholder="OTP">
            <div class="modal-check-row">
                <input type="checkbox" id="modalTerms">
                <label for="modalTerms">I read all the <a href="#">Terms &amp; Condition</a> | <a href="#">Privacy
                        Policy</a></label>
            </div>
            <button type="button" class="btn btn-primary modal-submit">Sent OTP</button>
        </div>
    </div>

    <div class="lightbox-overlay" id="galleryLightbox">
        <div class="lightbox-inner">
            <span class="lightbox-counter" id="lightboxCounter"></span>
            <div class="lightbox-close" id="lightboxClose" role="button" aria-label="Close">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M4 4l16 16M20 4L4 20" />
                </svg>
            </div>
            <div class="lightbox-nav lightbox-prev" id="lightboxPrev" role="button" aria-label="Previous image">
                <svg viewBox="0 0 24 24">
                    <path d="M15 6l-6 6 6 6" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div class="lightbox-media">
                <img id="lightboxImg" src="" alt="">
                <div class="lightbox-caption">
                    <span class="gallery-cat" id="lightboxCat"></span>
                    <h4 id="lightboxName"></h4>
                </div>
            </div>
            <div class="lightbox-nav lightbox-next" id="lightboxNext" role="button" aria-label="Next image">
                <svg viewBox="0 0 24 24">
                    <path d="M9 6l6 6-6 6" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
        </div>
    </div>

    <div class="modal-overlay benefits-modal" id="benefitsModal">
        <div class="modal-card">
            <div class="modal-close" id="benefitsModalClose" role="button" aria-label="Close">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M4 4l16 16M20 4L4 20" />
                </svg>
            </div>
            <div class="benefits-list">
                <div class="benefit-row">
                    <div class="benefit-num">1</div>
                    <div class="benefit-text">15 referral - Free entry</div>
                </div>
                <div class="benefit-row">
                    <div class="benefit-num">2</div>
                    <div class="benefit-text">10 referral - 50% off</div>
                </div>
                <div class="benefit-row">
                    <div class="benefit-num">3</div>
                    <div class="benefit-text">5 referral - Goodies</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ---------- Reserve / Claim modal ----------
        (function () {
            var overlay = document.getElementById('reserveModal');
            var closeBtn = document.getElementById('modalClose');
            if (!overlay) return;

            function openModal() {
                overlay.classList.add('open');
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                overlay.classList.remove('open');
                document.body.style.overflow = '';
            }

            closeBtn.addEventListener('click', closeModal);
            overlay.addEventListener('click', function (e) {
                if (e.target === overlay) closeModal();
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeModal();
            });
        })();

        // ---------- Benefits modal ----------
        (function () {
            var overlay = document.getElementById('benefitsModal');
            var openBtn = document.getElementById('benefitsBtn');
            var closeBtn = document.getElementById('benefitsModalClose');
            if (!overlay || !openBtn || !closeBtn) return;

            function openModal() {
                overlay.classList.add('open');
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                overlay.classList.remove('open');
                document.body.style.overflow = '';
            }
            openBtn.addEventListener('click', function (e) {
                e.preventDefault();
                openModal();
            });
            closeBtn.addEventListener('click', closeModal);
            overlay.addEventListener('click', function (e) {
                if (e.target === overlay) closeModal();
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeModal();
            });
        })();
        // ---------- Mobile menu toggle ----------
        (function () {
            var btn = document.getElementById('menuToggle');
            var menu = document.getElementById('mobileMenu');
            if (!btn || !menu) return;
            btn.addEventListener('click', function () {
                var isOpen = menu.classList.toggle('open');
                btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                document.body.style.overflow = isOpen ? 'hidden' : '';
            });
            menu.querySelectorAll('a').forEach(function (a) {
                a.addEventListener('click', function () {
                    menu.classList.remove('open');
                    btn.setAttribute('aria-expanded', 'false');
                    document.body.style.overflow = '';
                });
            });
        })();

        // ---------- Slow down fireworks playback ----------
        (function () {
            var v = document.querySelector('.hero-video');
            if (v) v.playbackRate = 0.6;
        })();

        // ---------- Hero sparkles ----------
        (function () {
            var host = document.getElementById('hero-sparkles');
            if (!host) return;
            var positions = [{
                top: '6%'
                , left: '30%'
            }, {
                top: '3%'
                , left: '42%'
            }, {
                top: '10%'
                , left: '55%'
            }
                , {
                top: '2%'
                , left: '66%'
            }, {
                top: '14%'
                , left: '22%'
            }, {
                top: '8%'
                , left: '75%'
            }
            ];
            positions.forEach(function (p, i) {
                var s = document.createElement('span');
                s.className = 'spark';
                s.style.top = p.top;
                s.style.left = p.left;
                s.style.animationDelay = (i * 0.5) + 's';
                s.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l1.6 6.4L20 10l-6.4 1.6L12 18l-1.6-6.4L4 10l6.4-1.6z"/></svg>';
                host.appendChild(s);
            });
        })();

        // ---------- Countdown ----------
        (function () {
            var target = new Date(2026, 8, 5, 10, 0, 0); // 5 September 2026, 10:00 AM
            function tick() {
                var now = new Date();
                var diff = Math.max(0, target - now);
                var d = Math.floor(diff / (1000 * 60 * 60 * 24));
                var h = Math.floor(diff / (1000 * 60 * 60) % 24);
                var m = Math.floor(diff / (1000 * 60) % 60);
                document.getElementById('cd-days').textContent = String(d).padStart(2, '0');
                document.getElementById('cd-hours').textContent = String(h).padStart(2, '0');
                document.getElementById('cd-mins').textContent = String(m).padStart(2, '0');
            }
            tick();
            setInterval(tick, 1000 * 30);
        })();


        // ---------- Agenda (repeatable data-driven list) ----------
        var agenda = [{
            time: "1:45 PM – 2:00 PM"
            , title: "WELCOME & NETWORKING"
            , body: "Meet fellow traders, investors and market enthusiasts before the masterclass begins."
            , tag: "Opening"
        }
            , {
            time: "2:00 PM – 2:20 PM"
            , title: "WHY AI IS CHANGING THE MARKET"
            , body: "A grounded look at where AI genuinely helps traders, and where hype outruns reality."
            , tag: "Session"
        }
            , {
            time: "2:20 PM – 2:45 PM"
            , title: "LIVE AI STOCK SCREENING"
            , body: "Watch an AI-assisted screen built and stress-tested live, step by step."
            , tag: "Demo"
        }
            , {
            time: "2:45 PM – 3:05 PM"
            , title: "ALGO TRADING 101"
            , body: "The core logic behind rule-based strategies, explained without the jargon."
            , tag: "Session"
        }
            , {
            time: "3:05 PM – 3:30 PM"
            , title: "AI VS ALGO VS HUMAN — A LIVE DEBATE"
            , body: "Three approaches to the same trade, argued out loud by people who use them daily."
            , tag: "Debate"
        }
            , {
            time: "3:30 PM – 3:45 PM"
            , title: "Q&A AND CLOSING NOTES"
            , body: "Open floor for questions, plus how to keep building on what you learned today."
            , tag: "Closing"
        }
        ];
        var agendaHTML = agenda.map(function (a) {
            return '<div class="agenda-item">' +
                '<div class="agenda-time">' + a.time + '</div>' +
                '<div class="agenda-body"><h4>' + a.title + '</h4><p>' + a.body + '</p></div>' +
                '<div class="pill">' + a.tag + '</div>' +
                '</div>';
        }).join('');
        var agendaListEl = document.getElementById('agenda-list');
        if (agendaListEl) agendaListEl.innerHTML = agendaHTML;

        (function () {
            var panelists = [{
                name: "Vishal Mehta"
                , role: "Algo Trader | Market Educator"
                , img: "assets/images/21.png"
                , socials: [
                    { type: "youtube", url: "https://www.youtube.com/@vishalmehta_cmt" },
                    { type: "x", url: "https://x.com/vishalmehta29" },
                    { type: "linkedin", url: "https://www.linkedin.com/in/vishalmehta-cmt/" },
                    { type: "instagram", url: "https://www.instagram.com/vishal_mehta_cmt/" }
                ]
                , knowMore: "/vishal-mehta"
            }
                , {
                name: "Saurabh Sisodia"
                , role: "Data Driven Trader"
                , img: "assets/images/23.png"
                , socials: [
                    { type: "linkedin", url: "https://www.linkedin.com/in/sourabhsiso/" },
                    { type: "x", url: "https://x.com/sourabhsiso19?lang=en" },
                    { type: "instagram", url: "https://www.instagram.com/tradewithsourabhsisodiya/?hl=en" }
                ]
                , knowMore: "/saurabh-sisodia"
            }
                , {
                name: "Santosh Pasi"
                , role: "Option Trader"
                , img: "assets/images/22.png"
                , socials: [
                    { type: "x", url: "https://x.com/SantoshPasi?lang=ens" }
                ]
                , knowMore: "/santosh-pasi"
            }
                , {
                name: "Ankit Rai"
                , role: "Derivatives Trader & Strategy Consultant"
                , img: "assets/images/24.png"
                , socials: [
                    { type: "x", url: "https://x.com/AnkitRai259" }
                ]
                , knowMore: "/ankit-rai"
            }
                ,];
            var track = document.getElementById('panelistTrack');
            if (!track) return;

            var socialSVGs = {
                instagram: '<svg viewBox="0 0 24 24" fill="none" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.3" cy="6.7" r="1" fill="currentColor" stroke="none"/></svg>',
                x: '<svg viewBox="0 0 24 24" fill="none" stroke-width="1.8"><path d="M4 4l16 16M20 4L4 20"/></svg>',
                linkedin: '<svg viewBox="0 0 24 24" fill="none" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="3"/><path d="M7 10v7M7 7v.01M11 17v-4.5a2 2 0 014-.2M15 17v-4.5"/></svg>',
                youtube: '<svg viewBox="0 0 24 24" fill="none" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="4"/><polygon points="10,8 16,12 10,16" fill="currentColor" stroke="none"/></svg>'
            };

            track.innerHTML = panelists.map(function (p) {
                var socialLinks = (p.socials || []).map(function (s) {
                    var icon = socialSVGs[s.type];
                    if (!icon) return '';
                    return '<a href="' + s.url + '" target="_blank" aria-label="' + p.name + ' ' + s.type + '">' + icon + '</a>';
                }).join('');

                return '<div class="panelist-slide">' +
                    '<div class="panelist-photo-card">' +
                    '<div class="panelist-photo-mask">' +
                    '<img src="' + p.img + '" alt="' + p.name + '" loading="lazy">' +
                    '<div class="panelist-photo-shade"></div>' +
                    '<div class="panelist-info">' +
                    '<div class="panelist-social">' +
                    socialLinks +
                    '</div>' +
                    '<h4>' + p.name + '</h4><span>' + p.role + '</span>' +
                    '<a href="' + p.knowMore + '" class="panelist-know-btn">Know More</a>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
            }).join('');

            var prevBtn = document.getElementById('panelistPrev');
            var nextBtn = document.getElementById('panelistNext');
            if (!prevBtn || !nextBtn) return;

            function cardStep() {
                var slide = track.querySelector('.panelist-slide');
                if (!slide) return 0;
                var gap = parseFloat(getComputedStyle(track).gap) || 24;
                return slide.getBoundingClientRect().width + gap;
            }

            function updateArrows() {
                var max = track.scrollWidth - track.clientWidth - 2;
                prevBtn.disabled = track.scrollLeft <= 2;
                nextBtn.disabled = max <= 2 || track.scrollLeft >= max;
            }

            prevBtn.addEventListener('click', function () {
                track.scrollBy({
                    left: -cardStep()
                    , behavior: 'smooth'
                });
            });
            nextBtn.addEventListener('click', function () {
                track.scrollBy({
                    left: cardStep()
                    , behavior: 'smooth'
                });
            });
            track.addEventListener('scroll', updateArrows);
            window.addEventListener('resize', updateArrows);
            updateArrows();
        })();

        // ---------- FAQ ----------
        var faqs = [{
            q: "Who should attend this conclave?"
            , a: "Anyone curious about how AI and algorithmic trading are changing the markets — whether you're a complete beginner or already trading. No prior coding or algo experience is required."
        }
            , {
            q: "Do I need any trading experience to attend?"
            , a: "No. The sessions are designed to be followed by both beginners and experienced traders — from live, hands-on walkthroughs to deeper discussions for those already trading."
        }
            , {
            q: "Will this be practical, or just theory?"
            , a: "Practical. You'll build a live AI research routine on your own phone, watch a trading strategy get built and back tested live on stage, and walk away with tools you can use the same evening."
        }
            , {
            q: "What exactly will I get after attending?"
            , a: "A set of ready-to-use AI prompts, a strategy template from the live build session, access to a free AI toolkit and partner subscription, and a certificate of participation."
        }
            , {
            q: "Do I need to bring a laptop?"
            , a: "No laptop needed — most hands-on sessions are designed to be followed along on your phone. We'll share specific instructions closer to the event date."
        }
            , {
            q: "Is there a certificate of participation?"
            , a: "Yes, all attendees receive a certificate at the end of the day."
        }
            , {
            q: "Will there be food and breaks included?"
            , a: "Yes! Your ticket includes complimentary lunch, high tea, and snack breaks throughout the event."
        }
            , {
            q: "Is there an entertainment/experience element, or is it only sessions?"
            , a: "Yes — beyond the sessions, we've planned an experiential element to make this more than just a lecture-style event. Details will be shared closer to the date."
        }
            , {
            q: "What is the difference between a client and a non-client?"
            , a: "A Client is an individual who trades through Arihant Capital and enjoys the privileges and benefits associated with our events and financial offerings. A Non-Client is an individual who is eligible to avail of these privileges and benefits upon associating with Arihant Capital."
        }
            , {
            q: "Are there any partner/sponsor stalls at the event?"
            , a: "Yes, you'll have access to an Experience Zone with partner stalls where you can explore tools and platforms relevant to AI and algo trading."
        }
            , {
            q: "What is the refund/cancellation policy?"
            , a: "We follow a No Refund Policy."
        }
        ];
        document.getElementById('faq-list').innerHTML = faqs.map(function (f, i) {
            return '<div class="faq-item' + (i === 1 ? ' open' : '') + '">' +
                '<div class="faq-q" onclick="this.parentElement.classList.toggle(\'open\')">' +
                '<span class="dot"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.4"><path d="M12 5v14M5 12h14"/></svg></span>' +
                '<h4>' + f.q + '</h4>' +
                '</div>' +
                '<div class="faq-a">' + f.a + '</div>' +
                '</div>';
        }).join('');

        // ---------- Video Sessions ----------
        (function () {
            var frameWrap = document.getElementById('videoFrameWrap');
            var playlistHost = document.getElementById('videoPlaylist');
            var tagEl = document.getElementById('videoTag');
            var titleEl = document.getElementById('videoTitle');
            if (!frameWrap || !playlistHost) return;

            // Replace "id" with real YouTube video IDs (the part after ?v= in the URL).
            var videos = [{
                id: "yqxc18lRPCo"
                , title: "How to Research & Trade Using AI"
                , tag: "Featured"
                , duration: "0:00"
            }
                , {
                id: "7KVdASoLPAs"
                , title: "Connect Your Demat to AI"
                , tag: "Featured"
                , duration: "0:00"
            }
                , {
                id: "w_mtfEx-rCI"
                , title: "What If Your Next Investment Decision Had An AI Thinking With You?"
                , tag: "AI Insight"
                , duration: "12:10"
            }
                , {
                id: "ADQXJmZYFOc"
                , title: "अरिहंतप्लस MCP को AI चैटबॉट्स से कनेक्ट करना सीखें"
                , tag: "Tutorial"
                , duration: "15:47"
            }
                , {
                id: "BKACdyjnx8w"
                , title: "Don't Miss Trades! Auto-Login To Stratzy Algo Via ArihantPlus"
                , tag: "Quick Tip"
                , duration: "24:02"
            }
                , {
                id: "rUTS-bKB5W4"
                , title: "How To Setup Algo Strategies Via ArihantPlus App"
                , tag: "Tutorial"
                , duration: "9:35"
            }
            ];

            var playSVG = '<svg viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>';
            var currentIndex = 0;

            function thumbUrl(id) {
                return 'https://img.youtube.com/vi/' + id + '/hqdefault.jpg';
            }

            function hasRealId(id) {
                return !!id && id.indexOf('YOUR_VIDEO_ID') !== 0;
            }

            function renderFrame(index, autoplay) {
                var v = videos[index];
                if (!v) return;
                currentIndex = index;
                tagEl.textContent = v.tag;
                titleEl.textContent = v.title;

                if (autoplay && hasRealId(v.id)) {
                    frameWrap.innerHTML = '<iframe src="https://www.youtube.com/embed/' + v.id + '?autoplay=1&rel=0" ' +
                        'title="' + v.title + '" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" ' +
                        'allowfullscreen></iframe>';
                } else if (hasRealId(v.id)) {
                    frameWrap.innerHTML =
                        '<img src="' + thumbUrl(v.id) + '" alt="' + v.title + '">' +
                        '<div class="video-shade"></div>' +
                        '<div class="video-play-btn">' + playSVG + '</div>';
                } else {
                    frameWrap.innerHTML =
                        '<div class="video-shade"></div>' +
                        '<div class="video-play-btn">' + playSVG + '</div>';
                }

                Array.prototype.forEach.call(playlistHost.querySelectorAll('.video-playlist-item'), function (el, i) {
                    el.classList.toggle('active', i === index);
                });
            }

            playlistHost.innerHTML = videos.map(function (v, i) {
                var thumbImg = hasRealId(v.id) ? '<img src="' + thumbUrl(v.id) + '" alt="' + v.title + '" loading="lazy">' : '';
                return '<div class="video-playlist-item' + (i === 0 ? ' active' : '') + '" data-index="' + i + '">' +
                    '<div class="video-thumb">' +
                    thumbImg +
                    '<div class="video-thumb-play">' + playSVG + '</div>' +
                    '</div>' +
                    '<div class="video-meta">' +
                    '<h4>' + v.title + '</h4>' +
                    '<span>' + v.tag + ' · ' + v.duration + '</span>' +
                    '</div>' +
                    '</div>';
            }).join('');

            renderFrame(0, false);

            frameWrap.addEventListener('click', function () {
                renderFrame(currentIndex, true);
            });

            playlistHost.querySelectorAll('.video-playlist-item').forEach(function (el) {
                el.addEventListener('click', function () {
                    var idx = parseInt(el.getAttribute('data-index'), 10);
                    renderFrame(idx, true);
                });
            });
        })();

        // ---------- Event Gallery ----------
        (function () {
            var grid = document.getElementById('gallery-grid');
            var loadMoreBtn = document.getElementById('galleryLoadMore');
            if (!grid) return;

            var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            var BATCH_SIZE = 8;

            // Data-driven gallery — swap the img paths for real event photos later.
            var galleryItems = [{
                img: "assets/images/gallery/1.jpg"
                , name: "Opening Keynote — AI Trading Summit"
                , label: "Conclave"
            }
                , {
                img: "assets/images/gallery/2.jpg"
                , name: "Live AI Screening Demo"
                , label: "Workshop"
            }
                , {
                img: "assets/images/gallery/3.jpg"
                , name: "Networking Lounge"
                , label: "Community"
            }
                , {
                img: "assets/images/gallery/4.jpg"
                , name: "Panel Discussion On Algo Trading"
                , label: "Conclave"
            }
                , {
                img: "assets/images/gallery/5.jpg"
                , name: "Algo Trading Bootcamp"
                , label: "Workshop"
            }
                , {
                img: "assets/images/gallery/6.jpg"
                , name: "Trader Meetup Mixer"
                , label: "Community"
            }
                , {
                img: "assets/images/gallery/7.jpg"
                , name: "Award Ceremony"
                , label: "Conclave"
            }
                , {
                img: "assets/images/gallery/8.jpg"
                , name: "Hands-On Charting Session"
                , label: "Workshop"
            }
                , {
                img: "assets/images/gallery/9.jpg"
                , name: "Community Q&A"
                , label: "Community"
            }
                , {
                img: "assets/images/gallery/10.jpg"
                , name: "Expert Fireside Chat"
                , label: "Conclave"
            }
                , {
                img: "assets/images/gallery/11.jpg"
                , name: "Strategy Building Workshop"
                , label: "Workshop"
            }
                , {
                img: "assets/images/gallery/12.jpg"
                , name: "Closing Celebration"
                , label: "Community"
            }
                , {
                img: "assets/images/gallery/13.jpg"
                , name: "Behind The Scenes"
                , label: "Community"
            }
                , {
                img: "assets/images/gallery/14.jpg"
                , name: "Trading Floor Walkthrough"
                , label: "Conclave"
            }
                , {
                img: "assets/images/gallery/15.jpg"
                , name: "Speaker Meet & Greet"
                , label: "Workshop"
            }
                , {
                img: "assets/images/gallery/16.jpg"
                , name: "Attendee Highlights"
                , label: "Community"
            }
                , {
                img: "assets/images/gallery/17.jpg"
                , name: "Group Photo"
                , label: "Conclave"
            }
            ];

            var zoomSVG = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="10.5" cy="10.5" r="6.5"/><path d="M20 20l-4.35-4.35" stroke-linecap="round"/><path d="M10.5 8v5M8 10.5h5" stroke-linecap="round"/></svg>';

            // Render grid — items past BATCH_SIZE start hidden
            grid.innerHTML = galleryItems.map(function (item, i) {
                return '<div class="gallery-item' + (i >= BATCH_SIZE ? ' hidden' : '') + '" data-index="' + i + '">' +
                    '<img src="' + item.img + '" alt="' + item.name + '" loading="lazy">' +
                    '<div class="gallery-shade"></div>' +
                    '<div class="gallery-zoom-hint">' + zoomSVG + '</div>' +
                    '<div class="gallery-overlay">' +
                    '<span class="gallery-cat">' + item.label + '</span>' +
                    '<h4>' + item.name + '</h4>' +
                    '</div>' +
                    '</div>';
            }).join('');

            var itemEls = Array.prototype.slice.call(grid.querySelectorAll('.gallery-item'));
            var shownCount = Math.min(BATCH_SIZE, itemEls.length);

            if (loadMoreBtn && shownCount >= itemEls.length) {
                loadMoreBtn.classList.add('hidden');
            }

            // ---- Scroll reveal (only for the currently visible items) ----
            if (reduceMotion || !('IntersectionObserver' in window)) {
                itemEls.forEach(function (el) {
                    if (!el.classList.contains('hidden')) el.classList.add('reveal');
                });
            } else {
                var revealCount = 0;
                var io = new IntersectionObserver(function (entries) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            entry.target.style.transitionDelay = Math.min(revealCount * 70, 420) + 'ms';
                            entry.target.classList.add('reveal');
                            revealCount++;
                            io.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.15
                    , rootMargin: '0px 0px -40px 0px'
                });
                itemEls.forEach(function (el) {
                    if (!el.classList.contains('hidden')) io.observe(el);
                });
            }

            // ---- Load more (replaces filtering) ----
            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function () {
                    var next = itemEls.slice(shownCount, shownCount + BATCH_SIZE);
                    next.forEach(function (el, i) {
                        el.classList.remove('hidden');
                        el.style.transitionDelay = Math.min(i * 70, 420) + 'ms';
                        if (reduceMotion) {
                            el.classList.add('reveal');
                        } else {
                            setTimeout(function () {
                                el.classList.add('reveal');
                            }, 20);
                        }
                    });
                    shownCount += next.length;
                    if (shownCount >= itemEls.length) {
                        loadMoreBtn.classList.add('hidden');
                    }
                });
            }

            // ---- Lightbox (unchanged) ----
            var lightbox = document.getElementById('galleryLightbox');
            var lightboxImg = document.getElementById('lightboxImg');
            var lightboxCat = document.getElementById('lightboxCat');
            var lightboxName = document.getElementById('lightboxName');
            var lightboxCounter = document.getElementById('lightboxCounter');
            var lightboxClose = document.getElementById('lightboxClose');
            var lightboxPrev = document.getElementById('lightboxPrev');
            var lightboxNext = document.getElementById('lightboxNext');
            var currentIndex = 0;

            function visibleIndexes() {
                var list = [];
                itemEls.forEach(function (el, idx) {
                    if (!el.classList.contains('hidden')) list.push(idx);
                });
                return list;
            }

            function showLightbox(dataIndex) {
                var item = galleryItems[dataIndex];
                if (!item) return;
                currentIndex = dataIndex;
                lightboxImg.src = item.img;
                lightboxImg.alt = item.name;
                lightboxCat.textContent = item.label;
                lightboxName.textContent = item.name;
                var vis = visibleIndexes();
                var pos = vis.indexOf(dataIndex) + 1;
                lightboxCounter.textContent = (pos > 0 ? pos : 1) + ' / ' + (vis.length || galleryItems.length);
                lightbox.classList.add('open');
                document.body.style.overflow = 'hidden';
            }

            function closeLightbox() {
                lightbox.classList.remove('open');
                document.body.style.overflow = '';
            }

            function step(dir) {
                var vis = visibleIndexes();
                if (vis.length === 0) return;
                var pos = vis.indexOf(currentIndex);
                if (pos === -1) pos = 0;
                var nextPos = (pos + dir + vis.length) % vis.length;
                showLightbox(vis[nextPos]);
            }

            itemEls.forEach(function (el) {
                el.addEventListener('click', function () {
                    showLightbox(parseInt(el.getAttribute('data-index'), 10));
                });
            });

            lightboxClose.addEventListener('click', closeLightbox);
            lightboxPrev.addEventListener('click', function () {
                step(-1);
            });
            lightboxNext.addEventListener('click', function () {
                step(1);
            });
            lightbox.addEventListener('click', function (e) {
                if (e.target === lightbox) closeLightbox();
            });
            document.addEventListener('keydown', function (e) {
                if (!lightbox.classList.contains('open')) return;
                if (e.key === 'Escape') closeLightbox();
                if (e.key === 'ArrowLeft') step(-1);
                if (e.key === 'ArrowRight') step(1);
            });

        })();

    </script>
</body>

</html>