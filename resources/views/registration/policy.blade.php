@extends('layouts.app')

@section('title', 'Event Policy — ArihantPLUS Conclave 2026')

@push('styles')
<style>
    .policy-page {
        min-height: 100vh;
        padding: 100px 24px 80px;
        background: linear-gradient(180deg, #060208 0%, #0a0410 55%, #12081d 100%);
    }
    .policy-card {
        max-width: 800px;
        margin: 0 auto;
        background: linear-gradient(165deg, #170b22 0%, #0b0511 100%);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 26px;
        padding: 48px 44px;
        box-shadow: 0 40px 90px rgba(0, 0, 0, 0.6);
    }
    .policy-card h1 {
        font-family: 'Sora', sans-serif;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 8px;
        color: #fff;
    }
    .policy-card .subtitle {
        color: var(--muted);
        font-size: 14px;
        margin-bottom: 36px;
    }
    .policy-section {
        margin-bottom: 32px;
    }
    .policy-section h2 {
        font-size: 18px;
        font-weight: 700;
        color: #d4a5ff;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .policy-section h2::before {
        content: '';
        display: inline-block;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--purple-1);
    }
    .policy-section ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .policy-section ul li {
        position: relative;
        padding-left: 20px;
        margin-bottom: 10px;
        font-size: 14px;
        line-height: 1.7;
        color: rgba(230, 220, 240, 0.85);
    }
    .policy-section ul li::before {
        content: '—';
        position: absolute;
        left: 0;
        color: var(--purple-1);
        font-weight: 600;
    }
    .policy-footer {
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
        .policy-card {
            padding: 32px 22px;
            border-radius: 22px;
        }
        .policy-card h1 {
            font-size: 24px;
        }
    }
</style>
@endpush

@section('content')
<div class="policy-page">
    <div class="policy-card">
        <a href="{{ url()->previous() }}" class="back-btn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Back
        </a>

        <h1>Event Registration & Participation Policy</h1>
        <p class="subtitle">ArihantPLUS AI & Algo Conclave 2026</p>

        <div class="policy-section">
            <h2>1. Registration</h2>
            <ul>
                <li>Participants must complete the official event registration process before attending.</li>
                <li>Registration details must be accurate and complete.</li>
                <li>Registration may be subject to availability, eligibility, or approval requirements.</li>
                <li>Each registration is intended for the registered participant only and may not be transferred without prior approval.</li>
                <li>Participants must carry a valid registration confirmation or identification, where required.</li>
            </ul>
        </div>

        <div class="policy-section">
            <h2>2. Attendance</h2>
            <ul>
                <li>Participants should arrive on time and complete any required check-in before the event begins.</li>
                <li>Access to the event may be denied to individuals who have not completed the required registration.</li>
                <li>Participants are expected to attend only the sessions, activities, or areas for which they are registered or authorized.</li>
            </ul>
        </div>

        <div class="policy-section">
            <h2>3. Participation</h2>
            <ul>
                <li>Participants must behave respectfully and professionally toward organizers, speakers, staff, and other attendees.</li>
                <li>Participants are expected to follow event instructions, schedules, safety requirements, and venue rules.</li>
                <li>Disruptive, abusive, discriminatory, threatening, or inappropriate behavior will not be tolerated.</li>
                <li>Participants must respect the privacy, personal space, and property of others.</li>
            </ul>
        </div>

        <div class="policy-section">
            <h2>4. Event Materials and Activities</h2>
            <ul>
                <li>Participants may use event materials only for their intended purpose.</li>
                <li>Recording, photographing, or distributing event content may be restricted by the organizers.</li>
                <li>Participants must obtain permission before recording or publishing images or content involving other attendees, where applicable.</li>
            </ul>
        </div>

        <div class="policy-section">
            <h2>5. Safety and Venue Rules</h2>
            <ul>
                <li>Participants must comply with all health, safety, security, and emergency procedures.</li>
                <li>Any prohibited items or activities specified by the venue or organizers are not permitted.</li>
                <li>Participants are responsible for their personal belongings unless otherwise stated by the organizers.</li>
            </ul>
        </div>

        <div class="policy-section">
            <h2>6. Cancellation and Changes</h2>
            <ul>
                <li>Participants should notify the organizers as early as possible if they are unable to attend.</li>
                <li>The organizers reserve the right to modify the event schedule, speakers, venue, or activities when necessary.</li>
                <li>Any cancellation, refund, or transfer arrangements will be governed by the applicable event terms.</li>
            </ul>
        </div>

        <div class="policy-section">
            <h2>7. Non-Compliance</h2>
            <ul>
                <li>Organizers may refuse admission or remove a participant who violates this policy or applicable venue rules.</li>
                <li>Serious or repeated violations may result in cancellation of registration and restriction from future events.</li>
                <li>Decisions made by event organizers regarding participant conduct and access will be final, subject to applicable law.</li>
            </ul>
        </div>

        <div class="policy-section">
            <h2>8. Acceptance</h2>
            <ul>
                <li>By registering for or attending the event, participants acknowledge that they have read, understood, and agreed to comply with this Event Registration & Participation Policy.</li>
            </ul>
        </div>

        <div class="policy-footer">
            Last updated: August 2026 &nbsp;|&nbsp; ArihantPLUS Conclave
        </div>
    </div>
</div>
@endsection