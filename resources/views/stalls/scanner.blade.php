@extends('layouts.app')

@section('title', 'Scan Stall QR — ArihantPLUS')

@push('styles')
    <style>
        .scanner-page {
            min-height: 100vh;
            padding: 70px 20px 60px;
            background: var(--bg);
        }

        .scanner-wrap {
            max-width: 600px;
            margin: 0 auto;
        }

        .scanner-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .scanner-header h1 {
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .scanner-header p {
            color: var(--muted);
            font-size: 14px;
            margin: 0;
            line-height: 1.6;
        }

        .scanner-card {
            background: linear-gradient(160deg,
                    rgba(22, 12, 30, 0.95) 0%,
                    rgba(8, 4, 12, 0.98) 100%);

            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 22px;
            padding: 22px;
        }

        .scanner-box {
            position: relative;
            width: 100%;
            aspect-ratio: 1 / 1;
            max-width: 450px;
            margin: 0 auto;
            border-radius: 18px;
            overflow: hidden;
            background: #050308;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        #qr-reader {
            width: 100%;
            height: 100%;
        }

        #qr-reader video {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover;
            border-radius: 18px;
        }

        #qr-reader__dashboard {
            display: none !important;
        }

        #qr-reader__scan_region {
            min-height: 100% !important;
        }

        #qr-reader__scan_region img {
            display: none !important;
        }

        .scanner-overlay {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 5;
        }

        .scanner-frame {
            position: absolute;
            width: 65%;
            height: 65%;
            top: 17.5%;
            left: 17.5%;
            border: 2px solid rgba(184, 102, 247, 0.9);
            border-radius: 18px;
            box-shadow:
                0 0 0 999px rgba(0, 0, 0, 0.25),
                0 0 30px rgba(184, 102, 247, 0.15);
        }

        .scanner-line {
            position: absolute;
            left: 20%;
            width: 60%;
            top: 20%;
            height: 2px;
            background: var(--purple-1);
            box-shadow: 0 0 12px rgba(184, 102, 247, 0.8);
            animation: scanLine 2s infinite ease-in-out;
        }

        @keyframes scanLine {
            0% {
                top: 20%;
            }

            50% {
                top: 78%;
            }

            100% {
                top: 20%;
            }
        }

        .scanner-status {
            text-align: center;
            margin-top: 20px;
            color: var(--muted);
            font-size: 13px;
            min-height: 20px;
        }

        .scanner-error {
            margin-top: 16px;
            padding: 12px 14px;
            border-radius: 10px;
            background: rgba(255, 80, 80, 0.1);
            border: 1px solid rgba(255, 80, 80, 0.2);
            color: #ffaaaa;
            font-size: 13px;
            display: none;
        }

        .scanner-actions {
            display: flex;
            justify-content: center;
            margin-top: 22px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: var(--purple-1);
            text-decoration: none;
            font-size: 13px;
        }

        .back-btn:hover {
            color: var(--purple-1);
        }

        .scanner-note {
            margin-top: 20px;
            text-align: center;
            color: var(--muted-2);
            font-size: 12px;
            line-height: 1.6;
        }

        @media (max-width: 640px) {
            .scanner-page {
                padding: 45px 16px 40px;
            }

            .scanner-header h1 {
                font-size: 27px;
            }

            .scanner-card {
                padding: 14px;
            }
        }
    </style>
@endpush

@section('content')

    <div class="scanner-page">

        <div class="scanner-wrap">

            <div class="scanner-header">

                <h1>Scan Stall QR</h1>

                <p>
                    Point your camera at the QR code displayed at the stall
                    to check in and access its quiz and feedback.
                </p>

            </div>

            <div class="scanner-card">

                <div class="scanner-box">

                    <div id="qr-reader"></div>

                    <div class="scanner-overlay">

                        <div class="scanner-frame"></div>

                        <div class="scanner-line"></div>

                    </div>

                </div>

                <div id="scanner-status" class="scanner-status">
                    Requesting camera access...
                </div>

                <div id="scanner-error" class="scanner-error"></div>

                <div class="scanner-actions">

                    <a href="{{ route('stalls.index') }}" class="back-btn">
                        ← Back to Stalls
                    </a>

                </div>

                <div class="scanner-note">
                    Make sure you have allowed camera access in your browser.
                    Scan the QR code placed at the stall.
                </div>

            </div>

        </div>

    </div>

@endsection

@push('scripts')

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const status = document.getElementById('scanner-status');
            const errorBox = document.getElementById('scanner-error');

            let scannerStarted = false;
            let scanCompleted = false;

            function showError(message) {
                errorBox.textContent = message;
                errorBox.style.display = 'block';
                status.textContent = '';
            }

            function handleScan(decodedText) {

                if (scanCompleted) {
                    return;
                }

                scanCompleted = true;

                status.textContent = 'QR detected. Opening stall...';

                /**
                 * The QR contains the complete stall scan URL.
                 *
                 * Example:
                 * https://example.com/stalls/scan/abc123
                 */
                if (
                    decodedText.startsWith('{{ url('/stalls/scan') }}')
                ) {

                    window.location.href = decodedText;

                    return;
                }

                /**
                 * Also support a raw qr_token.
                 *
                 * This makes testing easier if the QR currently
                 * contains only the token.
                 */
                window.location.href =
                    '{{ url('/stalls/scan') }}/' +
                    encodeURIComponent(decodedText);
            }

            function handleScanError(errorMessage) {

                /**
                 * html5-qrcode generates continuous "QR not found"
                 * messages while scanning.
                 *
                 * We intentionally don't display those.
                 */
            }

            const scanner = new Html5Qrcode("qr-reader");

            Html5Qrcode.getCameras()
                .then(function (cameras) {

                    if (!cameras || cameras.length === 0) {

                        showError(
                            'No camera was found on this device.'
                        );

                        return;
                    }

                    /**
                     * Prefer the back camera.
                     */
                    let cameraId = cameras[0].id;

                    const backCamera = cameras.find(camera => {

                        const label = (
                            camera.label || ''
                        ).toLowerCase();

                        return (
                            label.includes('back') ||
                            label.includes('rear') ||
                            label.includes('environment')
                        );
                    });

                    if (backCamera) {
                        cameraId = backCamera.id;
                    }

                    scanner
                        .start(
                            cameraId,
                            {
                                fps: 10,

                                qrbox: {
                                    width: 250,
                                    height: 250
                                },

                                aspectRatio: 1
                            },
                            handleScan,
                            handleScanError
                        )
                        .then(function () {

                            scannerStarted = true;

                            status.textContent =
                                'Point your camera at a stall QR code.';

                        })
                        .catch(function (error) {

                            console.error(error);

                            showError(
                                'Unable to start the camera. Please allow camera access and try again.'
                            );

                        });

                })
                .catch(function (error) {

                    console.error(error);

                    showError(
                        'Camera permission was denied or the camera is unavailable.'
                    );

                });

            window.addEventListener('beforeunload', function () {

                if (scannerStarted) {

                    scanner
                        .stop()
                        .catch(function () { });
                }

            });

        });
    </script>

@endpush