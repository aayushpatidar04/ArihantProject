<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <title>It’s CONCLAVE Day!</title>
</head>

<body style="margin:0;padding:0;background:#f5f5f5;font-family:Arial,Helvetica,sans-serif;color:#222;">

    <div style="max-width:650px;margin:30px auto;background:#ffffff;padding:35px;border-radius:10px;">

        <p>
            Hi {{ $registration->full_name }},
        </p>

        <p>
            <strong>It’s CONCLAVE Day!</strong>
        </p>

        <p>
            We’re delighted to welcome you to the
            <strong>ARIHANT PLUS AI & ALGO CONCLAVE –
                Central India’s Largest AI & ALGO CONCLAVE.</strong>
        </p>

        <p>
            Here are your event details:
        </p>

        <p>
            📅 <strong>5th September 2026</strong><br>
            📍 <strong>Marriott Hotel, Indore</strong><br>
            ⏰ <strong>10:00 AM onwards</strong>
        </p>

        <p>
            Please find your
            <strong>event ticket and QR code</strong>
            below/attached. Kindly keep the QR code handy on your phone
            for a quick and hassle-free check-in at the venue.
        </p>

        <div style="text-align:center;margin:30px 0;">

            <p>
                <strong>Your Event QR Code</strong>
            </p>

            <img src="{{ $message->embed(public_path($qrImagePath)) }}" alt="Event QR Code"
                style="width:250px;height:250px;object-fit:contain;">

        </div>

        <p>
            <strong>A small request:</strong>
        </p>

        <p>
            To ensure a smooth and fair entry experience for everyone,
            <strong>each ticket is valid for entry for one individual only.</strong>
            We kindly request you to present your own ticket/QR code at the
            time of check-in.
        </p>

        <p>
            We’re excited to have you with us and hope you have a wonderful
            and insightful experience filled with
            <strong>AI and Algorithmic Trading.</strong>
        </p>

        <p>
            <strong>See you at the CONCLAVE! 🚀</strong>
        </p>

        <p>
            Regards,<br>
            <strong>Arihant Capital Markets Limited</strong>
        </p>

        <p style="color:#777;font-size:12px;margin-top:30px;">
            Template ID – XX22679679
        </p>

    </div>

</body>

</html>