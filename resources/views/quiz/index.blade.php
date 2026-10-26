<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0b0511">
    <title>ArihantPLUS Quizzes</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #05020a;
            --surface: #0b0511;
            --card: #170b22;
            --ink: #fff;
            --muted: #a99bbd;
            --purple-1: #b866f7;
            --purple-2: #7a1fc9;
            --pink: #d43fe0;
            --green: #34d399;
            --red: #ff6b87;
            --gold: #ffd54a;
            --c0: #ff4d6d;
            --c1: #3b82f6;
            --c2: #fbbf24;
            --c3: #22c55e;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent
        }

        html,
        body {
            min-height: 100%
        }

        body {
            font-family: 'Sora', system-ui, sans-serif;
            background: var(--bg);
            color: var(--ink)
        }

        /* =============== LISTING PAGE (unchanged) =============== */
        .listing-page {
            min-height: 100vh;
            padding: 60px 24px 80px
        }

        .listing-header {
            text-align: center;
            margin-bottom: 48px
        }

        .listing-header h1 {
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 8px
        }

        .listing-header p {
            color: var(--muted);
            font-size: 16px
        }

        .quizzes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
            max-width: 960px;
            margin: 0 auto
        }

        .quiz-card {
            background: linear-gradient(165deg, var(--card) 0%, var(--surface) 100%);
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 24px;
            padding: 36px 28px;
            text-align: center;
            transition: all .3s ease;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px
        }

        .quiz-card:hover {
            border-color: rgba(184, 102, 247, .4);
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(172, 89, 235, .15)
        }

        .quiz-card .icon {
            font-size: 48px;
            margin-bottom: 4px
        }

        .quiz-card h2 {
            font-size: 22px;
            font-weight: 700
        }

        .quiz-card p {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.5;
            flex: 1
        }

        .quiz-card .btn {
            margin-top: 8px;
            width: 100%
        }

        .badge {
            display: inline-block;
            background: rgba(184, 102, 247, .15);
            color: var(--purple-1);
            border-radius: 999px;
            padding: 4px 14px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px
        }

        .badge-inactive {
            background: rgba(156, 163, 175, .1);
            color: var(--muted)
        }

        /* =============== GAME SHELL =============== */
        .bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
            background: radial-gradient(700px 500px at 10% -5%, #3a0f63 0%, transparent 60%), radial-gradient(600px 500px at 100% 105%, #5a0f6e 0%, transparent 55%), var(--bg)
        }

        .bg i {
            position: absolute;
            display: block;
            border-radius: 50%;
            background: var(--purple-1);
            opacity: .07;
            animation: drift linear infinite
        }

        @keyframes drift {
            from {
                transform: translateY(110vh)
            }

            to {
                transform: translateY(-20vh)
            }
        }

        #fx {
            position: fixed;
            inset: 0;
            z-index: 60;
            pointer-events: none
        }

        .topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 20;
            display: none;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: calc(10px + env(safe-area-inset-top)) 16px 10px;
            background: linear-gradient(180deg, rgba(5, 2, 10, .85), transparent)
        }

        .topbar.on {
            display: flex
        }

        .who {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 14px;
            min-width: 0
        }

        .who .av {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-weight: 800;
            font-size: 14px;
            color: #12081c;
            flex-shrink: 0
        }

        .who .nm {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap
        }

        .score-pill {
            padding: 7px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .1);
            border: 1px solid rgba(255, 255, 255, .16);
            font-weight: 800;
            font-size: 14px;
            font-variant-numeric: tabular-nums;
            display: none
        }

        .score-pill.on {
            display: block
        }

        .scr {
            position: fixed;
            inset: 0;
            z-index: 10;
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            padding: calc(64px + env(safe-area-inset-top)) 20px calc(24px + env(safe-area-inset-bottom));
            text-align: center
        }

        /* centre short screens, but let tall ones scroll instead of clipping */
        .scr>*:first-child {
            margin-top: auto
        }

        .scr>*:last-child {
            margin-bottom: auto
        }

        .scr.active {
            display: flex
        }

        .scr.pad0 {
            padding-top: 0
        }

        .card {
            background: linear-gradient(165deg, rgba(255, 255, 255, .11), rgba(255, 255, 255, .03));
            border: 1px solid rgba(255, 255, 255, .14);
            border-radius: 28px;
            padding: 40px 28px;
            max-width: 460px;
            width: 100%;
            backdrop-filter: blur(10px);
            box-shadow: 0 30px 80px rgba(122, 31, 201, .3);
            animation: rise .6s cubic-bezier(.2, 1.1, .3, 1) both
        }

        .card h1 {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 8px
        }

        .card p {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 22px;
            line-height: 1.5
        }

        .quiz-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--purple-1);
            margin-bottom: 10px;
            letter-spacing: 1px;
            text-transform: uppercase
        }

        @keyframes rise {
            from {
                transform: translateY(30px) scale(.97);
                opacity: 0
            }

            to {
                transform: none;
                opacity: 1
            }
        }

        .input {
            width: 100%;
            background: rgba(255, 255, 255, .07);
            border: 1.5px solid rgba(255, 255, 255, .14);
            border-radius: 16px;
            padding: 16px 18px;
            color: var(--ink);
            font-size: 17px;
            text-align: center;
            outline: none;
            margin-bottom: 12px;
            font-family: inherit;
            transition: .2s
        }

        .input:focus {
            border-color: var(--purple-1);
            box-shadow: 0 0 0 4px rgba(184, 102, 247, .2)
        }

        .input.pin {
            font-size: 34px;
            font-weight: 800;
            letter-spacing: 12px;
            padding-left: 30px
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 16px 28px;
            border-radius: 999px;
            font-weight: 800;
            font-size: 16px;
            border: none;
            cursor: pointer;
            font-family: inherit;
            text-decoration: none;
            color: #fff;
            transition: transform .15s
        }

        .btn:active {
            transform: scale(.96)
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--pink), var(--purple-2));
            width: 100%;
            box-shadow: 0 8px 0 #4b0f80, 0 18px 30px rgba(122, 31, 201, .45)
        }

        .btn-primary:active {
            transform: translateY(5px);
            box-shadow: 0 3px 0 #4b0f80
        }

        .btn-ghost {
            background: rgba(255, 255, 255, .07);
            border: 1px solid rgba(255, 255, 255, .14);
            color: var(--muted)
        }

        .btn:disabled {
            opacity: .5;
            cursor: not-allowed
        }

        .error-msg {
            background: rgba(255, 77, 109, .12);
            border: 1px solid rgba(255, 77, 109, .35);
            border-radius: 12px;
            padding: 12px 16px;
            margin-bottom: 12px;
            color: #ff8ea3;
            font-size: 14px;
            display: none;
            animation: shake .4s
        }

        @keyframes shake {

            0%,
            100% {
                transform: none
            }

            25% {
                transform: translateX(-6px)
            }

            75% {
                transform: translateX(6px)
            }
        }

        /* ---- lobby ---- */
        .big-av {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: 44px;
            font-weight: 800;
            color: #12081c;
            margin: 0 auto 16px;
            animation: pop .8s cubic-bezier(.2, 1.7, .4, 1) both, bob 3s 1s ease-in-out infinite
        }

        @keyframes pop {
            from {
                transform: scale(0) rotate(-20deg)
            }

            to {
                transform: none
            }
        }

        @keyframes bob {

            50% {
                translate: 0 -8px
            }
        }

        .lobby-dots {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin-top: 22px
        }

        .lobby-dots span {
            width: 11px;
            height: 11px;
            border-radius: 50%;
            background: var(--purple-1);
            animation: bounce 1.4s ease-in-out infinite
        }

        .lobby-dots span:nth-child(2) {
            animation-delay: .2s
        }

        .lobby-dots span:nth-child(3) {
            animation-delay: .4s
        }

        @keyframes bounce {

            0%,
            80%,
            100% {
                transform: translateY(0)
            }

            40% {
                transform: translateY(-12px)
            }
        }

        .hint {
            margin-top: 18px;
            color: var(--muted);
            font-size: 13px
        }

        /* ---- ready ---- */
        .count-big {
            font-size: 110px;
            font-weight: 800;
            line-height: 1;
            background: linear-gradient(135deg, #fff, var(--purple-1));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: beat 1s infinite
        }

        @keyframes beat {
            0% {
                transform: scale(1)
            }

            15% {
                transform: scale(1.15)
            }

            30% {
                transform: scale(1)
            }
        }

        .q-read {
            font-size: 22px;
            font-weight: 700;
            line-height: 1.4;
            max-width: 480px;
            margin: 18px 0 0;
            animation: rise .6s both
        }

        .q-no {
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--purple-1)
        }

        /* ---- answering ---- */
        #s-answer>*:first-child {
            margin-top: 0
        }

        #s-answer {
            justify-content: flex-start;
            padding-top: calc(60px + env(safe-area-inset-top))
        }

        .tbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 8px;
            z-index: 30;
            background: rgba(255, 255, 255, .1);
            display: none
        }

        .tbar i {
            display: block;
            height: 100%;
            width: 100%;
            transform-origin: left;
            background: linear-gradient(90deg, var(--purple-1), var(--pink));
            transition: background .3s
        }

        .tbar.warn i {
            background: var(--gold)
        }

        .tbar.danger i {
            background: var(--c0)
        }

        .tbar.on {
            display: block
        }

        .a-head {
            width: 100%;
            max-width: 560px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 10px
        }

        .a-q {
            min-width: 0;
            overflow-wrap: anywhere;
            font-size: 15px;
            font-weight: 700;
            line-height: 1.35;
            text-align: left;
            flex: 1
        }

        .a-sec {
            font-size: 30px;
            font-weight: 800;
            min-width: 54px;
            text-align: right;
            font-variant-numeric: tabular-nums
        }

        .opts {
            width: 100%;
            max-width: 560px;
            flex: 1 0 auto;
            display: grid;
            grid-template-rows: repeat(4, minmax(68px, 1fr));
            gap: 12px
        }

        .opt {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 0 20px;
            border-radius: 20px;
            border: 0;
            color: #fff;
            font-family: inherit;
            font-weight: 700;
            font-size: 17px;
            text-align: left;
            cursor: pointer;
            box-shadow: 0 6px 0 rgba(0, 0, 0, .3);
            transition: transform .12s, opacity .3s, filter .3s, box-shadow .12s;
            animation: optIn .5s cubic-bezier(.2, 1.4, .4, 1) both
        }

        .opt:active {
            transform: translateY(5px);
            box-shadow: 0 1px 0 rgba(0, 0, 0, .3)
        }

        .opt svg {
            width: 34px;
            height: 34px;
            fill: #fff;
            flex-shrink: 0
        }

        .opt .t {
            line-height: 1.25;
            min-width: 0;
            overflow-wrap: anywhere
        }

        .opt.o0 {
            background: linear-gradient(160deg, #ff6b87, var(--c0))
        }

        .opt.o1 {
            background: linear-gradient(160deg, #5b9bff, var(--c1))
        }

        .opt.o2 {
            background: linear-gradient(160deg, #ffd04a, #e99a0b);
            color: #2a1c00
        }

        .opt.o2 svg {
            fill: #2a1c00
        }

        .opt.o3 {
            background: linear-gradient(160deg, #3ddb7e, var(--c3))
        }

        .opt.picked {
            transform: scale(1.03);
            box-shadow: 0 0 0 4px #fff, 0 0 40px rgba(255, 255, 255, .5)
        }

        .opt.dim {
            opacity: .25;
            filter: saturate(.3);
            pointer-events: none
        }

        .opt:disabled {
            pointer-events: none
        }

        @keyframes optIn {
            from {
                transform: translateY(40px) scale(.9);
                opacity: 0
            }

            to {
                transform: none;
                opacity: 1
            }
        }

        /* ---- locked ---- */
        .locked-shape {
            width: 130px;
            height: 130px;
            border-radius: 34px;
            display: grid;
            place-items: center;
            margin-bottom: 22px;
            animation: pop .6s cubic-bezier(.2, 1.7, .4, 1) both;
            position: relative
        }

        .locked-shape::after {
            content: '';
            position: absolute;
            inset: -10px;
            border-radius: 40px;
            border: 3px solid currentColor;
            opacity: .5;
            animation: ping 1.6s infinite
        }

        .locked-shape svg {
            width: 64px;
            height: 64px;
            fill: #fff
        }

        @keyframes ping {
            from {
                transform: scale(.92);
                opacity: .6
            }

            to {
                transform: scale(1.25);
                opacity: 0
            }
        }

        .h2 {
            font-size: 26px;
            font-weight: 800
        }

        .sub {
            color: var(--muted);
            margin-top: 8px;
            font-size: 14px
        }

        /* ---- result ---- */
        #s-result.good {
            background: radial-gradient(600px 600px at 50% 30%, rgba(52, 211, 153, .35), transparent 70%)
        }

        #s-result.bad {
            background: radial-gradient(600px 600px at 50% 30%, rgba(255, 77, 109, .35), transparent 70%)
        }

        #s-result.none {
            background: radial-gradient(600px 600px at 50% 30%, rgba(169, 155, 189, .25), transparent 70%)
        }

        .r-ic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: 64px;
            font-weight: 800;
            margin-bottom: 16px;
            animation: pop .7s cubic-bezier(.2, 1.9, .4, 1) both
        }

        .good .r-ic {
            background: var(--green);
            color: #04331f;
            box-shadow: 0 0 60px rgba(52, 211, 153, .6)
        }

        .bad .r-ic {
            background: var(--red);
            color: #4a0414;
            box-shadow: 0 0 60px rgba(255, 77, 109, .5)
        }

        .none .r-ic {
            background: #6b5f7e;
            color: #fff
        }

        .r-pts {
            font-size: 54px;
            font-weight: 800;
            margin: 6px 0;
            color: var(--gold);
            font-variant-numeric: tabular-nums
        }

        .streak {
            display: inline-block;
            margin-top: 8px;
            padding: 8px 18px;
            border-radius: 999px;
            font-weight: 800;
            background: linear-gradient(135deg, #ff9d2e, #ff4d6d);
            animation: pop .6s .5s cubic-bezier(.2, 1.9, .4, 1) both
        }

        .rank-pill {
            margin-top: 26px;
            padding: 14px 24px;
            border-radius: 20px;
            background: rgba(255, 255, 255, .09);
            border: 1px solid rgba(255, 255, 255, .15);
            font-weight: 700;
            animation: rise .6s .4s both
        }

        .rank-pill b {
            color: var(--purple-1);
            font-size: 1.3em
        }

        .corr {
            margin-top: 14px;
            font-size: 14px;
            color: var(--muted)
        }

        .corr b {
            color: #fff
        }

        /* ---- board ---- */
        .rank-huge {
            font-size: 120px;
            font-weight: 800;
            line-height: 1;
            background: linear-gradient(135deg, #fff, var(--purple-1));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            animation: pop .8s cubic-bezier(.2, 1.7, .4, 1) both
        }

        .rank-lab {
            font-weight: 700;
            color: var(--muted);
            margin-top: 4px
        }

        .gap {
            margin-top: 22px;
            padding: 12px 22px;
            border-radius: 18px;
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .14);
            font-weight: 600;
            animation: rise .6s .3s both
        }

        .gap b {
            color: var(--gold)
        }

        /* ---- final ---- */
        .fin-rank {
            font-size: 96px;
            font-weight: 800;
            line-height: 1;
            animation: pop .9s cubic-bezier(.2, 1.7, .4, 1) both
        }

        .fin-rank.gold {
            color: var(--gold);
            text-shadow: 0 0 50px rgba(255, 213, 74, .6)
        }

        .fin-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin: 22px 0;
            width: 100%;
            max-width: 420px
        }

        .fin-grid div {
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .13);
            border-radius: 16px;
            padding: 14px 6px;
            animation: rise .6s both
        }

        .fin-grid b {
            display: block;
            font-size: 22px
        }

        .fin-grid span {
            font-size: 11px;
            color: var(--muted);
            font-weight: 600
        }

        .top3 {
            width: 100%;
            max-width: 420px;
            display: grid;
            gap: 8px;
            margin-bottom: 20px
        }

        .top3 div {
            display: flex;
            gap: 12px;
            align-items: center;
            padding: 10px 16px;
            border-radius: 14px;
            background: rgba(255, 255, 255, .07);
            font-weight: 700;
            text-align: left;
            animation: rise .5s both
        }

        .top3 span {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap
        }

        .top3 em {
            font-style: normal;
            color: var(--gold)
        }

        .pause-ov {
            position: fixed;
            inset: 0;
            z-index: 40;
            background: rgba(5, 2, 10, .85);
            backdrop-filter: blur(6px);
            display: none;
            place-items: center;
            text-align: center
        }

        .pause-ov.on {
            display: grid
        }

        @media (max-height:640px) {
            .count-big {
                font-size: 76px
            }

            .rank-huge {
                font-size: 84px
            }

            .fin-rank {
                font-size: 68px
            }

            .r-ic,
            .locked-shape {
                width: 88px;
                height: 88px;
                font-size: 46px
            }

            .big-av {
                width: 72px;
                height: 72px;
                font-size: 32px
            }

            .card {
                padding: 28px 20px
            }
        }

        .toast {
            position: fixed;
            bottom: calc(20px + env(safe-area-inset-bottom));
            left: 50%;
            translate: -50% 20px;
            opacity: 0;
            z-index: 70;
            background: #2a0f3f;
            border: 1px solid rgba(255, 255, 255, .2);
            padding: 10px 20px;
            border-radius: 14px;
            font-weight: 600;
            font-size: 14px;
            transition: .3s
        }

        .toast.on {
            opacity: 1;
            translate: -50% 0
        }
    </style>
