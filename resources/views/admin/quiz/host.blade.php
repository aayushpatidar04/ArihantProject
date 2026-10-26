<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $quizName }} — Host Screen</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #05020a;
            --ink: #fff;
            --muted: #a99bbd;
            --p1: #b866f7;
            --p2: #7a1fc9;
            --pink: #d43fe0;
            --green: #34d399;
            --gold: #ffd54a;
            --c0: #ff4d6d;
            --c1: #3b82f6;
            --c2: #fbbf24;
            --c3: #22c55e;
            --row: 78px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        html,
        body {
            height: 100%;
            overflow: hidden
        }

        @supports (height:100dvh) {

            html,
            body {
                height: 100dvh
            }
        }

        body {
            font-family: 'Sora', system-ui, sans-serif;
            background: var(--bg);
            color: var(--ink);
            user-select: none
        }

        /* ---------- animated background ---------- */
        .bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
            background: radial-gradient(1200px 700px at 15% -10%, #3a0f63 0%, transparent 60%), radial-gradient(900px 600px at 100% 110%, #5a0f6e 0%, transparent 55%), var(--bg)
        }

        .bg i {
            position: absolute;
            display: block;
            opacity: .09;
            animation: drift linear infinite
        }

        .bg i:nth-child(3n) {
            border-radius: 50%;
            background: var(--p1)
        }

        .bg i:nth-child(3n+1) {
            background: var(--pink);
            transform: rotate(45deg)
        }

        .bg i:nth-child(3n+2) {
            width: 0 !important;
            height: 0 !important;
            background: none !important;
            border-left: 30px solid transparent;
            border-right: 30px solid transparent;
            border-bottom: 52px solid var(--p2)
        }

        @keyframes drift {
            from {
                transform: translateY(110vh) rotate(0deg)
            }

            to {
                transform: translateY(-20vh) rotate(360deg)
            }
        }

        #fx {
            position: fixed;
            inset: 0;
            z-index: 50;
            pointer-events: none
        }

        /* ---------- shell ---------- */
        .shell {
            position: relative;
            z-index: 1;
            height: 100%;
            display: grid;
            grid-template-rows: auto 1fr auto
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 28px
        }

        .brand {
            font-weight: 800;
            letter-spacing: .2px;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px
        }

        .brand .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--green);
            box-shadow: 0 0 0 0 rgba(52, 211, 153, .7);
            animation: live 1.8s infinite
        }

        @keyframes live {
            70% {
                box-shadow: 0 0 0 12px rgba(52, 211, 153, 0)
            }

            100% {
                box-shadow: 0 0 0 0 rgba(52, 211, 153, 0)
            }
        }

        .tools {
            display: flex;
            gap: 10px
        }

        .icon-btn {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, .12);
            background: rgba(255, 255, 255, .06);
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            transition: .2s
        }

        .icon-btn:hover {
            background: rgba(255, 255, 255, .14);
            transform: translateY(-2px)
        }

        main {
            position: relative;
            min-height: 0
        }

        .view {
            position: absolute;
            inset: 0;
            display: none;
            flex-direction: column;
            padding: 0 4vw 16px;
            min-height: 0;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, .25) transparent
        }

        .view>*:first-child {
            margin-top: 0
        }

        .view.active {
            display: flex
        }

        /* ---------- lobby ---------- */
        #v-lobby {
            align-items: center
        }

        .lobby-title {
            font-size: clamp(18px, 2vw, 28px);
            font-weight: 700;
            color: var(--p1);
            letter-spacing: 1px;
            text-transform: uppercase;
            animation: dropIn .7s cubic-bezier(.2, 1.2, .3, 1) both
        }

        .join-card {
            margin-top: 14px;
            display: flex;
            align-items: center;
            gap: 36px;
            padding: 22px 36px;
            border-radius: 30px;
            background: linear-gradient(160deg, rgba(255, 255, 255, .10), rgba(255, 255, 255, .03));
            border: 1px solid rgba(255, 255, 255, .14);
            backdrop-filter: blur(10px);
            box-shadow: 0 30px 80px rgba(122, 31, 201, .35);
            animation: dropIn .8s .1s cubic-bezier(.2, 1.2, .3, 1) both
        }

        .join-l {
            text-align: center
        }

        .kicker {
            color: var(--muted);
            font-size: clamp(12px, 1.2vw, 16px);
            font-weight: 600;
            letter-spacing: .5px
        }

        .join-url {
            font-size: clamp(20px, 2.6vw, 38px);
            font-weight: 800;
            margin: 2px 0 10px
        }

        .pin {
            display: flex;
            gap: clamp(6px, .8vw, 12px);
            justify-content: center;
            margin-top: 6px
        }

        .pin b {
            width: clamp(44px, 5.2vw, 84px);
            height: clamp(58px, 6.8vw, 108px);
            border-radius: 16px;
            display: grid;
            place-items: center;
            font-size: clamp(32px, 4.6vw, 76px);
            font-weight: 800;
            background: linear-gradient(160deg, var(--p1), var(--p2));
            box-shadow: 0 10px 30px rgba(122, 31, 201, .5), inset 0 2px 0 rgba(255, 255, 255, .3);
            animation: flipIn .7s cubic-bezier(.2, 1.1, .3, 1) both
        }

        @keyframes flipIn {
            from {
                transform: perspective(500px) rotateX(-90deg) scale(.7);
                opacity: 0
            }

            to {
                transform: none;
                opacity: 1
            }
        }

        .qr {
            width: clamp(120px, 14vw, 210px);
            height: clamp(120px, 14vw, 210px);
            border-radius: 18px;
            background: #060208;
            padding: 8px;
            border: 1px solid rgba(255, 255, 255, .15)
        }

        .qr-missing {
            display: grid;
            place-items: center;
            color: var(--muted);
            font-size: 12px;
            text-align: center
        }

        .lobby-count {
            margin: 22px 0 6px;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 10px 22px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .07);
            border: 1px solid rgba(255, 255, 255, .12);
            font-weight: 700;
            font-size: clamp(15px, 1.6vw, 22px)
        }

        .lobby-count b {
            font-size: 1.35em;
            color: var(--green);
            display: inline-block;
            min-width: 1.2em;
            text-align: center
        }

        .bump {
            animation: bump .45s ease
        }

        @keyframes bump {
            40% {
                transform: scale(1.5)
            }
        }

        .players {
            flex: 1 0 auto;
            width: 100%;
            max-width: 1500px;
            display: flex;
            flex-wrap: wrap;
            align-content: flex-start;
            justify-content: center;
            gap: 12px 14px;
            padding: 14px 8px 4px
        }

        .chip {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 18px 8px 8px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .10);
            border: 1px solid rgba(255, 255, 255, .16);
            font-weight: 700;
            font-size: clamp(14px, 1.5vw, 20px);
            animation: pop .65s cubic-bezier(.2, 1.6, .4, 1) both, bob 3.6s ease-in-out .7s infinite;
            box-shadow: 0 8px 22px rgba(0, 0, 0, .35)
        }

        .chip .av {
            width: 2em;
            height: 2em;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: .9em;
            font-weight: 800;
            color: #12081c
        }

        .chip.fresh {
            box-shadow: 0 0 0 3px rgba(184, 102, 247, .7), 0 0 40px rgba(184, 102, 247, .6)
        }

        .chip span.nm {
            max-width: 14ch;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap
        }

        @keyframes pop {
            0% {
                transform: scale(.2) rotate(-14deg);
                opacity: 0
            }

            60% {
                transform: scale(1.18) rotate(4deg);
                opacity: 1
            }

            100% {
                transform: scale(1) rotate(0)
            }
        }

        @keyframes bob {

            0%,
            100% {
                translate: 0 0
            }

            50% {
                translate: 0 -5px
            }
        }

        .waiting {
            margin: 28px auto;
            color: var(--muted);
            font-size: clamp(18px, 2vw, 28px);
            font-weight: 600;
            text-align: center
        }

        .waiting .dots span {
            display: inline-block;
            animation: dot 1.4s infinite
        }

        .waiting .dots span:nth-child(2) {
            animation-delay: .2s
        }

        .waiting .dots span:nth-child(3) {
            animation-delay: .4s
        }

        @keyframes dot {

            0%,
            60%,
            100% {
                transform: translateY(0);
                opacity: .4
            }

            30% {
                transform: translateY(-8px);
                opacity: 1
            }
        }

        @keyframes dropIn {
            from {
                transform: translateY(-30px);
                opacity: 0
            }

            to {
                transform: none;
                opacity: 1
            }
        }

        /* ---------- question ---------- */
        .q-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 4px 0 10px
        }

        .pill {
            padding: 9px 20px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .09);
            border: 1px solid rgba(255, 255, 255, .14);
            font-weight: 700;
            font-size: clamp(13px, 1.3vw, 18px)
        }

        .ans-counter {
            display: flex;
            align-items: baseline;
            gap: 10px;
            padding: 8px 20px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .14)
        }

        .ans-counter b {
            font-size: clamp(26px, 3vw, 44px);
            font-weight: 800;
            color: var(--green)
        }

        .ans-counter span {
            color: var(--muted);
            font-size: 14px;
            font-weight: 600
        }

        .q-body {
            display: grid;
            grid-template-columns: clamp(120px, 14vw, 200px) 1fr clamp(120px, 14vw, 200px);
            align-items: center;
            gap: 22px;
            flex: 1 0 auto;
            padding: 6px 0
        }

        .q-card {
            text-align: center;
            padding: clamp(18px, 3vw, 44px);
            border-radius: 32px;
            background: linear-gradient(160deg, rgba(255, 255, 255, .13), rgba(255, 255, 255, .04));
            border: 1px solid rgba(255, 255, 255, .16);
            box-shadow: 0 30px 80px rgba(0, 0, 0, .45);
            animation: slideUp .7s cubic-bezier(.2, 1.1, .3, 1) both
        }

        .q-card h1 {
            font-size: clamp(24px, 3.6vw, 54px);
            line-height: 1.22;
            font-weight: 800
        }

        .q-card h1.sm {
            font-size: clamp(20px, 2.8vw, 40px)
        }

        .q-card h1.xs {
            font-size: clamp(17px, 2.1vw, 30px)
        }

        @keyframes slideUp {
            from {
                transform: translateY(40px) scale(.97);
                opacity: 0
            }

            to {
                transform: none;
                opacity: 1
            }
        }

        .timer {
            position: relative;
            width: clamp(110px, 12vw, 180px);
            aspect-ratio: 1;
            justify-self: center
        }

        .timer svg {
            width: 100%;
            height: 100%;
            transform: rotate(-90deg)
        }

        .timer .trk {
            stroke: rgba(255, 255, 255, .12)
        }

        .timer .bar {
            stroke: var(--p1);
            stroke-linecap: round;
            transition: stroke .3s
        }

        .timer.warn .bar {
            stroke: var(--gold)
        }

        .timer.danger .bar {
            stroke: var(--c0)
        }

        .timer.danger {
            animation: shake .5s infinite
        }

        .timer.reading .bar {
            stroke: #7dd3fc
        }

        .t-mid {
            position: absolute;
            inset: 0;
            display: grid;
            place-content: center;
            text-align: center
        }

        #tNum {
            font-size: clamp(38px, 5vw, 76px);
            font-weight: 800;
            line-height: 1
        }

        #tLabel {
            font-size: 12px;
            color: var(--muted);
            font-weight: 600;
            margin-top: 4px;
            letter-spacing: .5px;
            text-transform: uppercase
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0)
            }

            25% {
                transform: translateX(-3px)
            }

            75% {
                transform: translateX(3px)
            }
        }

        .opts {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: clamp(10px, 1.4vw, 20px);
            padding: 18px 0 6px
        }

        .opt {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: clamp(14px, 2vw, 26px) clamp(16px, 2vw, 30px);
            border-radius: 22px;
            color: #fff;
            font-weight: 700;
            font-size: clamp(17px, 2.2vw, 32px);
            min-height: clamp(70px, 11vh, 120px);
            box-shadow: 0 8px 0 rgba(0, 0, 0, .28), 0 20px 40px rgba(0, 0, 0, .35);
            opacity: 0;
            transform: translateY(40px) scale(.9);
            transition: opacity .5s, transform .5s cubic-bezier(.2, 1.4, .4, 1)
        }

        .opt.show {
            opacity: 1;
            transform: none
        }

        .opt svg {
            width: clamp(28px, 3vw, 46px);
            height: clamp(28px, 3vw, 46px);
            flex-shrink: 0;
            fill: #fff;
            filter: drop-shadow(0 2px 0 rgba(0, 0, 0, .25))
        }

        .opt .t {
            line-height: 1.2;
            text-align: left;
            min-width: 0;
            overflow-wrap: anywhere
        }

        .o0 {
            background: linear-gradient(160deg, #ff6b87, var(--c0))
        }

        .o1 {
            background: linear-gradient(160deg, #5b9bff, var(--c1))
        }

        .o2 {
            background: linear-gradient(160deg, #ffd04a, #e99a0b);
            color: #2a1c00
        }

        .o3 {
            background: linear-gradient(160deg, #3ddb7e, var(--c3))
        }

        .o2 svg {
            fill: #2a1c00
        }

        /* ---------- reveal ---------- */
        .r-text {
            text-align: center;
            font-size: clamp(18px, 2.2vw, 32px);
            font-weight: 700;
            color: #e9dcfb;
            padding: 0 6vw;
            animation: dropIn .5s both
        }

        .bars {
            flex: 1 0 clamp(240px, 40vh, 520px);
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: clamp(12px, 2vw, 32px);
            align-items: end;
            padding: 16px 4vw 6px
        }

        .col {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            height: 100%
        }

        .col .cnt {
            font-size: clamp(24px, 3.2vw, 48px);
            font-weight: 800;
            margin-bottom: 8px
        }

        .col .stick {
            width: 100%;
            height: 8px;
            min-height: 8px;
            border-radius: 18px 18px 6px 6px;
            transition: height 1.1s cubic-bezier(.2, 1, .3, 1);
            position: relative
        }

        .col .lab {
            margin-top: 12px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 16px;
            font-weight: 700;
            font-size: clamp(13px, 1.5vw, 22px);
            text-align: center
        }

        .col .lab svg {
            width: 1.4em;
            height: 1.4em;
            flex-shrink: 0;
            fill: currentColor
        }

        .col.go .stick {
            height: var(--p, 8%)
        }

        .col.wrong {
            opacity: .38;
            filter: saturate(.5);
            transition: .8s .9s
        }

        .col.right .lab {
            box-shadow: 0 0 0 4px #fff, 0 0 50px rgba(255, 255, 255, .55);
            animation: glow 1.2s .9s ease infinite alternate
        }

        .col.right .stick::after {
            content: '✓';
            position: absolute;
            top: -4px;
            left: 50%;
            transform: translateX(-50%) scale(0);
            font-size: clamp(26px, 3vw, 46px);
            font-weight: 800;
            color: #fff;
            animation: tick .6s 1s cubic-bezier(.2, 1.8, .4, 1) forwards
        }

        @keyframes tick {
            to {
                transform: translateX(-50%) scale(1)
            }
        }

        @keyframes glow {
            to {
                transform: scale(1.04)
            }
        }

        .stats {
            display: flex;
            gap: 14px;
            justify-content: center;
            flex-wrap: wrap;
            padding: 6px 0 4px
        }

        .stat {
            padding: 10px 20px;
            border-radius: 16px;
            background: rgba(255, 255, 255, .09);
            border: 1px solid rgba(255, 255, 255, .14);
            font-weight: 700;
            font-size: clamp(13px, 1.4vw, 19px);
            animation: dropIn .6s 1.1s both
        }

        .stat em {
            font-style: normal;
            color: var(--green)
        }

        /* ---------- scoreboard ---------- */
        #v-scoreboard,
        #v-podium {
            align-items: center
        }

        .h-title {
            font-size: clamp(28px, 4vw, 58px);
            font-weight: 800;
            text-align: center;
            margin: 6px 0 4px;
            animation: dropIn .6s both
        }

        .h-sub {
            color: var(--muted);
            font-weight: 600;
            text-align: center;
            margin-bottom: 18px
        }

        .board {
            position: relative;
            width: min(900px, 92vw)
        }

        .brow {
            position: absolute;
            left: 0;
            right: 0;
            height: calc(var(--row) - 12px);
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 0 26px 0 14px;
            border-radius: 20px;
            background: linear-gradient(90deg, rgba(255, 255, 255, .14), rgba(255, 255, 255, .06));
            border: 1px solid rgba(255, 255, 255, .16);
            transition: transform 1s cubic-bezier(.3, 1.1, .3, 1), opacity .6s;
            font-weight: 700;
            font-size: clamp(16px, 2vw, 28px)
        }

        .brow.top1 {
            background: linear-gradient(90deg, rgba(255, 213, 74, .35), rgba(255, 213, 74, .08));
            border-color: rgba(255, 213, 74, .6)
        }

        .brow .rk {
            width: 2.2em;
            height: 2.2em;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: rgba(255, 255, 255, .12);
            font-size: .8em
        }

        .brow .nm {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap
        }

        .brow .mv {
            font-size: .6em;
            color: var(--green);
            font-weight: 800;
            min-width: 3em
        }

        .brow .gn {
            font-size: .62em;
            color: var(--gold);
            font-weight: 800;
            opacity: 0;
            transition: opacity .5s
        }

        .brow .gn.on {
            opacity: 1
        }

        .brow .sc {
            min-width: 4.5em;
            text-align: right;
            font-variant-numeric: tabular-nums
        }

        /* ---------- podium ---------- */
        .podium {
            display: flex;
            align-items: flex-end;
            justify-content: center;
            gap: clamp(10px, 2vw, 28px);
            height: clamp(250px, 46vh, 420px);
            margin-top: 8px
        }

        .pcol {
            width: clamp(92px, 17vw, 250px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            height: 100%
        }

        .pcol .who {
            text-align: center;
            margin-bottom: 10px;
            opacity: 0;
            transform: translateY(20px);
            transition: .6s
        }

        .pcol .who .n {
            font-weight: 800;
            font-size: clamp(15px, 1.8vw, 26px);
            max-width: 14ch;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            margin: 0 auto
        }

        .pcol .who .s {
            color: var(--gold);
            font-weight: 800;
            font-size: clamp(14px, 1.5vw, 22px)
        }

        .pcol .who .crown {
            font-size: clamp(28px, 3.4vw, 52px);
            animation: bob 2s infinite
        }

        .pcol .blk {
            width: 100%;
            height: 0;
            border-radius: 22px 22px 0 0;
            display: grid;
            place-items: start center;
            padding-top: 14px;
            font-weight: 800;
            font-size: clamp(34px, 5vw, 80px);
            transition: height 1.2s cubic-bezier(.2, 1, .3, 1);
            box-shadow: inset 0 3px 0 rgba(255, 255, 255, .3), 0 20px 50px rgba(0, 0, 0, .4)
        }

        .pcol.p1 .blk {
            background: linear-gradient(180deg, #ffe27a, #e8a90f);
            color: #5b3b00
        }

        .pcol.p2 .blk {
            background: linear-gradient(180deg, #e6ebf5, #98a2b8);
            color: #2c3548
        }

        .pcol.p3 .blk {
            background: linear-gradient(180deg, #f0b27a, #b86b2b);
            color: #4a2506
        }

        .pcol.in .who {
            opacity: 1;
            transform: none
        }

        .rest {
            width: min(720px, 90vw);
            margin-top: 18px;
            display: grid;
            gap: 8px
        }

        .rest div {
            display: flex;
            gap: 14px;
            align-items: center;
            padding: 9px 18px;
            border-radius: 14px;
            background: rgba(255, 255, 255, .07);
            font-weight: 600;
            animation: dropIn .5s both
        }

        .rest b {
            width: 2em;
            color: var(--muted)
        }

        .rest span {
            flex: 1
        }

        /* ---------- host bar ---------- */
        .hostbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 14px 28px 22px
        }

        .hb {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 10px
        }

        .hb.c {
            justify-content: center
        }

        .hb.r {
            justify-content: flex-end
        }

        .status {
            color: var(--muted);
            font-weight: 600;
            font-size: 14px
        }

        .btn {
            border: 0;
            cursor: pointer;
            font-family: inherit;
            font-weight: 800;
            font-size: clamp(15px, 1.6vw, 22px);
            color: #fff;
            padding: 16px 44px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--pink), var(--p2));
            box-shadow: 0 10px 0 #4b0f80, 0 22px 40px rgba(122, 31, 201, .5);
            transition: transform .15s, box-shadow .15s, filter .2s;
            text-decoration: none;
            display: inline-flex;
            gap: 10px;
            align-items: center
        }

        .btn:hover {
            transform: translateY(-3px)
        }

        .btn:active {
            transform: translateY(6px);
            box-shadow: 0 4px 0 #4b0f80
        }

        .btn:disabled {
            filter: grayscale(.8) brightness(.6);
            cursor: not-allowed;
            transform: none
        }

        .btn.ghost {
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .16);
            box-shadow: none;
            font-size: 15px;
            padding: 12px 22px
        }

        .btn.danger {
            background: rgba(255, 77, 109, .16);
            border: 1px solid rgba(255, 77, 109, .45);
            color: #ff8ea3;
            box-shadow: none;
            font-size: 15px;
            padding: 12px 22px
        }

        .btn.pulse:not(:disabled) {
            animation: btnp 1.6s infinite
        }

        @keyframes btnp {
            50% {
                box-shadow: 0 10px 0 #4b0f80, 0 22px 70px rgba(212, 63, 224, .9)
            }
        }

        .overlay {
            position: fixed;
            inset: 0;
            z-index: 40;
            display: none;
            place-items: center;
            background: rgba(5, 2, 10, .78);
            backdrop-filter: blur(8px);
            text-align: center
        }

        .overlay.on {
            display: grid
        }

        #pauseOv {
            pointer-events: none
        }

        .hostbar {
            position: relative;
            z-index: 45
        }

        .overlay h2 {
            font-size: clamp(36px, 6vw, 90px);
            font-weight: 800
        }

        .overlay p {
            color: var(--muted);
            margin-top: 8px
        }

        .toast {
            position: fixed;
            top: 76px;
            left: 50%;
            translate: -50% -20px;
            opacity: 0;
            z-index: 60;
            background: #2a0f3f;
            border: 1px solid rgba(255, 255, 255, .2);
            padding: 10px 22px;
            border-radius: 14px;
            font-weight: 600;
            transition: .3s
        }

        .toast.on {
            opacity: 1;
            translate: -50% 0
        }

        /* ---------- tablets / narrow windows ---------- */
        @media (max-width:900px) {
            .topbar {
                padding: 12px 16px
            }

            .view {
                padding: 0 16px 14px
            }

            .q-body {
                grid-template-columns: 1fr;
                gap: 12px
            }

            .q-body>div:last-child {
                display: none
            }

            .timer {
                width: 92px
            }

            #tNum {
                font-size: 34px
            }

            .join-card {
                flex-direction: column;
                gap: 14px;
                padding: 18px 20px
            }

            .opts {
                grid-template-columns: 1fr
            }

            .opt {
                min-height: 64px
            }

            .hostbar {
                flex-wrap: wrap;
                padding: 10px 16px 14px
            }

            .podium {
                gap: 8px
            }
        }

        /* ---------- phones ---------- */
        @media (max-width:700px) {
            :root {
                --row: 66px
            }

            .brand {
                font-size: 15px;
                min-width: 0
            }

            .brand span:last-child {
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                max-width: 52vw
            }

            .icon-btn {
                width: 38px;
                height: 38px;
                border-radius: 12px;
                font-size: 16px
            }

            .q-head {
                gap: 8px
            }

            .ans-counter {
                padding: 6px 14px
            }

            .ans-counter span {
                font-size: 12px
            }

            .q-card {
                padding: 18px 16px;
                border-radius: 22px
            }

            .hostbar .hb:first-child {
                display: none
            }

            .hostbar .hb {
                flex: 1 1 100%
            }

            .hostbar .hb.c {
                order: 1
            }

            .hostbar .hb.r {
                order: 2;
                justify-content: center
            }

            .hostbar .btn {
                padding: 12px 30px;
                font-size: 16px
            }

            .hostbar .btn.ghost,
            .hostbar .btn.danger {
                padding: 9px 18px;
                font-size: 13px
            }

            .brow {
                gap: 10px;
                padding: 0 14px 0 10px;
                font-size: 15px
            }

            .brow .mv {
                display: none
            }

            .brow .sc {
                min-width: 3.4em
            }

            .podium {
                height: 270px
            }

            .pcol {
                width: 31%
            }

            .stat {
                padding: 8px 12px;
                font-size: 12px
            }

            /* reveal chart: one row per option, bar grows sideways */
            .bars {
                grid-template-columns: 1fr;
                align-items: stretch;
                gap: 10px;
                padding: 10px 0;
                flex-basis: auto
            }

            .col {
                display: grid;
                grid-template-columns: 1fr auto;
                grid-template-areas: "lab cnt" "stick stick";
                align-items: center;
                height: auto;
                gap: 6px 10px
            }

            .col .lab {
                grid-area: lab;
                margin: 0;
                justify-content: flex-start;
                text-align: left;
                font-size: 14px
            }

            .col .cnt {
                grid-area: cnt;
                margin: 0;
                font-size: 22px
            }

            .col .stick,
            .col.go .stick {
                grid-area: stick;
                height: 14px;
                width: 8px;
                min-width: 8px;
                border-radius: 8px;
                transition: width 1.1s cubic-bezier(.2, 1, .3, 1)
            }

            .col.go .stick {
                width: var(--p, 8%)
            }

            .col.right .stick::after {
                display: none
            }
        }

        /* ---------- short windows (laptops, landscape phones) ---------- */
        @media (max-height:720px) {
            .topbar {
                padding: 8px 20px
            }

            .hostbar {
                padding: 8px 20px 12px
            }

            .btn {
                padding: 11px 32px
            }

            .lobby-count {
                margin-top: 12px
            }

            .join-card {
                padding: 14px 24px;
                margin-top: 8px
            }

            .qr {
                width: 110px;
                height: 110px
            }

            .q-card {
                padding: 16px 22px
            }

            .q-card h1 {
                font-size: clamp(20px, 2.6vw, 34px)
            }

            .opt {
                min-height: 54px;
                padding: 10px 18px;
                font-size: clamp(16px, 1.9vw, 24px)
            }

            .opts {
                padding-top: 8px
            }

            .timer {
                width: 96px
            }

            #tNum {
                font-size: 36px
            }

            .h-title {
                font-size: 30px
            }

            .h-sub {
                margin-bottom: 8px
            }

            :root {
                --row: 62px
            }
        }

        @media (prefers-reduced-motion:reduce) {

            .bg i,
            .chip,
            .timer.danger {
                animation: none !important
            }
        }
    </style>
