@extends('layouts.app')

@section('title', 'Disclaimer & Risk Disclosure — ArihantPLUS Conclave 2026')

@push('styles')
<style>
    .disclaimer-page {
        min-height: 100vh;
        padding: 100px 24px 80px;
        background: linear-gradient(180deg, #060208 0%, #0a0410 55%, #12081d 100%);
    }
    .disclaimer-card {
        max-width: 800px;
        margin: 0 auto;
        background: linear-gradient(165deg, #170b22 0%, #0b0511 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 26px;
        padding: 48px 44px;
        box-shadow: 0 40px 90px rgba(0, 0, 0, 0.6);
    }
    .disclaimer-card h1 {
        font-family: 'Sora', sans-serif;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 8px;
        color: #fff;
    }
    .disclaimer-card .subtitle {
        color: var(--muted);
        font-size: 14px;
        margin-bottom: 36px;
    }
    .disclaimer-section {
        margin-bottom: 32px;
    }
    .disclaimer-section h2 {
        font-size: 18px;
        font-weight: 700;
        color: #d4a5ff;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .disclaimer-section h2::before {
        content: '';
        display: inline-block;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--purple-1);
    }
    .disclaimer-section p {
        font-size: 14px;
        line-height: 1.7;
        color: rgba(230, 220, 240, 0.85);
        margin-bottom: 10px;
    }
    .disclaimer-section ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .disclaimer-section ul li {
        position: relative;
        padding-left: 20px;
        margin-bottom: 10px;
        font-size: 14px;
        line-height: 1.7;
        color: rgba(230, 220, 240, 0.85);
    }
    .disclaimer-section ul li::before {
        content: '—';
        position: absolute;
        left: 0;
        color: var(--purple-1);
        font-weight: 600;
    }
    .disclaimer-footer {
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
        .disclaimer-card {
            padding: 32px 22px;
            border-radius: 22px;
        }
        .disclaimer-card h1 {
            font-size: 24px;
        }
    }
</style>
@endpush

@section('content')
<div class="disclaimer-page">
    <div class="disclaimer-card">
        <a href="{{ url()->previous() }}" class="back-btn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Back
        </a>

        <h1>Disclaimer / Risk Disclosure</h1>
        <p class="subtitle">ArihantPLUS AI & Algo Conclave 2026</p>

        <div class="disclaimer-section">
            <h2>1. General Disclaimer</h2>
            <p>The information, discussions, demonstrations, presentations, educational materials, and other content provided during this event are intended solely for educational and informational purposes.</p>
            <p>Nothing presented during the event constitutes or should be construed as financial, investment, trading, legal, tax, accounting, or other professional advice.</p>
            <p>Participants are solely responsible for evaluating their own financial circumstances, objectives, risk tolerance, and investment decisions.</p>
        </div>

        <div class="disclaimer-section">
            <h2>2. AI and Technology Disclaimer</h2>
            <p>Any discussion, demonstration, strategy, model, algorithm, software, artificial intelligence (AI) tool, machine-learning system, or technology presented at the event is provided for educational purposes.</p>
            <p>AI-generated or algorithmically generated information may contain errors, omissions, inaccuracies, biases, or outdated information. AI systems and trading algorithms can produce incorrect signals or predictions and should not be relied upon as a guarantee of trading or investment outcomes.</p>
            <p>Participants should independently verify information and conduct appropriate due diligence before making any financial decision.</p>
        </div>

        <div class="disclaimer-section">
            <h2>3. Algorithmic and Automated Trading Risk</h2>
            <p>Algorithmic, systematic, and automated trading involve significant risks. Trading systems may produce unexpected results due to market conditions, technical failures, data errors, connectivity issues, software bugs, execution delays, liquidity constraints, or incorrect configuration.</p>
            <p>Past performance, backtested results, simulated results, hypothetical examples, or demonstrations do not guarantee future performance.</p>
            <p>Actual trading results may differ materially from simulated or historical results.</p>
        </div>

        <div class="disclaimer-section">
            <h2>4. Options Trading Risk</h2>
            <p>Options trading involves substantial risk and may not be suitable for all investors.</p>
            <p>Depending on the strategy, participants may experience losses that are significant relative to the amount invested. Certain options strategies can expose traders to losses that may exceed the initial amount paid or deposited.</p>
            <p>Participants should fully understand the characteristics, risks, obligations, margin requirements, and potential outcomes of any options strategy before trading.</p>
        </div>

        <div class="disclaimer-section">
            <h2>5. Market and Financial Risks</h2>
            <p>Financial markets are volatile and unpredictable. Prices can move rapidly and may be affected by economic conditions, market events, liquidity, interest rates, news, geopolitical developments, and other factors.</p>
            <p>There is no guarantee of profit, and participants may lose some or all of their invested capital. Leverage, derivatives, margin, and automated trading can increase both potential gains and potential losses.</p>
        </div>

        <div class="disclaimer-section">
            <h2>6. No Guarantee of Results</h2>
            <p>Any examples of profits, returns, trading performance, strategies, testimonials, case studies, or successful outcomes shown or discussed during the event are illustrative only.</p>
            <p>No representation or guarantee is made that participants will achieve similar results. Individual results will vary based on numerous factors, including market conditions, capital, experience, execution, risk management, and trading decisions.</p>
        </div>

        <div class="disclaimer-section">
            <h2>7. No Personalized Recommendations</h2>
            <p>Speakers, organizers, trainers, sponsors, and other event participants do not provide personalized investment recommendations merely by discussing a particular security, asset, strategy, trading system, AI tool, or market view during the event.</p>
            <p>Participants should not interpret general examples or discussions as recommendations to buy, sell, hold, or trade any particular financial instrument.</p>
        </div>

        <div class="disclaimer-section">
            <h2>8. Independent Decision-Making</h2>
            <p>Participants are responsible for conducting their own research and obtaining independent advice from appropriately qualified professionals where necessary.</p>
            <p>Before undertaking any trading activity, participants should consider whether the activity is appropriate for their financial situation, experience, knowledge, and risk tolerance.</p>
        </div>

        <div class="disclaimer-section">
            <h2>9. Regulatory and Jurisdictional Considerations</h2>
            <p>Financial products, trading activities, and investment services may be subject to regulatory requirements that vary by jurisdiction.</p>
            <p>Participants are responsible for complying with all laws, regulations, broker requirements, exchange rules, tax obligations, and other requirements applicable to them.</p>
            <p>Nothing in this event is intended to create a broker-client, investment-adviser-client, fiduciary, or other professional advisory relationship unless separately established in writing and permitted under applicable law.</p>
        </div>

        <div class="disclaimer-section">
            <h2>10. Third-Party Platforms and Tools</h2>
            <p>The event may demonstrate or refer to third-party brokers, exchanges, data providers, AI platforms, software, APIs, or other services.</p>
            <p>The organizers do not guarantee the availability, accuracy, security, performance, or suitability of third-party products or services. Participants should review the applicable terms, fees, risks, and privacy policies of any third-party service before using it.</p>
        </div>

        <div class="disclaimer-footer">
            Last updated: August 2026 &nbsp;|&nbsp; ArihantPLUS Conclave
        </div>
    </div>
</div>
@endsection