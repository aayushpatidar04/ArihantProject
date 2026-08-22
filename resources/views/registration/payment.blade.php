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
            <div class="amount">₹{{ $reg->is_existing_client ? '399' : '599' }}</div>
            @php
                $name = $reg->full_name;
                $nLen = mb_strlen($name);
                if ($nLen <= 2) {
                    $maskedName = $name;
                } else {
                    $visible   = (int) round($nLen * 0.6);
                    $maskCount = $nLen - $visible;
                    $startLen  = (int) ceil($visible / 2);
                    $endLen    = $visible - $startLen;

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
                    $visible   = (int) round($nLen * 0.6);
                    $maskCount = $nLen - $visible;
                    $startLen  = (int) ceil($visible / 2);
                    $endLen    = $visible - $startLen;

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
                    <li>💻 Stratzy Access at ₹99</li>
                    <li>🎁 Exciting Rewards & Prizes</li>
                    <li>🧰 Trader Toolkit</li>
                    <li>📜 Certificate of Participation</li>
                    <li>🍽️ Food & Refreshments</li>
                </ul>
            </div>
            {{-- <div class="secure-badge">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" />
                    <path d="M7 11V7a5 5 0 0110 0v4" />
                </svg>
                Secure Payment via Atom / NTT DATA PAY
            </div> --}}

            {{-- @if(app()->environment('local'))
            <div class="debug-info">
                <strong>Debug:</strong><br>
                token: {{ $order['atomTokenId'] ?? 'MISSING' }}<br>
                returnUrl: {{ $order['returnUrl'] ?? 'MISSING' }}<br>
                env: {{ $order['env'] ?? 'prod' }}
            </div>
            @endif --}}

            <button id="payBtn" class="btn btn-primary" style="width:100%">Pay Now</button>
            <div
                style="text-align:center; font-size:12px; line-height:1.6; color:red; padding:14px 18px; background:rgba(255,255,255,0.02); border:1px dashed rgba(255,255,255,0.08); border-radius:12px; max-width:520px; margin:20px auto 0;">
                Disclaimer: An additional convenience fee upto ₹5 may be charged for payments made via Credit Card, UPI, Net
                Banking, Debit Card, or EMI.
            </div>
            <div id="atomError" style="color:#ff6b6b;font-size:13px;margin-top:16px;display:none"></div>
        </div>
    </div>

    <script src="{{ config('services.atom.js_cdn') }}"></script>
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
    </script>
@endsection