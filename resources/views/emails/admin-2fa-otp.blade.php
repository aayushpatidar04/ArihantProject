<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login OTP</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #060208;
            font-family: Arial, Helvetica, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        .wrapper {
            width: 100%;
            max-width: 520px;
            margin: 0 auto;
            background-color: #0e0812;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            overflow: hidden;
        }

        .logo-wrap {
            text-align: center;
            padding: 32px 32px 16px;
        }

        .logo-wrap img {
            width: 160px;
            height: auto;
            display: block;
            margin: 0 auto;
            border: 0;
            outline: none;
        }

        .content {
            padding: 24px 36px 36px;
            color: #e9e4f0;
            font-size: 15px;
            line-height: 1.7;
        }

        .greeting {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 16px;
            color: #f6f3fa;
        }

        .otp-box {
            text-align: center;
            margin: 28px 0;
            padding: 20px;
            background: rgba(184, 102, 247, 0.08);
            border: 1px solid rgba(184, 102, 247, 0.2);
            border-radius: 14px;
        }

        .otp-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #b866f7;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .otp-code {
            font-size: 32px;
            font-weight: 700;
            color: #b866f7;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
        }

        .warning {
            margin-top: 24px;
            font-size: 13px;
            color: #7c7188;
            padding: 14px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 10px;
            border-left: 3px solid #b866f7;
        }

        .footer {
            text-align: center;
            padding: 20px 36px;
            font-size: 12px;
            color: #4a3f5c;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }
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
                        <div class="greeting">Dear {{ $user->name }},</div>
                        <p>Your One-Time Password (OTP) for admin login on the ARIHANT PLUS AI & ALGO CONCLAVE portal
                            is:</p>
                        <div class="otp-box">
                            <div class="otp-label">Verification Code</div>
                            <div class="otp-code">{{ $otp }}</div>
                        </div>
                        <p>This OTP is valid for 5 minutes. Please do not share this OTP with anyone.</p>
                        <div class="warning">
                            For your security, never share this code. Arihant Capital will never ask for your OTP.
                        </div>
                    </div>
                    <div class="footer">
                        Arihant Capital Markets Ltd.<br>
                        AI Powered. Algo Driven.
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>