@extends('layouts.app')

@section('title', 'Payment — ArihantPLUS')

@push('styles')
    <style>
        .pay-page {
            min-height: 100vh;
            padding: 80px 24px 60px;
            background: var(--bg);
            text-align: center
        }

        .pay-card {
            max-width: 480px;
            margin: 0 auto;
            background: linear-gradient(165deg, #170b22 0%, #0b0511 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 26px;
            padding: 48px 36px
        }

        .pay-card h1 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 12px
        }

        .pay-card .amount {
            font-size: 48px;
            font-weight: 800;
            color: var(--purple-1);
            margin: 16px 0
        }

        .pay-card .detail {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 32px
        }

        .secure-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 10px 18px;
            border-radius: 999px;
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 24px
        }

        .client-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(40, 180, 100, 0.12);
            border: 1px solid rgba(40, 180, 100, 0.3);
            color: #8ff0b3;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 16px
        }

        .debug-info {
            background: rgba(255, 200, 0, 0.08);
            border: 1px solid rgba(255, 200, 0, 0.3);
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 11px;
            color: #ffd700;
            text-align: left;
            font-family: monospace
        }

        .benefits-list {
            margin: 24px 0;
            padding: 20px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 16px;
        }

        .benefits-title {
            font-size: 13px;
            font-weight: 600;
            color: #b866f7;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 14px;
        }

        .benefits-list ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .benefits-list li {
            position: relative;
            padding-left: 22px;
            margin-bottom: 8px;
            font-size: 14px;
            line-height: 1.35;
            color: #c4b8d4;
            text-align: justify;
        }

        .benefits-list li:last-child {
            margin-bottom: 0;
        }

        .benefits-list li::before {
            content: '';
            position: absolute;
            left: 0;
            top: 6px;
            width: 7px;
            height: 7px;
            background: linear-gradient(135deg, #b866f7, #8b5cf6);
            border-radius: 50%;
            box-shadow: 0 0 8px rgba(184, 102, 247, 0.35);
        }

        .disclaimer {
            text-align: center;
            font-size: 12px;
            line-height: 1.6;
            color: red;
            padding: 14px 18px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px dashed rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            max-width: 520px;
            margin: 20px auto 0;
        }
    </style>
@endpush

@section('content')
    <div class="pay-page">
        <div class="pay-card">
            @if($reg->is_existing_client)
                <div class="client-badge">✓ Client Special Price</div>
            @endif
            <h1>Complete Payment</h1>
            <div class="amount" id="paymentAmount">
                ₹{{ $reg->is_existing_client ? '399' : '599' }}
            </div>
            @php
                $name = $reg->full_name;
                $nLen = mb_strlen($name);
                if ($nLen <= 2) {
                    $maskedName = $name;
                } else {
                    $visible = (int) round($nLen * 0.6);
                    $maskCount = $nLen - $visible;
                    $startLen = (int) ceil($visible / 2);
                    $endLen = $visible - $startLen;

                    $maskedName = mb_substr($name, 0, $startLen)
                        . str_repeat('*', $maskCount)
                        . mb_substr($name, -$endLen);
                }

                $email = $reg->email;
                $at = strpos($email, '@');
                $local = substr($email, 0, $at);
                $domain = substr($email, $at);
                $lLen = strlen($local);
                if ($nLen <= 2) {
                    $maskedEmail = $local;
                } else {
                    $visible = (int) round($nLen * 0.6);
                    $maskCount = $nLen - $visible;
                    $startLen = (int) ceil($visible / 2);
                    $endLen = $visible - $startLen;

                    $maskedEmail = mb_substr($local, 0, $startLen)
                        . str_repeat('*', $maskCount)
                        . mb_substr($local, -$endLen) . '@' . $domain;
                }
            @endphp

            <div class="detail">
                {{ $reg->is_existing_client ? 'Existing Client Rate' : 'Standard Registration' }}<br>
                {{ $maskedName }} • {{ $maskedEmail }}
            </div>
            <div class="benefits-list">
                <div class="benefits-title">What's Included</div>
                <ul>
                    <li>🤖 AI + Algo Cheat Sheet</li>
                    <li>⚡ Live AI & Algo Demos</li>
                    <li>🎯 Actionable Trading Strategies</li>
                    <li>💻 Stratzy Access at ₹297</li>
                    <li>🎁 Exciting Rewards & Prizes</li>
                    <li>🧰 Trader Toolkit</li>
                    <li>📜 Certificate of Participation</li>
                    <li>🍽️ Lunch + High Tea</li>
                    <li>✨ Sound Healing</li>
                </ul>
            </div>

            <div style="margin:24px 0 18px;text-align:left">

                <label for="promoCode" style="display:block;font-size:13px;font-weight:600;color:#e9e4f0;margin-bottom:7px">
                    Have a Promo Code?
                </label>

                <div style="display:flex;gap:8px">

                    <input type="text" id="promoCode" maxlength="50" placeholder="Enter promo code" autocomplete="off"
                        style="flex:1;min-width:0;background:rgba(255,255,255,0.055);border:1px solid rgba(255,255,255,0.1);border-radius:12px;padding:12px 14px;color:var(--ink);font-size:14px;outline:none;text-transform:uppercase">

                    <button type="button" id="applyPromoBtn" class="btn btn-primary"
                        style="padding:10px 16px;white-space:nowrap">
                        Apply
                    </button>

                </div>

                <div id="promoMessage" style="display:none;font-size:12px;margin-top:7px">
                </div>

            </div>


            <button id="payBtn" class="btn btn-primary" style="width:100%">Pay Now</button>
            {{-- <div
                style="text-align:center; font-size:12px; line-height:1.6; color:red; padding:14px 18px; background:rgba(255,255,255,0.02); border:1px dashed rgba(255,255,255,0.08); border-radius:12px; max-width:520px; margin:20px auto 0;">
                Disclaimer: An additional convenience fee upto ₹5 may be charged for payments made via Credit Card, UPI, Net
                Banking, Debit Card, or EMI.
            </div> --}}
            <div id="atomError" style="color:#ff6b6b;font-size:13px;margin-top:16px;display:none"></div>
        </div>
    </div>

    <script src="{{ config('services.atom.js_cdn') }}"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    {{--
    <script>
        document.getElementById('payBtn').onclick = function () {
            const atomTokenId = '{{ $order["atomTokenId"] ?? "" }}';
            const merchId = '{{ $order["merchId"] ?? "" }}';
            const custEmail = '{{ $order["custEmail"] ?? "" }}';
            const custMobile = '{{ $order["custMobile"] ?? "" }}';
            const returnUrl = '{{ $order["returnUrl"] ?? "" }}';
            const env = '{{ $order["env"] ?? "uat" }}';

            if (!atomTokenId) {
                document.getElementById('atomError').textContent = 'Payment token missing. Please refresh.';
                document.getElementById('atomError').style.display = 'block';
                return;
            }

            console.log('AtomPaynetz init:', { atomTokenId, merchId, custEmail, custMobile, returnUrl, env });

            try {
                const atom = new AtomPaynetz({
                    atomTokenId: String(atomTokenId), // force string
                    merchId: String(merchId),
                    custEmail: custEmail,
                    custMobile: custMobile,
                    returnUrl: returnUrl
                }, env);

                // Some versions of Atom SDK expose this
                if (atom && atom.onError) {
                    atom.onError = function (err) {
                        console.error('Atom checkout error:', err);
                        document.getElementById('atomError').textContent =
                            'Payment gateway error: ' + (err.message || JSON.stringify(err));
                        document.getElementById('atomError').style.display = 'block';
                    };
                }
            } catch (e) {
                console.error('AtomPaynetz exception:', e);
                document.getElementById('atomError').textContent =
                    'Failed to load payment gateway. Please try again.';
                document.getElementById('atomError').style.display = 'block';
            }
        };
    </script> --}}
    <script>

        const originalAmount =
            {{ $reg->is_existing_client ? 399 : 599 }};

        let appliedPromoCode = null;

        const paymentAmount =
            document.getElementById('paymentAmount');

        const promoCodeInput =
            document.getElementById('promoCode');

        const applyPromoBtn =
            document.getElementById('applyPromoBtn');

        const promoMessage =
            document.getElementById('promoMessage');

        const payBtn =
            document.getElementById('payBtn');

        const atomError =
            document.getElementById('atomError');


        function showPromoMessage(message, success = false) {
            promoMessage.textContent = message;

            promoMessage.style.display = 'block';

            promoMessage.style.color =
                success ? '#8ff0b3' : '#ff6b6b';
        }


        function resetPromo() {
            appliedPromoCode = null;

            paymentAmount.textContent =
                '₹' + originalAmount;

            promoCodeInput.disabled = false;

            applyPromoBtn.disabled = false;

            applyPromoBtn.textContent = 'Apply';

            promoMessage.style.display = 'none';
        }


        /*
         * Check promo code.
         * IMPORTANT: This DOES NOT consume the promo.
         */
        applyPromoBtn.addEventListener(
            'click',
            async function () {

                const promoCode =
                    promoCodeInput.value
                        .trim()
                        .toUpperCase();

                if (!promoCode) {

                    showPromoMessage(
                        'Please enter a promo code.'
                    );

                    return;
                }

                applyPromoBtn.disabled = true;

                applyPromoBtn.textContent =
                    'Checking...';

                try {

                    const response = await fetch(
                        '{{ route("registration.check-promo") }}',
                        {
                            method: 'POST',

                            headers: {
                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    '{{ csrf_token() }}'
                            },

                            body: JSON.stringify({
                                promo_code: promoCode
                            })
                        }
                    );

                    const data =
                        await response.json();

                    if (!response.ok || !data.valid) {

                        resetPromo();

                        showPromoMessage(
                            data.message ||
                            'Invalid promo code.'
                        );

                        return;
                    }

                    appliedPromoCode =
                        data.promo_code;

                    paymentAmount.textContent =
                        '₹' + data.amount;

                    promoCodeInput.disabled = true;

                    applyPromoBtn.disabled = true;

                    applyPromoBtn.textContent =
                        'Applied';

                    showPromoMessage(
                        data.message,
                        true
                    );

                } catch (error) {

                    console.error(
                        'Promo validation error:',
                        error
                    );

                    resetPromo();

                    showPromoMessage(
                        'Unable to validate promo code.'
                    );
                }

            });


        /*
         * If promo input changes, remove previously
         * applied promo.
         */
        promoCodeInput.addEventListener(
            'input',
            function () {

                this.value =
                    this.value.toUpperCase();

                if (appliedPromoCode) {
                    resetPromo();
                }

            });


        /*
         * Pay Now
         */
        payBtn.onclick = async function () {

            payBtn.disabled = true;

            payBtn.textContent =
                'Processing...';

            atomError.style.display = 'none';

            try {

                /*
                 * Server decides the actual amount.
                 */
                const response = await fetch(
                    '{{ route("registration.payment.create-order") }}',
                    {
                        method: 'POST',

                        headers: {
                            'Content-Type':
                                'application/json',

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                '{{ csrf_token() }}'
                        },

                        body: JSON.stringify({
                            promo_code:
                                appliedPromoCode
                        })
                    }
                );

                const data =
                    await response.json();

                if (!response.ok || !data.success) {
                    throw new Error(
                        data.message ||
                        'Unable to create payment order.'
                    );
                }


                const options = {

                    key:
                        '{{ config("services.payment.key_id") }}',

                    amount:
                        data.amount * 100,

                    currency: 'INR',

                    name:
                        'ArihantPLUS Conclave',

                    description:
                        data.promo_applied
                            ? 'AI & Algo Conclave 2026 Registration - Promo'
                            : 'AI & Algo Conclave 2026 Registration',

                    image:
                        'https://event.arihantplus.com/assets/images/logo.png',

                    order_id:
                        data.order_id,

                    handler:
                        function (response) {

                            const form =
                                document.createElement('form');

                            form.method = 'POST';

                            form.action =
                                '{{ route("razor.payment.callback", $reg->user_id) }}';

                            form.innerHTML = `

                            @csrf

                            <input
                                type="hidden"
                                name="razorpay_payment_id"
                                value="${response.razorpay_payment_id}"
                            >

                            <input
                                type="hidden"
                                name="razorpay_order_id"
                                value="${response.razorpay_order_id}"
                            >

                            <input
                                type="hidden"
                                name="razorpay_signature"
                                value="${response.razorpay_signature}"
                            >

                            <input
                                type="hidden"
                                name="promo_code"
                                value="${data.promo_code ?? ''}"
                            >

                        `;

                            document.body.appendChild(form);

                            form.submit();
                        },

                    prefill: {
                        name:
                            @json($reg->full_name),

                        email:
                            @json($reg->email),

                        contact:
                            @json($reg->phone)
                    },

                    theme: {
                        color: '#8b2fd9'
                    }
                };


                const rzp =
                    new Razorpay(options);

                rzp.open();


                rzp.on(
                    'payment.failed',
                    function (response) {

                        console.error(
                            'Razorpay payment failed:',
                            response
                        );

                        atomError.textContent =
                            response.error?.description ||
                            'Payment failed. Please try again.';

                        atomError.style.display =
                            'block';

                        payBtn.disabled = false;

                        payBtn.textContent =
                            'Pay Now';
                    });


            } catch (error) {

                console.error(error);

                atomError.textContent =
                    error.message ||
                    'Unable to initiate payment.';

                atomError.style.display =
                    'block';

                payBtn.disabled = false;

                payBtn.textContent =
                    'Pay Now';
            }
        };

    </script>
@endsection