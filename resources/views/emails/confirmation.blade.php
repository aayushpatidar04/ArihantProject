<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Registration Confirmed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 20px;
            background: #f5f5f5;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
        }

        h2 {
            color: #6b21a8;
            margin-bottom: 10px;
        }

        .qr {
            text-align: center;
            margin: 20px 0;
        }

        .qr img {
            max-width: 200px;
            border-radius: 8px;
            border: 1px solid #e5e5e5;
        }

        .calendar {
            margin: 24px 0;
            padding: 16px;
            background: #faf5ff;
            border-radius: 8px;
            border: 1px solid #e9d5ff;
        }

        .calendar-title {
            font-weight: bold;
            color: #6b21a8;
            margin-bottom: 10px;
        }

        .btn-group {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .btn {
            display: inline-block;
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-google {
            background: #fff;
            color: #ea4335;
            border: 1px solid #ea4335;
        }

        .btn-outlook {
            background: #fff;
            color: #0078d4;
            border: 1px solid #0078d4;
        }

        .btn-yahoo {
            background: #fff;
            color: #6001d2;
            border: 1px solid #6001d2;
        }

        .btn-apple {
            background: #fff;
            color: #333;
            border: 1px solid #333;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <p>Hi {{ $registration->full_name }},</p>

        <p>🎉 Your registration is confirmed!</p>

        <p>Thank you for registering for Central India's Largest AI & Algo Conclave, presented by Arihant Capital.</p>

        <p>Your registration and payment have been successfully completed.</p>

        <p><strong>Event Details:</strong><br>
            📅 {{ $eventDate }}<br>
            📍 {{ $venue }}<br>
            ⏰ {{ $eventTime }}</p>

        <p>Get ready to explore the evolving world of AI, Algo Trading, Markets & Investing and hear from industry
            experts shaping the future of finance.</p>

        {{-- Add to Calendar --}}
        <div class="calendar">
            <div class="calendar-title">📆 Add to your calendar</div>
            <p style="margin:0 0 8px 0; font-size:13px; color:#555;">Click your preferred calendar below or open the
                attached .ics file.</p>
            <div class="btn-group">
                <a href="{{ $googleLink }}" target="_blank" class="btn btn-google">Google Calendar</a>
                <a href="{{ $outlookLink }}" target="_blank" class="btn btn-outlook">Outlook</a>
                <a href="{{ $yahooLink }}" target="_blank" class="btn btn-yahoo">Yahoo</a>
                <a href="{{ $icsUrl }}" class="btn btn-apple">Apple / Download ICS</a>
            </div>
        </div>

        <div class="qr">
            <img src="{{ $qrUrl }}" alt="Entry QR Code">
        </div>

        <p>Please keep this QR code handy for entry at the venue.</p>

        <p>We look forward to seeing you there!</p>

        <p><strong>Arihant Capital</strong><br>
            AI Powered. Algo Driven.</p>

        <div class="footer">
            Arihant Capital Markets Ltd. &copy; {{ date('Y') }}<br>
            All rights reserved.
        </div>
    </div>
</body>

</html>