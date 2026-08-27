<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Seat Is Waiting</title>
    <style>
        body { margin: 0; padding: 0; background-color: #060208; font-family: Arial, Helvetica, sans-serif; -webkit-font-smoothing: antialiased; }
        .wrapper { width: 100%; max-width: 560px; margin: 0 auto; background-color: #0e0812; border: 1px solid rgba(255,255,255,0.08); border-radius: 20px; overflow: hidden; }
        .logo-wrap { text-align: center; padding: 32px 32px 16px; }
        .logo-wrap img { width: 160px; height: auto; display: block; margin: 0 auto; border: 0; outline: none; }
        .content { padding: 24px 36px 36px; color: #e9e4f0; font-size: 15px; line-height: 1.7; }
        .greeting { font-size: 16px; font-weight: 600; margin-bottom: 16px; color: #f6f3fa; }
        .highlight { color: #b866f7; font-weight: 700; }
        .event-box { margin: 24px 0; padding: 18px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.06); border-radius: 14px; }
        .event-box p { margin: 6px 0; font-size: 14px; color: #c4b8d4; }
        .cta-wrap { text-align: center; margin: 28px 0; }
        .cta-btn { display: inline-block; padding: 14px 32px; background: linear-gradient(135deg, #8b2fd9, #b866f7); color: #fff; font-size: 15px; font-weight: 600; text-decoration: none; border-radius: 14px; }
        .divider { height: 1px; background: rgba(255,255,255,0.06); margin: 24px 0; }
        .footer { text-align: center; padding: 20px 36px; font-size: 12px; color: #4a3f5c; border-top: 1px solid rgba(255,255,255,0.05); }
    </style>
</head>
<body>
    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <div class="wrapper">
                    <div class="logo-wrap">
                        <img src="https://event.arihantplus.com/assets/images/logo-colored.png" alt="ArihantPLUS">
                    </div>
                    <div class="content">
                        <div class="greeting">Hi {{ $registration->full_name }},</div>

                        <p>🚀 <strong>Your Seat Is Waiting!</strong></p>

                        <p>This is a gentle reminder to complete your payment and reserve your seat for the <strong>ARIHANT PLUS AI & ALGO CONCLAVE</strong>, happening on <strong>5th September 2026</strong> at <strong>Marriott Hotel, Indore</strong>.</p>

                        <div class="event-box">
                            <p>📅 <strong>Date:</strong> 5th September 2026</p>
                            <p>📍 <strong>Venue:</strong> Marriott Hotel, Indore</p>
                            <p>⏰ <strong>Time:</strong> 10:00 AM onwards</p>
                        </div>

                        <p>🎟️ Complete your payment now to confirm your registration and secure your seat.</p>

                        <div class="cta-wrap">
                            <a href="{{ $paymentLink }}" class="cta-btn">👉 Complete Payment</a>
                        </div>

                        <p>Don't miss the opportunity to be part of Central India's Largest AI & ALGO CONCLAVE and explore the future of AI, Algorithmic Trading & Financial Markets.</p>

                        <p>We look forward to welcoming you!</p>

                        <div class="divider"></div>

                        <p style="font-size: 14px;"><strong>Regards,</strong><br>Arihant Capital Markets Limited</p>
                    </div>
                    <div class="footer">
                        AI Powered. Algo Driven.
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>