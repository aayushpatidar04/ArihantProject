<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
</head>

<body
    style="margin:0;padding:0;background-color:#060208;font-family:Arial,Helvetica,sans-serif;-webkit-font-smoothing:antialiased;">
    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background-color:#060208;">
        <tr>
            <td align="center" style="padding:40px 16px;">
                <table role="presentation" cellpadding="0" cellspacing="0" width="560"
                    style="max-width:560px;width:100%;background-color:#0e0812;border:1px solid rgba(255,255,255,0.08);border-radius:16px;overflow:hidden;">
                    <!-- Logo -->
                    <tr>
                        <td align="center" style="padding:32px 32px 16px;">
                            <img src="https://event.arihantplus.com/assets/images/logo-colored.png" alt="ArihantPLUS"
                                width="160"
                                style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;">
                        </td>
                    </tr>
                    <!-- Greeting -->
                    <tr>
                        <td style="padding:8px 32px 8px;">
                            <p style="margin:0;font-size:15px;color:#f6f3fa;line-height:1.6;">Hi
                                {{ $registration->full_name }},
                            </p>
                        </td>
                    </tr>
                    <!-- Confirmation -->
                    <tr>
                        <td style="padding:4px 32px 16px;">
                            @if($registration->is_subbroker)
                                <p style="margin:0;font-size:18px;color:#b866f7;font-weight:700;">🎉 Your registration is
                                    confirmed!</p>
                            @else
                                <p style="margin:0;font-size:18px;color:#b866f7;font-weight:700;">🎉 Almost There! Your Registration Is successful , Payment Is Pending</p>
                            @endif
                        </td>
                    </tr>
                    <!-- Intro -->
                    <tr>
                        <td style="padding:0 32px 12px;">
                            <p style="margin:0;font-size:14px;color:#a79bb5;line-height:1.7;">
                                Thank you for registering for Central India’s Largest AI &amp; Algo Conclave, presented
                                by Arihant Capital Markets Limited.
                            </p>
                        </td>
                    </tr>
                    <!-- Event Details -->
                    <tr>
                        <td style="padding:0 32px 20px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" width="100%"
                                style="background-color:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.06);border-radius:12px;">
                                <tr>
                                    <td style="padding:20px;">
                                        <p
                                            style="margin:0 0 12px;font-size:13px;color:#7c7188;text-transform:uppercase;letter-spacing:0.5px;font-weight:700;">
                                            Event Details</p>
                                        <p style="margin:0 0 8px;font-size:14px;color:#f6f3fa;line-height:1.6;">📅 5th
                                            September 2026</p>
                                        <p style="margin:0 0 8px;font-size:14px;color:#f6f3fa;line-height:1.6;">📍 Mariott Hotel, Indore</p>
                                        <p style="margin:0;font-size:14px;color:#f6f3fa;line-height:1.6;">⏰ 10:00 AM
                                            onwards</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- Payment CTA -->
                    @if(!$registration->is_subbroker)
                    <tr>
                        <td style="padding:0 32px 8px;">
                            <p style="margin:0;font-size:14px;color:#a79bb5;line-height:1.7;">💳 Complete your payment to reserve your seat and confirm your participation at the event.</p>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding:0 32px 28px;">
                            <table role="presentation" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center"
                                        style="border-radius:999px;background:linear-gradient(135deg,#d43fe0,#7a1fc9);">
                                        <a href="https://event.arihantplus.com/register/payment"
                                            style="display:inline-block;padding:14px 32px;font-size:15px;font-weight:600;color:#ffffff;text-decoration:none;border-radius:999px;">Complete
                                            Your Payment</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    @endif

                    <tr>
                        <td style="padding:0 32px 8px;">
                            <p style="margin:0;font-size:14px;color:#a79bb5;line-height:1.7;">Get ready to explore the evolving world of AI, Algo Trading, Markets & Investing, and gain insights from industry experts shaping the future of finance.</p>
                        </td>
                    </tr>
                    <!-- Ticket Info -->
                    <tr>
                        <td style="padding:0 32px 20px;">
                            @if($registration->is_subbroker)
                            <p style="margin:0;font-size:14px;color:#a79bb5;line-height:1.7;">
                                🎟️ Your event ticket and QR code will be shared separately. Please keep the QR code handy for smooth entry at the venue.
                            </p>
                            @else
                            <p style="margin:0;font-size:14px;color:#a79bb5;line-height:1.7;">
                                🎟️ Your event ticket and QR code will be shared separately after successful completion
                                of the payment. Please keep the QR code handy for smooth entry at the venue.
                            </p>
                            @endif
                        </td>
                    </tr>
                    <!-- Closing -->
                    <tr>
                        <td style="padding:0 32px 8px;">
                            <p style="margin:0;font-size:14px;color:#a79bb5;line-height:1.7;">We look forward to
                                welcoming you and making this an insightful and impactful experience!</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 32px 4px;">
                            <p style="margin:0;font-size:14px;color:#f6f3fa;font-weight:700;">Arihant Capital Markets
                                Limited</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 32px 32px;">
                            <p style="margin:0;font-size:13px;color:#7c7188;"><ii>AI Powered. Algo Driven.</ii></p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="padding:20px 32px;border-top:1px solid rgba(255,255,255,0.06);text-align:center;">
                            <p style="margin:0;font-size:12px;color:#7c7188;line-height:1.6;">
                                Arihant Capital Markets Ltd.<br>
                                All copyrights reserved &copy; Arihantcapital
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>