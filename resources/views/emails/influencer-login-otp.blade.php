<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Influencer Login OTP</title>
</head>

<body style="margin:0;padding:0;background:#0b0b0b;font-family:Arial,sans-serif;">

    <div style="max-width:600px;margin:40px auto;padding:30px;background:#161616;border-radius:12px;color:#ffffff;">

        <h2 style="margin-top:0;">
            ArihantPLUS Influencer Login
        </h2>

        <p style="color:#cccccc;">
            Use the OTP below to complete your influencer account login.
        </p>

        <div style="
            margin:30px 0;
            padding:20px;
            text-align:center;
            background:#21152b;
            border-radius:10px;
        ">
            <span style="
                font-size:32px;
                font-weight:bold;
                letter-spacing:8px;
                color:#b866f7;
            ">
                {{ $otp }}
            </span>
        </div>

        <p style="color:#aaaaaa;">
            This OTP is valid for <strong>2 minutes</strong>.
        </p>

        <p style="color:#aaaaaa;">
            If you did not attempt to log in, you can safely ignore this email.
        </p>

        <hr style="border:0;border-top:1px solid #333;margin:30px 0;">

        <p style="font-size:12px;color:#777;">
            ArihantPLUS AI & Algo Conclave 2026
        </p>

    </div>

</body>

</html>