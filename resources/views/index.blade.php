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
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        h1,
        h2,
        h3,
        .font-display {
            font-family: 'Sora', sans-serif;
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
            max-width: var(--max);
            margin: 0 auto;
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
            gap: 38px;
            font-size: 15px;
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

        @media(max-width:819px) {
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

        @media(min-width:820px) {
            .mobile-menu {
                display: none !important;
            }
        }

        /* ---------- HERO ---------- */
        .hero {
            padding: 64px 24px 0;
            text-align: center;
            background:
                linear-gradient(180deg, #060208 0%, #0a0410 55%, #12081d 100%);
            position: relative;
            overflow: hidden;
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
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: .55;
            mix-blend-mode: screen;
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
            background:
                radial-gradient(120% 140% at 50% 105%, rgba(215, 180, 255, 0.9) 0%, rgba(150, 100, 220, 0.5) 16%, transparent 40%),
                linear-gradient(150deg, #6a49a8 0%, #3c2470 38%, #180d30 78%, #0e0820 100%);
            border: 1px solid rgba(200, 160, 255, 0.28);
            border-radius: 24px;
            padding: 0;
            box-shadow:
                0 18px 40px rgba(90, 30, 160, 0.4),
                inset 0 -14px 26px rgba(190, 140, 255, 0.35),
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
            color: var(--muted);
            font-size: clamp(15px, 1.7vw, 18px);
            line-height: 1.6;
        }

        .hero-visual {
            position: relative;
            margin-top: 44px;
        }

        .hero-visual img {
            width: 100%;
            height: 420px;
            object-fit: cover;
            object-position: top center;
            filter: saturate(1.1);
        }

        .hero-visual::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(6, 2, 8, 0) 55%, rgba(6, 2, 8, 0.55) 100%);
            pointer-events: none;
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
            font-size: 16px;
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
                left: 50%;
                top: 56px;
                width: calc(100% - 32px);
                max-width: calc(100% - 32px);
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
                justify-content: center;
                text-align: center;
                flex-direction: column;
            }

            .price-tiers {
                align-items: center;
            }

            .price-tier {
                justify-content: center;
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
            border-radius: 18px;
            padding: 40px 26px;
            text-align: center;
            position: relative;
            overflow: hidden;
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .card::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 18px;
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
            height: 46px;
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
            width: 72px;
            height: 72px;
            border-radius: 50%;
            margin: 0 auto 22px;
            border: 2px solid transparent;
            background:
                radial-gradient(circle at 32% 28%, rgba(150, 70, 220, 0.55), rgba(16, 8, 24, 0.9)) padding-box,
                linear-gradient(135deg, var(--purple-1), var(--magenta)) border-box;
            box-shadow: 0 0 26px rgba(184, 102, 247, 0.5), inset 0 0 18px rgba(184, 102, 247, 0.18);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-circle svg {
            width: 27px;
            height: 27px;
            stroke: var(--purple-1);
            filter: drop-shadow(0 0 7px rgba(190, 110, 255, 0.85));
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
            text-align: left;
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

        /* ---------- PANELIST ---------- */
        .panel-sec {
            padding: 100px 24px;
            background: var(--bg-soft);
            position: relative;
            overflow: hidden;
        }

        .panel-sec::after {
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

        .panelist-card {
            max-width: var(--max);
            margin: 0 auto 20px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.045), rgba(255, 255, 255, 0.015));
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 28px 32px;
            position: relative;
            z-index: 1;
        }

        .panel-sec .center-btn {
            position: relative;
            z-index: 1;
        }

        .panelist-card h3 {
            font-size: 18px;
            font-weight: 600;
            font-family: 'Inter';
            padding-bottom: 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 22px;
        }

        .panelist-person {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .avatar {
            width: 76px;
            height: 76px;
            border-radius: 14px;
            flex-shrink: 0;
            background: linear-gradient(145deg, #5a2f8f, #231238);
            border: 1px solid rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .avatar svg {
            width: 38px;
            height: 38px;
            opacity: .85;
        }

        .panelist-person h4 {
            font-size: 16px;
            font-weight: 700;
        }

        .panelist-person span {
            font-size: 13.5px;
            color: var(--muted);
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
    </style>
</head>

<body>

    <header>
        <div class="nav">
            <div class="logo"><img src="assets/images/logo.png" alt="ArihantPLUS" class="logo-img"></div>
            <nav class="links">
                <a href="#home">Home</a>
                <a href="#speaker">Speaker</a>
                <a href="#agenda">Agenda</a>
            </nav>
            <a href="#" class="btn btn-primary nav-cta">Reserve Your Spot</a>
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
        <a href="#agenda">Agenda</a>
        <a href="#" class="btn btn-primary">Reserve Your Spot</a>
    </div>

    <section class="hero" id="home">
        <img class="hero-beam beam-right-top" src="assets/images/right-top.png" alt="" aria-hidden="true">
        <img class="hero-beam beam-left" src="assets/images/left-shade.png" alt="" aria-hidden="true">
        <img class="hero-beam beam-right-bottom" src="assets/images/right-bottom.png" alt="" aria-hidden="true">
        <div class="hero-sparkles" id="hero-sparkles"></div>

        <video class="hero-video" autoplay muted loop playsinline>
            <source src="assets/images/fireworks.mp4" type="video/mp4">
        </video>

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
        <h1>Central India's Largest<br>AI &amp; Algo Conclave</h1>
        <p class="sub">Discover how artificial intelligence is transforming trading — and learn to use it to read the
            markets, manage risk and build smarter strategies.</p>

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
                        <div>Date<br><strong>8 September 2026</strong></div>
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
                    <div class="info-field">
                        <span class="ic">
                            <svg viewBox="0 0 24 24">
                                <path d="M3 11l18-7-7 18-2.5-7.5L3 11z" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <div>Venue<br><strong>Labh Mandapam<br>Indore-</strong></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="info-bar">
        <div class="info-inner">
            <div class="price-tiers">
                <div class="price-tier">
                    <span class="tier-label">Non clients</span>
                    <span class="price-old">₹999</span>
                    <span class="price-new">Just - ₹599</span>
                </div>
                <div class="price-tier client">
                    <span class="tier-label">For clients -</span>
                    <span class="price-new">₹299</span>
                </div>
            </div>
            <a href="#" class="btn btn-primary">Claim your spot</a>
        </div>
    </div>

    <div class="learn-get-wrap">
        <img class="lg-glow lg-glow-soft" src="assets/images/7.png" alt="" aria-hidden="true">
        <img class="lg-glow lg-glow-beam" src="assets/images/8.png" alt="" aria-hidden="true">

        <section class="learn" id="learn">
            <div class="section-head purple">
                <h2>What You'll Learn</h2>
            </div>
            <div class="grid6 wrap" style="padding:0;">
                <div class="card">
                    <div class="icon-circle"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                            <path d="M12 2l1.8 5.6L19 9l-5.2 1.4L12 16l-1.8-5.6L5 9l5.2-1.4L12 2z" />
                        </svg></div>
                    <h3>7 Ready-To-Use AI Prompts</h3>
                    <p>Copy-paste prompts for research</p>
                </div>
                <div class="card">
                    <div class="icon-circle"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                            <path d="M4 6h16M4 12h10M4 18h16" stroke-linecap="round" />
                        </svg></div>
                    <h3>The 3-Check Rule for AI Picks</h3>
                    <p>Verify any AI-generated stock</p>
                </div>
                <div class="card">
                    <div class="icon-circle"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                            <path
                                d="M14.7 6.3a1 1 0 010 1.4l-7 7a1 1 0 01-1.4 0l-2-2a1 1 0 011.4-1.4L7 12.6l6.3-6.3a1 1 0 011.4 0z" />
                            <path d="M18 4l1 2 2 1-2 1-1 2-1-2-2-1 2-1 1-2z" />
                        </svg></div>
                    <h3>Free AI Toolkit</h3>
                    <p>Walk away with tools and a free trial</p>
                </div>
                <div class="card">
                    <div class="icon-circle"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                            <rect x="4" y="4" width="16" height="4" rx="1" />
                            <rect x="4" y="10" width="16" height="4" rx="1" />
                            <rect x="4" y="16" width="10" height="4" rx="1" />
                        </svg></div>
                    <h3>A Live-Built Strategy Template</h3>
                    <p>Take home the exact logic built</p>
                </div>
                <div class="card">
                    <div class="icon-circle"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                            <rect x="9" y="3" width="6" height="11" rx="3" />
                            <path d="M5 11a7 7 0 0014 0M12 18v3" />
                        </svg></div>
                    <h3>Real Answers From A Live Debate</h3>
                    <p>Where AI, algos, and human judgment clash</p>
                </div>
                <div class="card">
                    <div class="icon-circle"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                            <circle cx="12" cy="8" r="3.2" />
                            <path d="M5 20c0-3.5 3-6 7-6s7 2.5 7 6" />
                        </svg></div>
                    <h3>Direct Access To Industry Experts</h3>
                    <p>Ask your questions and network with speakers</p>
                </div>
            </div>
        </section>

        <section class="get">
            <div class="section-head">
                <h2>What You'll Get</h2>
            </div>
            <div class="grid6 wrap" style="padding:0;">
                <div class="card">
                    <div class="icon-circle"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                            <path d="M9 3v18M15 3v18" stroke-linecap="round" />
                            <circle cx="9" cy="9" r="1.4" fill="currentColor" stroke="none" />
                            <circle cx="15" cy="15" r="1.4" fill="currentColor" stroke="none" />
                        </svg></div>
                    <h3>Decode AI-Powered Trading</h3>
                    <p>Learn how AI is reshaping trading decisions</p>
                </div>
                <div class="card">
                    <div class="icon-circle"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                            <path d="M5 20V10M12 20V4M19 20v-7" stroke-linecap="round" />
                        </svg></div>
                    <h3>Algo Trading Simplified</h3>
                    <p>See how algorithmic strategies work</p>
                </div>
                <div class="card">
                    <div class="icon-circle"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                            <path
                                d="M14.7 6.3a1 1 0 010 1.4l-7 7a1 1 0 01-1.4 0l-2-2a1 1 0 011.4-1.4L7 12.6l6.3-6.3a1 1 0 011.4 0z" />
                            <path d="M18 4l1 2 2 1-2 1-1 2-1-2-2-1 2-1 1-2z" />
                        </svg></div>
                    <h3>Free AI Toolkit</h3>
                    <p>Walk away with tools and a free trial</p>
                </div>
                <div class="card">
                    <div class="icon-circle"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                            <circle cx="12" cy="8" r="3.2" />
                            <path d="M5 20c0-3.5 3-6 7-6s7 2.5 7 6" />
                        </svg></div>
                    <h3>Learn Directly From Experts</h3>
                    <p>Hear from experienced traders and speakers</p>
                </div>
                <div class="card">
                    <div class="icon-circle"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                            <rect x="3" y="5" width="14" height="11" rx="2" />
                            <path d="M21 8v6M9 19h4" stroke-linecap="round" />
                        </svg></div>
                    <h3>Build Your Own AI-Powered Strategy</h3>
                    <p>Understand the future of trading and investing</p>
                </div>
                <div class="card">
                    <div class="icon-circle"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                            <path d="M4 20l5-1 10-10-4-4L5 15l-1 5z" />
                            <path d="M18 4l2 2" stroke-linecap="round" />
                        </svg></div>
                    <h3>Hands-On With Real AI Tools</h3>
                    <p>Get exposure to AI tools traders use</p>
                </div>
            </div>
            <div class="center-btn left">
                <a href="#" class="btn btn-primary">Claim your spot</a>
            </div>
        </section>
    </div>

    <section class="schedule" id="agenda">
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

        <div class="center-btn"><a href="#" class="btn btn-primary">Claim your spot</a></div>
    </section>

    <section class="panel-sec" id="speaker">
        <div class="section-head">
            <h2>Meet Our Panelist</h2>
        </div>
        <div id="panelist-list"></div>
        <div class="center-btn"><a href="#" class="btn btn-primary">Claim your spot</a></div>
    </section>

    <section class="invite">
        <div class="invite-sphere">
            <img class="sphere-img sphere-img-left" src="assets/images/14.png" alt="" aria-hidden="true">
            <img class="sphere-img sphere-img-right" src="assets/images/15.png" alt="" aria-hidden="true">
            <img class="sphere-img sphere-img-base" src="assets/images/16.png" alt="" aria-hidden="true">
            <h2>Invite &amp; Earn</h2>
            <p>The best traders don't learn alone. Bring your circle, get rewarded for it.</p>
            <a href="#" class="btn btn-ghost">Benefits</a>
            <a href="#" class="btn btn-primary">Refer a friend</a>
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
            <a href="#" class="btn btn-white">Reserve Your Spot</a>

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

    <section class="faq">
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
        <div class="footer-social">
            <a class="social-ic" href="#" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="none"
                    stroke-width="1.8">
                    <rect x="3" y="3" width="18" height="18" rx="5" />
                    <circle cx="12" cy="12" r="4" />
                    <circle cx="17.3" cy="6.7" r="1" fill="currentColor" stroke="none" />
                </svg></a>
            <a class="social-ic" href="#" aria-label="LinkedIn"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                    <rect x="3" y="3" width="18" height="18" rx="3" />
                    <path d="M7 10v7M7 7v.01M11 17v-4.5a2 2 0 014-.2M15 17v-4.5" />
                </svg></a>
            <a class="social-ic" href="#" aria-label="X"><svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
                    <path d="M4 4l16 16M20 4L4 20" />
                </svg></a>
        </div>
        <div class="footer-bottom">
            <span>All copyrights are reserved @Arihantcapital</span>
            <span>Made on earth with <span class="heart">♥</span> human</span>
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
            document.querySelectorAll('.btn').forEach(function (el) {
                var label = el.textContent.trim().toLowerCase();
                if (label === 'reserve your spot' || label === 'claim your spot') {
                    el.addEventListener('click', function (e) {
                        e.preventDefault();
                        openModal();
                    });
                }
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

        // ---------- Hero sparkles ----------
        (function () {
            var host = document.getElementById('hero-sparkles');
            if (!host) return;
            var positions = [
                { top: '6%', left: '30%' }, { top: '3%', left: '42%' }, { top: '10%', left: '55%' },
                { top: '2%', left: '66%' }, { top: '14%', left: '22%' }, { top: '8%', left: '75%' }
            ];
            positions.forEach(function (p, i) {
                var s = document.createElement('span');
                s.className = 'spark';
                s.style.top = p.top; s.style.left = p.left;
                s.style.animationDelay = (i * 0.5) + 's';
                s.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l1.6 6.4L20 10l-6.4 1.6L12 18l-1.6-6.4L4 10l6.4-1.6z"/></svg>';
                host.appendChild(s);
            });
        })();

        // ---------- Countdown ----------
        (function () {
            var target = new Date(2026, 8, 8, 10, 0, 0); // 8 September 2026, 10:00 AM
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
        var agenda = [
            { time: "1:45 PM – 2:00 PM", title: "WELCOME & NETWORKING", body: "Meet fellow traders, investors and market enthusiasts before the masterclass begins.", tag: "Opening" },
            { time: "2:00 PM – 2:20 PM", title: "WHY AI IS CHANGING THE MARKET", body: "A grounded look at where AI genuinely helps traders, and where hype outruns reality.", tag: "Session" },
            { time: "2:20 PM – 2:45 PM", title: "LIVE AI STOCK SCREENING", body: "Watch an AI-assisted screen built and stress-tested live, step by step.", tag: "Demo" },
            { time: "2:45 PM – 3:05 PM", title: "ALGO TRADING 101", body: "The core logic behind rule-based strategies, explained without the jargon.", tag: "Session" },
            { time: "3:05 PM – 3:30 PM", title: "AI VS ALGO VS HUMAN — A LIVE DEBATE", body: "Three approaches to the same trade, argued out loud by people who use them daily.", tag: "Debate" },
            { time: "3:30 PM – 3:45 PM", title: "Q&A AND CLOSING NOTES", body: "Open floor for questions, plus how to keep building on what you learned today.", tag: "Closing" }
        ];
        var agendaHTML = agenda.map(function (a) {
            return '<div class="agenda-item">' +
                '<div class="agenda-time">' + a.time + '</div>' +
                '<div class="agenda-body"><h4>' + a.title + '</h4><p>' + a.body + '</p></div>' +
                '<div class="pill">' + a.tag + '</div>' +
                '</div>';
        }).join('');
        document.getElementById('agenda-list').innerHTML = agendaHTML;

        var panelists = [
            { group: "India's Lead Technical Analyst & Algo Trader", name: "Vishal Mehta", role: "Algo Trader | Market Educator", img: "assets/images/21.png" },
            { group: "India's #1 Financial Astrology Expert", name: "Harshubh", role: "Financial Astrology", img: "assets/images/22.png" },
            { group: "Co-Founder Quantify Capital | Algorithmic Trading", name: "Saurabh Sisodia", role: "Data Driven Trader", img: "assets/images/23.png" }
        ];
        var avatarSVG = '<svg viewBox="0 0 24 24" fill="none" stroke="#d8bfff" stroke-width="1.6"><circle cx="12" cy="8" r="3.4"/><path d="M5 20c0-3.6 3.1-6.2 7-6.2s7 2.6 7 6.2"/></svg>';
        document.getElementById('panelist-list').innerHTML = panelists.map(function (p) {
            var avatarContent = p.img ? '<img src="' + p.img + '" alt="' + p.name + '" style="width:100%;height:100%;object-fit:cover;">' : avatarSVG;
            return '<div class="panelist-card">' +
                '<h3>' + p.group + '</h3>' +
                '<div class="panelist-person">' +
                '<div class="avatar">' + avatarContent + '</div>' +
                '<div><h4>' + p.name + '</h4><span>' + p.role + '</span></div>' +
                '</div>' +
                '</div>';
        }).join('');

        // ---------- FAQ ----------
        var faqs = [
            { q: "How do I open a trading and demat account?", a: "You can open both accounts online in a few minutes through the ArihantPLUS app or website by completing e-KYC and e-sign — no paperwork or branch visit required." },
            { q: "What documents are required for account opening?", a: "ArihantPlus requires a PAN card, an Aadhaar card, bank proof, a signature and a photograph for account opening. Users opting for F&O trading must also submit proof of income, such as salary slips, bank statements, ITR acknowledgment or Form 16, during the verification process." },
            { q: "How long does the account activation process take?", a: "Most accounts are verified and activated within 24–48 hours once all documents and e-sign steps are completed correctly." },
            { q: "Is there any account opening fee or annual maintenance charge?", a: "Account opening is free for a limited period during this event; standard annual maintenance charges apply afterward as per the published fee schedule." },
            { q: "What tools or charts are available for analysis?", a: "You'll get access to advanced charting, AI-assisted stock screeners, algo strategy builders and real-time market data as part of the ArihantPLUS toolkit." }
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
    </script>
</body>

</html>