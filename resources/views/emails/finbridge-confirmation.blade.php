<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Welcome to ArihantPlus</title>
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
        <p>Hi {{ $registration->full_name }}, 👋</p>

        <p>🎉 Welcome to the ArihantPlus Family!</p>

        <p>Thank you for visiting ArihantPlus at Finbridge – Stall No. 8. 💚<br>
            We’re delighted to have you as a part of our growing family!</p>

        <p>📲 Download the ArihantPlus App:<br>
            <a href="https://onelink.to/3buf7e">https://onelink.to/3buf7e</a>
        </p>

        <p>🎁 Your FREE goodies are waiting for you!</p>

        <p>Simply visit ArihantPlus Stall No. 8, get the QR code below scanned by our team, and collect your FREE
            goodies. 🎁</p>

        <div class="qr">
            <img src="{{ $qrUrl }}" alt="Goodies QR Code">
        </div>

        <p>📍 Find us at: ArihantPlus – Stall No. 8, Finbridge</p>

        <p>Thank you for being a part of ArihantPlus.<br>
            Here’s to learning, investing & growing together! 🚀</p>

        <p><strong>Team ArihantPlus</strong></p>

        <div class="footer">
            Arihant Capital Markets Ltd. &copy; {{ date('Y') }}<br>
            All rights reserved.
        </div>
    </div>
</body>

</html>