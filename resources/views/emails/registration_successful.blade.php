<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Registration Successful</title>
    <style>
        body {
            background: #060208;
            color: #f6f3fa;
            font-family: Arial, sans-serif;
            padding: 40px 20px
        }

        .container {
            max-width: 560px;
            margin: 0 auto;
            background: #0e0812;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 40px
        }

        h1 {
            color: #b866f7;
            font-size: 24px;
            margin-bottom: 16px
        }

        p {
            line-height: 1.6;
            color: #a79bb5
        }

        .badge {
            display: inline-block;
            background: rgba(184, 102, 247, 0.15);
            border: 1px solid rgba(184, 102, 247, 0.4);
            color: #b866f7;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 16px
        }

        .details {
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05)
        }

        .detail-row:last-child {
            border: none
        }

        .label {
            color: #7c7188;
            font-size: 13px
        }

        .value {
            color: #f6f3fa;
            font-weight: 600
        }

        .password-box {
            background: rgba(255, 180, 0, 0.08);
            border: 1px solid rgba(255, 180, 0, 0.25);
            border-radius: 12px;
            padding: 16px;
            margin: 20px 0
        }

        .password-box .pwd {
            font-size: 16px;
            font-weight: 700;
            color: #ffd700;
            font-family: monospace
        }

        .cta-box {
            background: rgba(184, 102, 247, 0.08);
            border: 1px solid rgba(184, 102, 247, 0.25);
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            text-align: center
        }

        .cta-box a {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #d43fe0, #7a1fc9);
            color: #fff;
            text-decoration: none;
            border-radius: 999px;
            font-weight: 600
        }

        .footer {
            text-align: center;
            margin-top: 32px;
            font-size: 12px;
            color: #7c7188
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="badge">Registration Successful</div>
        <h1>Welcome to ArihantPLUS, {{ $registration->full_name }}!</h1>
        <p>Your registration for the AI & Algo Conclave is successful. Complete your payment to secure your spot.</p>

        <div class="details">
            <div class="detail-row"><span class="label">Registration # &nbsp;&nbsp;&nbsp;&nbsp;</span><span
                    class="value">{{ $registration->registration_number }}</span></div>
            <div class="detail-row"><span class="label">Name &nbsp;&nbsp;&nbsp;&nbsp;</span><span
                    class="value">{{ $registration->full_name }}</span></div>
            <div class="detail-row"><span class="label">Email &nbsp;&nbsp;&nbsp;&nbsp;</span><span
                    class="value">{{ $registration->email }}</span></div>
            <div class="detail-row"><span class="label">Phone &nbsp;&nbsp;&nbsp;&nbsp;</span><span class="value">+91
                    {{ $registration->phone }}</span></div>
            <div class="detail-row"><span class="label">City &nbsp;&nbsp;&nbsp;&nbsp;</span><span
                    class="value">{{ $registration->city ?? '-' }}</span></div>
            <div class="detail-row"><span class="label">Type &nbsp;&nbsp;&nbsp;&nbsp;</span><span
                    class="value">{{ ucfirst($registration->type) }}</span></div>
            <div class="detail-row"><span class="label">Date &nbsp;&nbsp;&nbsp;&nbsp;</span><span class="value">{{ $eventDate }}</span></div>
            <div class="detail-row"><span class="label">Time &nbsp;&nbsp;&nbsp;&nbsp;</span><span class="value">{{ $eventTime }}</span></div>
            <div class="detail-row"><span class="label">Venue &nbsp;&nbsp;&nbsp;&nbsp;</span><span class="value">{{ $venue }}</span></div>
        </div>

        @if($password)
            <div class="password-box">
                <p style="margin:0 0 8px;font-size:13px;color:#a79bb5">Your account password:</p>
                <div class="pwd">{{ $password }}</div>
                <p style="margin:8px 0 0;font-size:12px;color:#7c7188">Save this. You'll need it to login.</p>
            </div>
        @endif

        <div class="cta-box">
            <p style="margin:0 0 12px;font-size:14px;color:#a79bb5">Complete payment to get your entry QR code</p>
            <a href="{{ route('registration.payment') }}">Complete Payment</a>
        </div>

        <div class="footer">
            Arihant Capital Markets Ltd.<br>
            All copyrights reserved @Arihantcapital
        </div>
    </div>
</body>

</html>