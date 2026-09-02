@extends('layouts.app')

@section('title', 'Venue Check-In — ArihantPLUS')

@push('styles')
    <style>
        .scanner-page {
            min-height: 100vh;
            padding: 40px 24px;
            background: #000;
            text-align: center
        }

        .scanner-card {
            max-width: 520px;
            margin: 0 auto;
            background: linear-gradient(165deg, #170b22 0%, #0b0511 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 26px;
            padding: 36px
        }

        .scanner-card h1 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px
        }

        .scanner-card p {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 24px
        }

        #reader {
            width: 100%;
            border-radius: 14px;
            overflow: hidden;
            margin-bottom: 16px;
            display: none
        }

        #reader video {
            border-radius: 14px
        }

        #qr-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 14px;
            padding: 16px;
            color: #fff;
            font-size: 16px;
            text-align: center;
            margin-bottom: 12px;
            outline: none
        }

        #qr-input:focus {
            border-color: var(--purple-1)
        }

        .cam-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: var(--muted);
            font-size: 13px;
            cursor: pointer;
            margin-bottom: 16px
        }

        .cam-btn.active {
            background: rgba(184, 102, 247, 0.15);
            border-color: rgba(184, 102, 247, 0.4);
            color: var(--purple-1)
        }

        .result-box {
            margin-top: 20px;
            padding: 24px;
            border-radius: 16px;
            display: none;
            text-align: left
        }

        .result-box.success {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1)
        }

        .result-box.error {
            background: rgba(220, 60, 60, 0.1);
            border: 1px solid rgba(220, 60, 60, 0.3)
        }

        .result-box h3 {
            font-size: 18px;
            margin-bottom: 16px;
            text-align: center
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06)
        }

        .detail-row:last-child {
            border: none
        }

        .detail-row .lbl {
            color: var(--muted);
            font-size: 13px
        }

        .detail-row .val {
            color: var(--ink);
            font-size: 14px;
            font-weight: 600
        }

        .client-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(40, 180, 100, 0.12);
            border: 1px solid rgba(40, 180, 100, 0.3);
            color: #8ff0b3;
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600
        }

        .action-btns {
            display: flex;
            gap: 12px;
            margin-top: 24px
        }

        .action-btns button {
            flex: 1;
            padding: 14px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 15px;
            border: none;
            cursor: pointer
        }

        .btn-allocate {
            background: linear-gradient(135deg, #d43fe0, #7a1fc9);
            color: #fff
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: var(--muted)
        }

        .seat-result {
            text-align: center;
            padding: 20px;
            background: rgba(40, 180, 100, 0.08);
            border: 1px solid rgba(40, 180, 100, 0.2);
            border-radius: 16px;
            margin-top: 16px
        }

        .seat-result .seat-num {
            font-size: 42px;
            font-weight: 800;
            color: #8ff0b3
        }

        .seat-result .seat-sec {
            font-size: 14px;
            color: var(--muted);
            margin-top: 4px
        }
    </style>
@endpush

@section('content')
    <div class="scanner-page">
        <div class="scanner-card">
            <h1>🔍 Venue Check-In</h1>
            <p>Scan participant QR code using camera or enter manually.</p>

            <div id="reader"></div>

            <button class="cam-btn" id="camToggle" onclick="toggleCamera()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z" />
                    <circle cx="12" cy="13" r="4" />
                </svg>
                Open Camera
            </button>

            <input type="text" id="qr-input" placeholder="Or type QR code manually..." maxlength="32">
            <button class="btn btn-primary" style="width:100%" onclick="validateQr()">Validate & Show Details</button>

            <div id="result" class="result-box">
                <h3 id="resultTitle"></h3>
                <div id="details"></div>
                <div class="action-btns" id="actions" style="display:none">
                    <button class="btn-allocate" onclick="allocateSeat()">✓ Allocate Seat</button>
                    <button class="btn-back" onclick="resetScanner()">← Go Back</button>
                </div>
                <div id="seatResult"></div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        let currentCode = null;
        let processing = false;
        let html5QrCode = null;
        let cameraRunning = false;

        function toggleCamera() {
            const reader = document.getElementById('reader');
            const btn = document.getElementById('camToggle');

            if (cameraRunning) {
                html5QrCode.stop().then(() => {
                    reader.style.display = 'none';
                    btn.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/><circle cx="12" cy="13" r="4"/></svg> Open Camera`;
                    btn.classList.remove('active');
                    cameraRunning = false;
                });
                return;
            }

            reader.style.display = 'block';
            btn.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="6" y="4" width="12" height="16" rx="2"/><line x1="12" y1="8" x2="12" y2="8"/></svg> Stop Camera`;
            btn.classList.add('active');

            html5QrCode = new Html5Qrcode("reader");
            html5QrCode.start(
                { facingMode: "environment" },
                { fps: 10, qrbox: { width: 250, height: 250 } },
                (decodedText) => {
                    document.getElementById('qr-input').value = decodedText;
                    html5QrCode.stop().then(() => {
                        reader.style.display = 'none';
                        btn.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/><circle cx="12" cy="13" r="4"/></svg> Open Camera`;
                        btn.classList.remove('active');
                        cameraRunning = false;
                    });
                    validateQr();
                },
                (errorMessage) => { }
            ).then(() => {
                cameraRunning = true;
            }).catch(err => {
                alert('Camera error: ' + err);
                reader.style.display = 'none';
                cameraRunning = false;
            });
        }

        document.getElementById('qr-input').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') validateQr();
        });

        async function validateQr() {
            if (processing) return;
            const code = document.getElementById('qr-input').value.trim();
            if (code.length !== 32) { showError('Invalid QR', 'Code must be 32 characters.'); return; }

            processing = true;
            try {
                const res = await fetch('{{ route("checkin.validate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ code })
                });
                const data = await res.json();

                if (data.valid) {
                    currentCode = code;
                    showDetails(data);
                } else {
                    showError('❌ ' + (data.message || 'Invalid'), '');
                }
            } catch (e) {
                showError('Error', 'Network error. Try again.');
            }
            processing = false;
        }

        function showDetails(data) {
            const box = document.getElementById('result');
            box.className = 'result-box success';
            box.style.display = 'block';
            document.getElementById('resultTitle').innerHTML = '👤 ' + data.name;

            let html = '';
            if (data.is_existing_client) {
                html += '<div style="margin-bottom:12px"><span class="client-badge">Existing Client</span></div>';
            }
            html += `
            <div class="detail-row"><span class="lbl">Reg #</span><span class="val">${data.registration_number}</span></div>
            <div class="detail-row"><span class="lbl">Email</span><span class="val">${data.email}</span></div>
            <div class="detail-row"><span class="lbl">Phone</span><span class="val">+91 ${data.phone}</span></div>
            <div class="detail-row"><span class="lbl">City</span><span class="val">${data.city}</span></div>
            <div class="detail-row"><span class="lbl">Type</span><span class="val">${data.type.charAt(0).toUpperCase() + data.type.slice(1)}</span></div>
        `;
            document.getElementById('details').innerHTML = html;
            document.getElementById('actions').style.display = 'flex';
            document.getElementById('seatResult').innerHTML = '';
        }

        async function allocateSeat() {
            if (!currentCode || processing) return;
            processing = true;

            try {
                const res = await fetch('{{ route("checkin.allocate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ code: currentCode })
                });
                const data = await res.json();

                if (data.success) {
                    document.getElementById('actions').style.display = 'none';
               //     document.getElementById('seatResult').innerHTML = `
               //     <div class="seat-result">
               //         <div class="seat-num">${data.seat}</div>
               //         <div class="seat-sec">Section: ${data.section}</div>
               //     </div>
               // `;
                    document.getElementById('resultTitle').innerHTML = '✅ Check-in Complete';
                } else {
                    showError('❌ Failed', data.message);
                }
            } catch (e) {
                showError('Error', 'Network error. Try again.');
            }
            processing = false;
        }

        function resetScanner() {
            document.getElementById('qr-input').value = '';
            document.getElementById('result').style.display = 'none';
            document.getElementById('actions').style.display = 'none';
            document.getElementById('seatResult').innerHTML = '';
            currentCode = null;
            document.getElementById('qr-input').focus();
        }

        function showError(title, msg) {
            const box = document.getElementById('result');
            box.className = 'result-box error';
            box.style.display = 'block';
            document.getElementById('resultTitle').innerHTML = title;
            document.getElementById('details').innerHTML = msg ? `<p style="text-align:center;color:var(--muted)">${msg}</p>` : '';
            document.getElementById('actions').style.display = 'none';
            document.getElementById('seatResult').innerHTML = '';
        }
    </script>
@endsection