</head>

<body>
    @php
        $mode = $mode ?? 'join';
        $quizTypeKey = $quizType ?? '';
        $currentSession = $session ?? null;
        $quizName = $quizName ?? (\App\Models\QuizType::where('key', $quizTypeKey)->value('name') ?? 'Quiz');
    @endphp

    @if($mode === 'listing')
        <!-- ===================== LISTING PAGE ===================== -->
        <div class="listing-page">
            <div class="listing-header">
                <h1>Quizzes</h1>
                <p>Choose a quiz and join the fun. Enter the PIN shared by your host to participate.</p>
            </div>
            <div class="quizzes-grid">
                @forelse($allTypes ?? [] as $type)
                    <div class="quiz-card"
                        onclick="@if($type->is_active) window.location.href='/quiz?type={{ $type->key }}' @endif">
                        <div class="icon">🧠</div>
                        <span class="badge {{ $type->is_active ? '' : 'badge-inactive' }}">
                            {{ $type->is_active ? 'Available' : 'Coming Soon' }}
                        </span>
                        <h2>{{ $type->name }}</h2>
                        <p>{{ $type->description ?? 'Test your knowledge and compete with others!' }}</p>
                        @if($type->is_active)
                            <a href="/quiz?type={{ $type->key }}" class="btn btn-primary">Join Quiz</a>
                        @else
                            <button class="btn btn-primary" disabled>Coming Soon</button>
                        @endif
                    </div>
                @empty
                    <div class="card" style="grid-column:1/-1;max-width:400px;margin:0 auto">
                        <h1>No Quizzes Yet</h1>
                        <p>Quizzes will be available soon. Stay tuned!</p>
                    </div>
                @endforelse
            </div>
        </div>
    @else
        <div class="bg" id="bg"></div>
        <canvas id="fx"></canvas>
        <div class="tbar" id="tbar"><i id="tbarFill"></i></div>

        <div class="topbar" id="topbar">
            <div class="who">
                <div class="av" id="meAv"></div>
                <div class="nm" id="meName"></div>
            </div>
            <div class="score-pill" id="meScore">0</div>
        </div>

        <!-- 1. PIN -->
        <section class="scr {{ !$currentSession || !$participant ? 'active' : '' }}" id="s-pin">
            <div class="card">
                @if($currentSession)
                    <div class="quiz-title">{{ $quizName }}</div>
                    <h1>Enter Game PIN</h1>
                    <p>Type the 6-digit PIN shown on the big screen.</p>
                    <div class="error-msg" id="pinError"></div>
                    <input type="text" class="input pin" id="pinInput" placeholder="······" maxlength="6" inputmode="numeric"
                        pattern="[0-9]*" autocomplete="off">
                    <button class="btn btn-primary" id="pinBtn">Enter</button>
                @else
                    <div class="big-av"
                        style="background:linear-gradient(135deg,var(--purple-1),var(--pink));color:#fff;font-size:40px">⏳</div>
                    <div class="quiz-title">{{ $quizName }}</div>
                    <h1>Quiz not started yet</h1>
                    <p style="margin-bottom:10px">The host hasn't started this quiz. Please wait — the PIN screen will appear
                        here automatically as soon as the quiz begins.</p>
                    <div class="lobby-dots" style="margin:14px 0 22px"><span></span><span></span><span></span></div>
                    <a href="/quiz" class="btn btn-ghost">Back to All Quizzes</a>
                @endif
            </div>
        </section>

        <!-- 2. Details -->
        <section class="scr" id="s-details">
            <div class="card">
                <div class="quiz-title">{{ $quizName }}</div>
                <h1>Who's playing?</h1>
                <p>Your name will appear on the big screen.</p>
                <div class="error-msg" id="detailError"></div>
                <input type="text" class="input" id="nameInput" placeholder="Your name" maxlength="30" autocomplete="name">
                <input type="email" class="input" id="emailInput" placeholder="Email address" autocomplete="email">
                <input type="tel" class="input" id="mobileInput" placeholder="Mobile number" autocomplete="tel">
                <button class="btn btn-primary" id="joinBtn">Join game</button>
            </div>
        </section>

        <!-- 3. Lobby -->
        <section class="scr" id="s-lobby">
            <div class="card">
                <div class="big-av" id="lobbyAv"></div>
                <h1>You're in!</h1>
                <p>See your name on the big screen?<br>Waiting for the host to start…</p>
                <div class="lobby-dots"><span></span><span></span><span></span></div>
                <div class="hint" id="lobbyCount"></div>
            </div>
        </section>

        <!-- 4. Get ready (question is being read) -->
        <section class="scr" id="s-ready">
            <div class="q-no" id="readyNo"></div>
            <div class="count-big" id="readyNum">3</div>
            <div class="q-read" id="readyQ"></div>
            <div class="sub">Get ready…</div>
        </section>

        <!-- 5. Answer -->
        <section class="scr" id="s-answer">
            <div class="a-head">
                <div class="a-q" id="ansQ"></div>
                <div class="a-sec" id="ansSec"></div>
            </div>
            <div class="opts" id="opts"></div>
        </section>

        <!-- 6. Locked in -->
        <section class="scr" id="s-locked">
            <div class="locked-shape" id="lockedShape"></div>
            <div class="h2">Answer locked in!</div>
            <div class="sub" id="lockedSub">Waiting for the others…</div>
        </section>

        <!-- 7. Result -->
        <section class="scr" id="s-result">
            <div class="r-ic" id="rIc"></div>
            <div class="h2" id="rTitle"></div>
            <div class="r-pts" id="rPts"></div>
            <div id="rStreak"></div>
            <div class="rank-pill" id="rRank"></div>
            <div class="corr" id="rCorr"></div>
        </section>

        <!-- 8. Leaderboard position -->
        <section class="scr" id="s-board">
            <div class="q-no">Your position</div>
            <div class="rank-huge" id="bRank"></div>
            <div class="rank-lab" id="bScore"></div>
            <div class="gap" id="bGap"></div>
            <div class="hint">Check the big screen for the top 5 👀</div>
        </section>

        <!-- 9. Final -->
        <section class="scr" id="s-final">
            <div class="q-no">Final result</div>
            <div class="fin-rank" id="fRank"></div>
            <div class="h2" id="fMsg" style="margin-top:6px"></div>
            <div class="fin-grid" id="fGrid"></div>
            <div class="top3" id="fTop"></div>
            <a class="btn btn-primary" id="fBreak" href="#" style="max-width:420px">See my answers</a>
            <a class="btn btn-ghost" href="/quiz" style="margin-top:12px">All quizzes</a>
        </section>

        <!-- Ended / lost -->
        <section class="scr" id="s-gone">
            <div class="card">
                <div style="font-size:52px;margin-bottom:12px">🏁</div>
                <h1>This quiz has ended</h1>
                <p>Thanks for playing! Join another quiz any time.</p>
                <a href="/quiz" class="btn btn-primary">All quizzes</a>
            </div>
        </section>

        <div class="pause-ov" id="pauseOv">
            <div>
                <div style="font-size:64px">⏸</div>
                <div class="h2">Paused by host</div>
                <div class="sub">The timer will continue shortly</div>
            </div>
        </div>
        <div class="toast" id="toast"></div>

        <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
        <script>
            (function () {
                const CSRF = document.querySelector('meta[name=csrf-token]').content;
                const QUIZ_TYPE = @json($quizTypeKey);
                const POLL_MS = {{ (int) config('quiz.polling_interval_ms', 3000) }};
                const COLORS = ['#ffb3c0', '#bcd4ff', '#ffe29a', '#a7f3c6', '#e9c8ff', '#9ee7ff', '#ffc9a3', '#d6f5a0'];
                const SHAPES = [
                    '<svg viewBox="0 0 24 24"><path d="M12 3 L22 21 H2 Z"/></svg>',
                    '<svg viewBox="0 0 24 24"><path d="M12 2 L22 12 L12 22 L2 12 Z"/></svg>',
                    '<svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg>',
                    '<svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>',
                ];
                const SHAPE_BG = ['linear-gradient(160deg,#ff6b87,#ff4d6d)', 'linear-gradient(160deg,#5b9bff,#3b82f6)', 'linear-gradient(160deg,#ffd04a,#e99a0b)', 'linear-gradient(160deg,#3ddb7e,#22c55e)'];

                const $ = (id) => document.getElementById(id);
                let sessionId = @json($currentSession ? $currentSession->id : null);
                let me = @json($participant ? ['id' => $participant->id, 'name' => $participant->name] : null);
                let offset = 0, current = null /* last applied state */, screenKey = '', pusher = null, lastEventAt = 0, selected = null, submitting = false, sfxOn = true;

                const serverNow = () => Date.now() + offset;
                const toast = (m) => { const t = $('toast'); t.textContent = m; t.classList.add('on'); clearTimeout(toast.h); toast.h = setTimeout(() => t.classList.remove('on'), 2400); };
                const hue = (n) => { let h = 0; for (const c of String(n)) h = (h * 31 + c.charCodeAt(0)) >>> 0; return COLORS[h % COLORS.length]; };
                const buzz = (p) => { try { navigator.vibrate && navigator.vibrate(p); } catch (e) { } };
                function show(id) { document.querySelectorAll('.scr').forEach(s => s.classList.remove('active')); $(id).classList.add('active'); $('topbar').classList.toggle('on', !['s-pin', 's-details', 's-gone'].includes(id)); if (id !== 's-answer') { $('tbar').classList.remove('on'); } }
                function countUp(el, from, to, ms = 900, fmt = (v) => v) { const t0 = performance.now(); (function step(t) { const k = Math.min(1, (t - t0) / ms), e = 1 - Math.pow(1 - k, 3); el.textContent = fmt(Math.round(from + (to - from) * e)); if (k < 1) requestAnimationFrame(step); })(t0); }

                /* ---- tiny synthesised sounds (phones: only after first tap) ---- */
                let ac = null;
                function tone(f, d, vol = .1, when = 0, type = 'triangle') { try { ac = ac || new (window.AudioContext || window.webkitAudioContext)(); if (ac.state === 'suspended') ac.resume(); const t = ac.currentTime + when, o = ac.createOscillator(), g = ac.createGain(); o.type = type; o.frequency.value = f; g.gain.setValueAtTime(.0001, t); g.gain.exponentialRampToValueAtTime(vol, t + .01); g.gain.exponentialRampToValueAtTime(.0001, t + d); o.connect(g); g.connect(ac.destination); o.start(t); o.stop(t + d + .02); } catch (e) { } }
                const sfx = { lock() { tone(660, .1); tone(990, .12, .1, .07); }, good() { [523, 659, 784, 1046].forEach((f, i) => tone(f, .16, .12, i * .08)); }, bad() { tone(220, .3, .12, 0, 'sawtooth'); tone(165, .4, .1, .15, 'sawtooth'); }, fan() { [523, 659, 784, 1046, 784, 1046, 1318].forEach((f, i) => tone(f, .2, .12, i * .1)); } };

                /* ---- confetti ---- */
                const cv = $('fx'), cx = cv ? cv.getContext('2d') : null; let parts = [], run = false;
                function size() { if (cv) { cv.width = innerWidth; cv.height = innerHeight; } } addEventListener('resize', size); size();
                function confetti(n = 140) { const cols = ['#ff4d6d', '#3b82f6', '#fbbf24', '#22c55e', '#b866f7', '#fff']; for (let i = 0; i < n; i++) { const a = Math.random() * Math.PI * 2, v = 4 + Math.random() * 10; parts.push({ x: innerWidth / 2, y: innerHeight * .4, vx: Math.cos(a) * v, vy: Math.sin(a) * v - 6, w: 6 + Math.random() * 7, h: 4 + Math.random() * 5, r: Math.random() * 6, vr: (Math.random() - .5) * .4, c: cols[i % 6], life: 150 + Math.random() * 80 }); } if (!run) { run = true; requestAnimationFrame(fx); } }
                function fx() { cx.clearRect(0, 0, cv.width, cv.height); parts = parts.filter(p => p.life-- > 0 && p.y < cv.height + 30); parts.forEach(p => { p.vy += .26; p.vx *= .99; p.x += p.vx; p.y += p.vy; p.r += p.vr; cx.save(); cx.translate(p.x, p.y); cx.rotate(p.r); cx.fillStyle = p.c; cx.globalAlpha = Math.min(1, p.life / 40); cx.fillRect(-p.w / 2, -p.h / 2, p.w, p.h); cx.restore(); }); if (parts.length) requestAnimationFrame(fx); else run = false; }

                /* ---- bg ---- */
                (function () { const el = $('bg'); if (!el) return; for (let i = 0; i < 14; i++) { const s = document.createElement('i'), z = 20 + Math.random() * 60; s.style.cssText = `left:${Math.random() * 100}%;width:${z}px;height:${z}px;animation-duration:${25 + Math.random() * 30}s;animation-delay:-${Math.random() * 40}s`; el.appendChild(s); } })();

                /* ---- API ---- */
                async function post(url, body) {
                    const res = await fetch(url, { method: 'POST', credentials: 'same-origin', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }, body: JSON.stringify(body) });
                    let data = {}; try { data = await res.json(); } catch (e) { }
                    return { ok: res.ok, status: res.status, data };
                }
                const err = (id, msg) => { const e = $(id); e.textContent = msg; e.style.display = 'block'; e.style.animation = 'none'; void e.offsetWidth; e.style.animation = ''; };

                /* ---- join flow ---- */
                async function validatePin() {
                    const pin = $('pinInput').value.trim();
                    if (pin.length !== 6) return err('pinError', 'PIN must be 6 digits.');
                    $('pinError').style.display = 'none'; $('pinBtn').disabled = true;
                    try {
                        const r = await post('/api/quiz/validate-pin', { quiz_type: QUIZ_TYPE, pin });
                        if (r.data.valid) { sessionId = r.data.session_id; show('s-details'); $('nameInput').focus(); }
                        else err('pinError', r.data.message || (r.status === 429 ? 'Too many tries — wait a minute.' : 'Invalid PIN.'));
                    } catch (e) { err('pinError', 'Network error. Try again.'); }
                    $('pinBtn').disabled = false;
                }
                async function joinQuiz() {
                    const name = $('nameInput').value.trim(), email = $('emailInput').value.trim(), mobile = $('mobileInput').value.trim();
                    if (!name || !email || !mobile) return err('detailError', 'All fields are required.');
                    $('detailError').style.display = 'none'; $('joinBtn').disabled = true;
                    try {
                        const r = await post('/api/quiz/join', { session_id: sessionId, quiz_type: QUIZ_TYPE, name, email, mobile });
                        if (r.data.participant_id) { me = { id: r.data.participant_id, name: r.data.name || name }; enter(); }
                        else err('detailError', r.data.message || firstError(r.data) || 'Could not join.');
                    } catch (e) { err('detailError', 'Network error. Try again.'); }
                    $('joinBtn').disabled = false;
                }
                const firstError = (d) => d && d.errors ? Object.values(d.errors)[0][0] : null;

                function enter() {
                    setMe(); initRealtime(); refresh();
                }
                function setMe() {
                    const av = $('meAv'); av.textContent = me.name.trim().charAt(0).toUpperCase(); av.style.background = hue(me.name);
                    $('meName').textContent = me.name;
                    const l = $('lobbyAv'); l.textContent = av.textContent; l.style.background = hue(me.name);
                }

                /* ---- realtime ---- */
                function initRealtime() {
                    if (pusher) return;
                    try {
                        pusher = new Pusher(@json(config('broadcasting.connections.pusher.key') ?: env('PUSHER_APP_KEY', 'local')), { cluster: @json(config('broadcasting.connections.pusher.options.cluster') ?: env('PUSHER_APP_CLUSTER', 'ap2')), forceTLS: true });
                        const ch = pusher.subscribe('quiz.' + sessionId);
                        ch.bind('quiz.question.shown', (d) => { lastEventAt = Date.now(); if (d.server_now_ms) offset = d.server_now_ms - Date.now(); selected = null; applyState({ server_now_ms: d.server_now_ms, phase: 'question', status: 'active', question: d.question, me: { ...(current && current.me || me), answered: false, selected_option: null }, participant_count: current ? current.participant_count : 0 }); });
                        ['quiz.question.revealed', 'quiz.scoreboard.shown', 'quiz.ended'].forEach(ev => ch.bind(ev, () => { lastEventAt = Date.now(); setTimeout(refresh, Math.random() * 700); }));
                        ['quiz.question.paused', 'quiz.question.resumed'].forEach(ev => ch.bind(ev, () => { lastEventAt = Date.now(); refresh(); }));
                    } catch (e) { }
                    // safety net: fast polling if the socket is down, slow heartbeat if it is up
                    (function loop() { setTimeout(() => { const up = pusher && pusher.connection && pusher.connection.state === 'connected'; if (!up || Date.now() - lastEventAt > 15000) refresh(); loop(); }, up() ? 6000 : POLL_MS); function up() { return pusher && pusher.connection && pusher.connection.state === 'connected'; } })();
                }

                let refreshing = false;
                async function refresh() {
                    if (!sessionId || !me || refreshing) return; refreshing = true;
                    try {
                        const res = await fetch('/api/quiz/session/' + sessionId + '/state', { credentials: 'same-origin', headers: { 'Accept': 'application/json' } });
                        if (res.status === 404) { show('s-gone'); }
                        else { const st = await res.json(); if (st.server_now_ms) offset = st.server_now_ms - Date.now(); applyState(st); }
                    } catch (e) { }
                    refreshing = false;
                }

                /* ---- state -> screen ---- */
                function applyState(st) {
                    if (!st.me && me) st.me = { id: me.id, name: me.name };
                    if (!st.me || !st.me.id) { show('s-details'); return; }
                    const prev = current; current = st;
                    const q = st.question, phase = st.phase, m = st.me;
                    $('pauseOv').classList.toggle('on', st.status === 'paused' && phase === 'question');
                    if (typeof m.score === 'number') { const el = $('meScore'); el.classList.add('on'); if (el.dataset.v !== String(m.score)) { countUp(el, Number(el.dataset.v || 0), m.score, 800, v => v + ' pts'); el.dataset.v = m.score; } }

                    let key;
                    if (st.status === 'completed' && phase !== 'podium') key = 'gone';
                    else if (phase === 'lobby') key = 'lobby';
                    else if (phase === 'question') key = 'q' + q.id + (m.answered ? '-locked' : (serverNow() < q.opens_at_ms ? '-ready' : '-answer'));
                    else if (phase === 'reveal') key = 'r' + (q ? q.id : '');
                    else if (phase === 'scoreboard') key = 'b' + (q ? q.id : '');
                    else if (phase === 'podium') key = 'final';
                    else key = 'lobby';
                    if (key === screenKey) { if (phase === 'lobby') $('lobbyCount').textContent = st.participant_count + (st.participant_count === 1 ? ' player' : ' players') + ' in the lobby'; if (phase === 'question') tickTimer(); return; }
                    screenKey = key;

                    if (key === 'gone') return show('s-gone');
                    if (phase === 'lobby') { show('s-lobby'); setMe(); $('lobbyCount').textContent = st.participant_count + (st.participant_count === 1 ? ' player' : ' players') + ' in the lobby'; return; }
                    if (phase === 'question') {
                        selected = m.answered ? m.selected_option : selected;
                        if (m.answered) return showLocked(q, m.selected_option);
                        if (serverNow() < q.opens_at_ms) return showReady(q);
                        return showAnswer(q);
                    }
                    if (phase === 'reveal') return showResult(st);
                    if (phase === 'scoreboard') return showBoard(st);
                    if (phase === 'podium') return showFinal(st);
                }

                /* ---- screens ---- */
                function showReady(q) {
                    show('s-ready');
                    $('readyNo').textContent = `Question ${q.order} of ${q.total}`;
                    $('readyQ').textContent = q.text;
                }
                function showAnswer(q) {
                    show('s-answer');
                    $('ansQ').textContent = q.text;
                    const box = $('opts'); box.innerHTML = '';
                    q.options.forEach((t, i) => {
                        const b = document.createElement('button'); b.className = 'opt o' + i; b.style.animationDelay = (i * 70) + 'ms';
                        b.innerHTML = SHAPES[i]; const s = document.createElement('div'); s.className = 't'; s.textContent = t; b.appendChild(s);
                        b.onclick = () => submit(q, i, b); box.appendChild(b);
                    });
                    $('tbar').classList.add('on'); buzz(25);
                }
                function showLocked(q, idx) {
                    show('s-locked');
                    const sh = $('lockedShape'); sh.innerHTML = idx != null ? SHAPES[idx] : '✓'; sh.style.background = idx != null ? SHAPE_BG[idx] : 'var(--c3)'; sh.style.color = ['#ff4d6d', '#3b82f6', '#fbbf24', '#22c55e'][idx] || '#22c55e';
                }
                async function submit(q, idx, btn) {
                    if (submitting || selected !== null) return; submitting = true; selected = idx;
                    document.querySelectorAll('#opts .opt').forEach((b, i) => { b.disabled = true; b.classList.add(i === idx ? 'picked' : 'dim'); });
                    buzz(40); sfx.lock();
                    try {
                        const r = await post('/api/quiz/submit-answer', { session_id: sessionId, question_id: q.id, selected_option: idx });
                        if (r.data.success) { setTimeout(() => { if (current && current.question && current.question.id === q.id && current.phase === 'question') { screenKey = 'q' + q.id + '-locked'; showLocked(q, idx); } }, 450); }
                        else {
                            const msg = (r.data && r.data.message) || 'Could not send answer';
                            toast(msg);
                            if (/already/i.test(msg)) { screenKey = 'q' + q.id + '-locked'; showLocked(q, idx); }
                            else if (/closed|up|not running|no longer/i.test(msg)) { selected = idx; }
                            else { selected = null; document.querySelectorAll('#opts .opt').forEach(b => { b.disabled = false; b.classList.remove('picked', 'dim'); }); }
                        }
                    } catch (e) { toast('Connection problem — tap again'); selected = null; document.querySelectorAll('#opts .opt').forEach(b => { b.disabled = false; b.classList.remove('picked', 'dim'); }); }
                    submitting = false;
                }

                function showResult(st) {
                    const m = st.me, q = st.question, el = $('s-result');
                    const answered = m.answered, ok = !!m.is_correct;
                    el.className = 'scr ' + (answered ? (ok ? 'good' : 'bad') : 'none');
                    show('s-result'); el.classList.add(answered ? (ok ? 'good' : 'bad') : 'none');
                    $('rIc').textContent = !answered ? '⏰' : ok ? '✓' : '✕';
                    $('rTitle').textContent = !answered ? "Time's up!" : ok ? 'Correct!' : 'Incorrect';
                    const pts = $('rPts'); pts.textContent = '';
                    if (answered && ok) countUp(pts, 0, m.points_earned || 0, 900, v => '+' + v); else pts.textContent = '+0';
                    $('rStreak').innerHTML = (m.streak >= 2 && ok) ? `<span class="streak">🔥 ${m.streak} in a row</span>` : '';
                    $('rRank').innerHTML = m.rank ? `You're <b>#${m.rank}</b> of ${m.total_players}` : '';
                    const c = $('rCorr'); c.innerHTML = '';
                    if (!ok && q && typeof q.correct_option === 'number') { c.append('Correct answer: '); const b = document.createElement('b'); b.textContent = q.options[q.correct_option]; c.appendChild(b); }
                    if (ok) { sfx.good(); buzz([30, 40, 30]); } else { sfx.bad(); buzz(160); }
                }

                function showBoard(st) {
                    const m = st.me; show('s-board');
                    $('bRank').textContent = '#' + (m.rank || '–');
                    $('bScore').textContent = (m.score || 0) + ' points';
                    const g = $('bGap');
                    if (m.ahead) { g.innerHTML = ''; g.append(document.createTextNode('')); const b = document.createElement('b'); b.textContent = m.ahead.gap + ' pts'; g.append(b, ` behind `); const n = document.createElement('strong'); n.textContent = m.ahead.name; g.appendChild(n); }
                    else g.textContent = (m.rank === 1) ? "👑 You're in the lead!" : 'Keep going!';
                }

                function showFinal(st) {
                    const f = st.final || {}, el = $('fRank'); show('s-final');
                    el.textContent = '#' + (f.rank || '–'); el.className = 'fin-rank' + (f.rank && f.rank <= 3 ? ' gold' : '');
                    $('fMsg').textContent = f.rank === 1 ? '🏆 You won!' : f.rank && f.rank <= 3 ? '🎉 On the podium!' : 'Great game!';
                    const g = $('fGrid'); g.innerHTML = '';
                    [[f.score ?? 0, 'points'], [`${f.correct_count ?? 0}/${f.total_questions ?? 0}`, 'correct'], [f.avg_response_time_ms ? (f.avg_response_time_ms / 1000).toFixed(1) + 's' : '–', 'avg time']].forEach(([v, l], i) => { const d = document.createElement('div'); d.style.animationDelay = (.3 + i * .12) + 's'; d.innerHTML = '<b></b><span></span>'; d.querySelector('b').textContent = v; d.querySelector('span').textContent = l; g.appendChild(d); });
                    const t = $('fTop'); t.innerHTML = '';
                    (f.top3 || []).forEach((r, i) => { const d = document.createElement('div'); d.style.animationDelay = (.7 + i * .12) + 's'; d.innerHTML = `<b>${['🥇', '🥈', '🥉'][i] || r.rank}</b><span></span><em></em>`; d.querySelector('span').textContent = r.name; d.querySelector('em').textContent = r.score; t.appendChild(d); });
                    $('fBreak').href = f.results_url || '#';
                    if (f.rank && f.rank <= 3) { sfx.fan(); confetti(180); setTimeout(() => confetti(120), 700); } else sfx.good();
                }

                /* ---- timer (answer phase) ---- */
                function tickTimer() {
                    const st = current; if (!st || st.phase !== 'question' || !st.question) return;
                    const q = st.question, limit = q.time_limit * 1000, paused = st.status === 'paused';
                    // ready -> answer transition
                    if ($('s-ready').classList.contains('active')) {
                        const rem = paused ? Math.max(0, (q.paused_remaining_ms || 0) - limit) : q.opens_at_ms - serverNow();
                        if (rem <= 0 && !(current.me && current.me.answered)) { screenKey = 'q' + q.id + '-answer'; showAnswer(q); }
                        else $('readyNum').textContent = Math.max(1, Math.ceil(rem / 1000));
                        return;
                    }
                    if (!$('s-answer').classList.contains('active') && !$('s-locked').classList.contains('active')) return;
                    const rem = paused ? Math.min(limit, q.paused_remaining_ms || 0) : Math.max(0, q.ends_at_ms - serverNow());
                    const sec = Math.ceil(rem / 1000), bar = $('tbar');
                    $('tbarFill').style.transform = `scaleX(${Math.max(0, rem / limit)})`;
                    bar.className = 'tbar on' + (sec <= 3 ? ' danger' : sec <= 5 ? ' warn' : '');
                    $('ansSec').textContent = sec;
                    if (rem <= 0 && $('s-answer').classList.contains('active') && selected === null) {
                        document.querySelectorAll('#opts .opt').forEach(b => { b.disabled = true; b.classList.add('dim'); });
                        $('ansSec').textContent = '⏰';
                    }
                    if ($('s-locked').classList.contains('active')) { bar.className = 'tbar on'; $('lockedSub').textContent = rem > 0 ? 'Waiting for the others…' : "Time's up — results coming…"; }
                }
                setInterval(tickTimer, 100);

                /* ---- wire up ---- */
                const pin = $('pinInput');
                if (pin) {
                    pin.addEventListener('input', () => { pin.value = pin.value.replace(/\D/g, '').slice(0, 6); if (pin.value.length === 6) validatePin(); });
                    pin.addEventListener('keydown', e => { if (e.key === 'Enter') validatePin(); });
                    $('pinBtn').onclick = validatePin;
                }
                $('joinBtn').onclick = joinQuiz;
                ['nameInput', 'emailInput', 'mobileInput'].forEach(id => $(id).addEventListener('keydown', e => { if (e.key === 'Enter') joinQuiz(); }));
                document.addEventListener('visibilitychange', () => { if (!document.hidden) refresh(); });
                addEventListener('online', refresh);

                @if(!$currentSession)
                    setTimeout(() => location.reload(), 5000);
                @endif

                    if (me && sessionId) enter();   // page refresh: slide straight back into the game
            })();
        </script>
    @endif
</body>

</html>