</head>

<body>
    <div class="bg" id="bg"></div>
    <canvas id="fx"></canvas>

    <div class="shell">
        <header class="topbar">
            <div class="brand"><span class="dot"></span><span>{{ $quizName }}</span></div>
            <div class="tools">
                <button class="icon-btn" id="btnSound" title="Sound (M)">🔊</button>
                <button class="icon-btn" id="btnFs" title="Fullscreen (F)">⛶</button>
            </div>
        </header>

        <main>
            <!-- LOBBY -->
            <section class="view active" id="v-lobby">
                <div class="lobby-title">{{ $quizName }}</div>
                <div class="join-card">
                    <div class="join-l">
                        <div class="kicker">Join at</div>
                        <div class="join-url">{{ $joinHost }}</div>
                        <div class="kicker">with Game PIN</div>
                        <div class="pin" id="pin"></div>
                    </div>
                    @if($qrUrl)
                        <img class="qr" src="{{ $qrUrl }}" alt="Scan to join">
                    @else
                        <div class="qr qr-missing">QR not generated</div>
                    @endif
                </div>
                <div class="lobby-count"><span>👥</span><b id="lobbyCount">0</b><span>players joined</span></div>
                <div class="players" id="players"></div>
                <div class="waiting" id="waiting">Waiting for players<span class="dots"><span>.</span><span>.</span><span>.</span></span></div>
            </section>

            <!-- QUESTION -->
            <section class="view" id="v-question">
                <div class="q-head">
                    <span class="pill" id="qCounter"></span>
                    <div class="ans-counter"><b id="ansNum">0</b><span id="ansOf"></span></div>
                </div>
                <div class="q-body">
                    <div class="timer reading" id="timer">
                        <svg viewBox="0 0 120 120">
                            <circle class="trk" cx="60" cy="60" r="54" fill="none" stroke-width="10" />
                            <circle class="bar" id="ring" cx="60" cy="60" r="54" fill="none" stroke-width="10" stroke-dasharray="339.29" stroke-dashoffset="0" />
                        </svg>
                        <div class="t-mid"><div id="tNum">0</div><div id="tLabel">Get ready</div></div>
                    </div>
                    <div class="q-card"><h1 id="qText"></h1></div>
                    <div></div>
                </div>
                <div class="opts" id="opts"></div>
            </section>

            <!-- REVEAL -->
            <section class="view" id="v-reveal">
                <div class="q-head"><span class="pill" id="rCounter"></span><span></span></div>
                <div class="r-text" id="rText"></div>
                <div class="bars" id="bars"></div>
                <div class="stats" id="stats"></div>
            </section>

            <!-- SCOREBOARD -->
            <section class="view" id="v-scoreboard">
                <div class="h-title">Leaderboard</div>
                <div class="h-sub" id="boardSub"></div>
                <div class="board" id="board"></div>
            </section>

            <!-- PODIUM -->
            <section class="view" id="v-podium">
                <div class="h-title">🏆 Final Podium</div>
                <div class="h-sub" id="podSub"></div>
                <div class="podium" id="podium"></div>
                <div class="rest" id="rest"></div>
            </section>
        </main>

        <footer class="hostbar">
            <div class="hb"><span class="status" id="status"></span></div>
            <div class="hb c">
                <button class="btn pulse" id="btnMain" disabled>Start</button>
                <a class="btn" id="btnResults" href="{{ route('admin.quiz.results', $type) }}" style="display:none">📋 View full results</a>
            </div>
            <div class="hb r">
                <button class="btn ghost" id="btnPause" style="display:none">⏸ Pause</button>
                <button class="btn danger" id="btnEnd">⏹ End</button>
            </div>
        </footer>
    </div>

    <div class="overlay" id="pauseOv"><div><h2>⏸ Paused</h2><p>Press Resume to continue the timer</p></div></div>
    <div class="overlay" id="goneOv"><div><h2>Quiz ended</h2><p><a href="{{ route('admin.quiz.index') }}" style="color:var(--p1)">Back to quiz dashboard</a></p></div></div>
    <div class="toast" id="toast"></div>

    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        (function () {
            const TYPE = @json($type);
            const SESSION_ID = @json($session->id);
            const PIN = @json($session->pin);
            const CSRF = document.querySelector('meta[name=csrf-token]').content;
            const URLS = {
                state: @json(route('admin.quiz.host-state', $type)),
                base: @json(url('/admin/quiz/' . $type)),
            };
            const READ_GRACE_MS = 1200;      // "Time's up!" beat before locking
            const POLL_MS = {{ (int) config('quiz.host_polling_interval_ms', 2000) }};
            const RING = 339.29;
            const COLORS = ['#ffb3c0', '#bcd4ff', '#ffe29a', '#a7f3c6', '#e9c8ff', '#9ee7ff', '#ffc9a3', '#d6f5a0'];
            const SHAPES = [
                '<svg viewBox="0 0 24 24"><path d="M12 3 L22 21 H2 Z"/></svg>',
                '<svg viewBox="0 0 24 24"><path d="M12 2 L22 12 L12 22 L2 12 Z"/></svg>',
                '<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>',
                '<svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>',
            ];

            const $ = (id) => document.getElementById(id);
            let S = null;                       // latest host state
            let offset = 0;                     // serverNow = Date.now() + offset
            let shownPhase = null, shownQ = null;
            let players = new Map();            // id -> {el}
            let maxPid = 0;
            let busy = false, lastActionAt = 0;
            let revealTimer = null, revealQ = null;
            let optsOpened = false, lastTickSec = null;
            let soundOn = true;

            const serverNow = () => Date.now() + offset;
            const syncClock = (ms) => { if (ms) offset = ms - Date.now(); };

            /* ---------------- background shapes ---------------- */
            (function bg() {
                const el = $('bg');
                for (let i = 0; i < 22; i++) {
                    const s = document.createElement('i');
                    const size = 30 + Math.random() * 70;
                    s.style.cssText = `left:${Math.random() * 100}%;width:${size}px;height:${size}px;animation-duration:${22 + Math.random() * 30}s;animation-delay:-${Math.random() * 40}s`;
                    el.appendChild(s);
                }
            })();

            /* ---------------- sound (synthesised, no assets) ---------------- */
            let ac = null;
            function ensureAudio() {
                if (!soundOn) return null;
                try {
                    ac = ac || new (window.AudioContext || window.webkitAudioContext)();
                    if (ac.state === 'suspended') ac.resume();
                } catch (e) { ac = null; }
                return ac;
            }
            function tone(f, d, type = 'sine', vol = .12, when = 0, to = null) {
                const c = ensureAudio(); if (!c) return;
                const t = c.currentTime + when, o = c.createOscillator(), g = c.createGain();
                o.type = type; o.frequency.setValueAtTime(f, t);
                if (to) o.frequency.exponentialRampToValueAtTime(to, t + d);
                g.gain.setValueAtTime(0.0001, t);
                g.gain.exponentialRampToValueAtTime(vol, t + .01);
                g.gain.exponentialRampToValueAtTime(0.0001, t + d);
                o.connect(g); g.connect(c.destination); o.start(t); o.stop(t + d + .02);
            }
            const sfx = {
                pop() { tone(520, .12, 'triangle', .1); tone(820, .14, 'triangle', .08, .06); },
                whoosh() { tone(180, .35, 'sawtooth', .05, 0, 900); },
                go() { [523, 659, 784].forEach((f, i) => tone(f, .18, 'triangle', .12, i * .07)); },
                tick() { tone(1000, .05, 'square', .035); },
                alarm() { tone(1400, .08, 'square', .06); },
                reveal() { tone(392, .15, 'triangle', .12); tone(523, .15, 'triangle', .12, .12); tone(784, .4, 'triangle', .14, .24); },
                rise() { tone(300, .5, 'sine', .1, 0, 700); },
                fanfare() { [523, 659, 784, 1046, 784, 1046, 1318].forEach((f, i) => tone(f, .22, 'triangle', .14, i * .11)); },
            };
            document.addEventListener('click', ensureAudio, { once: true });
            $('btnSound').onclick = () => { soundOn = !soundOn; $('btnSound').textContent = soundOn ? '🔊' : '🔇'; if (soundOn) { ensureAudio(); sfx.pop(); } };
            $('btnFs').onclick = () => { document.fullscreenElement ? document.exitFullscreen() : document.documentElement.requestFullscreen().catch(() => { }); };

            /* ---------------- confetti ---------------- */
            const cv = $('fx'), cx = cv.getContext('2d');
            let parts = [], fxRun = false;
            const resize = () => { cv.width = innerWidth; cv.height = innerHeight; };
            addEventListener('resize', resize); resize();
            function confetti(n = 160, x = innerWidth / 2, y = innerHeight * .35, spread = 1) {
                const cols = ['#ff4d6d', '#3b82f6', '#fbbf24', '#22c55e', '#b866f7', '#fff'];
                for (let i = 0; i < n; i++) {
                    const a = Math.random() * Math.PI * 2, v = (4 + Math.random() * 11) * spread;
                    parts.push({ x, y, vx: Math.cos(a) * v, vy: Math.sin(a) * v - 7, w: 6 + Math.random() * 8, h: 4 + Math.random() * 6, r: Math.random() * 6, vr: (Math.random() - .5) * .4, c: cols[i % cols.length], life: 160 + Math.random() * 80 });
                }
                if (!fxRun) { fxRun = true; requestAnimationFrame(fxLoop); }
            }
            function fxLoop() {
                cx.clearRect(0, 0, cv.width, cv.height);
                parts = parts.filter(p => p.life-- > 0 && p.y < cv.height + 30);
                parts.forEach(p => { p.vy += .28; p.vx *= .99; p.x += p.vx; p.y += p.vy; p.r += p.vr; cx.save(); cx.translate(p.x, p.y); cx.rotate(p.r); cx.fillStyle = p.c; cx.globalAlpha = Math.min(1, p.life / 40); cx.fillRect(-p.w / 2, -p.h / 2, p.w, p.h); cx.restore(); });
                if (parts.length) requestAnimationFrame(fxLoop); else fxRun = false;
            }

            /* ---------------- helpers ---------------- */
            function toast(msg) { const t = $('toast'); t.textContent = msg; t.classList.add('on'); clearTimeout(toast.h); toast.h = setTimeout(() => t.classList.remove('on'), 2600); }
            function hue(name) { let h = 0; for (const c of String(name)) h = (h * 31 + c.charCodeAt(0)) >>> 0; return COLORS[h % COLORS.length]; }
            function countUp(el, from, to, ms = 900, fmt = (v) => v) {
                const t0 = performance.now();
                (function step(t) { const k = Math.min(1, (t - t0) / ms), e = 1 - Math.pow(1 - k, 3); el.textContent = fmt(Math.round(from + (to - from) * e)); if (k < 1) requestAnimationFrame(step); })(t0);
            }
            function show(id) { document.querySelectorAll('.view').forEach(v => v.classList.remove('active')); $(id).classList.add('active'); }
            const fmtSec = (ms) => (ms / 1000).toFixed(1) + 's';

            /* ---------------- API ---------------- */
            async function api(path, method = 'POST') {
                const res = await fetch(URLS.base + '/' + path, { method, credentials: 'same-origin', headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, body: method === 'POST' ? '{}' : undefined });
                let data = {}; try { data = await res.json(); } catch (e) { }
                return { ok: res.ok && data.success !== false, status: res.status, data };
            }
            async function act(path) {
                if (busy) return; busy = true; setBar();
                try {
                    const r = await api(path);
                    lastActionAt = Date.now();
                    if (r.ok && r.data.state) apply(r.data.state);
                    else if (r.data && r.data.last) await endQuiz(true);
                    else if (r.data && r.data.message) toast(r.data.message);
                } catch (e) { toast('Network problem — retrying'); }
                busy = false; setBar();
            }

            /* ---------------- lobby ---------------- */
            (function buildPin() {
                const el = $('pin');
                String(PIN).split('').forEach((d, i) => { const b = document.createElement('b'); b.textContent = d; b.style.animationDelay = (.25 + i * .09) + 's'; el.appendChild(b); });
            })();

            function addPlayer(p, fresh = true) {
                if (!p || players.has(p.id)) return;
                maxPid = Math.max(maxPid, p.id);
                const el = document.createElement('div'); el.className = 'chip' + (fresh ? ' fresh' : '');
                el.style.animationDelay = '0s, ' + (Math.random() * 1.5 + .7) + 's';
                const av = document.createElement('div'); av.className = 'av'; av.style.background = hue(p.name); av.textContent = (p.name || '?').trim().charAt(0).toUpperCase();
                const nm = document.createElement('span'); nm.className = 'nm'; nm.textContent = p.name;
                el.append(av, nm); $('players').prepend(el); players.set(p.id, el);
                if (fresh) { sfx.pop(); setTimeout(() => el.classList.remove('fresh'), 1400); }
                $('waiting').style.display = 'none';
            }
            function setCount(n) {
                const el = $('lobbyCount');
                if (String(n) !== el.textContent) { el.textContent = n; el.classList.remove('bump'); void el.offsetWidth; el.classList.add('bump'); }
                $('waiting').style.display = (n === 0 && players.size === 0) ? '' : 'none';
            }

            /* ---------------- phases ---------------- */
            function apply(state) {
                syncClock(state.server_now_ms);
                S = state;
                (state.participants || []).forEach(p => addPlayer(p, shownPhase === 'lobby' && players.size > 0));
                setCount(state.participant_count);
                const phase = state.session.phase, qid = state.question ? state.question.id : null;
                if (state.session.status === 'completed' && phase !== 'podium') { $('goneOv').classList.add('on'); }
                if (phase !== shownPhase || qid !== shownQ) enterPhase(phase, state);
                else liveUpdate(state);
                setBar();
            }

            function enterPhase(phase, st) {
                const prevPhase = shownPhase;
                shownPhase = phase; shownQ = st.question ? st.question.id : null;
                clearTimeout(revealTimer); revealQ = null;
                if (phase === 'lobby') { show('v-lobby'); }
                else if (phase === 'question') { buildQuestion(st); show('v-question'); sfx.whoosh(); }
                else if (phase === 'reveal') { buildReveal(st); show('v-reveal'); sfx.reveal(); }
                else if (phase === 'scoreboard') { buildBoard(st); show('v-scoreboard'); }
                else if (phase === 'podium') { buildPodium(st); show('v-podium'); }
                $('pauseOv').classList.toggle('on', st.session.status === 'paused');
            }

            function liveUpdate(st) {
                const phase = st.session.phase;
                if (phase === 'question') {
                    $('ansNum').textContent = st.answered_count;
                    $('pauseOv').classList.toggle('on', st.session.status === 'paused');
                }
            }

            function buildQuestion(st) {
                const q = st.question, total = st.session.total_questions;
                $('qCounter').textContent = `Question ${q.order} of ${total}`;
                const h = $('qText'); h.textContent = q.text; h.className = q.text.length > 150 ? 'xs' : q.text.length > 80 ? 'sm' : '';
                const card = h.parentElement; card.style.animation = 'none'; void card.offsetWidth; card.style.animation = '';
                $('ansNum').textContent = st.answered_count;
                $('ansOf').textContent = `of ${st.participant_count} answered`;
                const box = $('opts'); box.innerHTML = '';
                q.options.forEach((t, i) => {
                    const d = document.createElement('div'); d.className = 'opt o' + i; d.style.transitionDelay = (i * 90) + 'ms';
                    d.innerHTML = SHAPES[i]; const s = document.createElement('div'); s.className = 't'; s.textContent = t; d.appendChild(s); box.appendChild(d);
                });
                optsOpened = false; lastTickSec = null;
                $('timer').className = 'timer reading';
            }

            function openOptions(sound = true) {
                if (optsOpened) return; optsOpened = true;
                document.querySelectorAll('#opts .opt').forEach(o => o.classList.add('show'));
                if (sound) sfx.go();
            }

            function buildReveal(st) {
                const q = st.question, counts = st.option_counts || [0, 0, 0, 0];
                $('rCounter').textContent = `Question ${q.order} of ${st.session.total_questions}`;
                $('rText').textContent = q.text;
                const max = Math.max(1, ...counts), bars = $('bars'); bars.innerHTML = '';
                q.options.forEach((t, i) => {
                    const right = i === q.correct_option;
                    const col = document.createElement('div'); col.className = 'col ' + (right ? 'right' : 'wrong');
                    col.innerHTML = `<div class="cnt">0</div><div class="stick o${i}"></div><div class="lab o${i}">${SHAPES[i]}<span></span></div>`;
                    col.querySelector('.lab span').textContent = t; bars.appendChild(col);
                    const stick = col.querySelector('.stick'), cnt = col.querySelector('.cnt');
                    stick.style.setProperty('--p', (counts[i] === 0 ? 3 : Math.max(3, (counts[i] / max) * 100)) + '%');
                    requestAnimationFrame(() => requestAnimationFrame(() => col.classList.add('go')));
                    countUp(cnt, 0, counts[i], 1000);
                });
                const a = st.analytics || {}, stats = $('stats'); stats.innerHTML = '';
                const add = (html) => { const s = document.createElement('div'); s.className = 'stat'; s.innerHTML = html; stats.appendChild(s); return s; };
                add(`🎯 <em>${a.correct_rate ?? 0}%</em> got it right`);
                if (a.first_correct) { const s = add('⚡ Fastest: <em></em>'); s.querySelector('em').textContent = `${a.first_correct.name} (${fmtSec(a.first_correct.response_time_ms)})`; }
                add(`🙋 ${st.answered_count} of ${st.participant_count} answered`);
            }

            function buildBoard(st) {
                const rows = st.scoreboard || [], ROW = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--row')) || 78;
                const last = st.session.current_question_order >= st.session.total_questions;
                $('boardSub').textContent = last ? 'Final question done — standings' : `After question ${st.session.current_question_order} of ${st.session.total_questions}`;
                const board = $('board'); board.innerHTML = ''; board.style.height = (rows.length * ROW) + 'px';
                const prevOrder = [...rows].sort((a, b) => (a.prev_rank - b.prev_rank) || (a.rank - b.rank)).map(r => r.participant_id);
                const els = rows.map((r, i) => {
                    const el = document.createElement('div'); el.className = 'brow' + (i === 0 ? ' top1' : '');
                    const moved = r.prev_rank - r.rank;
                    el.innerHTML = '<div class="rk"></div><div class="nm"></div><div class="mv"></div><div class="gn"></div><div class="sc"></div>';
                    el.querySelector('.rk').textContent = r.rank; el.querySelector('.nm').textContent = r.name;
                    el.querySelector('.mv').textContent = moved > 0 ? '▲ ' + moved : '';
                    el.querySelector('.gn').textContent = r.gain > 0 ? '+' + r.gain : '';
                    el.querySelector('.sc').textContent = Math.max(0, r.score - r.gain);
                    const pi = prevOrder.indexOf(r.participant_id);
                    el.style.transition = 'none'; el.style.transform = `translateY(${pi * ROW}px)`;
                    board.appendChild(el); return el;
                });
                setTimeout(() => els.forEach((el, i) => {
                    const r = rows[i]; el.style.transition = ''; el.style.transform = `translateY(${i * ROW}px)`;
                    if (r.gain > 0) el.querySelector('.gn').classList.add('on');
                    countUp(el.querySelector('.sc'), Math.max(0, r.score - r.gain), r.score, 1000);
                }), 900);
                sfx.rise();
            }

            function buildPodium(st) {
                const list = st.podium || [];
                $('podSub').textContent = `${st.participant_count} players · ${st.session.total_questions} questions`;
                const pod = $('podium'); pod.innerHTML = '';
                const order = [1, 0, 2].filter(i => list[i]);           // 2nd, 1st, 3rd
                const heights = { 0: '72%', 1: '52%', 2: '36%' };
                const cols = order.map(i => {
                    const r = list[i], c = document.createElement('div'); c.className = 'pcol p' + (i + 1);
                    c.innerHTML = `<div class="who">${i === 0 ? '<div class="crown">👑</div>' : ''}<div class="n"></div><div class="s"></div></div><div class="blk">${i + 1}</div>`;
                    c.querySelector('.n').textContent = r.name; c.querySelector('.s').textContent = r.score + ' pts';
                    pod.appendChild(c); return { c, i };
                });
                [2, 1, 0].forEach((place, k) => {
                    const item = cols.find(x => x.i === place); if (!item) return;
                    setTimeout(() => {
                        item.c.querySelector('.blk').style.height = heights[place];
                        setTimeout(() => item.c.classList.add('in'), 900);
                        if (place === 0) { setTimeout(() => { sfx.fanfare(); confetti(220); setTimeout(() => confetti(140, innerWidth * .2, innerHeight * .5), 500); setTimeout(() => confetti(140, innerWidth * .8, innerHeight * .5), 800); }, 1000); }
                        else sfx.rise();
                    }, 600 + k * 1300);
                });
                const rest = $('rest'); rest.innerHTML = '';
                list.slice(3, 8).forEach((r, k) => { const d = document.createElement('div'); d.style.animationDelay = (4.6 + k * .15) + 's'; d.innerHTML = '<b></b><span></span><em style="font-style:normal;color:var(--gold)"></em>'; d.querySelector('b').textContent = r.rank; d.querySelector('span').textContent = r.name; d.querySelector('em').textContent = r.score; rest.appendChild(d); });
                if (list.length === 0) pod.innerHTML = '<div class="h-sub">No players joined this session.</div>';
            }

            /* ---------------- host bar ---------------- */
            function setBar() {
                if (!S) return;
                const ph = S.session.phase, last = S.session.current_question_order >= S.session.total_questions;
                const main = $('btnMain'), pause = $('btnPause'), status = $('status');
                main.style.display = ph === 'podium' ? 'none' : ''; $('btnResults').style.display = ph === 'podium' ? '' : 'none';
                $('btnEnd').style.display = ph === 'podium' ? 'none' : '';
                const labels = { lobby: '▶ Start quiz', question: '⏭ Skip', reveal: '🏅 Leaderboard', scoreboard: last ? '🏆 Show podium' : 'Next question ➜' };
                main.textContent = labels[ph] || '';
                main.disabled = busy || (ph === 'lobby' && S.participant_count < 1) || S.session.status === 'paused';
                pause.style.display = ph === 'question' ? '' : 'none';
                pause.textContent = S.session.status === 'paused' ? '▶ Resume' : '⏸ Pause';
                status.textContent = ph === 'lobby' ? (S.participant_count < 1 ? 'Waiting for the first player…' : `${S.participant_count} ready · press Space to start`) : ph === 'podium' ? 'Quiz complete' : `Question ${S.session.current_question_order} / ${S.session.total_questions}`;
            }

            async function primary() {
                if (!S || busy) return;
                const ph = S.session.phase, last = S.session.current_question_order >= S.session.total_questions;
                ensureAudio();
                if (ph === 'lobby') return act('show-question');
                if (ph === 'question') return requestReveal(true);
                if (ph === 'reveal') return act('scoreboard');
                if (ph === 'scoreboard') return last ? endQuiz(true) : act('show-question');
            }
            async function endQuiz(skipConfirm) {
                if (!skipConfirm && !confirm('End this quiz for everyone now?')) return;
                await act('end');
            }
            function requestReveal(now) {
                if (!S || S.session.phase !== 'question' || revealQ === S.question.id) return;
                revealQ = S.question.id;
                act('reveal');
            }
            $('btnMain').onclick = primary;
            $('btnEnd').onclick = () => endQuiz(false);
            $('btnPause').onclick = () => act(S && S.session.status === 'paused' ? 'resume' : 'pause');
            addEventListener('keydown', (e) => {
                if (e.code === 'Space' || e.code === 'Enter') { e.preventDefault(); primary(); }
                else if (e.key === 'f' || e.key === 'F') $('btnFs').click();
                else if (e.key === 'm' || e.key === 'M') $('btnSound').click();
            });

            /* ---------------- timer loop ---------------- */
            (function loop() {
                requestAnimationFrame(loop);
                if (!S || S.session.phase !== 'question' || !S.question) return;
                const q = S.question, limit = q.time_limit * 1000, paused = S.session.status === 'paused';
                let readRem, ansRem;
                if (paused) {
                    const pr = q.paused_remaining_ms || 0;
                    readRem = Math.max(0, pr - limit); ansRem = Math.min(limit, pr);
                } else {
                    const now = serverNow();
                    readRem = Math.max(0, q.opens_at_ms - now);
                    ansRem = readRem > 0 ? limit : Math.max(0, q.ends_at_ms - now);
                }
                const timer = $('timer'), ring = $('ring');
                if (readRem > 0) {
                    timer.className = 'timer reading';
                    $('tNum').textContent = Math.ceil(readRem / 1000); $('tLabel').textContent = 'Get ready';
                    ring.style.strokeDashoffset = 0;
                    return;
                }
                openOptions(!paused);
                const sec = Math.ceil(ansRem / 1000);
                $('tNum').textContent = sec; $('tLabel').textContent = ansRem > 0 ? 'seconds' : "Time's up!";
                ring.style.strokeDashoffset = RING * (1 - ansRem / limit);
                timer.className = 'timer' + (sec <= 3 && ansRem > 0 ? ' danger' : sec <= 5 ? ' warn' : '');
                if (!paused && ansRem > 0 && sec <= 5 && sec !== lastTickSec) { lastTickSec = sec; sec <= 3 ? sfx.alarm() : sfx.tick(); }
                if (!paused && ansRem <= 0 && revealQ !== q.id) { clearTimeout(revealTimer); revealQ = q.id; revealTimer = setTimeout(() => act('reveal'), READ_GRACE_MS); }
                if (!paused && ansRem > 0 && S.participant_count > 0 && S.answered_count >= S.participant_count && revealQ !== q.id) { clearTimeout(revealTimer); revealQ = q.id; revealTimer = setTimeout(() => act('reveal'), 900); }
            })();

            /* ---------------- sync: realtime + polling ---------------- */
            try {
                const pusher = new Pusher(@json(config('broadcasting.connections.pusher.key') ?: env('PUSHER_APP_KEY', 'local')), { cluster: @json(config('broadcasting.connections.pusher.options.cluster') ?: env('PUSHER_APP_CLUSTER', 'ap2')), forceTLS: true });
                const ch = pusher.subscribe('admin.quiz.' + SESSION_ID);
                ch.bind('quiz.participant.joined', (d) => { addPlayer({ id: d.participant_id, name: d.participant_name }); if (S) { S.participant_count = d.total_participants; setCount(d.total_participants); setBar(); } });
                ch.bind('quiz.answer.received', (d) => { if (S && S.question && d.question_id === S.question.id && S.session.phase === 'question') { S.answered_count = d.total_responded; $('ansNum').textContent = d.total_responded; } });
            } catch (e) { /* polling covers it */ }

            async function poll() {
                const started = Date.now();
                try {
                    const res = await fetch(URLS.state + '?since=' + maxPid, { credentials: 'same-origin', headers: { 'Accept': 'application/json' } });
                    if (res.status === 404) { $('goneOv').classList.add('on'); return; }
                    const st = await res.json();
                    if (started >= lastActionAt && !busy) {
                        const changed = !S || st.session.phase !== S.session.phase || st.session.status !== S.session.status || (st.question && S.question && st.question.id !== S.question.id) || (st.question && S.question && st.question.ends_at_ms !== S.question.ends_at_ms);
                        if (changed) apply(st);
                        else { syncClock(st.server_now_ms); S.participant_count = st.participant_count; S.answered_count = st.answered_count; (st.participants || []).forEach(p => addPlayer(p)); setCount(st.participant_count); liveUpdate(S); $('ansOf').textContent = `of ${st.participant_count} answered`; setBar(); }
                    }
                } catch (e) { }
            }
            (function schedule() { setTimeout(async () => { await poll(); schedule(); }, S && S.session.phase === 'question' ? 1000 : POLL_MS); })();

            // initial load: restore whatever state the quiz is in (refresh-safe)
            poll().then(() => { if (!S) toast('Could not load quiz state'); });
        })();
    </script>
</body>

</html>
