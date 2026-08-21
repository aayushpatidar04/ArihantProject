@extends('layouts.app')

@section('title', 'Cookie Policy — ArihantPLUS Conclave 2026')

@push('styles')
    <style>
        .cookie-page {
            min-height: 100vh;
            padding: 100px 24px 80px;
            background: linear-gradient(180deg, #060208 0%, #0a0410 55%, #12081d 100%);
        }

        .cookie-card {
            max-width: 800px;
            margin: 0 auto;
            background: linear-gradient(165deg, #170b22 0%, #0b0511 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 26px;
            padding: 48px 44px;
            box-shadow: 0 40px 90px rgba(0, 0, 0, 0.6);
        }

        .cookie-card h1 {
            font-family: 'Sora', sans-serif;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #fff;
        }

        .cookie-card .subtitle {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 36px;
        }

        .cookie-section {
            margin-bottom: 32px;
        }

        .cookie-section h2 {
            font-size: 18px;
            font-weight: 700;
            color: #d4a5ff;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cookie-section h2::before {
            content: '';
            display: inline-block;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--purple-1);
        }

        .cookie-section p {
            font-size: 14px;
            line-height: 1.7;
            color: rgba(230, 220, 240, 0.85);
            margin-bottom: 10px;
        }

        .cookie-section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .cookie-section ul li {
            position: relative;
            padding-left: 20px;
            margin-bottom: 10px;
            font-size: 14px;
            line-height: 1.7;
            color: rgba(230, 220, 240, 0.85);
        }

        .cookie-section ul li::before {
            content: '—';
            position: absolute;
            left: 0;
            color: var(--purple-1);
            font-weight: 600;
        }

        .cookie-footer {
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
            .cookie-card {
                padding: 32px 22px;
                border-radius: 22px;
            }

            .cookie-card h1 {
                font-size: 24px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="cookie-page">
        <div class="cookie-card">
            <a href="{{ url()->previous() }}" class="back-btn">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7" />
                </svg>
                Back
            </a>

            <h1>Cookie Policy</h1>
            <p class="subtitle">ArihantPLUS AI & Algo Conclave 2026</p>

            <div class="cookie-section">
                <h2>1. Introduction</h2>
                <p>This Cookie Policy explains how cookies and similar technologies may be used on our website, event
                    registration platform, and related services (“Platform”).</p>
                <p>By using the Platform, you acknowledge the use of cookies in accordance with this policy, subject to your
                    available cookie preferences and applicable law.</p>
            </div>

            <div class="cookie-section">
                <h2>2. What Are Cookies?</h2>
                <p>Cookies are small text files stored on your device when you visit a website. They help websites function
                    properly, remember preferences, improve user experience, and understand how visitors use the Platform.
                </p>
            </div>

            <div class="cookie-section">
                <h2>3. Types of Cookies We May Use</h2>
                <ul>
                    <li><strong>Essential Cookies</strong> — These cookies are necessary for the Platform to operate. They
                        may support functions such as registration, login, security, session management, and payment
                        processing.</li>
                    <li><strong>Functional Cookies</strong> — These cookies remember choices and preferences to provide a
                        more personalized experience, such as language or regional settings.</li>
                    <li><strong>Analytics Cookies</strong> — These cookies help us understand how visitors use the Platform,
                        including which pages are visited and how users interact with our services. This information may be
                        used to improve the Platform.</li>
                    <li><strong>Marketing Cookies</strong> — Where applicable and with the required consent, these cookies
                        may be used to deliver relevant communications or measure the effectiveness of promotional
                        activities.</li>
                </ul>
            </div>

            <div class="cookie-section">
                <h2>4. Third-Party Cookies</h2>
                <p>Some services used on the Platform, such as analytics, payment, registration, or embedded content
                    providers, may place cookies on your device. These third parties may process information in accordance
                    with their own privacy policies.</p>
            </div>

            <div class="cookie-section">
                <h2>5. Managing Cookies</h2>
                <p>You may be able to manage or disable certain cookies through your browser settings or the cookie
                    preference tools provided on the Platform.</p>
                <p>Please note that disabling essential cookies may affect the functionality of registration, login,
                    payments, or other Platform features.</p>
            </div>

            <div class="cookie-section">
                <h2>6. Personal Information</h2>
                <p>Cookies may collect information such as device type, browser information, IP address, website activity,
                    and preferences. Where cookies are linked to information that identifies you, such information will be
                    handled in accordance with our applicable Privacy Policy.</p>
            </div>

            <div class="cookie-section">
                <h2>7. Policy Updates</h2>
                <p>We may update this Cookie Policy from time to time to reflect changes in technology, legal requirements,
                    or our practices. The updated version will be made available on the Platform with the revised effective
                    date, where applicable.</p>
            </div>

            <div class="cookie-section">
                <h2>8. Contact</h2>
                <p>If you have questions about this Cookie Policy or how cookies are used, please contact the event
                    organizers through the contact details provided on the Platform.</p>
            </div>

            <div class="cookie-section">
                <h2>9. Acceptance</h2>
                <p>By continuing to use the Platform, you acknowledge this Cookie Policy, subject to any consent choices or
                    rights available to you under applicable law.</p>
            </div>

            <div class="cookie-footer">
                Last updated: August 2026 &nbsp;|&nbsp; ArihantPLUS Conclave
            </div>
        </div>
    </div>
@endsection