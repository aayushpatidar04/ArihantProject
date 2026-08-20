<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Seat Confirmed</title>
    <style>
        body{background:#060208;color:#f6f3fa;font-family:Arial,sans-serif;padding:40px 20px}
        .container{max-width:480px;margin:0 auto;background:#0e0812;border:1px solid rgba(255,255,255,0.08);border-radius:20px;padding:40px;text-align:center}
        h1{color:#b866f7;font-size:22px;margin-bottom:12px}
        .seat{font-size:48px;font-weight:800;color:#fff;margin:20px 0}
        p{color:#a79bb5;line-height:1.6}
        .footer{margin-top:32px;font-size:12px;color:#7c7188}
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to ArihantPLUS!</h1>
        <p>Hi {{ $name }}, your seat has been allocated.</p>
        <div class="seat">{{ $seatNumber }}</div>
        <p>Please proceed to your designated section. Have a great day at the conclave!</p>
        <div class="footer">Arihant Capital Markets Ltd.</div>
    </div>
</body>
</html>
