<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $code == 404 ? 'Page Not Found' : ($code == 419 ? 'Session Expired' : 'Something Went Wrong') }} —
        ArihantPLUS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #060208;
            --ink: #f6f3fa;
            --muted: #7c7188;
            --purple-1: #b866f7;
            --card-bg: linear-gradient(165deg, #170b22 0%, #0b0511 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .error-card {
            width: 100%;
            max-width: 460px;
            background: var(--card-bg);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 26px;
            padding: 56px 40px;
            text-align: center;
        }

        .icon-wrap {
            width: 72px;
            height: 72px;
            margin: 0 auto 24px;
            background: rgba(184, 102, 247, 0.1);
            border: 1px solid rgba(184, 102, 247, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-wrap svg {
            width: 32px;
            height: 32px;
            color: var(--purple-1);
        }

        .error-card h1 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .error-card p {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.65;
            margin-bottom: 28px;
        }

        .error-code {
            display: inline-block;
            font-size: 12px;
            font-weight: 600;
            color: var(--purple-1);
            background: rgba(184, 102, 247, 0.1);
            border: 1px solid rgba(184, 102, 247, 0.15);
            padding: 6px 14px;
            border-radius: 20px;
            margin-bottom: 24px;
            letter-spacing: 0.5px;
        }

        .actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            padding: 13px 24px;
            border-radius: 14px;
            border: none;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.2s;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-home {
            background: var(--purple-1);
            color: #fff;
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.06);
            color: var(--ink);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .btn svg {
            width: 16px;
            height: 16px;
        }

        .footer-note {
            margin-top: 28px;
            font-size: 12px;
            color: rgba(124, 113, 136, 0.5);
        }

        @media (max-width: 480px) {
            .error-card {
                padding: 40px 24px;
            }

            .actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    @php
        $messages = [
            404 => [
                'title' => 'Page Not Found',
                'desc' => 'The page you are looking for doesn\'t exist or has been moved.',
            ],
            419 => [
                'title' => 'Session Expired',
                'desc' => 'Your session has expired. Please refresh the page and try again.',
            ],
            403 => [
                'title' => 'Access Denied',
                'desc' => 'You don\'t have permission to access this page.',
            ],
            503 => [
                'title' => 'Service Unavailable',
                'desc' => 'We are temporarily down for maintenance. Please check back soon.',
            ],
            500 => [
                'title' => 'Something Went Wrong',
                'desc' => 'Please try again later after some time. There is some problem at our end.',
            ],
        ];

        $msg = $messages[$code] ?? [
            'title' => 'Something Went Wrong',
            'desc' => 'Please try again later after some time. There is some problem at our end.',
        ];
    @endphp

    <div class="error-card">
        <div class="icon-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                <line x1="12" y1="9" x2="12" y2="13" />
                <line x1="12" y1="17" x2="12.01" y2="17" />
            </svg>
        </div>

        <h1>{{ $msg['title'] }}</h1>

        @if(isset($code))
            <div class="error-code">Error {{ $code }}</div>
        @endif

        <p>{{ $msg['desc'] }}</p>

        <div class="actions">
            <button type="button" class="btn btn-back" onclick="history.back()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                    stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12" />
                    <polyline points="12 19 5 12 12 5" />
                </svg>
                Go Back
            </button>

            <a href="{{ route('index') }}" class="btn btn-home">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                    <polyline points="9 22 9 12 15 12 15 22" />
                </svg>
                Back to Home
            </a>
        </div>

        <div class="footer-note">
            Arihant Capital Markets Ltd. &copy; {{ date('Y') }}
        </div>
    </div>
</body>

</html>