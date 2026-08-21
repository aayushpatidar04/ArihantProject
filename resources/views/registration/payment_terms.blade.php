@extends('layouts.app')

@section('title', 'Payment Terms — ArihantPLUS Conclave 2026')

@push('styles')
    <style>
        .terms-page {
            min-height: 100vh;
            padding: 100px 24px 80px;
            background: linear-gradient(180deg, #060208 0%, #0a0410 55%, #12081d 100%);
        }

        .terms-card {
            max-width: 800px;
            margin: 0 auto;
            background: linear-gradient(165deg, #170b22 0%, #0b0511 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 26px;
            padding: 48px 44px;
            box-shadow: 0 40px 90px rgba(0, 0, 0, 0.6);
        }

        .terms-card h1 {
            font-family: 'Sora', sans-serif;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #fff;
        }

        .terms-card .subtitle {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 36px;
        }

        .terms-section {
            margin-bottom: 32px;
        }

        .terms-section h2 {
            font-size: 18px;
            font-weight: 700;
            color: #d4a5ff;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .terms-section h2::before {
            content: '';
            display: inline-block;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--purple-1);
        }

        .terms-section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .terms-section ul li {
            position: relative;
            padding-left: 20px;
            margin-bottom: 10px;
            font-size: 14px;
            line-height: 1.7;
            color: rgba(230, 220, 240, 0.85);
        }

        .terms-section ul li::before {
            content: '—';
            position: absolute;
            left: 0;
            color: var(--purple-1);
            font-weight: 600;
        }

        .terms-footer {
            margin-top: 40px;
            padding-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            font-size: 13px;
            color: var(--muted);
            text-align: center;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
            color: var(--muted);
            font-size: 14px;
            text-decoration: none;
            transition: color 0.2s;
        }

        .back-btn:hover {
            color: #fff;
        }

        @media (max-width: 600px) {
            .terms-card {
                padding: 32px 22px;
                border-radius: 22px;
            }

            .terms-card h1 {
                font-size: 24px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="terms-page">
        <div class="terms-card">
            <a href="{{ url()->previous() }}" class="back-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7" />
                </svg>
                Back
            </a>

            <h1>Payment Terms</h1>
            <p class="subtitle">ArihantPLUS AI & Algo Conclave 2026</p>

            <div class="terms-section">
                <h2>1. Payment</h2>
                <ul>
                    <li>All applicable registration or participation fees must be paid through the payment methods.</li>
                    <li>Registration will be considered confirmed only after the required payment has been successfully
                        received.</li>
                    <li>Participants are responsible for providing accurate payment and billing information.</li>
                </ul>
            </div>

            <div class="terms-section">
                <h2>2. Fees and Taxes</h2>
                <ul>
                    <li>All applicable fees, taxes, service charges, and payment processing charges will be communicated
                        during the registration process.</li>
                    <li>Participants are responsible for any additional charges imposed by their bank, card issuer, or
                        payment provider if any.</li>
                </ul>
            </div>

            <div class="terms-section">
                <h2>3. Payment Confirmation</h2>
                <ul>
                    <li>A payment confirmation or receipt will be provided after successful payment, where applicable.</li>
                    <li>Participants should retain their payment confirmation for event check-in and any future reference.
                    </li>
                </ul>
            </div>

            <div class="terms-section">
                <h2>4. Cancellations and Refunds</h2>
                <ul>
                    <li>Refunds, cancellations, and registration transfers will be subject to the event's applicable
                        cancellation and refund policy.</li>
                    <li>Any eligible refund will be processed using the original payment method, unless otherwise agreed by
                        the organizers.</li>
                    <li>Processing fees or other non-refundable charges may be excluded from refunds where stated at the
                        time of registration.</li>
                </ul>
            </div>

            <div class="terms-section">
                <h2>5. Failed or Unsuccessful Payments</h2>
                <ul>
                    <li>If a payment fails or is declined, participants may be required to complete payment again before
                        their registration is confirmed.</li>
                    <li>The organizers are not responsible for delays caused by banks, payment gateways, or other
                        third-party payment providers.</li>
                </ul>
            </div>

            <div class="terms-section">
                <h2>6. Changes to Fees</h2>
                <ul>
                    <li>The organizers reserve the right to revise event fees before registration or payment, subject to
                        applicable terms and conditions.</li>
                    <li>Any applicable fee payable by a participant will be clearly communicated before payment is
                        completed.</li>
                </ul>
            </div>

            <div class="terms-section">
                <h2>7. Disputes and Unauthorized Transactions</h2>
                <ul>
                    <li>Participants should promptly notify the organizers of any payment discrepancy or unauthorized
                        transaction.</li>
                    <li>Payment disputes will be reviewed based on the registration records and applicable payment-provider
                        procedures.</li>
                </ul>
            </div>

            <div class="terms-section">
                <h2>8. Acceptance</h2>
                <ul>
                    <li>By completing payment, participants acknowledge that they have reviewed and accepted these Payment
                        Terms, including any applicable cancellation and refund conditions.</li>
                </ul>
            </div>

            <div class="terms-footer">
                Last updated: August 2026 &nbsp;|&nbsp; ArihantPLUS Conclave
            </div>
        </div>
    </div>
@endsection