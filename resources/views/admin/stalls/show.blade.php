@extends('layouts.app')

@section('title', $stall->name . ' — Stall')

@push('styles')
    <style>
        .admin-page {
            min-height: 100vh;
            padding: 40px 24px 70px;
            background: var(--bg-soft);
        }

        .admin-wrap {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Header */
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 28px;
        }

        .admin-header h1 {
            font-size: 30px;
            margin-bottom: 6px;
        }

        .admin-header p {
            color: var(--muted);
            font-size: 14px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Buttons */
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 9px 14px;
            border-radius: 9px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.04);
            color: #e9defa;
            font-size: 13px;
            text-decoration: none;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .action-btn:hover {
            border-color: rgba(184, 102, 247, 0.55);
            background: rgba(184, 102, 247, 0.12);
            color: #ffffff;
        }

        .action-btn-primary {
            background: rgba(184, 102, 247, 0.15);
            border-color: rgba(184, 102, 247, 0.35);
            color: #e9cfff;
        }

        .action-btn-primary:hover {
            background: rgba(184, 102, 247, 0.24);
            border-color: rgba(184, 102, 247, 0.65);
        }

        /* Main grid */
        .stall-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.45fr) minmax(320px, 0.75fr);
            gap: 24px;
            align-items: start;
        }

        /* Cards */
        .admin-card {
            background: linear-gradient(160deg,
                    rgba(22, 12, 30, 0.9),
                    rgba(8, 4, 12, 0.96));
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 20px;
            overflow: hidden;
        }

        .card-header {
            padding: 18px 22px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .card-header h2 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
        }

        .card-header p {
            margin: 5px 0 0;
            color: var(--muted);
            font-size: 12px;
        }

        .card-body {
            padding: 22px;
        }

        /* Stall information */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 24px 28px;
        }

        .info-item {
            min-width: 0;
        }

        .info-item-full {
            grid-column: 1 / -1;
        }

        .info-label {
            display: block;
            margin-bottom: 7px;
            color: var(--muted);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.7px;
        }

        .info-value {
            color: #e9e1ef;
            font-size: 14px;
            line-height: 1.6;
            word-break: break-word;
        }

        .info-value strong {
            color: var(--ink);
            font-size: 15px;
        }

        .muted-value {
            color: var(--muted-2);
        }

        /* Status */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
        }

        .badge-active {
            background: rgba(40, 180, 100, 0.12);
            color: #8ff0b3;
            border: 1px solid rgba(40, 180, 100, 0.22);
        }

        .badge-inactive {
            background: rgba(255, 180, 70, 0.1);
            color: #ffd08a;
            border: 1px solid rgba(255, 180, 70, 0.2);
        }

        /* QR card */
        .qr-card {
            position: sticky;
            top: 24px;
        }

        .qr-body {
            padding: 24px;
            text-align: center;
        }

        .qr-preview {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 340px;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.025);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .qr-preview img {
            display: block;
            width: 100%;
            max-width: 300px;
            height: auto;
            border-radius: 10px;
            background: #ffffff;
            padding: 10px;
        }

        .qr-empty {
            padding: 45px 20px;
            color: var(--muted);
        }

        .qr-empty-icon {
            margin-bottom: 15px;
            font-size: 52px;
            opacity: 0.5;
        }

        .qr-empty h3 {
            margin: 0 0 7px;
            color: var(--ink);
            font-size: 16px;
        }

        .qr-empty p {
            margin: 0;
            font-size: 13px;
            line-height: 1.6;
        }

        .qr-actions {
            display: flex;
            gap: 9px;
        }

        .qr-actions .action-btn {
            flex: 1;
        }

        /* Token */
        .token-card {
            margin-top: 24px;
        }

        .token-box {
            display: flex;
            align-items: stretch;
            gap: 8px;
        }

        .token-value {
            flex: 1;
            min-width: 0;
            padding: 11px 13px;
            border-radius: 9px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(255, 255, 255, 0.035);
            color: #dcd0e8;
            font-family: monospace;
            font-size: 12px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .copy-btn {
            flex-shrink: 0;
        }

        /* System information */
        .system-card {
            margin-top: 24px;
        }

        /* Alerts */
        .alert {
            margin-bottom: 22px;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .stall-grid {
                grid-template-columns: 1fr;
            }

            .qr-card {
                position: static;
            }
        }

        @media (max-width: 640px) {
            .admin-page {
                padding: 28px 16px 50px;
            }

            .admin-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .header-actions {
                width: 100%;
            }

            .header-actions .action-btn {
                flex: 1;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .info-item-full {
                grid-column: auto;
            }

            .card-header,
            .card-body,
            .qr-body {
                padding: 18px;
            }

            .qr-preview {
                min-height: 280px;
            }

            .qr-actions {
                flex-direction: column;
            }

            .token-box {
                flex-direction: column;
            }

            .copy-btn {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')

    <div class="admin-page">

        <div class="admin-wrap">

            {{-- Header --}}
            <div class="admin-header">

                <div>
                    <h1>{{ $stall->name }}</h1>

                    <p>
                        View stall details and manage its unique QR code.
                    </p>
                </div>

                <div class="header-actions">

                    <a href="{{ route('admin.stalls.index') }}" class="action-btn">
                        ← Back
                    </a>

                    <a href="{{ route('admin.stalls.edit', $stall) }}" class="action-btn action-btn-primary">
                        Edit Stall
                    </a>

                </div>

            </div>


            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif


            <div class="stall-grid">

                {{-- Left: Stall Information --}}
                <div>

                    <div class="admin-card">

                        <div class="card-header">
                            <h2>Stall Information</h2>
                            <p>Basic information configured for this stall.</p>
                        </div>

                        <div class="card-body">

                            <div class="info-grid">

                                {{-- Name --}}
                                <div class="info-item">

                                    <span class="info-label">
                                        Stall Name
                                    </span>

                                    <div class="info-value">
                                        <strong>{{ $stall->name }}</strong>
                                    </div>

                                </div>


                                {{-- Status --}}
                                <div class="info-item">

                                    <span class="info-label">
                                        Status
                                    </span>

                                    <div class="info-value">

                                        @if($stall->is_active)
                                            <span class="badge badge-active">
                                                Active
                                            </span>
                                        @else
                                            <span class="badge badge-inactive">
                                                Inactive
                                            </span>
                                        @endif

                                    </div>

                                </div>


                                {{-- Slug --}}
                                <div class="info-item">

                                    <span class="info-label">
                                        Slug
                                    </span>

                                    <div class="info-value">
                                        {{ $stall->slug }}
                                    </div>

                                </div>


                                {{-- Location --}}
                                <div class="info-item">

                                    <span class="info-label">
                                        Location
                                    </span>

                                    <div class="info-value">
                                        @if($stall->location)
                                            {{ $stall->location }}
                                        @else
                                            <span class="muted-value">Not specified</span>
                                        @endif
                                    </div>

                                </div>


                                {{-- Description --}}
                                <div class="info-item info-item-full">

                                    <span class="info-label">
                                        Description
                                    </span>

                                    <div class="info-value">

                                        @if($stall->description)
                                            {!! nl2br(e($stall->description)) !!}
                                        @else
                                            <span class="muted-value">
                                                No description available.
                                            </span>
                                        @endif

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- QR Token --}}
                    <div class="admin-card token-card">

                        <div class="card-header">
                            <h2>QR Token</h2>
                            <p>
                                Unique token associated with this stall QR code.
                            </p>
                        </div>

                        <div class="card-body">

                            @if($stall->qr_token)

                                <div class="token-box">

                                    <div class="token-value" id="qr-token" title="{{ $stall->qr_token }}">
                                        {{ $stall->qr_token }}
                                    </div>

                                    <button type="button" class="action-btn copy-btn" onclick="copyQrToken()">
                                        Copy Token
                                    </button>

                                </div>

                            @else

                                <div class="muted-value">
                                    QR token has not been generated yet.
                                </div>

                            @endif

                        </div>

                    </div>


                    {{-- System Information --}}
                    <div class="admin-card system-card">

                        <div class="card-header">
                            <h2>System Information</h2>
                        </div>

                        <div class="card-body">

                            <div class="info-grid">

                                <div class="info-item">

                                    <span class="info-label">
                                        Created At
                                    </span>

                                    <div class="info-value">
                                        {{ $stall->created_at?->format('d M Y, h:i A') ?? '—' }}
                                    </div>

                                </div>


                                <div class="info-item">

                                    <span class="info-label">
                                        Last Updated
                                    </span>

                                    <div class="info-value">
                                        {{ $stall->updated_at?->format('d M Y, h:i A') ?? '—' }}
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Right: QR --}}
                <div>

                    <div class="admin-card qr-card">

                        <div class="card-header">
                            <h2>Stall QR Code</h2>
                            <p>
                                Scan this QR code to access this stall.
                            </p>
                        </div>

                        <div class="qr-body">

                            @if($stall->qr_image_path)

                                <div class="qr-preview">

                                    <img src="{{ Storage::url($stall->qr_image_path) }}" alt="{{ $stall->name }} QR Code">

                                </div>

                                <div class="qr-actions">

                                    <a href="{{ Storage::url($stall->qr_image_path) }}" target="_blank" class="action-btn">
                                        Open
                                    </a>

                                    <a href="{{ Storage::url($stall->qr_image_path) }}"
                                        download="stall-{{ $stall->slug }}-qr.png" class="action-btn action-btn-primary">
                                        Download
                                    </a>

                                </div>

                            @else

                                <div class="qr-preview">

                                    <div class="qr-empty">

                                        <div class="qr-empty-icon">
                                            ⌗
                                        </div>

                                        <h3>
                                            No QR Code Generated
                                        </h3>

                                        <p>
                                            A QR code has not been generated
                                            for this stall yet.
                                        </p>

                                    </div>

                                </div>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    @if($stall->qr_token)
        <script>
            function copyQrToken() {
                const token = @json($stall->qr_token);

                navigator.clipboard.writeText(token).then(() => {
                    const button = document.querySelector('.copy-btn');

                    if (!button) {
                        return;
                    }

                    const originalText = button.textContent;

                    button.textContent = 'Copied!';

                    setTimeout(() => {
                        button.textContent = originalText;
                    }, 1500);
                });
            }
        </script>
    @endif

@endsection