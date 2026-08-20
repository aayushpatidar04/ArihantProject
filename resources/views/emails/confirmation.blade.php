<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registration Confirmed</title>
    <style>
        body{background:#060208;color:#f6f3fa;font-family:Arial,sans-serif;padding:40px 20px}
        .container{max-width:560px;margin:0 auto;background:#0e0812;border:1px solid rgba(255,255,255,0.08);border-radius:20px;padding:40px}
        h1{color:#b866f7;font-size:24px;margin-bottom:16px}
        p{line-height:1.6;color:#a79bb5}
        .qr{text-align:center;margin:24px 0}
        .qr img{max-width:200px;border-radius:12px}
        .details{background:rgba(255,255,255,0.03);border-radius:12px;padding:20px;margin:20px 0}
        .detail-row{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid rgba(255,255,255,0.05)}
        .detail-row:last-child{border:none}
        .label{color:#7c7188;font-size:13px}
        .value{color:#f6f3fa;font-weight:600}
        .footer{text-align:center;margin-top:32px;font-size:12px;color:#7c7188}
    </style>
</head>
<body>
    <div class="container">
        <h1>You're registered for ArihantPLUS Conclave 2026!</h1>
        <p>Hi {{ $registration->full_name }},</p>
        <p>Your registration is confirmed. Please find your entry QR code below. Show this at the venue entrance.</p>
        <div class="qr">
            <img src="{{ $qrUrl }}" alt="Entry QR Code">
        </div>
        <div class="details">
            <div class="detail-row"><span class="label">Registration #</span><span class="value">{{ $registration->registration_number }}</span></div>
            <div class="detail-row"><span class="label">Date</span><span class="value">{{ $eventDate }}</span></div>
            <div class="detail-row"><span class="label">Time</span><span class="value">{{ $eventTime }}</span></div>
            <div class="detail-row"><span class="label">Venue</span><span class="value">{{ $venue }}</span></div>
        </div>
        <p style="font-size:13px">Add this event to your calendar. We look forward to seeing you there!</p>
        <div class="footer">
            Arihant Capital Markets Ltd.<br>
            All copyrights reserved @Arihantcapital
        </div>
    </div>
</body>
</html>
